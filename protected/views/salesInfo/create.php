<?php
/* @var $this SalesInfoController */
/* @var $model SalesInfo */

$this->breadcrumbs=array(
	'Sales Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SalesInfo', 'url'=>array('index')),
	array('label'=>'Manage SalesInfo', 'url'=>array('admin')),
);
?>

<h1>Create SalesInfo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>