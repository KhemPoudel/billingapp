<?php
/* @var $this MoneyReceivedController */
/* @var $model MoneyReceived */

$this->breadcrumbs=array(
	'Money Receiveds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MoneyReceived', 'url'=>array('index')),
	array('label'=>'Create MoneyReceived', 'url'=>array('create')),
	array('label'=>'Update MoneyReceived', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MoneyReceived', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MoneyReceived', 'url'=>array('admin')),
);
?>

<h1>View MoneyReceived #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'received_date',
		'sales_invoice_id',
		'customer_id',
		'amount',
	),
)); ?>
