<?php
/* @var $this CustomersContactController */
/* @var $model CustomersContact */

$this->breadcrumbs=array(
	'Customers Contacts'=>array('index'),
	'Create',
);
$id=$_GET['id'];
$customerName=$_GET['customerName'];
$this->menu=array(
	array('label'=>'List CustomersContact', 'url'=>array('index'), 'class'=>'btn'),
	array('label'=>'Manage CustomersContact', 'url'=>array('admin')),
);
?>

<h1>Create <?php echo CHtml::link(CHtml::encode($customerName),$this->createAbsoluteUrl('/customers/index'));?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'id'=>$id)); ?>