<?php
/* @var $this CustomersController */
/* @var $data Customers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customerName')); ?>:</b>
	<?php echo CHtml::encode($data->customerName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PANNumber')); ?>:</b>
	<?php echo CHtml::encode($data->PANNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BillingAddress')); ?>:</b>
	<?php echo CHtml::encode($data->BillingAddress); ?>
	<br />


</div>