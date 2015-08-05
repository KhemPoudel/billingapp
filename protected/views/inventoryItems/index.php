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
                '<button class="btn btn-default btn-sm"><span class="btn-label-style"> Add New Inventory Item</span></button>',
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
            Edit
        </th>
        <th>
            Item Name
        </th>
        <th>
            Item Identifier
        </th>
        <th>
            Selling Price
        </th>
        <th>
            Cost Price
        </th>
        <th>
            Quantity
        </th>
        <th>
            Total Cost
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
            <?php
            echo $model->item_name;
            ?>
        </td>
        <td>
            <?php
            echo $model->item_identifier;
            ?>
        </td>
        <td>
            <?php
            echo $model->sp;
            ?>
        </td>
        <td>
            <?php
            echo $model->cp;
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link($model->qty,$this->createAbsoluteUrl('inventoryItems/viewTransaction',array('id'=>$model->id)));;
            ?>
        </td>
        <td>
            <?php
            echo $model->total_cost;
            ?>
        </td>
    </tr>
    <?php endforeach ?>
</table>
<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>

