

<h2>Create MoneyReceived</h2>
<div style="border: 1px inset gold;padding: 3%;">
    <span><b>Customer: </b><?php echo Customers::model()->findByPk(SalesInvoices::model()->findByPk($id)->customer_id)->customerName;?></span>
    <br>
    <br>
    <span><b>Sales Invoice: </b><?php echo $id;?></span>
    <br>
    <br>
<?php $this->renderPartial('_form', array('model'=>$model,'id'=>$id)); ?>
</div>