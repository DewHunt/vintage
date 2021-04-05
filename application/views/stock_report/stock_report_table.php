<?php
    $company_information;
    $client_invoice_details_list;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="details-table">
        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Product</th>
                <th>Open</th>
                <th>Recieve</th>
                <th>Branch Return</th>
                <th>Hot Kitchen Return</th>
                <th>Transfer</th>
                <th>Sale</th>
                <th>Damage</th>
                <th>Return To Supplier</th>
                <th>Closing</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $sl = 1;
                $totalOpenStock = 0;
                $totalReceiveStock = 0;
                $totalReturnFromBranch = 0;
                $totalReturnFromHotKitchen = 0;
                $totalTransferStock = 0;
                $totalSaleFromStock = 0;
                $totalDamageStock = 0;
                $totalReturnToSupplier = 0;
                $totalClosingStock = 0;
            ?>

            <?php foreach ($stockReports as $stock): ?>
                <?php
                    $totalOpenStock += $stock->open_stock;
                    $totalReceiveStock += $stock->receive_stock;
                    $totalReturnFromBranch += $stock->return_from_branch;
                    $totalReturnFromHotKitchen += $stock->return_from_hot_kitchen;
                    $totalTransferStock += $stock->transfer_stock;
                    $totalSaleFromStock += $stock->sale_from_stock;
                    $totalDamageStock += $stock->damage_stock;
                    $totalReturnToSupplier += $stock->return_to_supplier;
                    $totalClosingStock += $stock->closing_stock;
                ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $stock->product_name ?></td>
                    <td align="right"><?= $stock->open_stock ?></td>
                    <td align="right"><?= $stock->receive_stock ?></td>
                    <td align="right"><?= $stock->return_from_branch ?></td>
                    <td align="right"><?= $stock->return_from_hot_kitchen ?></td>
                    <td align="right"><?= $stock->transfer_stock ?></td>
                    <td align="right"><?= $stock->sale_from_stock ?></td>
                    <td align="right"><?= $stock->damage_stock ?></td>
                    <td align="right"><?= $stock->return_to_supplier ?></td>
                    <td align="right"><?= $stock->closing_stock ?></td>
                </tr>                
            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right"><?= $totalOpenStock ?></th>
                <th class="text-right"><?= $totalReceiveStock ?></th>
                <th class="text-right"><?= $totalReturnFromBranch ?></th>
                <th class="text-right"><?= $totalReturnFromHotKitchen ?></th>
                <th class="text-right"><?= $totalTransferStock ?></th>
                <th class="text-right"><?= $totalSaleFromStock ?></th>
                <th class="text-right"><?= $totalDamageStock ?></th>
                <th class="text-right"><?= $totalReturnToSupplier ?></th>
                <th class="text-right"><?= $totalClosingStock ?></th>
            </tr>
        </tfoot>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-all-information" style="display: none">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 60%; }
        .right { width: 40%; }
        .full { width: 100% }
        /* Clear floats after the columns */
        .row:after { content: ""; display: table; clear: both; }
        .text-center { text-align: center }
        .text-right { text-align: right }
    </style>

    <div class="print-content">
        <div class="row">
            <div class="column full text-center">
                <font size="5px"><?= strtoupper($companyInfo->company_name_1) ?></font>
                <p><?= $companyInfo->company_address_1 ?></p>
            </div>
        </div>

        <div class="row">
            <div class="column full" align="center">
                Stock Report <br>
                <label class="search-from-date">Period : </label> <?= $start_date ?> To <?= $end_date ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table class="table table-bordered table-striped" id="details-table">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Open</th>
                            <th>Recieve</th>
                            <th>Branch Return</th>
                            <th>Hot Kitchen Return</th>
                            <th>Transfer</th>
                            <th>Sale</th>
                            <th>Damage</th>
                            <th>Return To Supplier</th>
                            <th>Closing</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $sl = 1;
                            $totalOpenStock = 0;
                            $totalReceiveStock = 0;
                            $totalReturnFromBranch = 0;
                            $totalReturnFromHotKitchen = 0;
                            $totalTransferStock = 0;
                            $totalSaleFromStock = 0;
                            $totalDamageStock = 0;
                            $totalReturnToSupplier = 0;
                            $totalClosingStock = 0;
                        ?>

                        <?php foreach ($stockReports as $stock): ?>
                            <?php
                                $totalOpenStock += $stock->open_stock;
                                $totalReceiveStock += $stock->receive_stock;
                                $totalReturnFromBranch += $stock->return_from_branch;
                                $totalReturnFromHotKitchen += $stock->return_from_hot_kitchen;
                                $totalTransferStock += $stock->transfer_stock;
                                $totalSaleFromStock += $stock->sale_from_stock;
                                $totalDamageStock += $stock->damage_stock;
                                $totalReturnToSupplier += $stock->return_to_supplier;
                                $totalClosingStock += $stock->closing_stock;
                            ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $stock->product_name ?></td>
                                <td align="right"><?= $stock->open_stock ?></td>
                                <td align="right"><?= $stock->receive_stock ?></td>
                                <td align="right"><?= $stock->return_from_branch ?></td>
                                <td align="right"><?= $stock->return_from_hot_kitchen ?></td>
                                <td align="right"><?= $stock->transfer_stock ?></td>
                                <td align="right"><?= $stock->sale_from_stock ?></td>
                                <td align="right"><?= $stock->damage_stock ?></td>
                                <td align="right"><?= $stock->return_to_supplier ?></td>
                                <td align="right"><?= $stock->closing_stock ?></td>
                            </tr>                
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">Total</th>
                            <th class="text-right"><?= $totalOpenStock ?></th>
                            <th class="text-right"><?= $totalReceiveStock ?></th>
                            <th class="text-right"><?= $totalReturnFromBranch ?></th>
                            <th class="text-right"><?= $totalReturnFromHotKitchen ?></th>
                            <th class="text-right"><?= $totalTransferStock ?></th>
                            <th class="text-right"><?= $totalSaleFromStock ?></th>
                            <th class="text-right"><?= $totalDamageStock ?></th>
                            <th class="text-right"><?= $totalReturnToSupplier ?></th>
                            <th class="text-right"><?= $totalClosingStock ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });
</script>
