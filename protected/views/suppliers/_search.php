<?php
/* @var $this SuppliersController */
/* @var $model Suppliers */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplierName'); ?>
		<?php echo $form->textField($model,'supplierName',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PANNumber'); ?>
		<?php echo $form->textField($model,'PANNumber',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BillingAddress'); ?>
		<?php echo $form->textArea($model,'BillingAddress',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'purchasesInvoices'); ?>
		<?php echo $form->textField($model,'purchasesInvoices'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Accountspayables'); ?>
		<?php echo $form->textField($model,'Accountspayables'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->