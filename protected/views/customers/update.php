<?php
/* @var $this CustomersController */
/* @var $model Customers */
$id=$_GET['id'];
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Customers', 'url'=>array('index')),
	array('label'=>'Create Customers', 'url'=>array('create')),
	array('label'=>'View Customers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Customers', 'url'=>array('admin')),
);

?>

<h1>Update <?php echo CHtml::link(CHtml::encode($model->customerName),$this->createAbsoluteUrl('index')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>