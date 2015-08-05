<?php
/* @var $this CustomersContactController */
/* @var $data CustomersContact */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Email')); ?>:</b>
	<?php echo CHtml::encode($data->Email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Telephone')); ?>:</b>
	<?php echo CHtml::encode($data->Telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mobile')); ?>:</b>
	<?php echo CHtml::encode($data->Mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />


</div>