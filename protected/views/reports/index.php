
<div style="border: 1px inset #808080;">
    <table class="table">
        <tr>
            <td>
                <div style="" class="text-left">
                    <div style="">
                        <table class="table table-bordered" id="tbl-transaction">
                            <tr>
                                <th style="background-color: #eeeddd;"><b>General Ledger</b></th>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('General Ledger Transaction',$this->createAbsoluteUrl('indexTransactionType',array('type'=>'ledger','model'=>''))); ?></td>
                            </tr>
                            <tr>
                                <td>General Ledger Summary</td>
                            </tr>
                        </table>
                    </div>
                    <div style="">
                        <table class="table table-bordered" id="tbl-transaction">
                            <tr>
                                <th style="background-color: #eeeddd;"><b>Accounts Receivables</b></th>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Customer Statements(Unpaid Invoices)',$this->createAbsoluteUrl('customerUnpaidInv/index'));?></td>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Customer Statements(Transactions)',$this->createAbsoluteUrl('create',array('type'=>'customerStmtTransac')));?></td>
                            </tr>
                        </table>
                    </div>
                    <div style="">
                        <table class="table table-bordered" id="tbl-transaction">
                            <tr>
                                <th style="background-color: #eeeddd;"><b>Financial Statements</b></th>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Profit Loss Statement',$this->createAbsoluteUrl('indexTransactionType',array('type'=>'PLStmt')));?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td>
                <div style="" class="text-right">
                    <div style="">
                        <table class="table table-bordered" id="tbl-transaction">
                            <tr>
                                <th style="background-color: #eeeddd;"><b>Accounts Payables</b></th>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Supplier Statements',$this->createAbsoluteUrl('indexTransactionType',array('type'=>'supplierStmt')));?></td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: ;">
                        <table class="table table-bordered" id="tbl-transaction">
                            <tr>
                                <th style="background-color: #eeeddd;"><b>Inventory Movements</b></th>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Inventory Value Movement',$this->createAbsoluteUrl('indexTransactionType',array('type'=>'inventoryVM')));?></td>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Inventory Quantity Movement',$this->createAbsoluteUrl('indexTransactionType',array('type'=>'inventoryQM')));?></td>
                            </tr>
                            <tr>
                                <td><?php echo CHtml::link('Inventory Profit Margin',$this->createAbsoluteUrl('indexTransactionType',array('type'=>'inventoryPM')));?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>


<script type="text/javascript">

</script>