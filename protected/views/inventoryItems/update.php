<?php
/* @var $this InventoryItemsController */
/* @var $model InventoryItems */

$this->breadcrumbs=array(
	'Inventory Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InventoryItems', 'url'=>array('index')),
	array('label'=>'Create InventoryItems', 'url'=>array('create')),
	array('label'=>'View InventoryItems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InventoryItems', 'url'=>array('admin')),
);
?>

    <h1>Update <?php echo CHtml::link(CHtml::encode($model->item_name),$this->createAbsoluteUrl('index')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>