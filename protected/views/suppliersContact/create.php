<?php
/* @var $this SuppliersContactController */
/* @var $model SuppliersContact */

$this->breadcrumbs=array(
	'Suppliers Contacts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SuppliersContact', 'url'=>array('index')),
	array('label'=>'Manage SuppliersContact', 'url'=>array('admin')),
);
?>

<h1>Create SuppliersContact</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>