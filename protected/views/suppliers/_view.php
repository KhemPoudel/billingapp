<?php
/* @var $this SuppliersController */
/* @var $data Suppliers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplierName')); ?>:</b>
	<?php echo CHtml::encode($data->supplierName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PANNumber')); ?>:</b>
	<?php echo CHtml::encode($data->PANNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BillingAddress')); ?>:</b>
	<?php echo CHtml::encode($data->BillingAddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchasesInvoices')); ?>:</b>
	<?php echo CHtml::encode($data->purchasesInvoices); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Accountspayables')); ?>:</b>
	<?php echo CHtml::encode($data->Accountspayables); ?>
	<br />


</div>