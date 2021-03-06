<?php
/* @var $this ReportsController */
/* @var $model Reports */

$this->breadcrumbs=array(
	'Reports'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Reports', 'url'=>array('index')),
	array('label'=>'Create Reports', 'url'=>array('create')),
	array('label'=>'View Reports', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Reports', 'url'=>array('admin')),
);
?>

<h1>Update Reports <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'type'=>$type)); ?>