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
            $SalesInvoice=SalesInvoices::model()->findByPk($id);
        ?>
        <td><?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style">Edit</span></button>',
                $this->createAbsoluteUrl('salesInvoices/update',array('id'=>$id))
            );
            ?>
        </td>
        <td><?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style">View</span></button>',
                $this->createAbsoluteUrl('salesInvoices/view',array('id'=>$id))
            );
            ?>
        </td>
        <td>
            <?php echo $SalesInvoice->issue_date?>
        </td>
        <td>
            Sales Invoice
        </td>
        <td>
            <?php echo $id;?>
        </td>
        <td>

        </td>
        <td>
            <?php echo $SalesInvoice->customer_id;?>
        </td>
        <td>
            <?php echo $SalesInvoice->total_amount;?>
        </td>
        <td>
            <?php
                $balance=$SalesInvoice->total_amount;
                echo $balance;
            ?>
        </td>
    </tr>
    <?php
        foreach(MoneyReceived::model()->findAll(array('condition'=>'sales_invoice_id=:invoice','params'=>array(':invoice'=>$id))) as $receipt){
            ?>
            <tr>
                <td>
                    <?php
                    echo CHtml::link(
                        '<button class="btn btn-default btn-sm"><span class="btn-label-style">Edit</span></button>',
                        $this->createAbsoluteUrl('moneyReceived/update',array('id'=>$receipt->id))
                    );
                    ?>
                </td>
                <td>

                </td>
                <td>
                    <?php
                        echo $receipt->received_date;
                    ?>
                </td>
                <td>
                    <?php
                        echo 'Receive Money';
                    ?>
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    <?php echo $SalesInvoice->customer_id;?>
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
    foreach(AutomatedTransactionCustomers::model()->findAll(array('condition'=>'to_sales_invoice_id=:invoice','params'=>array(':invoice'=>$id))) as $receipt){
        ?>
        <tr>
            <td>
            </td>
            <td>

            </td>
            <td>
                <?php
                echo $receipt->received_date;
                ?>
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <?php
                echo 'Automatic credit allocation to sales invoice #'.$SalesInvoice->id;
                ?>
            </td>

            <td>
                <?php echo $SalesInvoice->customer_id;?>
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
    foreach(CustomersCredit::model()->findAll(array('condition'=>'credited_from=:invoice','params'=>array(':invoice'=>$id))) as $receipt){
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
                echo 'Overpayment on sales invoice #'.$SalesInvoice->id.' transferred to customer\'s credit';
                ?>
            </td>

            <td>
                <?php echo $SalesInvoice->customer_id;?>
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