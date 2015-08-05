<?php
/* @var $this CustomersContactController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Customers Contacts',
);

$this->menu=array(
	array('label'=>'Create CustomersContact', 'url'=>array('create')),
	array('label'=>'Manage CustomersContact', 'url'=>array('admin')),
);
?>

<h1>Customers Contacts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
