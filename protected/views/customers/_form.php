<?php
/* @var $this CustomersController */
/* @var $model Customers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'customerName'); ?>
		<?php echo $form->textField($model,'customerName',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'customerName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PANNumber'); ?>
		<?php echo $form->textField($model,'PANNumber',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'PANNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BillingAddress'); ?>
		<?php echo $form->textArea($model,'BillingAddress',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'BillingAddress'); ?>
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