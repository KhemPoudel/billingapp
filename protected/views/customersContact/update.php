<?php
/* @var $this CustomersContactController */
/* @var $model CustomersContact */

/*$this->breadcrumbs=array(
	'Customers Contacts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);*/
$cust_id = $_GET['id'];
$customerName = $_GET['customerName'];
$this->menu=array(
	array('label'=>'List CustomersContact', 'url'=>array('index')),
	array('label'=>'Create CustomersContact', 'url'=>array('create')),
	array('label'=>'View CustomersContact', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomersContact', 'url'=>array('admin')),
);
//echo $name1;
?>

<h1>Update  <?php echo CHtml::link(CHtml::encode($customerName),$this->createAbsoluteUrl('Customers/view',array('id'=>$cust_id)));?>
</h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>