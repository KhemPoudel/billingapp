<h2>Update MoneyPaid</h2>
<div style="border: 1px inset gold;padding: 3%;">
    <span><b>Supplier: </b><?php echo Suppliers::model()->findByPk(PurchasesInvoices::model()->findByPk($id)->supplier_id)->supplierName;?></span>
    <br>
    <br>
    <span><b>Purchase Invoice: </b><?php echo $id;?></span>
    <br>
    <br>
    <?php $this->renderPartial('_form', array('model'=>$model,'id'=>$id)); ?>
</div>