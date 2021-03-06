
<?php
$sts=0;
/* @var $this PurchasesInvoicesController */
/* @var $model1 PurchasesInvoices */
/* @var $form CActiveForm */
?>


<div class="form" style="border: 1px inset #e1e1e1;padding: 2% ">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'purchases-invoices-form',

        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false

    )); ?>

    <?php echo $form->errorSummary($model1); ?>
    <div class="row-inline">
        <div class="row">
            <?php echo $form->labelEx($model1,'issue_date'); ?>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>'PurchasesInvoices[issue_date]',
                'model'=>$model1,
                'attribute'=>'issue_date',

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

            <?php echo $form->error($model1,'issue_date'); ?>
        </div>


    </div>



    <div class="row">
        <?php echo $form->labelEx($model1,'supplier_id'); ?>
        <?php
        $this->widget('bootstrap.widgets.select2.ESelect2',array(
            'model'=>$model1,
            'attribute'=>'supplier_id',
            'data'=>CHtml::listData(Suppliers::model()->findAll(), 'id', 'supplierName'),
            'htmlOptions'=>array(
                'class'=>''
            )
        ));
        ?>
        <?php echo $form->error($model1,'supplier_id'); ?>
    </div>
    <br>
    <div id="form-content" style="margin-right: 5%;">
        <?php
        if($mode==='update')
        {
            foreach($model2 as $indmodel)
            {
                $this->renderPartial('_form-purchases-info',array('form'=>$form,'model2'=>$indmodel,'sts'=>$sts));
                $sts++;
            }
        }
        else
        {
            $this->renderPartial('_form-purchases-info',array('form'=>$form,'model2'=>$model2,'sts'=>0));
        }

        ?>



    </div>

    <?php
    $_SESSION['form']=$form;
    $_SESSION['model2']=new PurchasesInfo;
    $_SESSION['sts']=$sts;

    ?>
    <div class="row-inline">
        <button type="button" class="btn btn-primary" id="add-row-btn">Add row</button>
        <!---------------------------test form end-------------------------------------->
        <div class="row row-total">
            <div class="input-prepend">
                <span class="add-on" style="margin-top: 3px;">Rs.</span>
                <?php echo $form->textField($model1,'total_amount',array('readonly'=>true,)); ?>
            </div>
            <?php echo $form->error($model1,'total_amount'); ?>
        </div>
    </div>

    <div class="row-inline">

        <!---------------------------test form end-------------------------------------->
        <div class="label-received">
            <label class="">Received Amount</label>
        </div>
        <div class="div-received">
            <div class="input-prepend">
                <span class="add-on" style="margin-top: 3px;">Rs.</span>
                <?php echo $form->textField($paidModel,'amount'); ?>
            </div>
        </div>
        <?php echo $paidModel->amount; ?>
        <?php echo $form->error($paidModel,'amount'); ?>

    </div>
    <br>
    <div class="row buttons">
        <?php echo CHtml::submitButton(
            $model1->isNewRecord ? 'Create' : 'Update',
            array(
                'class'=>'btn btn-success'
            )
        ); ?>

        <?php

        if(!$model1->isNewRecord)
            echo CHtml::button('Delete',
                array(
                    'submit'=>array(
                        'delete',
                        'id'=>$model1->id
                    ),
                    'class'=>'btn btn-danger',
                    'confirm'=>'Are you sure you want to delete this purchases Invoice??
                    All the balances and credits related will be deleted together.'
                )
            );
        ?>

    </div>
    <?php
    $cs = Yii::app()->clientScript;
    $cs->registerScript("DynamicForm", "
        var count=".$sts.";
        $('#add-row-btn').click(function(){
            count++;
            jQuery.ajax(
            {
                'type':'POST',
                'url':'/index.php/PurchasesInvoices/getNewForm',
                'data':{'sts':count},
                'cache':false,
                'success':function(html)
                {
                    jQuery('#form-content').append(html);
                }
            }
            );
                return false;
        });
    ");
    ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->