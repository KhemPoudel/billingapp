<?php
/* @var $this CustomersController */
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
                echo 'Customers';
            ?>
        </th>
        <th colspan="2" style="border-left: none">
            <?php
                echo CHtml::link(
                    '<button class="btn btn-default btn-sm"><span class="btn-label-style"> Add Customer</span></button>',
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
            Customer Name
        </th>
        <th>
            PAN Number
        </th>
        <th>
            Billing Address
        </th>
        <th>
            Sales Invoices
        </th>
        <th>Customer Credits</th>
        <th>
            Amount Receivables
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
                echo $model->customerName;
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
                echo CHtml::link(sizeof($model->salesInvoices),$this->createAbsoluteUrl('SalesInvoices/index',array('customer'=>$model->id)));
                ?>
            </td>

            <td>
                <?php
                $customerCredits=CustomersCredit::model()->findAll(array('condition'=>'customer_id=:customer','params'=>array(':customer'=>$model->id)));
                $credits=0;
                foreach($customerCredits as $customerCredit){
                    $credits+=($customerCredit->amount-$customerCredit->credit_assigned);
                }
                if($credits<0){
                    echo '-';
                }
                else{
                    echo CHtml::link($credits,$this->createAbsoluteUrl('customers/viewTransactionCreditType',array('id'=>$model->id)));
                }
                ?>
            </td>

            <td>
                <?php
                    $Invoices=$model->salesInvoices;
                    $receivables=0;
                    foreach($Invoices as $invoice){
                        $receivables+=($invoice->balance-$invoice->credited);
                    }
                    if($receivables<0){
                        echo '-';
                    }
                    else{

                        echo CHtml::link($receivables,$this->createAbsoluteUrl('customers/viewTransaction',array('id'=>$model->id)));

                    }
                ?>
            </td>

            <td>
                <?php
                $contacts= $model->customersContacts;
                if(count($contacts)>0){
                    ?>
                    <div class="input-group">
                        <button class="btn btn-sm btn-default" type="button" data-toggle="collapse" data-target="#collapseExample-<?php echo ++$i;?>" aria-expanded="false" aria-controls="collapseExample-<?php echo $i?>">
                            <span class="btn-label-style">Contact Details</span>
                        </button>
                        <?php echo CHtml::link('<button class="btn btn-default">
                                                <span class="btn-label-style">Add Contact</span>
                                            </button>',
                            $this->createAbsoluteUrl('CustomersContact/create',array(
                                'id'=>$model->id,
                                'customerName'=>$model->customerName)));
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
                                                'CustomersContact/update',
                                                array(
                                                    'id'=>$contact->id,
                                                    'customerName'=>$model->customerName)));
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
                        $this->createAbsoluteUrl('CustomersContact/create',array(
                            'id'=>$model->id,
                            'customerName'=>$model->customerName)));
                    }
                ?>
                <?php //echo CHtml::link('<button class="btn btn-default">Add Contact</button>',array('CustomersContact/update','customer_id'=>$model->id)); ?>
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
