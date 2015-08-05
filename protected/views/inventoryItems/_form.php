<?php
/* @var $this InventoryItemsController */
/* @var $model InventoryItems */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-items-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'item_name'); ?>
		<?php echo $form->textField($model,'item_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'item_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_identifier'); ?>
		<?php echo $form->textField($model,'item_identifier',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'item_identifier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sp'); ?>
		<?php echo $form->textField($model,'sp'); ?>
		<?php echo $form->error($model,'sp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cp'); ?>
		<?php echo $form->textField($model,'cp'); ?>
		<?php echo $form->error($model,'cp'); ?>
	</div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            array(
                'class'=>'btn btn-success'
            )
        ); ?>

        <?php
        if(!$model->isNewRecord)
            echo CHtml::button('Delete',
                array(
                    'submit'=>array(
                        'delete',
                        'id'=>$model->id
                    ),
                    'class'=>'btn btn-danger',
                    'confirm'=>'Are you sure you want to delete this inventory item??'
                )
            );
        ?>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->