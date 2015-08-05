<table class="table table-striped table-bordered">
    <tr>
        <th colspan="2">
            <?php
            echo 'Inventory Items';
            ?>
        </th>
        <th colspan="2" style="border-left: none">
            <?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style"> Add New Invoice</span></button>',
                $this->createAbsoluteUrl('create')
            );
            ?>
        </th>
        <th colspan="4">
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
            Edit
        </th>
        <th>
            View
        </th>
        <th>
            Issue date
        </th>
        <th>
            #
        </th>
        <th>
            Customer
        </th>
        <th>
            Invoice total
        </th>
        <th>
            Balance Due
        </th>
        <th>
            Status
        </th>
    </tr>
    <?php foreach($models as $model): ?>
        <tr>
            <td>
                <?php echo CHtml::link(
                    '<button class="btn btn-default">
                    <span class="btn-label-style">Edit</span>
                    </button>',
                    array(
                        'update',
                        'id'=>$model->id)
                );
                ?>
            </td>
            <td>
                <?php echo CHtml::link(
                    '<button class="btn btn-default">
                    <span class="btn-label-style">View</span>
                    </button>',
                    array(
                        'view',
                        'id'=>$model->id)
                );
                ?>
            </td>
            <td>
                <?php
                echo $model->issue_date;
                ?>
            </td>
            <td>
                <?php
                echo $model->id;
                ?>
            </td>
            <td>
                <?php
                $customer=$model->customer;
                echo $customer->customerName;
                ?>
            </td>
            <td>
                <?php
                echo $model->total_amount;
                ?>
            </td>
            <td>
                <?php
                echo CHtml::link($model->balance-$model->credited,$this->createAbsoluteUrl('salesInvoices/viewTransaction',array('id'=>$model->id)));
                ?>
            </td>
            <td>
                <?php
                    if(($model->balance-$model->credited)==0){

                        ?>
                        <span class="label label-success">Paid in full</span>
                    <?php }

                    else{
                        ?>
                        <span class="label label-danger">Due Remaining</span>
                    <?php
                    }

                ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>

