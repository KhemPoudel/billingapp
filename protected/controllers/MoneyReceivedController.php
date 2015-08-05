<?php

class MoneyReceivedController extends Controller
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
		$model=new MoneyReceived;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MoneyReceived']))
		{
			$model->attributes=$_POST['MoneyReceived'];
            $model->sales_invoice_id=$InvoiceId;
            $total_received=0;

            $model1=SalesInvoices::model()->findByPk($InvoiceId);
            $model->customer_id=$model1->customer_id;
            $model->save();
            foreach(MoneyReceived::model()->findAll(array('condition'=>'sales_invoice_id=:invoice','params'=>array(':invoice'=>$model->sales_invoice_id))) as $receipts){
                $total_received+=$receipts->amount;
            }
            $tempBalance=$model1->total_amount-$total_received;
            $creditRow=CustomersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$InvoiceId)));
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
                    $creditRow->credited_from=$InvoiceId;
                    $creditRow->customer_id=$model1->customer_id;
                }
                $creditRow->amount=-1*$tempBalance;
                $creditRow->credited_date=$model->received_date;
                $creditRow->customer_id=$model1->customer_id;
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
        $InvoiceId=MoneyReceived::model()->findByPk($id)->sales_invoice_id;
		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['MoneyReceived']))
        {
            $model->attributes=$_POST['MoneyReceived'];
            $model->sales_invoice_id=$InvoiceId;
            $total_received=0;

            $model1=SalesInvoices::model()->findByPk($InvoiceId);
            $model->customer_id=$model1->customer_id;
            $model->save();
            foreach(MoneyReceived::model()->findAll(array('condition'=>'sales_invoice_id=:invoice','params'=>array(':invoice'=>$model->sales_invoice_id))) as $receipts){
                $total_received+=$receipts->amount;
            }
            $tempBalance=$model1->total_amount-$total_received;
            $creditRow=CustomersCredit::model()->find(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$InvoiceId)));
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
                    $creditRow->credited_from=$InvoiceId;
                    $creditRow->customer_id=$model1->customer_id;
                }
                $creditRow->amount=-1*$tempBalance;
                $creditRow->credited_date=$model->received_date;
                $creditRow->customer_id=$model1->customer_id;
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

        $invoiceId=MoneyReceived::model()->find(array('condition'=>':invoice','params'=>array(':invoice'=>$id)))->sales_invoice_id;
        $this->redirect(array('salesInvoices/view','id'=>$invoiceId));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MoneyReceived');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MoneyReceived('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MoneyReceived']))
			$model->attributes=$_GET['MoneyReceived'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MoneyReceived the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MoneyReceived::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MoneyReceived $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='money-received-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

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
                    foreach($creditTakerInvoices as $creditTakerInv){
                        $creditToPay=$creditTakerInv->balance-$creditTakerInv->credited;
                        $this->GetCreditfor($creditTakerInv,$creditToPay);
                    }
                }
                if($customersCredit->amount==0)
                    $customersCredit->delete();
                else{
                    $customersCredit->credit_assigned=$customersCredit->amount;
                    $customersCredit->save();
                }
            }
        }
        if($mode=='delete'){
            $salesInv->delete();
            $this->redirect(array('index'));
        }
        $this->redirect(array('salesInvoices/view','id'=>$id));
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
            if($remainingCredit==0){
                //break;
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
}
