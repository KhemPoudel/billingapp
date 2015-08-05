<?php
/* @var $this CustomersContactController */
/* @var $model CustomersContact */
/* @var $form CActiveForm */
$customerName = $_GET['customerName']
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-contact-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Email'); ?>
		<?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'Email'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'Fax'); ?>
        <?php echo $form->textField($model,'Fax',array('size'=>60,'maxlength'=>60)); ?>
        <?php echo $form->error($model,'Fax'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'Telephone'); ?>
		<?php echo $form->textField($model,'Telephone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'Telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Mobile'); ?>
		<?php echo $form->textField($model,'Mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'Mobile'); ?>
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
                    'confirm'=>'Are you sure you want to delete this contact??'
                )
            );
        ?>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->