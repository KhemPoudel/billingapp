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
    <tr>
        <?php
            $balance=0;
            $PurchasesInvoice=PurchasesInvoices::model()->findByPk($id);
        ?>
        <td><?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style">Edit</span></button>',
                $this->createAbsoluteUrl('purchasesInvoices/update',array('id'=>$id))
            );
            ?>
        </td>
        <td><?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style">View</span></button>',
                $this->createAbsoluteUrl('purchasesInvoices/view',array('id'=>$id))
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
            <?php echo $id;?>
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
                $balance=$PurchasesInvoice->total_amount;
                echo $balance;
            ?>
        </td>
    </tr>
    <?php
        foreach(MoneyPaid::model()->findAll(array('condition'=>'purchases_invoice_id=:invoice','params'=>array(':invoice'=>$id))) as $receipt){
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
                    <?php echo $PurchasesInvoice->supplier_id;?>
                </td>
                <td style="color: red;">
                    <?php
                    echo '-'.$receipt->amount;
                    ?>
                </td>
                <td>
                    <?php
                    $balance-=$receipt->amount;
                    if($balance<0){
                        ?>
                    <span style="color: red;"><?php echo $balance;}?></span>
                    <?php
                    if($balance>=0)
                        echo $balance;
                    ?>
                </td>
            </tr>

        <?php
        }
    ?>
    <?php
    foreach(AutomatedTransactionSuppliers::model()->findAll(array('condition'=>'to_purchases_invoice_id=:invoice','params'=>array(':invoice'=>$id))) as $receipt){
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
                echo 'Automatic credit allocation to purchase invoice #'.$PurchasesInvoice->id;
                ?>
            </td>

            <td>
                <?php echo $PurchasesInvoice->supplier_id;?>
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
    foreach(SuppliersCredit::model()->findAll(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$id))) as $receipt){
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
                echo 'Overpayment on purchase invoice #'.$PurchasesInvoice->id.' transferred to Supplier\'s credit';
                ?>
            </td>

            <td>
                <?php echo $PurchasesInvoice->supplier_id;?>
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
</table>