<?php
/* @var $this SalesInfoController */
/* @var $model SalesInfo */

$this->breadcrumbs=array(
	'Sales Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SalesInfo', 'url'=>array('index')),
	array('label'=>'Create SalesInfo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sales-info-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sales Infos</h1>

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
	'id'=>'sales-info-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'item_id',
		'unit_price',
		'qty',
		'discount',
		'total_amount',
		/*
		'sales_invoice_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
