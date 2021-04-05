<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Outlet: <?= !empty($branch_names) ? ($branch_names) : ''; ?></label>
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
                    <th class="text-right">Total Sale</th>
                    <th class="text-right">Average Sale of <?= $month_duration_count . ' month(s)' ?></th>
                    <th class="text-right">Stock</th>
                    <th class="text-right">Expected Months</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (!empty($stock_report)) {
                    foreach ($stock_report as $report) {
//                        $employee_id = intval($report->employee_id);
//                        if (in_array($employee_id, remove_employee_ids())) {
//                            continue;
//                        }
                        $product_name_part_1 = '';
                        $product_name_part_2 = '';
                        if (strpos(($report->product_name), '#') !== false) {
                            $product_name = explode("#", ($report->product_name));
                            $product_name_part_1 = $product_name[0];
                            $product_name_part_2 = $product_name[1];
                        } else {
                            $product_name_part_1 = $report->product_name;
                        }

                        $grade1 = '';
                        if (!empty($report->api)) {
                            $grade1 .= 'API: ' . $report->api . '<br>';
                        }
                        if (!empty($grade1) && !empty($report->sae)) {
                            // $grade1 .= ', ';
                        }
                        if (!empty($report->sae)) {
                            $grade1 .= 'SAE: ' . $report->sae . '<br>';
                        }
                        if (!empty($grade1) && !empty($report->iso)) {
                            //   $grade1 .= ', ';
                        }
                        if (!empty($report->iso)) {
                            $grade1 .= 'ISO: ' . $report->iso;
                        }
                        $pack_size = !empty($report->pack_size) ? $report->pack_size : '';
                        $current_stock = intval($report->current_stock);
                        $quantity = !empty($report->quantity) ? intval($report->quantity) : 0;
                        $average_sale = ($month_duration_count > 0) ? ($quantity / $month_duration_count) : 0;
                        $average_sale = round($average_sale);
                        $expected_months = ($average_sale > 0) ? ($current_stock / $average_sale) : $current_stock;
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $product_name_part_1; ?></td>
                            <td><?= $grade1 ?></td>
                            <td><?= $pack_size; ?></td>
                            <td class="text-right"><?= $quantity; ?></td>
                            <td class="text-right"><?= round($average_sale); ?></td>
                            <td class="text-right"><?= $current_stock; ?></td>
                            <td class="text-right"><?= round($expected_months); ?></td>
                        </tr>
                    <?php }
                    ?>
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
        <label class="search-from-date">Outlet: <?= !empty($branch_names) ? ($branch_names) : ''; ?></label>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= display_date($start_date); ?> To <?= display_date($end_date); ?> </label><br>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Grade</th>
                <th>Pack</th>
                <th class="text-right">Total Sale</th>
                <th class="text-right">Average Sale of <?= $month_duration_count . ' month(s)' ?></th>
                <th class="text-right">Stock</th>
                <th class="text-right">Expected Months</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($stock_report)) {
                foreach ($stock_report as $report) {
//                        $employee_id = intval($report->employee_id);
//                        if (in_array($employee_id, remove_employee_ids())) {
//                            continue;
//                        }
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    if (strpos(($report->product_name), '#') !== false) {
                        $product_name = explode("#", ($report->product_name));
                        $product_name_part_1 = $product_name[0];
                        $product_name_part_2 = $product_name[1];
                    } else {
                        $product_name_part_1 = $report->product_name;
                    }

                    $grade1 = '';
                    if (!empty($report->api)) {
                        $grade1 .= 'API: ' . $report->api . '<br>';
                    }
                    if (!empty($grade1) && !empty($report->sae)) {
                        // $grade1 .= ', ';
                    }
                    if (!empty($report->sae)) {
                        $grade1 .= 'SAE: ' . $report->sae . '<br>';
                    }
                    if (!empty($grade1) && !empty($report->iso)) {
                        //   $grade1 .= ', ';
                    }
                    if (!empty($report->iso)) {
                        $grade1 .= 'ISO: ' . $report->iso;
                    }
                    $pack_size = !empty($report->pack_size) ? $report->pack_size : '';
                    $current_stock = intval($report->current_stock);
                    $quantity = !empty($report->quantity) ? intval($report->quantity) : 0;
                    $average_sale = ($month_duration_count > 0) ? ($quantity / $month_duration_count) : 0;
                    $average_sale = round($average_sale);
                    $expected_months = ($average_sale > 0) ? ($current_stock / $average_sale) : $current_stock;
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $product_name_part_1; ?></td>
                        <td><?= $grade1 ?></td>
                        <td><?= $pack_size; ?></td>
                        <td class="text-right"><?= $quantity; ?></td>
                        <td class="text-right"><?= round($average_sale); ?></td>
                        <td class="text-right"><?= $current_stock; ?></td>
                        <td class="text-right"><?= round($expected_months); ?></td>
                    </tr>
                <?php }
                ?>
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

