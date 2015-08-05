<?php
/* @var $this PurchasesInfoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Purchases Infos',
);

$this->menu=array(
	array('label'=>'Create PurchasesInfo', 'url'=>array('create')),
	array('label'=>'Manage PurchasesInfo', 'url'=>array('admin')),
);
?>

<h1>Purchases Infos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
