<?php
/* @var $this InventoryItemsController */
/* @var $data InventoryItems */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_name')); ?>:</b>
	<?php echo CHtml::encode($data->item_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_identifier')); ?>:</b>
	<?php echo CHtml::encode($data->item_identifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sp')); ?>:</b>
	<?php echo CHtml::encode($data->sp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cp')); ?>:</b>
	<?php echo CHtml::encode($data->cp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_cost')); ?>:</b>
	<?php echo CHtml::encode($data->total_cost); ?>
	<br />


</div>