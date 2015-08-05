<?php
/* @var $this ParticularsController */
/* @var $model Particulars */

$this->breadcrumbs=array(
	'Particulars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Particulars', 'url'=>array('index')),
	array('label'=>'Manage Particulars', 'url'=>array('admin')),
);
?>

<h1>Create Particulars</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>