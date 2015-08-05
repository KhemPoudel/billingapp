<div style="position: relative;" class="row-inline well" id="<?php echo 'div_form_content_',$sts; ?>">
    <?php
    if($sts!=0)
    {
        ?>
        <button style="position: absolute;top: 0;right: 0;" type="button" class="btn btn-sm btn-default close_btn" id="<?php echo $sts; ?>"><span class="btn-label-style">X</span></button>
    <?php
    }
    if($sts===0){
        //$sts=1;
        ?>
        <div class="row row1">
            <?php echo $form->labelEx($model2,'item_id'); ?>
            <?php
            $this->widget('bootstrap.widgets.select2.ESelect2',array(
                'model'=>$model2,
                'attribute'=>"[$sts]item_id",
                'data'=>CHtml::listData(InventoryItems::model()->findAll(), 'id', 'item_name'),
                'htmlOptions'=>array(
                    'class'=>'form-control',
                    'style'=>'width:90%;'
                )
            ));
            ?>
            <?php echo $form->error($model2,'item_id'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,'unit_price'); ?>
            <div class="input-prepend">
                <span class="add-on" style="margin-top: 3px;">Rs.</span>
                <?php echo $form->textField($model2,"[$sts]unit_price",array('class'=>$sts)); ?>
            </div>
            <?php echo $form->error($model2,'unit_price'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,'qty'); ?>
            <?php echo $form->textField($model2,"[$sts]qty",array('class'=>$sts)); ?>
            <?php echo $form->error($model2,'qty'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,'discount'); ?>
            <div class="input-append">
                <?php echo $form->textField($model2,"[$sts]discount",array('class'=>$sts)); ?>
                <span class="add-on" style="margin-top: 3px;">%</span>
            </div>
            <?php echo $form->error($model2,'discount'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,'total_amount'); ?>
            <div class="input-prepend">
                <span class="add-on" style="margin-top: 3px;">Rs.</span>
                <?php echo $form->textField($model2,"[$sts]total_amount",array('readonly'=>true,'class'=>$sts)); ?>
            </div>
            <?php echo $form->error($model2,'total_amount'); ?>
        </div>

    <?php
    }
    else{
        ?>
        <div class="row row1">
            <?php echo $form->labelEx($model2,''); ?>
            <?php
            $this->widget('bootstrap.widgets.select2.ESelect2',array(
                'model'=>$model2,
                'attribute'=>"[$sts]item_id",
                'data'=>CHtml::listData(InventoryItems::model()->findAll(), 'id', 'item_name'),
                'htmlOptions'=>array(
                    'class'=>'form-control'
                )
            ));
            ?>
            <?php echo $form->error($model2,'item_id'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,''); ?>
            <div class="input-prepend">
                <span class="add-on" style="margin-top: 3px;">Rs.</span>
                <?php echo $form->textField($model2,"[$sts]unit_price",array('class'=>$sts)); ?>
            </div>
            <?php echo $form->error($model2,'unit_price'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,''); ?>
            <?php echo $form->textField($model2,"[$sts]qty",array('class'=>$sts)); ?>
            <?php echo $form->error($model2,'qty'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,''); ?>
            <div class="input-append">
                <?php echo $form->textField($model2,"[$sts]discount",array('class'=>$sts)); ?>
                <span class="add-on" style="margin-top: 3px;">%</span>
            </div>
            <?php echo $form->error($model2,'discount'); ?>
        </div>

        <div class="row row2">
            <?php echo $form->labelEx($model2,''); ?>
            <div class="input-prepend">
                <span class="add-on" style="margin-top: 3px;">Rs.</span>
                <?php echo $form->textField($model2,"[$sts]total_amount",array('readonly'=>true,'class'=>$sts)); ?>
            </div>
            <?php echo $form->error($model2,'total_amount'); ?>
        </div>
    <?php
    }
    ?>
</div>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScript("totalCalc","
$(document).ready(function(){
 var interval;
$('#add-row-btn').bind('click',function(){
    eventBind(count);
});
    for(var i=0;i<=count;i++)
    {
        eventBind(i);
    }
    function eventBind(count){

        divId='#div_form_content_'+count;
        btnId='#'+count;
        uid='#PurchasesInfo_'+count+'_unit_price';
        qid='#PurchasesInfo_'+count+'_qty';
        did='#PurchasesInfo_'+count+'_discount';
        tid='#PurchasesInfo_'+count+'_total_amount';
        $('#form-content').on('click',btnId,function(){
            diffTotal($(this).parents('div:first')['context'].id);
            $(this).parents('div:first').remove();
        });

        $('#form-content').on('focus',uid,function(){
            var divName=$(this).parents('div:first')['context'].className;
            scopepreserver(divName);
        });

        $('#form-content').on('focus',qid,function(){
            var divName=$(this).parents('div:first')['context'].className;
            scopepreserver(divName);
        });


        $('#form-content').on('focus',did,function(){
            var divName=$(this).parents('div:first')['context'].className;
            scopepreserver(divName);
        });
        $('#form-content').on('blur',uid,function(){
            stopCalc();
        });
        $('#form-content').on('blur',qid,function(){
            stopCalc();
        });
         $('#form-content').on('blur',did,function(){
            stopCalc();
        });
    }


    function stopCalc()
    {
        clearInterval(interval);
    }

    function scopepreserver(divCount)
    {

            var tidIndv='#PurchasesInfo_'+divCount+'_total_amount';
            var uidIndv='#PurchasesInfo_'+divCount+'_unit_price';
            var qidIndv='#PurchasesInfo_'+divCount+'_qty';
            var didIndv='#PurchasesInfo_'+divCount+'_discount';
            interval=setInterval(function(){
                var up=$(uidIndv).val();
                var qty=$(qidIndv).val();
                var discount=$(didIndv).val();
                $(tidIndv).val((up*1.0)*(qty*1)-(up*1.0)*(qty*1)*0.01*discount);
                totalAmount=0;
                for(var i=0;i<=count;i++)
                {
                    var elem=document.getElementById('PurchasesInfo_'+i+'_total_amount');
                    if(elem==null)
                        indVal=0;
                    else
                        indVal=elem.value;
                    totalAmount+=indVal*1.0;
                }
                $('#PurchasesInvoices_total_amount').val(totalAmount);
            },1);

    }
    var totalAmount=$('#PurchasesInvoices_total_amount').val();
    function diffTotal(removedDiv)
    {
        totalAmount-=$('#PurchasesInfo_'+removedDiv+'_total_amount').val();
        $('#PurchasesInvoices_total_amount').val(totalAmount);
    }
});

");
?>
