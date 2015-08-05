<?php
class AutomatedClass{
    public static function AutomatedTransaction($id,$mode){
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
                AutomatedClass::TransferringCredit($indvCredited);
            }
        }
        else{
            if($remainingCredit<0){
                $remainingCredit=-1*$remainingCredit;
                AutomatedClass::GetCreditfor($salesInv,$remainingCredit);
            }

        }
        if(isset($customersCredit)){
            $creditRemainingOfThisModel=$customersCredit->amount-$customersCredit->credit_assigned;
            if($creditRemainingOfThisModel>0){
                AutomatedClass::TransferringCredit($customersCredit);
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
                    AutomatedClass::GetCreditfor($creditTakerInv,$creditToPay);
                }
            }
        }
    }
    public static function TransferringCredit($indvCredited)
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

    public static function GetCreditfor($salesInvoice,$remainingCredit)
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
}

?>