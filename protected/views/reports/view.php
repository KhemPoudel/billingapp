<?php
$transaction=array();
$transaction['ledger']='General Ledger Transaction';
$transaction['customerStmt']='Customer Statements';
$transaction['supplierStmt']='Supplier Statements';
$transaction['PLStmt']='Profit Loss Statements';
$transaction['inventoryVM']='Inventory Value Movement';
$transaction['inventoryQM']='Inventory Quantity Movement';
$transaction['inventoryPM']='Inventory Profit Margin';
?>

<div class="text-center">
    <h3>Milijuli copy Udhyog</h3>
    <h4><?php echo $transaction[$model->type];?></h4>
    <h5><?php echo 'For the period from '.$model->from_date.' to '.$model->to_date;?></h5>
</div>
<br>
<div>
    <?php
        if($model->type=='ledger'){
            ?>
            <table class="table table-striped">
                <tr>
                    <th colspan="8">Account</th>
                    <th>Debit</th>
                    <th>Credit</th>
                </tr>
               <!------------------------------------- //sales portion begin-------------------->
                <tr>
                    <th colspan="10">Sales Of Inventory Items</th>
                </tr>
                <?php
                    $total_sales=0;
                    foreach(SalesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'issue_date>=:start_date AND issue_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $salesInv){ ?>
                        <tr>
                            <td colspan="8"><?php echo $salesInv->issue_date.'- '.$salesInv->customer->customerName.'-SalesInvoice #'.$salesInv->id?></td>
                            <td></td>
                            <td><?php
                                $total_sales+=$salesInv->total_amount;
                                echo $salesInv->total_amount;
                                ?>
                            </td>
                        </tr>
                    <?php }
                ?>
                <tr>
                    <th colspan="8">Total Sales Of Inventory Items</th>
                    <th>0.00</th>
                    <th><?php echo $total_sales;?></th>
                </tr>

                <tr><td colspan="10"></td></tr>
                <!-----------------------//sales portion end------------------------------------------------>
                <!------------------------Purchases begin-------------------------------------------------->
                <tr>
                    <th colspan="10">Purchases Of Inventory Items</th>
                </tr>
                <?php
                $total_debit_purchases=0;
                foreach(SalesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'issue_date>=:start_date AND issue_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $salesInv){
                    foreach($salesInv->salesInfos as $salesInfo){
                        ?>
                        <tr>
                            <td colspan="8"><?php echo $salesInv->issue_date.'- '.$salesInv->customer->customerName.'-SalesInvoice #'.$salesInv->id.'- '.$salesInfo->item->item_name?></td>

                            <td>
                                <?php
                                $unit_cost_price=0;
                                $total_cost=0;
                                $qty=0;
                                foreach(PurchasesInvoices::model()->findAll(array('condition'=>'issue_date<=:sales_inv_issue_date','params'=>array(':sales_inv_issue_date'=>$salesInv->issue_date))) as $purchasesInv){

                                    foreach($purchasesInv->purchasesInfos as $purchasesInfo){
                                        if($purchasesInfo->item_id==$salesInfo->item_id){
                                            $total_cost+=$purchasesInfo->total_amount;
                                            $qty+=$purchasesInfo->qty;
                                        }

                                    }

                                }
                                if($qty!=0)
                                    $unit_cost_price=$total_cost/$qty;
                                $total_debit_purchases+=$salesInfo->qty*$unit_cost_price;
                                echo $salesInfo->qty*$unit_cost_price;
                                ?>
                            </td>
                            <td></td>
                        </tr>
                    <?php } }
                ?>
                <tr>
                    <th colspan="8">Total Purchases Of Inventory Items</th>
                    <th><?php echo $total_debit_purchases;?></th>
                    <th>0.00</th>
                </tr>

                <tr><td colspan="10"></td></tr>
                <!------------------------Purchase end---------------------------------------------------->
                <!-----------------------------accounts-receivables-begin---------------------->
                <tr>
                    <th colspan="10">Accounts Receivables</th>
                </tr>
                <?php
                $total_debit_receivables=0;
                foreach(SalesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'issue_date>=:start_date AND issue_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $salesInv){ ?>
                    <tr>
                        <td colspan="8"><?php echo $salesInv->issue_date.'- '.$salesInv->customer->customerName.'-SalesInvoice #'.$salesInv->id?></td>
                        <td><?php
                            $total_debit_receivables+=$salesInv->total_amount;
                            echo $salesInv->total_amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>
                <?php }
                $total_credit_receivables=0;
                foreach(MoneyReceived::model()->findAll(array('order'=>'received_date','condition'=>'received_date>=:start_date AND received_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $receipt){ ?>
                <tr>
                    <td colspan="8"><?php echo $receipt->received_date.'- '.$receipt->customer->customerName.'-Receipt #'.$receipt->id?></td>
                    <td></td>
                    <td><?php
                        $total_credit_receivables+=$receipt->amount;
                        echo $receipt->amount;
                        ?>
                    </td>
                </tr>
                <?php }
                foreach(CustomersCredit::model()->findAll(array('order'=>'credited_date','condition'=>'credited_date>=:start_date AND credited_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $creditRow){ ?>
                    <tr>
                        <td colspan="8"><?php echo $creditRow->credited_date.'- '.$creditRow->customer->customerName.'-OverPayment on SalesInvoice #'.$salesInv->id.' transferred to customer credit'?></td>

                        <td><?php
                            $total_debit_receivables+=$creditRow->amount;
                            echo $creditRow->amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>
                <?php }
                foreach(AutomatedTransactionCustomers::model()->findAll(array('condition'=>'received_date>=:start_date AND received_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $transac){ ?>
                    <tr>

                        <td colspan="8"><?php echo $transac->received_date.'- '.$transac->customer->customerName.'-Automatic credit allocation to sales invoice #'.$transac->to_sales_invoice_id;?></td>
                        <td></td>
                        <td><?php
                            $total_credit_receivables+=$transac->amount;
                            echo $transac->amount;
                            ?>
                        </td>
                    </tr>

                <?php }
                ?>
                <tr>
                    <th colspan="8">Total Account Receivables</th>
                    <th><?php echo $total_debit_receivables;?></th>
                    <th><?php echo $total_credit_receivables;?></th>
                </tr>
                <tr><td colspan="10"></td></tr>
                <!----accounts-receivables-end--------------------------------------------------------------------------->
                <!---------cash-on-hand-begin----------------------------------------------------------------------------->
                <tr>
                    <th colspan="10">Cash On Hand</th>
                </tr>
                <?php
                $total_debit_cash=0;
                foreach(MoneyReceived::model()->findAll(array('order'=>'received_date','condition'=>'received_date>=:start_date AND received_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $receipt){ ?>
                <tr>
                    <td colspan="8"><?php echo $receipt->received_date.'- '.$receipt->customer->customerName.'-Receipt #'.$receipt->id?></td>

                    <td><?php
                        $total_debit_cash+=$receipt->amount;
                        echo $receipt->amount;
                        ?>
                    </td>
                    <td></td>
                </tr>
                <?php }
                $total_credit_cash=0;
                foreach(MoneyPaid::model()->findAll(array('order'=>'paid_date','condition'=>'paid_date>=:start_date AND paid_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $receipt){ ?>
                    <tr>
                        <td colspan="8"><?php echo $receipt->paid_date.'- '.$receipt->supplier->supplierName.'-Payment #'.$receipt->id?></td>
                        <td></td>
                        <td><?php
                            $total_credit_cash+=$receipt->amount;
                            echo $receipt->amount;
                            ?>
                        </td>

                    </tr>
                <?php }
                ?>
                <tr>
                    <th colspan="8">Total Cash On Hand</th>
                    <th><?php echo $total_debit_cash;?></th>
                    <th><?php echo $total_credit_cash;?></th>
                </tr>
                <tr><td colspan="10"></td></tr>
                <!--------------------------------------------//cash-on-hand-end----------------------------->
                <!--------------------------------------------inventory on hand start------------------------->
                <tr>
                    <th colspan="10">
                        Inventory On Hand
                    </th>
                </tr>
                <?php
                $total_debit_invoice=0;
                foreach(PurchasesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'issue_date>=:start_date AND issue_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $purchasesInv){
                    foreach($purchasesInv->purchasesInfos as $purchasesInfo){
                    ?>
                    <tr>
                        <td colspan="8"><?php echo $purchasesInv->issue_date.'- '.$purchasesInv->supplier->supplierName.'- '.$purchasesInfo->item->item_name?></td>

                        <td><?php
                            $total_debit_invoice+=$purchasesInfo->total_amount;
                            echo $purchasesInfo->total_amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>
                <?php } }
                ?>
                <?php
                $total_credit_invoice=0;
                foreach(SalesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'issue_date>=:start_date AND issue_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $salesInv){
                    foreach($salesInv->salesInfos as $salesInfo){
                    ?>
                    <tr>
                        <td colspan="8"><?php echo $salesInv->issue_date.'- '.$salesInv->customer->customerName.'-SalesInvoice #'.$salesInv->id.'- '.$salesInfo->item->item_name?></td>
                        <td></td>
                        <td>
                            <?php
                            $unit_cost_price=0;
                            $total_cost=0;
                            $qty=0;
                            foreach(PurchasesInvoices::model()->findAll(array('condition'=>'issue_date<=:sales_inv_issue_date','params'=>array(':sales_inv_issue_date'=>$salesInv->issue_date))) as $purchasesInv){

                                foreach($purchasesInv->purchasesInfos as $purchasesInfo){
                                    if($purchasesInfo->item_id==$salesInfo->item_id){
                                        $total_cost+=$purchasesInfo->total_amount;
                                        $qty+=$purchasesInfo->qty;
                                    }

                                }

                            }
                            if($qty!=0)
                                $unit_cost_price=$total_cost/$qty;
                            $total_credit_invoice+=$salesInfo->qty*$unit_cost_price;
                            echo $salesInfo->qty*$unit_cost_price;
                            ?>
                        </td>
                    </tr>
                <?php } }
                ?>
                <tr>
                    <th colspan="8">Total Inventory On Hand</th>
                    <th><?php echo $total_debit_invoice;?></th>
                    <th><?php echo $total_credit_invoice;?></th>
                </tr>

                <tr><td colspan="10"></td></tr>
                <!-------------------------------------------inventory on hand end------------------------->
                <!------------------------------------------accounts payable start------------------------->
                <tr>
                    <th colspan="10">Accounts Payables</th>
                </tr>
                <?php
                $total_credit_payables=0;
                foreach(PurchasesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'issue_date>=:start_date AND issue_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $purchasesInv){ ?>
                    <tr>
                        <td colspan="8"><?php echo $purchasesInv->issue_date.'- '.$purchasesInv->supplier->supplierName.'-PurchasesInvoice #'.$purchasesInv->id?></td>
                        <td></td>
                        <td><?php
                            $total_credit_payables+=$purchasesInv->total_amount;
                            echo $purchasesInv->total_amount;
                            ?>
                        </td>

                    </tr>
                <?php }
                $total_debit_payables=0;
                foreach(MoneyPaid::model()->findAll(array('order'=>'paid_date','condition'=>'paid_date>=:start_date AND paid_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $receipt){ ?>
                    <tr>
                        <td colspan="8"><?php echo $receipt->paid_date.'- '.$receipt->supplier->supplierName.'-Payment #'.$receipt->id?></td>

                        <td><?php
                            $total_debit_payables+=$receipt->amount;
                            echo $receipt->amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>
                <?php }
                foreach(SuppliersCredit::model()->findAll(array('order'=>'credited_date','condition'=>'credited_date>=:start_date AND credited_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $creditRow){ ?>
                    <tr>
                        <td colspan="8"><?php echo $creditRow->credited_date.'- '.$creditRow->supplier->supplierName.'-OverPayment on SalesInvoice #'.$purchasesInv->id.' transferred to customer credit'?></td>
                        <td></td>
                        <td><?php
                            $total_credit_payables+=$creditRow->amount;
                            echo $creditRow->amount;
                            ?>
                        </td>

                    </tr>
                <?php }
                foreach(AutomatedTransactionSuppliers::model()->findAll(array('condition'=>'paid_date>=:start_date AND paid_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $transac){ ?>
                    <tr>

                        <td colspan="8"><?php echo $transac->paid_date.'- '.$transac->supplier->supplierName.'-Automatic credit allocation to sales invoice #'.$transac->to_purchases_invoice_id;?></td>

                        <td><?php
                            $total_debit_payables+=$transac->amount;
                            echo $transac->amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>

                <?php }
                ?>
                <tr>
                    <th colspan="8">Total Account Payables</th>
                    <th><?php echo $total_debit_payables;?></th>
                    <th><?php echo $total_credit_payables;?></th>
                </tr>
                <tr><td colspan="10"></td></tr>
            <!----------------------------------------------account payables end-------------------------------->
            <!-----------------------------customer credits start------------------------------------------------->
                <tr>
                    <th colspan="10">Customers Credit</th>
                </tr>
                <?php
                $total_debit_customerCredit=0;
                $total_credit_customerCredit=0;
                foreach(CustomersCredit::model()->findAll(array('order'=>'credited_date','condition'=>'credited_date>=:start_date AND credited_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $creditRow){ ?>
                    <tr>
                        <td colspan="8"><?php echo $creditRow->credited_date.'- '.$creditRow->customer->customerName.'-OverPayment on SalesInvoice #'.$salesInv->id.' transferred to customer credit'?></td>
                        <td></td>
                        <td><?php
                            $total_credit_customerCredit+=$creditRow->amount;
                            echo $creditRow->amount;
                            ?>
                        </td>

                    </tr>

                <?php }
                foreach(AutomatedTransactionCustomers::model()->findAll(array('condition'=>'received_date>=:start_date AND received_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $transac){ ?>
                    <tr>

                        <td colspan="8"><?php echo $transac->received_date.'- '.$transac->customer->customerName.'-Automatic credit allocation to sales invoice #'.$transac->to_sales_invoice_id;?></td>

                        <td><?php
                            $total_debit_customerCredit+=$transac->amount;
                            echo $transac->amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>

                <?php }
                ?>
                <tr>
                    <th colspan="8">Total Customer Credits</th>
                    <th><?php echo $total_debit_customerCredit;?></th>
                    <th><?php echo $total_credit_customerCredit;?></th>
                </tr>
                <tr><td colspan="10"></td></tr>
            <!----------------------------------customer credit end----------------------------------------------------------->
                <tr>
                    <th colspan="8">Suppliers Credit</th>
                </tr>
                <?php
                $total_credit_suppliersCredit=0;
                $total_debit_suppliersCredit=0;
                foreach(SuppliersCredit::model()->findAll(array('order'=>'credited_date','condition'=>'credited_date>=:start_date AND credited_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $creditRow){ ?>
                <tr>
                    <td colspan="8"><?php echo $creditRow->credited_date.'- '.$creditRow->supplier->supplierName.'-OverPayment on purchases invoice #'.$creditRow->credited_from.' transferred to customer credit'?></td>

                    <td><?php
                        $total_debit_suppliersCredit+=$creditRow->amount;
                        echo $creditRow->amount;
                        ?>
                    </td>
                    <td></td>
                </tr>
                <?php }
                foreach(AutomatedTransactionSuppliers::model()->findAll(array('condition'=>'paid_date>=:start_date AND paid_date<=:end_date','params'=>array(':start_date'=>$model->from_date,':end_date'=>$model->to_date))) as $transac){ ?>
                    <tr>

                        <td colspan="8"><?php echo $transac->paid_date.'- '.$transac->supplier->supplierName.'-Automatic credit allocation to purchases invoice #'.$transac->to_purchases_invoice_id;?></td>

                        <td><?php
                            $total_debit_suppliersCredit+=$transac->amount;
                            echo $transac->amount;
                            ?>
                        </td>
                        <td></td>
                    </tr>

                <?php }
                ?>
                <tr>
                    <th colspan="8">Total Supplier Credits</th>
                    <th><?php echo $total_debit_suppliersCredit;?></th>
                    <th><?php echo $total_credit_suppliersCredit;?></th>
                </tr>
                <tr><td colspan="10"></td></tr>
            <!-----------------------------------------------supplier credit end------------------------------------------------>
                <?php
                    $ledger_credit=$total_sales+$total_credit_receivables+$total_credit_invoice+$total_credit_customerCredit+$total_credit_suppliersCredit+$total_credit_payables+$total_credit_cash;
                    $ledger_debit=$total_debit_payables+$total_debit_suppliersCredit+$total_debit_customerCredit+$total_debit_purchases+$total_debit_receivables+$total_debit_invoice+$total_debit_cash;

                ?>
            <tr>
                <th colspan="8"></th>
                <th>
                    <?php
                        echo $ledger_debit;
                    ?>
                </th>
                <th>
                    <?php
                        echo $ledger_credit;
                    ?>
                </th>
            </tr>
            </table>
            <br>

       <?php }
    ?>
</div>