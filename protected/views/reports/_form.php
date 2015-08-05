<?php
/* @var $this ReportsController */
/* @var $model Reports */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reports-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
    echo $form->errorSummary($model);
    ?>
    <?php
    if(!($type=='customerStmtUnpaid' || $type=='customerStmtTransac')){
    ?>
        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textArea($model,'title',array('rows'=>2, 'cols'=>50)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model,'description',array('rows'=>2, 'cols'=>50)); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>

    <?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from_date'); ?>
        <?php

        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'Reports[from_date]',
            'model'=>$model,
            'attribute'=>'from_date',

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
		<?php echo $form->error($model,'from_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to_date'); ?>
        <?php

        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'Reports[issue_date]',
            'model'=>$model,
            'attribute'=>'to_date',

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
		<?php echo $form->error($model,'to_date'); ?>
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
                    'confirm'=>'Are you sure you want to delete this report??'
                )
            );
        ?>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->