<?php
$modelPurchasesInfos=$model->purchasesInfos;
?>
    <div class="btn-group" style="margin-top: -2%;">
        <?php echo CHtml::link('<button class="btn btn-default"><span class="btn-label-style">Edit</span></button>',array('update','id'=>$model->id)); ?>
        <button type="button" id="" class="btn">Print</button>
        <?php echo CHtml::link('<button class="btn btn-default"><span class="btn-label-style">Pay Money</span></button>',array('moneyPaid/create','id'=>$model->id)); ?>
    </div>
    <div id="printable_view" style="background-color: #ffffff;width: 50%;height: 75%;margin-left: 25%;">
        <div style="font-family: 'Baskerville';text-align: center;">
            <h3>MILIJULI COPY UDHYOG</h3>
            <h4 style="margin-top: -1%;">Srijana Chowk, Pokhara</h4>
            <h5 style="margin-top: -0.5%;">Contact: 9812345670</h5>
        </div>
        <div style="float: right;font-family: calibri;margin-right: 5%;">
            <b>Issue Date</b><br>
            <span><?php echo $model->issue_date;?></span><br><br>
            <b>Invoice Number</b><br>
            <span><?php echo $model->id;?></span>
        </div>
        <br>
        <div style="font-family: calibri;line-break: loose;">
            <b>To:</b>
        <span><?php $supplierModel= Suppliers::model()->findByPk($model->supplier_id);
            echo $supplierModel->supplierName;
            ?></span><br>
            <b>PAN Address:</b> <span><?php echo $supplierModel->PANNumber;?></span><br>
            <b>Billing Address:</b><span><?php echo $supplierModel->BillingAddress;?></span>
        </div>
        <br>
        <br>
        <div style="border: 2px inset #000000;">
            <table>
                <tr>
                    <td class="bottom-bordered">
                        <b>S.No.</b>
                    </td>
                    <td class="left-bordered bottom-bordered">
                        <b>Items</b>
                    </td>
                    <td class="left-bordered bottom-bordered">
                        <b>Unit Price</b>
                    </td>
                    <td class="left-bordered bottom-bordered">
                        <b>Qty</b>
                    </td>
                    <td class="left-bordered bottom-bordered">
                        <b>Amount</b>
                    </td>
                </tr>
                <?php foreach($modelPurchasesInfos as $serialNum=>$indModel)
                {
                    ?>
                    <tr>
                        <td>
                            <?php echo $serialNum;?>
                        </td>
                        <td class="left-bordered">
                            <?php echo InventoryItems::model()->findByPk($indModel->item_id)->item_name;?>
                        </td>
                        <td class="left-bordered">
                            <?php echo $indModel->unit_price;?>
                        </td>
                        <td class="left-bordered">
                            <?php echo $indModel->qty;?>
                        </td>
                        <td class="left-bordered">
                            <?php echo $indModel->total_amount;?>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td colspan="3"></td>
                    <td >Total Amount</td>
                    <td class=""><?php echo $model->total_amount;?></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>Amount Accredited</td>
                    <td><?php echo $model->total_amount+$model->credited-$model->balance; ?></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>Balance Due</td>
                    <td><?php echo $model->balance-$model->credited; ?></td>
                </tr>
            </table>
        </div>

    </div>


<?php
$cs = Yii::app()->clientScript;
$cs->registerScript("DynamicForm", "
    $('#print-btn').click(function(){
        var w=window.open('about:blank','print');
        $(w.document.body).html($('#printable_view').html());
        w.print();
    });
");
?>