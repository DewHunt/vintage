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
                <th width="20px">SL</th>
                <th width="140px">Date</th>
                <th width="120px">Challan</th>
                <th>Branch</th>
                <th width="120px">User</th>
                <th width="80px">Total Item</th>
                <th width="80px">Total Qty</th>
                <th width="20px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $sl = 1; $totalItem = 0; $totalQty = 0; ?>

            <?php foreach ($transferReport as $transfer): ?>
                <?php
                    $totalItem += $transfer->total_item;
                    $totalQty += $transfer->total_qty;
                ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $transfer->product_receive_date ?></td>
                    <td><?= $transfer->challan_number ?></td>
                    <td><?= ucfirst($transfer->branchName) ?></td>
                    <td><?= ucfirst($transfer->userName) ?></td>
                    <td align="right"><?= ucfirst($transfer->total_item) ?></td>
                    <td align="right"><?= ucfirst($transfer->total_qty) ?></td>
                    <td>
                        <span class="btn btn-primary" onclick="viewTransferReportProductList(<?= $transfer->id ?>)">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </td>
                </tr>                
            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total</th>
                <th class="text-right"><?= $totalItem ?></th>
                <th class="text-right"><?= $totalQty ?></th>
                <th></th>
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
            <div class="column full" align="center"><label class="search-from-date">Period : </label> <?= $start_date ?> To <?= $end_date ?></div>
        </div>

        <div class="row">
            <div class="column full">
                <table id="branch-stock-list-table">
                    <caption><strong>Transfer Report</strong></caption>
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th width="100px">Date</th>
                            <th width="80px">Challan</th>
                            <th width="150px">Branch</th>
                            <th width="100px">User</th>
                            <th width="90px">Total Item</th>
                            <th width="90px">Total Qty</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $count = 1;
                            $totalItem = 0;
                            $totalQty = 0;
                        ?>

                        <?php foreach ($transferReport as $transfer): ?>
                            <?php
                                $totalItem += $transfer->total_item;
                                $totalQty += $transfer->total_qty;
                            ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $transfer->product_receive_date ?></td>
                                <td><?= $transfer->challan_number ?></td>
                                <td><?= ucfirst($transfer->branchName) ?></td>
                                <td><?= ucfirst($transfer->userName) ?></td>
                                <td align="right"><?= ucfirst($transfer->total_item) ?></td>
                                <td align="right"><?= ucfirst($transfer->total_qty) ?></td>
                            </tr>                            
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="5">Total</th>
                            <th class="text-right"><?= $totalItem ?></th>
                            <th class="text-right"><?= $totalQty ?></th>
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
