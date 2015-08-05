<?php
/* @var $this SalesInfoController */
/* @var $model SalesInfo */

$this->breadcrumbs=array(
	'Sales Infos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SalesInfo', 'url'=>array('index')),
	array('label'=>'Create SalesInfo', 'url'=>array('create')),
	array('label'=>'View SalesInfo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SalesInfo', 'url'=>array('admin')),
);
?>

<h1>Update SalesInfo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>