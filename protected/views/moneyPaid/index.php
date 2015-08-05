<?php
/* @var $this MoneyPaidController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Money Paids',
);

$this->menu=array(
	array('label'=>'Create MoneyPaid', 'url'=>array('create')),
	array('label'=>'Manage MoneyPaid', 'url'=>array('admin')),
);
?>

<h1>Money Paids</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
