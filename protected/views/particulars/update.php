<?php
/* @var $this ParticularsController */
/* @var $model Particulars */

$this->breadcrumbs=array(
	'Particulars'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Particulars', 'url'=>array('index')),
	array('label'=>'Create Particulars', 'url'=>array('create')),
	array('label'=>'View Particulars', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Particulars', 'url'=>array('admin')),
);
?>

<h1>Update Particulars <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>