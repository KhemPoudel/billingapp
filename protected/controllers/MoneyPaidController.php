<?php

class MoneyPaidController extends Controller
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
                'actions'=>array('index','view','automatedTransaction'),
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
        $InvoiceId=$_GET['id'];
        $model=new MoneyPaid;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['MoneyPaid']))
        {
            $model->attributes=$_POST['MoneyPaid'];
            $model->purchases_invoice_id=$InvoiceId;
            $total_paid=0;
            $model1=PurchasesInvoices::model()->findByPk($InvoiceId);
            $model->supplier_id=$model1->supplier_id;
            $model->save();

            foreach(MoneyPaid::model()->findAll(array('condition'=>'purchases_invoice_id=:invoice','params'=>array(':invoice'=>$InvoiceId))) as $receipts){
                $total_paid+=$receipts->amount;
            }
            $tempBalance=$model1->total_amount-$total_paid;
            $creditRow=SuppliersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$InvoiceId)));
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
                    $creditRow->credited_from=$InvoiceId;
                    $creditRow->supplier_id=$model1->supplier_id;
                }
                $creditRow->amount=-1*$tempBalance;
                $creditRow->credited_date=$model->paid_date;
                $creditRow->supplier_id=$model1->supplier_id;
                $creditRow->save();
            }
            $model1->save();

            $this->redirect(array('automatedTransaction','id'=>$model1->id,'mode'=>''));
        }

        $this->render('create',array(
            'model'=>$model,
            'id'=>$InvoiceId
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $InvoiceId=MoneyPaid::model()->findByPk($id)->purchases_invoice_id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['MoneyPaid']))
        {
            $model->attributes=$_POST['MoneyPaid'];
            $model->purchases_invoice_id=$InvoiceId;
            $total_paid=0;
            $model1=PurchasesInvoices::model()->findByPk($InvoiceId);
            $model->supplier_id=$model1->supplier_id;
            $model->save();

            foreach(MoneyPaid::model()->findAll(array('condition'=>'purchases_invoice_id=:invoice','params'=>array(':invoice'=>$InvoiceId))) as $receipts){
                $total_paid+=$receipts->amount;
            }
            $tempBalance=$model1->total_amount-$total_paid;
            $creditRow=SuppliersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$InvoiceId)));
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
                    $creditRow->credited_from=$InvoiceId;
                    $creditRow->supplier_id=$model1->supplier_id;
                }
                $creditRow->amount=-1*$tempBalance;
                $creditRow->credited_date=$model->paid_date;
                $creditRow->supplier_id=$model1->supplier_id;
                $creditRow->save();
            }
            $model1->save();

            $this->redirect(array('automatedTransaction','id'=>$model1->id,'mode'=>''));
        }

        $this->render('update',array(
            'model'=>$model,
            'id'=>$InvoiceId
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        $invoiceId=MoneyPaid::model()->find(array('condition'=>':invoice','params'=>array(':invoice'=>$id)))->purchases_invoice_id;
        $this->redirect(array('purchasesInvoices/view','id'=>$invoiceId));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('MoneyPaid');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new MoneyPaid('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['MoneyPaid']))
            $model->attributes=$_GET['MoneyPaid'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MoneyPaid the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=MoneyPaid::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MoneyPaid $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='money-paid-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

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
                    foreach($creditTakerInvoices as $creditTakerInv){
                        $creditToPay=$creditTakerInv->balance-$creditTakerInv->credited;
                        $this->GetCreditfor($creditTakerInv,$creditToPay);
                    }
                }
                if($suppliersCredit->amount==0)
                    $suppliersCredit->delete();
                else{
                    $suppliersCredit->credit_assigned=$suppliersCredit->amount;
                    $suppliersCredit->save();
                }
            }
        }
        if($mode=='delete'){
            $purchasesInv->delete();
            $this->redirect(array('purchasesInvoices/index'));
        }
        $this->redirect(array('purchasesInvoices/view','id'=>$id));
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
            if($remainingCredit==0){
                //break;
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
}
