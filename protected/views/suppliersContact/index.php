<?php
/* @var $this SuppliersContactController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Suppliers Contacts',
);

$this->menu=array(
	array('label'=>'Create SuppliersContact', 'url'=>array('create')),
	array('label'=>'Manage SuppliersContact', 'url'=>array('admin')),
);
?>

<h1>Suppliers Contacts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
