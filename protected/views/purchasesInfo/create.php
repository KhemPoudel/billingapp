<?php
/* @var $this PurchasesInfoController */
/* @var $model PurchasesInfo */

$this->breadcrumbs=array(
	'Purchases Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchasesInfo', 'url'=>array('index')),
	array('label'=>'Manage PurchasesInfo', 'url'=>array('admin')),
);
?>

<h1>Create PurchasesInfo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>