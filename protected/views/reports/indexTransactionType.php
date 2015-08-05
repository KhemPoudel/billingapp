<?php
    $transaction=array();
    $transaction['ledger']='General Ledger Transaction';
    $transaction['customerStmtUnpaid']='Customer Statements';
    $transaction['customerStmtTransac']='Customer Statements';
    $transaction['supplierStmt']='Supplier Statements';
    $transaction['PLStmt']='Profit Loss Statements';
    $transaction['inventoryVM']='Inventory Value Movement';
    $transaction['inventoryQM']='Inventory Quantity Movement';
    $transaction['inventoryPM']='Inventory Profit Margin';
?>
<table class="table table-bordered">
    <tr>
        <th colspan="2">
            <?php
            echo $transaction[$type];
            ?>
        </th>


        <th colspan="2" style="border-left: none;">
            <?php
            echo CHtml::link(
                '<button class="btn btn-default btn-sm"><span class="btn-label-style"> Add New Report</span></button>',
                $this->createAbsoluteUrl('create',array('type'=>$type))
            );
            ?>
        </th>
        <th colspan="4" style="border-left: none;">
            <?php
            echo CHtml::link(
                '<input type="text" ><span class="btn-label-style">Search</span></input>',
                $this->createAbsoluteUrl('admin')
            );
            ?>
        </th>
    </tr>
    <tr>
        <?php
        if($type=='customerStmt'){
        ?>
            <th>View</th>
            <th>Customer</th>
            <?php if($stmtType=='transaction'){
            ?>
                <th>Transactions</th>
            <?php }
            else{
                ?>
                <th>Unpaid Invoices</th>
            <?php }
            ?>

            <th>Balance</th>
        <?php }
        else{

            ?>
            <th>
                Edit
            </th>
            <th>
                View
            </th>
            <th>
                From Date
            </th>
            <th>
                To Date
            </th>
            <th colspan="2">
                Description
            </th>
        <?php }

        ?>

    </tr>
    <?php
        foreach(Reports::model()->findAll(array('condition'=>'type=:type','params'=>array(':type'=>$type))) as $report){
         ?>
            <tr>
                <td>
                    <?php echo CHtml::link(
                        '<button class="btn btn-default">
                        <span class="btn-label-style">Edit</span>
                        </button>',
                        array(
                            'update',
                            'id'=>$report->id)
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
                            'id'=>$report->id)
                    );
                    ?>
                </td>
                <td>
                    <?php echo
                        $report->from_date;
                    ?>
                </td>
                <td>
                    <?php echo
                    $report->to_date;
                    ?>
                </td>
                <td>
                    <?php echo
                    $report->description;
                    ?>
                </td>
            </tr>
        <?php }
    ?>
</table>