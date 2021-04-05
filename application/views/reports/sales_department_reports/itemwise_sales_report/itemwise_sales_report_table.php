<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= display_date($start_date); ?> To <?= display_date($end_date); ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button itemwise-sales-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <div class="col-xs-12">
                    <button type="button" class="right-side-view btn btn-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="table-responsive table-bordered" style="width: 100%;">
        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product Name</th>
                    <th>Grade</th>
                    <th>Pack</th>
                    <th class="text-right">Sold Quantity</th>
                    <th class="text-right">Amount (<?= get_currency(); ?>)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $sum_of_quantity = 0;
                $sum_of_total_amount = 0;
                if (!empty($itemwise_sales_report)) {
                    foreach ($itemwise_sales_report as $itemwise_sales) {
                        $employee_id = intval($itemwise_sales->employee_id);
                        if (in_array($employee_id, remove_employee_ids())) {
                            continue;
                        }
                        $product_name_part_1 = '';
                        $product_name_part_2 = '';
                        if (strpos(($itemwise_sales->product_name), '#') !== false) {
                            $product_name = explode("#", ($itemwise_sales->product_name));
                            $product_name_part_1 = $product_name[0];
                            $product_name_part_2 = $product_name[1];
                        } else {
                            $product_name_part_1 = $itemwise_sales->product_name;
                        }

                        $grade1 = '';
                        if (!empty($itemwise_sales->api)) {
                            $grade1 .= 'API: ' . $itemwise_sales->api . '<br>';
                        }
                        if (!empty($grade1) && !empty($itemwise_sales->sae)) {
                            // $grade1 .= ', ';
                        }
                        if (!empty($itemwise_sales->sae)) {
                            $grade1 .= 'SAE: ' . $itemwise_sales->sae . '<br>';
                        }
                        if (!empty($grade1) && !empty($itemwise_sales->iso)) {
                            //   $grade1 .= ', ';
                        }
                        if (!empty($itemwise_sales->iso)) {
                            $grade1 .= 'ISO: ' . $itemwise_sales->iso;
                        }
                        $pack_size = !empty($itemwise_sales->pack_size) ? $itemwise_sales->pack_size : '';
                        $quantity = !empty($itemwise_sales->quantity) ? $itemwise_sales->quantity : 0;
                        $sum_of_quantity += intval($quantity);
                        $total_amount = !empty($itemwise_sales->total_amount) ? $itemwise_sales->total_amount : 0;
                        $sum_of_total_amount += doubleval($total_amount);
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $product_name_part_1; ?></td>
                            <td><?= $grade1 ?></td>
                            <td><?= $pack_size; ?></td>
                            <td class="text-right"><?= $quantity; ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_amount, TRUE); ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td><strong></strong></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong></strong></td>
                        <td class="text-right"><strong></strong></td>
                        <td class="text-right"><strong><?= ($sum_of_quantity); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_amount, TRUE); ?></strong></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="itemwise-sales-report-table-print-section" style="display: none; width: 100%" >
    <style>
        .print-table {
            width: 100%;
            border-collapse: collapse !important;
            border: 2px solid;            
        }
        .print-table th{
            text-align: center; 
            font-weight: bold; 
            background-color: black; 
            color: white; 
            font-size: 18px;
        }
        .print-table th,
        .print-table td {
            border: 1px solid #ddd !important;
        }
        .text-right{
            text-align: right;
        }
    </style>
    <?php $this->load->view('reports/company_info_as_report_header', $this->data); ?>
    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong><?= !empty($report_title) ? $report_title : ''; ?></strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Grade</th>
                <th>Pack</th>
                <th class="text-right">Sold Quantity</th>
                <th class="text-right">Amount (<?= get_currency(); ?>)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sum_of_quantity = 0;
            $sum_of_total_amount = 0;
            if (!empty($itemwise_sales_report)) {
                foreach ($itemwise_sales_report as $itemwise_sales) {
                    $employee_id = intval($itemwise_sales->employee_id);
                    if (in_array($employee_id, remove_employee_ids())) {
                        continue;
                    }
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    if (strpos(($itemwise_sales->product_name), '#') !== false) {
                        $product_name = explode("#", ($itemwise_sales->product_name));
                        $product_name_part_1 = $product_name[0];
                        $product_name_part_2 = $product_name[1];
                    } else {
                        $product_name_part_1 = $itemwise_sales->product_name;
                    }

                    $grade1 = '';
                    if (!empty($itemwise_sales->api)) {
                        $grade1 .= 'API: ' . $itemwise_sales->api . '<br>';
                    }
                    if (!empty($grade1) && !empty($itemwise_sales->sae)) {
                        // $grade1 .= ', ';
                    }
                    if (!empty($itemwise_sales->sae)) {
                        $grade1 .= 'SAE: ' . $itemwise_sales->sae . '<br>';
                    }
                    if (!empty($grade1) && !empty($itemwise_sales->iso)) {
                        //   $grade1 .= ', ';
                    }
                    if (!empty($itemwise_sales->iso)) {
                        $grade1 .= 'ISO: ' . $itemwise_sales->iso;
                    }
                    $pack_size = !empty($itemwise_sales->pack_size) ? $itemwise_sales->pack_size : '';
                    $quantity = !empty($itemwise_sales->quantity) ? $itemwise_sales->quantity : 0;
                    $sum_of_quantity += intval($quantity);
                    $total_amount = !empty($itemwise_sales->total_amount) ? $itemwise_sales->total_amount : 0;
                    $sum_of_total_amount += doubleval($total_amount);
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $product_name_part_1; ?></td>
                        <td><?= $grade1 ?></td>
                        <td><?= $pack_size; ?></td>
                        <td class="text-right"><?= $quantity; ?></td>
                        <td class="text-right"><?= get_floating_point_number($total_amount, TRUE); ?></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td><strong></strong></td>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong></strong></td>
                    <td class="text-right"><strong></strong></td>
                    <td class="text-right"><strong><?= ($sum_of_quantity); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_amount, TRUE); ?></strong></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {
        
        exportToExcel('print-table');

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $(".itemwise-sales-report-table-print-button").click(function () {
            var divContents = $('#itemwise-sales-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

