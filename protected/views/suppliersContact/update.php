<?php
/* @var $this SuppliersContactController */
/* @var $model SuppliersContact */

$this->breadcrumbs=array(
	'Suppliers Contacts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SuppliersContact', 'url'=>array('index')),
	array('label'=>'Create SuppliersContact', 'url'=>array('create')),
	array('label'=>'View SuppliersContact', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SuppliersContact', 'url'=>array('admin')),
);
?>

<h1>Update SuppliersContact <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>