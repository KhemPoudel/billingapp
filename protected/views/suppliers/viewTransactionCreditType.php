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
