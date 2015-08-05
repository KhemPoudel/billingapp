<?php
/* @var $this SuppliersController */
/* @var $model Suppliers */

$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Suppliers', 'url'=>array('index')),
	array('label'=>'Manage Suppliers', 'url'=>array('admin')),
);
?>

<h1>Create Suppliers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>