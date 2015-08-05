<?php
/* @var $this InventoryItemsController */
/* @var $model InventoryItems */

$this->breadcrumbs=array(
	'Inventory Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InventoryItems', 'url'=>array('index')),
	array('label'=>'Manage InventoryItems', 'url'=>array('admin')),
);
?>

<h1>Create InventoryItems</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>