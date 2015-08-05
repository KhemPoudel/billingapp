<table class="table table-bordered">
    <tr>
        <th>Edit</th>
        <th>View</th>
        <th>Date</th>
        <th>Transacation</th>
        <th>#</th>
        <th>Description</th>
        <th>Contact</th>
        <th>Amount</th>
        <th>Balance</th>
    </tr>
    <?php
    $balance=0;
    $PurchasesInvoices=PurchasesInvoices::model()->findAll(array('order'=>'issue_date','condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$id)));
    foreach($PurchasesInvoices as $PurchasesInvoice){
    ?>
        <tr>
            <td><?php
                echo CHtml::link(
                    '<button class="btn btn-default btn-sm"><span class="btn-label-style">Edit</span></button>',
                    $this->createAbsoluteUrl('PurchasesInvoices/update',array('id'=>$PurchasesInvoice->id))
                );
                ?>
            </td>
            <td><?php
                echo CHtml::link(
                    '<button class="btn btn-default btn-sm"><span class="btn-label-style">View</span></button>',
                    $this->createAbsoluteUrl('purchasesInvoices/view',array('id'=>$PurchasesInvoice->id))
                );
                ?>
            </td>
            <td>
                <?php echo $PurchasesInvoice->issue_date?>
            </td>
            <td>
                Purchases Invoice
            </td>
            <td>
                <?php echo $PurchasesInvoice->id;?>
            </td>
            <td>

            </td>
            <td>
                <?php echo $PurchasesInvoice->supplier_id;?>
            </td>
            <td>
                <?php echo $PurchasesInvoice->total_amount;?>
            </td>
            <td>
                <?php
                $balance+=$PurchasesInvoice->total_amount;
                echo $balance;
                ?>
            </td>
        </tr>
    <?php
        }
    ?>

    <?php
        foreach(MoneyPaid::model()->findAll(array('order'=>'paid_date','condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$id))) as $receipt){
            ?>
            <tr>
                <td>
                    <?php
                    echo CHtml::link(
                        '<button class="btn btn-default btn-sm"><span class="btn-label-style">Edit</span></button>',
                        $this->createAbsoluteUrl('moneyPaid/update',array('id'=>$receipt->id))
                    );
                    ?>
                </td>
                <td>

                </td>
                <td>
                    <?php
                        echo $receipt->paid_date;
                    ?>
                </td>
                <td>
                    <?php
                        echo 'Pay Money';
                    ?>
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    <?php echo $receipt->supplier_id;?>
                </td>
                <td style="color: red;">
                    <?php
                    echo '-'.$receipt->amount;
                    ?>
                </td>
                <td>
                    <?php
                    $balance-=$receipt->amount;
                    echo $balance;
                    ?>
                </td>
            </tr>

        <?php
        }
    ?>

    <?php
    foreach(SuppliersCredit::model()->findAll(array('order'=>'credited_date','condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$id))) as $receipt){
        ?>
        <tr>
            <td>
            </td>
            <td>

            </td>
            <td>
                <?php
                echo $receipt->credited_date;
                ?>
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <?php
                echo 'Overpayment on purchases invoice #'.$receipt->credited_from.' transferred to supplier\'s credit';
                ?>
            </td>

            <td>
                <?php echo $receipt->supplier_id;?>
            </td>
            <td>
                <?php
                echo $receipt->amount;
                ?>
            </td>
            <td>
                <?php
                $balance+=$receipt->amount;
                echo $balance;
                ?>
            </td>
        </tr>
    <?php
    }
    ?>
    <?php
    foreach(AutomatedTransactionSuppliers::model()->findAll(array('order'=>'paid_date','condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$id))) as $receipt){
        ?>
        <tr>
            <td>
            </td>
            <td>

            </td>
            <td>
                <?php
                echo $receipt->paid_date;
                ?>
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <?php
                echo 'Automatic credit allocation to purchases invoice #'.$receipt->to_purchases_invoice_id;
                ?>
            </td>

            <td>
                <?php echo $receipt->supplier_id;?>
            </td>
            <td style="color: red;">
                <?php
                echo '-'.$receipt->amount;
                ?>
            </td>
            <td>
                <?php
                $balance-=$receipt->amount;
                echo $balance;
                ?>
            </td>
        </tr>
    <?php
    }
    ?>

</table>