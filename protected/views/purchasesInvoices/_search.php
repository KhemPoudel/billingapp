<?php
/* @var $this PurchasesInvoicesController */
/* @var $model PurchasesInvoices */
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
		<?php echo $form->label($model,'issue_date'); ?>
		<?php echo $form->textField($model,'issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_amount'); ?>
		<?php echo $form->textField($model,'total_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'balance'); ?>
		<?php echo $form->textField($model,'balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'credited'); ?>
		<?php echo $form->textField($model,'credited'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->