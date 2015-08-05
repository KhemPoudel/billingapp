<?php
/* @var $this MoneyReceivedController */
/* @var $model MoneyReceived */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'money-received-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'received_date'); ?>
        <?php

        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'SalesInvoices[received_date]',
            'model'=>$model,
            'attribute'=>'received_date',

            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',

            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;',
                'value'=>CTimestamp::formatDate('Y-m-d'),
            ),
        ));
        ?>
		<?php echo $form->error($model,'received_date'); ?>
	</div>


    <br>
	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
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
                    'confirm'=>'Are you sure you want to delete this receipt??'
                )
            );
        ?>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->