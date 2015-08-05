<?php
/* @var $this PurchasesInfoController */
/* @var $model PurchasesInfo */

$this->breadcrumbs=array(
	'Purchases Infos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchasesInfo', 'url'=>array('index')),
	array('label'=>'Create PurchasesInfo', 'url'=>array('create')),
	array('label'=>'View PurchasesInfo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchasesInfo', 'url'=>array('admin')),
);
?>

<h1>Update PurchasesInfo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>