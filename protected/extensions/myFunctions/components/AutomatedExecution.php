<?php
class AutomatedExecution extends CApplicationComponent{
    public function AutomatedExecutionHandler()
    {
        AutomatedTransactionCustomers::model()->deleteAll();

        $modelCredits=CustomersCredit::model()->findAll(array('order'=>'credited_date'));
        foreach(SalesInvoices::model()->findAll() as $indSalesInv){
            $indSalesInv->credited=0;
            $indSalesInv->save();
        }
        foreach($modelCredits as $indCredits)
        {
            $modelInvoices=SalesInvoices::model()->findAll(array('condition'=>'customer_id=:customer_id','params'=>array(':customer_id'=>$indCredits->customer_id)));
            $temp_ind_credit=$indCredits->amount;
            while($temp_ind_credit>0){
                foreach($modelInvoices as $indInvoices){
                    $actualBalance=$indInvoices->balance-$indInvoices->credited;
                    if($actualBalance>0){
                        $transactionModel=new AutomatedTransactionCustomers;
                        if($temp_ind_credit>=$actualBalance){
                            $indInvoices->credited+=$actualBalance;
                            $temp_ind_credit-=$actualBalance;
                            $amount=$actualBalance;
                        }
                        else{
                            $indInvoices->credited+=$temp_ind_credit;
                            $temp_ind_credit=0;
                            $amount=$temp_ind_credit;
                        }
                        $indInvoices->save();
                        $transactionModel->received_date=$indCredits->credited_date;
                        $transactionModel->customer_id=$indCredits->customer_id;
                        $transactionModel->amount=$amount;
                        $transactionModel->from_sales_invoice_id=$indCredits->credited_from;
                        $transactionModel->to_sales_invoice_id=$indInvoices->id;
                        $transactionModel->save();
                    }
                }
            }

        }
    }
}
?>