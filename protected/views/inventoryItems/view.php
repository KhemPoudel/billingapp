<?php
/* @var $this InventoryItemsController */
/* @var $model InventoryItems */

$this->breadcrumbs=array(
	'Inventory Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InventoryItems', 'url'=>array('index')),
	array('label'=>'Create InventoryItems', 'url'=>array('create')),
	array('label'=>'Update InventoryItems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InventoryItems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InventoryItems', 'url'=>array('admin')),
);
?>

<h1>View InventoryItems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_name',
		'item_identifier',
		'sp',
		'cp',
		'qty',
		'total_cost',
	),
)); ?>
