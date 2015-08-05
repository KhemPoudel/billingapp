<?php
/* @var $this ParticularsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Particulars',
);

$this->menu=array(
	array('label'=>'Create Particulars', 'url'=>array('create')),
	array('label'=>'Manage Particulars', 'url'=>array('admin')),
);
?>

<h1>Particulars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
