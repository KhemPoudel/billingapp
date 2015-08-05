<?php
/* @var $this MoneyPaidController */
/* @var $model MoneyPaid */

$this->breadcrumbs=array(
	'Money Paids'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MoneyPaid', 'url'=>array('index')),
	array('label'=>'Create MoneyPaid', 'url'=>array('create')),
	array('label'=>'Update MoneyPaid', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MoneyPaid', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MoneyPaid', 'url'=>array('admin')),
);
?>

<h1>View MoneyPaid #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'paid_date',
		'purchases_invoice_id',
		'supplier_id',
		'amount',
		'status',
	),
)); ?>
