<?php
/* @var $this PurchasesInfoController */
/* @var $model PurchasesInfo */

$this->breadcrumbs=array(
	'Purchases Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchasesInfo', 'url'=>array('index')),
	array('label'=>'Create PurchasesInfo', 'url'=>array('create')),
	array('label'=>'Update PurchasesInfo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchasesInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchasesInfo', 'url'=>array('admin')),
);
?>

<h1>View PurchasesInfo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_id',
		'unit_price',
		'qty',
		'discount',
		'total_amount',
		'purchases_invoice_id',
	),
)); ?>
