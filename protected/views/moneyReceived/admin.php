<?php
/* @var $this MoneyReceivedController */
/* @var $model MoneyReceived */

$this->breadcrumbs=array(
	'Money Receiveds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MoneyReceived', 'url'=>array('index')),
	array('label'=>'Create MoneyReceived', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#money-received-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Money Receiveds</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'money-received-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'received_date',
		'sales_invoice_id',
		'customer_id',
		'amount',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
