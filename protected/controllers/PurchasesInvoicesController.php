<?php

class PurchasesInvoicesController extends Controller
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
        $model1=new PurchasesInvoices;
        $model2=new PurchasesInfo;
        $paidModel=new MoneyPaid;

        if(isset($_POST['PurchasesInvoices']))
        {
            $model1->attributes=$_POST['PurchasesInvoices'];
            $model1->save();
            $purchases_invoice_id=$model1->id;
            if(isset($_POST['PurchasesInfo']))
            {
                $testModel=array();
                while($i<=$_SESSION['sts'])
                {
                    $testModel[$i]=new PurchasesInfo;
                    if(isset($_POST['PurchasesInfo'][$i]))
                    {
                        $testModel[$i]->attributes=$_POST['PurchasesInfo'][$i];
                        $testModel[$i]->purchases_invoice_id=$purchases_invoice_id;
                        if(!empty($testModel[$i]->total_amount))
                        {
                            $testModel[$i]->save();
                            $item=InventoryItems::model()->findByPk($testModel[$i]->item_id);
                            $item->qty+=$testModel[$i]->qty;
                            $item->save();
                        }
                    }
                    $i++;
                }

            }
            if(isset($_POST['MoneyPaid']))
            {
                $paidModel->attributes=$_POST['MoneyPaid'];
                $paidModel->paid_date=$model1->issue_date;
                $paidModel->purchases_invoice_id=$model1->id;
                $paidModel->supplier_id=$model1->supplier_id;
                $paidModel->status=1;
                if($paidModel->save())
                {
                    $balance=($paidModel->amount)*1.0-($model1->total_amount)*1.0;
                    if($balance<=0){
                        $model1->balance=$balance*(-1.0);
                    }
                    else{
                        $model1->balance=0;
                        $creditModel=new SuppliersCredit;
                        $creditModel->amount=$balance;
                        $creditModel->credited_from=$model1->id;
                        $creditModel->supplier_id=$model1->supplier_id;
                        $creditModel->credited_date=$model1->issue_date;
                        $creditModel->save();
                    }
                    //PurchasesInvoices::model()->findByPk($model1->id)->delete();
                    $model1->save();
                    //Yii::app()->AutomatedExecution->AutomatedExecutionHandler();
                }
            }
            $this->redirect(array('AutomatedTransaction','id'=>$model1->id,'mode'=>'create'));
        }

        $this->render('create',array(
            'model1'=>$model1,
            'model2'=>$model2,
            'paidModel'=>$paidModel
        ));
    }



    /*------------------------------Automated transaction start-----------------------------------------------------------*/
    public function  actionAutomatedTransaction($id,$mode)
    {
        $purchasesInv=PurchasesInvoices::model()->findByPk($id);
        $suppliersCredit=SuppliersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$id)));
        $remainingCredit=$purchasesInv->credited-$purchasesInv->balance;
        if($remainingCredit>0){
            $purchasesInv->credited=$purchasesInv->balance;
            $modelsCreditedFrom=AutomatedTransactionSuppliers::model()->findAll(array(
                'condition'=>'to_purchases_invoice_id=:invoice_id','params'=>array(':invoice_id'=>$purchasesInv->id)));
            $creditedModels=array();
            foreach($modelsCreditedFrom as $indCredited)
            {
                $i=0;
                $creditAssigned=$indCredited->amount;
                $creditedModel=SuppliersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$indCredited->from_purchases_invoice_id)));

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
            $purchasesInv->save();
            foreach($creditedModels as $indvCredited)
            {
                $this->TransferringCredit($indvCredited);
            }
        }
        else{
            if($remainingCredit<0){
                $remainingCredit=-1*$remainingCredit;
                $this->GetCreditfor($purchasesInv,$remainingCredit);
            }

        }
        if(isset($suppliersCredit)){
            $creditRemainingOfThisModel=$suppliersCredit->amount-$suppliersCredit->credit_assigned;
            if($creditRemainingOfThisModel>0){
                $this->TransferringCredit($suppliersCredit);
            }
            else
            {
                if($creditRemainingOfThisModel<0){
                    $overAssignedCredit=-1*$creditRemainingOfThisModel;
                    $creditTakers=AutomatedTransactionSuppliers::model()->findAll(array('condition'=>'from_purchases_invoice_id=:invoice','params'=>array(':invoice'=>$suppliersCredit->credited_from)));
                    $creditTakerInvoices=array();
                    $i=0;
                    foreach($creditTakers as $creditTaker){
                        if($overAssignedCredit>0){
                            $creditTakerInvoice=PurchasesInvoices::model()->findByPk($creditTaker->to_purchases_invoice_id);
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
                if($suppliersCredit->amount==0)
                    $suppliersCredit->delete();
                else{
                    $suppliersCredit->credit_assigned=$suppliersCredit->amount;
                    $suppliersCredit->save();
                }
                foreach($creditTakerInvoices as $creditTakerInv){
                    $creditToPay=$creditTakerInv->balance-$creditTakerInv->credited;
                    $this->GetCreditfor($creditTakerInv,$creditToPay);
                }
            }
        }
        if($mode=='delete'){
            $purchasesInv->delete();
            $this->redirect(array('index'));
        }
        $this->redirect(array('view','id'=>$id));
    }
    public function TransferringCredit($indvCredited)
    {
        $creditRemainingOfThisModel=$indvCredited->amount-$indvCredited->credit_assigned;
        foreach(PurchasesInvoices::model()->findAll(array('condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$indvCredited->supplier_id))) as $indvPurchasesInvoice){
            if($creditRemainingOfThisModel>0){
                //echo $creditRemainingOfThisModel;
                $amountToGetBalanced=$indvPurchasesInvoice->balance-$indvPurchasesInvoice->credited;
                //echo $amountToGetBalanced;

                if($amountToGetBalanced>0){
                    if($creditRemainingOfThisModel>$amountToGetBalanced){
                        $amountCredited=$amountToGetBalanced;
                    }
                    else{
                        $amountCredited=$creditRemainingOfThisModel;
                    }
                    $indvPurchasesInvoice->credited+=$amountCredited;
                    $indvCredited->credit_assigned+=$amountCredited;
                    $creditRemainingOfThisModel-=$amountCredited;
                    $transaction=new AutomatedTransactionSuppliers;
                    $transaction->paid_date=$indvCredited->credited_date;
                    $transaction->supplier_id=$indvCredited->supplier_id;
                    $transaction->from_purchases_invoice_id=$indvCredited->credited_from;
                    $transaction->to_purchases_invoice_id=$indvPurchasesInvoice->id;
                    $transaction->amount=$amountCredited;
                    $indvPurchasesInvoice->save();
                    $indvCredited->save();
                    $transaction->save();
                }
            }
            else{

            }

        }
    }

    public function GetCreditfor($purchasesInvoice,$remainingCredit)
    {
        foreach(SuppliersCredit::model()->findAll(array('condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$purchasesInvoice->supplier_id))) as $indModel){
            $creditRemained=$indModel->amount-$indModel->credit_assigned;
            if($remainingCredit<=0){
                break;
            }

            else{
                if($creditRemained>$remainingCredit)
                    $creditBorrowed=$remainingCredit;
                else
                    $creditBorrowed=$creditRemained;
                $transaction=new AutomatedTransactionSuppliers;
                $transaction->paid_date=$indModel->credited_date;
                $transaction->from_purchases_invoice_id=$indModel->credited_from;
                $transaction->to_purchases_invoice_id=$purchasesInvoice->id;
                $transaction->amount=$creditBorrowed;
                $transaction->supplier_id=$purchasesInvoice->supplier_id;
                $indModel->credit_assigned+=$creditBorrowed;
                $purchasesInvoice->credited+=$creditBorrowed;
                $purchasesInvoice->save();
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
        $model2=$model1->purchasesInfos;
        $paidModel=$this->loadpaidModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['PurchasesInvoices']))
        {
            $model1->attributes=$_POST['PurchasesInvoices'];
            $model1->save();
            $purchases_invoice_id=$model1->id;
            if(isset($_POST['PurchasesInfo']))
            {
                $item_qty=array();
                foreach($model2 as $cnt=>$indModel)
                {
                    $item_qty[$cnt]=$indModel->qty;
                    $indModel->delete();
                }
                while($i<=$_SESSION['sts'])
                {
                    if(isset($_POST['PurchasesInfo'][$i]))
                    {
                        $indModel=new PurchasesInfo;
                        $indModel->attributes=$_POST['PurchasesInfo'][$i];
                        $indModel->purchases_invoice_id=$purchases_invoice_id;
                        $indModel->save();
                        $item=InventoryItems::model()->findByPk($indModel->item_id);
                        $item->qty+=($indModel->qty-$item_qty[$i]);
                        $item->save();
                    }
                    $i++;
                }
                //$model2->save();
            }
            if(isset($_POST['MoneyPaid']))
            {
                $paidModel->attributes=$_POST['MoneyPaid'];
                $paidModel->save();
                $total_paid=0;
                foreach(MoneyPaid::model()->findAll(array('condition'=>'purchases_invoice_id=:invoice','params'=>array(':invoice'=>$id))) as $receipts){
                    $total_paid+=$receipts->amount;
                }
                $tempBalance=$model1->total_amount-$total_paid;
                $creditRow=SuppliersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$id)));
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
                        $creditRow=new SuppliersCredit;
                        $creditRow->credited_from=$id;
                        $creditRow->supplier_id=$model1->supplier_id;
                    }
                    $creditRow->amount=-1*$tempBalance;
                    $creditRow->credited_date=$model1->issue_date;
                    $creditRow->supplier_id=$model1->supplier_id;
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
            'paidModel'=>$paidModel
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
        $creditModel=SuppliersCredit::model()->find(array('condition'=>'credited_from=:id','params'=>array(':id'=>$id)));
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

        if(isset($_GET['supplier']))
        {
            $criteria=new CDbCriteria();
            $criteria->condition='supplier_id=:supplier_id';
            $criteria->params=array(':supplier_id'=>$_GET['supplier']);
            $count=PurchasesInvoices::model()->count($criteria);
            $pages=new CPagination($count);
            // results per page
            $pages->pageSize=10;
            $pages->applyLimit($criteria);
            $models=PurchasesInvoices::model()->with('supplier')->findAll($criteria);
        }
        else
        {
            $criteria=new CDbCriteria();
            $count=PurchasesInvoices::model()->count($criteria);
            $pages=new CPagination($count);
            // results per page
            $pages->pageSize=10;
            $pages->applyLimit($criteria);
            $models=PurchasesInvoices::model()->with('supplier')->findAll($criteria);
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
        $model=new PurchasesInvoices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['PurchasesInvoices']))
            $model->attributes=$_GET['PurchasesInvoices'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionGetNewForm()
    {
        $sts=$_POST['sts'];
        $_SESSION['sts']=$sts;
        return $this->renderPartial('_form-purchases-info',array('form'=>$_SESSION['form'],'model2'=>$_SESSION['model2'],'sts'=>$sts));
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
        $model=PurchasesInvoices::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SalesInvoices $model the model to be validated
     */
    public function loadpaidModel($id)
    {
        $model=MoneyPaid::model()->find(array('condition'=>'purchases_invoice_id=:invoice AND status=:status','params'=>array(':status'=>1,':invoice'=>$id)));
        return $model;
    }
}

