<?php
/* @var $this SuppliersContactController */
/* @var $model SuppliersContact */

$this->breadcrumbs=array(
	'Suppliers Contacts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SuppliersContact', 'url'=>array('index')),
	array('label'=>'Create SuppliersContact', 'url'=>array('create')),
	array('label'=>'Update SuppliersContact', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SuppliersContact', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SuppliersContact', 'url'=>array('admin')),
);
?>

<h1>View SuppliersContact #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Email',
		'Fax',
		'Telephone',
		'Mobile',
		'supplier_id',
	),
)); ?>
