<?php
/* @var $this suppliersController */
/* @var $dataProvider CActiveDataProvider */
//$sts=$_GET['sts'];
$i=1;

?>
<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> Better check yourself, you're not looking too good.
</div>


<table class="table table-striped table-bordered">
    <tr>
        <th colspan="2">
            <?php
            echo 'suppliers';
            ?>
        </th>
        <th colspan="2" style="border-left: none">
            <?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style"> Add supplier</span></button>',
                $this->createAbsoluteUrl('create')
            );
            ?>
        </th>
        <th>
            <?php
            echo CHtml::link(
                '<input type="text" ><span class="btn-label-style">Search</span></input>',
                $this->createAbsoluteUrl('admin')
            );
            ?>
        </th>
    </tr>
    <tr>
        <th>
            <b class=""></b>
        </th>
        <th>
            Supplier Name
        </th>
        <th>
            PAN Number
        </th>
        <th>
            Billing Address
        </th>
        <th>
            Purchases Invoices
        </th>
        <th>
            Supplier Credits
        </th>
        <th>
            Amount Payables
        </th>
        <th>

        </th>
    </tr>
    <?php foreach($models as $model): ?>
        <tr>
            <td>
                <?php echo CHtml::link('<button class="btn btn-default"><span class="btn-label-style">Edit</span></button>',array('update','id'=>$model->id)); ?>
            </td>
            <td>
                <?php
                echo $model->supplierName;
                ?>
            </td>
            <td>
                <?php
                echo $model->PANNumber;
                ?>
            </td>
            <td>
                <?php
                echo $model->BillingAddress;
                ?>
            </td>
            <td>
                <?php
                echo CHtml::link(sizeof($model->purchasesInvs),$this->createAbsoluteUrl('PurchasesInvoices/index',array('supplier'=>$model->id)));
                ?>
            </td>

            <td>
                <?php
                $supplierCredits=SuppliersCredit::model()->findAll(array('condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$model->id)));
                $credits=0;
                foreach($supplierCredits as $supplierCredit){
                    $credits+=($supplierCredit->amount-$supplierCredit->credit_assigned);
                }
                if($credits<0){
                    echo '-';
                }
                else{
                    echo CHtml::link($credits,$this->createAbsoluteUrl('suppliers/viewTransactionCreditType',array('id'=>$model->id)));
                }
                ?>
            </td>

            <td>
                <?php
                $Invoices=PurchasesInvoices::model()->findAll(array('condition'=>'supplier_id=:supplier','params'=>array(':supplier'=>$model->id)));
                $payables=0;
                foreach($Invoices as $invoice){
                    $payables+=($invoice->balance-$invoice->credited);
                }
                if($payables<0){
                    echo '-';
                }
                else{

                    echo CHtml::link($payables,$this->createAbsoluteUrl('suppliers/viewTransaction',array('id'=>$model->id)));

                }
                ?>
            </td>
            <td>
                <?php
                $contacts= $model->suppliersContacts;
                if(count($contacts)>0){
                    ?>
                    <div class="input-group">
                        <button class="btn btn-sm btn-default" type="button" data-toggle="collapse" data-target="#collapseExample-<?php echo ++$i;?>" aria-expanded="false" aria-controls="collapseExample-<?php echo $i?>">
                            <span class="btn-label-style">Contact Details</span>
                        </button>
                        <?php echo CHtml::link('<button class="btn btn-default">
                                                <span class="btn-label-style">Add Contact</span>
                                            </button>',
                            $this->createAbsoluteUrl('suppliersContact/create',array(
                                'id'=>$model->id,
                                'supplierName'=>$model->supplierName)));
                        ?>
                    </div>

                    <div class="collapse" id="collapseExample-<?php echo $i?>">
                        <div>

                            <table class="table table-striped">
                                <tr>
                                    <th></th>
                                    <th>Email</th>
                                    <th>Fax</th>
                                    <th>Telephone</th>
                                    <th>Mobile</th>
                                </tr>
                                <?php
                                foreach($contacts as $contact)
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo CHtml::link('<button class="btn btn-default"><span class="btn-label-style">Edit</span></button>',$this->createAbsoluteUrl(
                                                'suppliersContact/update',
                                                array(
                                                    'id'=>$contact->id,
                                                    'supplierName'=>$model->supplierName)));
                                            ?>
                                        </td>
                                        <td><?php echo $contact->Email;?></td>
                                        <td><?php echo $contact->Fax;?></td>
                                        <td><?php echo $contact->Telephone;?></td>
                                        <td><?php echo $contact->Mobile;?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php
                }
                else{
                    echo CHtml::link('<button class="btn btn-default">
                                                    <span class="btn-label-style">Add Contact</span>
                                                </button>',
                        $this->createAbsoluteUrl('suppliersContact/create',array(
                            'id'=>$model->id,
                            'supplierName'=>$model->supplierName)));
                }
                ?>
                <?php //echo CHtml::link('<button class="btn btn-default">Add Contact</button>',array('suppliersContact/update','supplier_id'=>$model->id)); ?>
            </td>
        </tr>

        </td>
    <?php endforeach; ?>
</table>
<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));*/
?>
