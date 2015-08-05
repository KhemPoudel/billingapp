<?php
/* @var $this SalesInfoController */
/* @var $model SalesInfo */

$this->breadcrumbs=array(
	'Sales Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SalesInfo', 'url'=>array('index')),
	array('label'=>'Create SalesInfo', 'url'=>array('create')),
	array('label'=>'Update SalesInfo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SalesInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SalesInfo', 'url'=>array('admin')),
);
?>

<h1>View SalesInfo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_id',
		'unit_price',
		'qty',
		'discount',
		'total_amount',
		'sales_invoice_id',
	),
)); ?>
