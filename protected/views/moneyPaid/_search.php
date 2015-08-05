<?php
/* @var $this MoneyPaidController */
/* @var $model MoneyPaid */
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
		<?php echo $form->label($model,'paid_date'); ?>
		<?php echo $form->textField($model,'paid_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'purchases_invoice_id'); ?>
		<?php echo $form->textField($model,'purchases_invoice_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->