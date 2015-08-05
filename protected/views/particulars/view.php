<?php
/* @var $this ParticularsController */
/* @var $model Particulars */

$this->breadcrumbs=array(
	'Particulars'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Particulars', 'url'=>array('index')),
	array('label'=>'Create Particulars', 'url'=>array('create')),
	array('label'=>'Update Particulars', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Particulars', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Particulars', 'url'=>array('admin')),
);
?>

<h1>View Particulars #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'particularsname',
		'description',
		'price',
	),
)); ?>
