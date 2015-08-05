<?php

class SalesInvoicesController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view','getNewForm','automatedTransaction','viewTransaction'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),

        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $i=0;
        $model1=new SalesInvoices;
        $model2=new SalesInfo;
        $receivedModel=new MoneyReceived;

        if(isset($_POST['SalesInvoices']))
        {
            $model1->attributes=$_POST['SalesInvoices'];
            $model1->save();
            $sales_invoice_id=$model1->id;
            if(isset($_POST['SalesInfo']))
            {
                $testModel=array();
                while($i<=$_SESSION['sts'])
                {
                    $testModel[$i]=new SalesInfo;
                    if(isset($_POST['SalesInfo'][$i]))
                    {
                        $testModel[$i]->attributes=$_POST['SalesInfo'][$i];
                        $testModel[$i]->sales_invoice_id=$sales_invoice_id;
                        if(!empty($testModel[$i]->unit_price))
                        {
                            $testModel[$i]->save();
                            $item=InventoryItems::model()->findByPk($testModel[$i]->item_id);
                            $item->qty-=$testModel[$i]->qty;
                            $item->save();

                        }
                    }
                    $i++;
                }

            }
            if(isset($_POST['MoneyReceived']))
            {
                $receivedModel->attributes=$_POST['MoneyReceived'];
                $receivedModel->received_date=$model1->issue_date;
                $receivedModel->sales_invoice_id=$model1->id;
                $receivedModel->customer_id=$model1->customer_id;
                $receivedModel->status=1;
                if($receivedModel->save())
                {
                    $balance=($receivedModel->amount)*1.0-($model1->total_amount)*1.0;
                    if($balance<=0){
                        $model1->balance=$balance*(-1.0);
                    }
                    else{
                        $model1->balance=0;
                        $creditModel=new CustomersCredit;
                        $creditModel->amount=$balance;
                        $creditModel->credited_from=$model1->id;
                        $creditModel->customer_id=$model1->customer_id;
                        $creditModel->credited_date=$model1->issue_date;
                        $creditModel->save();
                    }
                    //SalesInvoices::model()->findByPk($model1->id)->delete();
                    $model1->save();
                    //Yii::app()->AutomatedExecution->AutomatedExecutionHandler();
                }
            }
            $this->redirect(array('AutomatedTransaction','id'=>$model1->id,'mode'=>'create'));
        }

        $this->render('create',array(
            'model1'=>$model1,
            'model2'=>$model2,
            'receivedModel'=>$receivedModel
        ));
    }



    /*------------------------------Automated transaction start-----------------------------------------------------------*/
     public function  actionAutomatedTransaction($id,$mode)
     {

         $salesInv=SalesInvoices::model()->findByPk($id);
         $customersCredit=CustomersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$id)));
         $remainingCredit=$salesInv->credited-$salesInv->balance;
         if($remainingCredit>0){
             $salesInv->credited=$salesInv->balance;
             $modelsCreditedFrom=AutomatedTransactionCustomers::model()->findAll(array(
                 'condition'=>'to_sales_invoice_id=:invoice_id','params'=>array(':invoice_id'=>$salesInv->id)));
             $creditedModels=array();
             foreach($modelsCreditedFrom as $indCredited)
             {
                 $i=0;
                 $creditAssigned=$indCredited->amount;
                 $creditedModel=CustomersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$indCredited->from_sales_invoice_id)));

                 if($remainingCredit>=$creditAssigned)
                 {
                     $indCredited->delete();
                     $creditedModel->credit_assigned-=$creditAssigned;
                     $creditedModel->save();
                     $remainingCredit-=$creditAssigned;
                     $creditedModels[$i]=$creditedModel;
                     $i++;
                 }
                 else{
                     $indCredited->amount-=$remainingCredit;
                     $creditedModel->credit_assigned-=$remainingCredit;
                     $creditedModel->save();
                     $indCredited->save();
                     $creditedModels[$i]=$creditedModel;
                     break;
                 }
             }
             $salesInv->save();
             foreach($creditedModels as $indvCredited)
             {
                 $this->TransferringCredit($indvCredited);
             }
         }
         else{
             if($remainingCredit<0){
                 $remainingCredit=-1*$remainingCredit;
                 $this->GetCreditfor($salesInv,$remainingCredit);
             }

         }
         if(isset($customersCredit)){
             $creditRemainingOfThisModel=$customersCredit->amount-$customersCredit->credit_assigned;
             if($creditRemainingOfThisModel>0){
                $this->TransferringCredit($customersCredit);
             }
             else
             {
                 if($creditRemainingOfThisModel<0){
                     $overAssignedCredit=-1*$creditRemainingOfThisModel;
                     $creditTakers=AutomatedTransactionCustomers::model()->findAll(array('condition'=>'from_sales_invoice_id=:invoice','params'=>array(':invoice'=>$customersCredit->credited_from)));
                     $creditTakerInvoices=array();
                     $i=0;
                     foreach($creditTakers as $creditTaker){
                         if($overAssignedCredit>0){
                             $creditTakerInvoice=SalesInvoices::model()->findByPk($creditTaker->to_sales_invoice_id);
                             if($creditTaker->amount<=$overAssignedCredit){
                                 $creditDeducted=$creditTaker->amount;
                                 $creditTaker->delete();
                             }
                             else{
                                 $creditDeducted=$overAssignedCredit;
                                 $creditTaker->amount-=$creditDeducted;
                                 $creditTaker->save();
                             }
                             $creditTakerInvoice->credited-=$creditDeducted;
                             $creditTakerInvoice->save();
                             $overAssignedCredit-=$creditDeducted;
                             $creditTakerInvoices[$i]=$creditTakerInvoice;
                             $i++;
                         }
                         else{

                         }
                     }

                 }
                 if($customersCredit->amount==0)
                     $customersCredit->delete();
                 else{
                     $customersCredit->credit_assigned=$customersCredit->amount;
                     $customersCredit->save();
                 }
                 foreach($creditTakerInvoices as $creditTakerInv){
                     $creditToPay=$creditTakerInv->balance-$creditTakerInv->credited;
                     $this->GetCreditfor($creditTakerInv,$creditToPay);
                 }
             }
         }
         if($mode=='delete'){
            $salesInv->delete();
            $this->redirect(array('index'));
         }
         $this->redirect(array('view','id'=>$id));
     }
    public function TransferringCredit($indvCredited)
    {
        $creditRemainingOfThisModel=$indvCredited->amount-$indvCredited->credit_assigned;
        foreach(SalesInvoices::model()->findAll(array('condition'=>'customer_id=:customer','params'=>array(':customer'=>$indvCredited->customer_id))) as $indvSalesInvoice){
            if($creditRemainingOfThisModel>0){
                //echo $creditRemainingOfThisModel;
                $amountToGetBalanced=$indvSalesInvoice->balance-$indvSalesInvoice->credited;
                //echo $amountToGetBalanced;

                if($amountToGetBalanced>0){
                    if($creditRemainingOfThisModel>$amountToGetBalanced){
                        $amountCredited=$amountToGetBalanced;
                    }
                    else{
                        $amountCredited=$creditRemainingOfThisModel;
                    }
                    $indvSalesInvoice->credited+=$amountCredited;
                    $indvCredited->credit_assigned+=$amountCredited;
                    $creditRemainingOfThisModel-=$amountCredited;
                    $transaction=new AutomatedTransactionCustomers;
                    $transaction->received_date=$indvCredited->credited_date;
                    $transaction->customer_id=$indvCredited->customer_id;
                    $transaction->from_sales_invoice_id=$indvCredited->credited_from;
                    $transaction->to_sales_invoice_id=$indvSalesInvoice->id;
                    $transaction->amount=$amountCredited;
                    $indvSalesInvoice->save();
                    $indvCredited->save();
                    $transaction->save();
                }
            }
            else{

            }

        }
    }

    public function GetCreditfor($salesInvoice,$remainingCredit)
    {
        foreach(CustomersCredit::model()->findAll(array('condition'=>'customer_id=:customer','params'=>array(':customer'=>$salesInvoice->customer_id))) as $indModel){
            $creditRemained=$indModel->amount-$indModel->credit_assigned;
            if($remainingCredit<=0){
                break;
            }

            else{
                if($creditRemained>$remainingCredit)
                    $creditBorrowed=$remainingCredit;
                else
                    $creditBorrowed=$creditRemained;
                $transaction=new AutomatedTransactionCustomers;
                $transaction->received_date=$indModel->credited_date;
                $transaction->from_sales_invoice_id=$indModel->credited_from;
                $transaction->to_sales_invoice_id=$salesInvoice->id;
                $transaction->amount=$creditBorrowed;
                $transaction->customer_id=$salesInvoice->customer_id;
                $indModel->credit_assigned+=$creditBorrowed;
                $salesInvoice->credited+=$creditBorrowed;
                $salesInvoice->save();
                $transaction->save();
                $indModel->save();
                $remainingCredit-=$creditBorrowed;
            }
        }
    }
    /*------------------------------Automated transaction end-------------------------------------------------------------*/

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */

    public function actionUpdate($id)
    {
        $i=0;
        $model1=$this->loadModel($id);
        $model2=$model1->salesInfos;
        $receivedModel=$this->loadReceivedModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['SalesInvoices']))
        {
            $model1->attributes=$_POST['SalesInvoices'];
            $model1->save();
            $sales_invoice_id=$model1->id;
            if(isset($_POST['SalesInfo']))
            {
                $item_qty=array();
                foreach($model2 as $cnt=>$indModel)
                {
                    $item_qty[$cnt]=$indModel->qty;
                    $indModel->delete();
                }
                while($i<=$_SESSION['sts'])
                {
                    if(isset($_POST['SalesInfo'][$i]))
                    {
                        $indModel=new SalesInfo;
                        $indModel->attributes=$_POST['SalesInfo'][$i];
                        $indModel->sales_invoice_id=$sales_invoice_id;
                        $indModel->save();
                        $item=InventoryItems::model()->findByPk($indModel->item_id);
                        $item->qty-=($indModel->qty-$item_qty[$i]);
                        $item->save();
                    }
                    $i++;
                }
                //$model2->save();
            }
            if(isset($_POST['MoneyReceived']))
            {
                $receivedModel->attributes=$_POST['MoneyReceived'];
                $receivedModel->save();
                $total_received=0;
                foreach(MoneyReceived::model()->findAll(array('condition'=>'sales_invoice_id=:invoice','params'=>array(':invoice'=>$id))) as $receipts){
                    $total_received+=$receipts->amount;
                }
                $tempBalance=$model1->total_amount-$total_received;
                $creditRow=CustomersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$id)));
                if($tempBalance>=0){
                    $model1->balance=$tempBalance;
                    if(isset($creditRow))
                    {
                       $creditRow->amount=0;
                        $creditRow->save();
                    }
                }
                else{
                    $model1->balance=0;
                    if(!isset($creditRow)){
                        $creditRow=new CustomersCredit;
                        $creditRow->credited_from=$id;
                        $creditRow->customer_id=$model1->customer_id;
                    }
                    $creditRow->amount=-1*$tempBalance;
                    $creditRow->credited_date=$model1->issue_date;
                    $creditRow->customer_id=$model1->customer_id;
                    $creditRow->save();
                }
                $model1->save();

            }


            $this->redirect(array('AutomatedTransaction','id'=>$model1->id,'mode'=>''));
            //$this->redirect(array('view','id'=>$model1->id));
        }

        $this->render('update',array(
            'model1'=>$model1,
            'model2'=>$model2,
            'receivedModel'=>$receivedModel
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model1=$this->loadModel($id);
        $model1->balance=0;
        $creditModel=CustomersCredit::model()->find(array('condition'=>'credited_from=:id','params'=>array(':id'=>$id)));
        if(isset($creditModel)){
            $creditModel->credit_assigned=0;
            $creditModel->save();
        }
        $model1->save();
        $this->redirect(array('AutomatedTransaction','id'=>$id,'mode'=>'delete'));
        $model1->delete();
        //$this->redirect(array('index'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        //if(!isset($_GET['ajax']))
          //  $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {

        if(isset($_GET['customer']))
        {
            $criteria=new CDbCriteria();
            $criteria->condition='customer_id=:customer_id';
            $criteria->params=array(':customer_id'=>$_GET['customer']);
            $count=SalesInvoices::model()->count($criteria);
            $pages=new CPagination($count);
            // results per page
            $pages->pageSize=10;
            $pages->applyLimit($criteria);
            $models=SalesInvoices::model()->with('customer')->findAll($criteria);
        }
        else
        {
            $criteria=new CDbCriteria();
            $count=SalesInvoices::model()->count($criteria);
            $pages=new CPagination($count);
            // results per page
            $pages->pageSize=10;
            $pages->applyLimit($criteria);
            $models=SalesInvoices::model()->with('customer')->findAll($criteria);
        }


        $this->render('index', array(
            'models' => $models,
            'pages' => $pages,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new SalesInvoices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SalesInvoices']))
            $model->attributes=$_GET['SalesInvoices'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionGetNewForm()
    {
        $sts=$_POST['sts'];
        $_SESSION['sts']=$sts;
        return $this->renderPartial('_form-sales-info',array('form'=>$_SESSION['form'],'model2'=>$_SESSION['model2'],'sts'=>$sts));
    }

    public function actionViewTransaction($id)
    {
        $this->render('viewTransaction',array('id'=>$id));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SalesInvoices the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=SalesInvoices::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SalesInvoices $model the model to be validated
     */
    public function loadReceivedModel($id)
    {
        $model=MoneyReceived::model()->find(array('condition'=>'sales_invoice_id=:invoice AND status=:status','params'=>array(':status'=>1,':invoice'=>$id)));
        return $model;
    }
}

