<?php
/* @var $this MoneyReceivedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Money Receiveds',
);

$this->menu=array(
	array('label'=>'Create MoneyReceived', 'url'=>array('create')),
	array('label'=>'Manage MoneyReceived', 'url'=>array('admin')),
);
?>

<h1>Money Receiveds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
