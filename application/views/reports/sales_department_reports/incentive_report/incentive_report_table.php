<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= ($start_month_year) ?> To <?= $end_month_year ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button monthly-sales-collection-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <div class="col-xs-12">
                    <button type="button" class="right-side-view btn btn-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    <?php
                }
            }
            ?>
        </div>
        <div class="table-responsive table-bordered" style="width: 100%;">
            <table class="table table-bordered" id="details-table1">
                <thead>
                    <tr>
                        <th></th>
                        <th colspan="4" class="text-center">Performance</th>
                        <th></th>
                        <th colspan="4" class="text-center">Segregation</th>
                        <th></th>
                        <th colspan="4" class="text-center">Incentive</th>
                    </tr>
                    <tr>
                        <th>SL</th>
                        <th>Person</th>
                        <th class="text-right">Target</th>
                        <th class="text-right">Sale</th>
                        <th class="text-right">Collection</th>
                        <th class="text-right"></th>
                        <th class="text-right">LP</th>
                        <th class="text-right">RP</th>
                        <th class="text-right">USA</th>
                        <th class="text-right">Total</th>
                        <th class="text-right"></th>
                        <th class="text-right">LP</th>
                        <th class="text-right">RP</th>
                        <th class="text-right">USA</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $sum_of_target_amount = 0;
                    $sum_of_lubzone_sale = 0;
                    $sum_of_repsol_sale = 0;
                    $sum_of_usa_sale = 0;
                    $sum_of_total_sale = 0;
                    $sum_of_lubzone_collection = 0;
                    $sum_of_repsol_collection = 0;
                    $sum_of_usa_collection = 0;
                    $sum_of_total_collection = 0;
                    $sum_of_lubzone_incentive = 0;
                    $sum_of_repsol_incentive = 0;
                    $sum_of_usa_incentive = 0;
                    $sum_of_total_incentive = 0;
                    if (!empty($incentive_report)) {
                        foreach ($incentive_report as $report) {
                            $employee_id = intval($report['employee_id']);
                            if (in_array($employee_id, remove_employee_ids())) {
                                continue;
                            }
                            $employee_name = !empty($report['employee_name']) ? $report['employee_name'] : '';
                            $target_amount = !empty($report['target_amount']) ? get_floating_point_number($report['target_amount']) : 0;
                            $sum_of_target_amount += $target_amount;
                            $lubzone_sale = !empty($report['lubzone_sale']) ? get_floating_point_number($report['lubzone_sale']) : 0;
                            $sum_of_lubzone_sale += $lubzone_sale;
                            $repsol_sale = !empty($report['repsol_sale']) ? get_floating_point_number($report['repsol_sale']) : 0;
                            $sum_of_repsol_sale += $repsol_sale;
                            $usa_sale = !empty($report['usa_sale']) ? get_floating_point_number($report['usa_sale']) : 0;
                            $sum_of_usa_sale += $usa_sale;
                            $total_sale = !empty($report['total_sale']) ? get_floating_point_number($report['total_sale']) : 0;
                            $sum_of_total_sale += $total_sale;
                            $lubzone_collection = !empty($report['lubzone_collection']) ? get_floating_point_number($report['lubzone_collection']) : 0;
                            $sum_of_lubzone_collection += $lubzone_collection;
                            $lubzone_incentive = !empty($report['lubzone_incentive']) ? get_floating_point_number($report['lubzone_incentive']) : 0;
                            $sum_of_lubzone_incentive += $lubzone_incentive;
                            $repsol_collection = !empty($report['repsol_collection']) ? get_floating_point_number($report['repsol_collection']) : 0;
                            $sum_of_repsol_collection += $repsol_collection;
                            $repsol_incentive = !empty($report['repsol_incentive']) ? get_floating_point_number($report['repsol_incentive']) : 0;
                            $sum_of_repsol_incentive += $repsol_incentive;
                            $usa_collection = !empty($report['usa_collection']) ? get_floating_point_number($report['usa_collection']) : 0;
                            $sum_of_usa_collection += $usa_collection;
                            $usa_incentive = !empty($report['usa_incentive']) ? get_floating_point_number($report['usa_incentive']) : 0;
                            $sum_of_usa_incentive += $usa_incentive;
                            $total_collection = !empty($report['total_collection']) ? get_floating_point_number($report['total_collection']) : 0;
                            $sum_of_total_collection += $total_collection;
                            $total_incentive = !empty($report['total_incentive']) ? get_floating_point_number($report['total_incentive']) : 0;
                            $sum_of_total_incentive += $total_incentive;
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $employee_name; ?></td>
                                <td class="text-right"><?= get_floating_point_number($target_amount, TRUE); ?></td>
                                <td class="text-right"><?= get_floating_point_number($total_sale, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($total_collection, TRUE) ?></td>
                                <td class="text-right"><?= ''; ?></td>
                                <td class="text-right"><?= get_floating_point_number($lubzone_collection, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($repsol_collection, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($usa_collection, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($total_collection, TRUE) ?></td>

                                <td class="text-right"><?= ''; ?></td>
                                <td class="text-right"><?= get_floating_point_number($lubzone_incentive, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($repsol_incentive, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($usa_incentive, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($total_incentive, TRUE) ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td><strong></strong></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_target_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_sale, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_collection, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= ''; ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_lubzone_collection, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_repsol_collection, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_usa_collection, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_collection, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= ''; ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_lubzone_incentive, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_repsol_incentive, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_usa_incentive, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_incentive, TRUE); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--DISPLAY NONE-->
    <!--USE FOR PRINT-->

    <div id="monthly-sales-collection-report-table-print-section" style="display: none; width: 100%;">
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
            <label class="search-from-date">Period: <?= $start_month_year; ?> To <?= $end_month_year; ?> </label><br>
        </div>
        <br>
        <table class="table table-bordered print-table" id="details-table1">
            <thead>
                <tr>
                    <th></th>
                    <th colspan="4" class="text-center">Performance</th>
                    <th></th>
                    <th colspan="4" class="text-center">Segregation</th>
                    <th></th>
                    <th colspan="4" class="text-center">Incentive</th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Person</th>
                    <th class="text-right">Target</th>
                    <th class="text-right">Sale</th>
                    <th class="text-right">Collection</th>
                    <th class="text-right" style="min-width: 10px;"></th>
                    <th class="text-right">LP</th>
                    <th class="text-right">RP</th>
                    <th class="text-right">USA</th>
                    <th class="text-right">Total</th>
                    <th class="text-right" style="min-width: 10px;"></th>
                    <th class="text-right">LP</th>
                    <th class="text-right">RP</th>
                    <th class="text-right">USA</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $sum_of_target_amount = 0;
                $sum_of_lubzone_sale = 0;
                $sum_of_repsol_sale = 0;
                $sum_of_usa_sale = 0;
                $sum_of_total_sale = 0;
                $sum_of_lubzone_collection = 0;
                $sum_of_repsol_collection = 0;
                $sum_of_usa_collection = 0;
                $sum_of_total_collection = 0;
                $sum_of_lubzone_incentive = 0;
                $sum_of_repsol_incentive = 0;
                $sum_of_usa_incentive = 0;
                $sum_of_total_incentive = 0;
                if (!empty($incentive_report)) {
                    foreach ($incentive_report as $report) {
                        $employee_id = intval($report['employee_id']);
                        if (in_array($employee_id, remove_employee_ids())) {
                            continue;
                        }
                        $employee_name = !empty($report['employee_name']) ? $report['employee_name'] : '';
                        $target_amount = !empty($report['target_amount']) ? get_floating_point_number($report['target_amount']) : 0;
                        $sum_of_target_amount += $target_amount;
                        $lubzone_sale = !empty($report['lubzone_sale']) ? get_floating_point_number($report['lubzone_sale']) : 0;
                        $sum_of_lubzone_sale += $lubzone_sale;
                        $repsol_sale = !empty($report['repsol_sale']) ? get_floating_point_number($report['repsol_sale']) : 0;
                        $sum_of_repsol_sale += $repsol_sale;
                        $usa_sale = !empty($report['usa_sale']) ? get_floating_point_number($report['usa_sale']) : 0;
                        $sum_of_usa_sale += $usa_sale;
                        $total_sale = !empty($report['total_sale']) ? get_floating_point_number($report['total_sale']) : 0;
                        $sum_of_total_sale += $total_sale;
                        $lubzone_collection = !empty($report['lubzone_collection']) ? get_floating_point_number($report['lubzone_collection']) : 0;
                        $sum_of_lubzone_collection += $lubzone_collection;
                        $lubzone_incentive = !empty($report['lubzone_incentive']) ? get_floating_point_number($report['lubzone_incentive']) : 0;
                        $sum_of_lubzone_incentive += $lubzone_incentive;
                        $repsol_collection = !empty($report['repsol_collection']) ? get_floating_point_number($report['repsol_collection']) : 0;
                        $sum_of_repsol_collection += $repsol_collection;
                        $repsol_incentive = !empty($report['repsol_incentive']) ? get_floating_point_number($report['repsol_incentive']) : 0;
                        $sum_of_repsol_incentive += $repsol_incentive;
                        $usa_collection = !empty($report['usa_collection']) ? get_floating_point_number($report['usa_collection']) : 0;
                        $sum_of_usa_collection += $usa_collection;
                        $usa_incentive = !empty($report['usa_incentive']) ? get_floating_point_number($report['usa_incentive']) : 0;
                        $sum_of_usa_incentive += $usa_incentive;
                        $total_collection = !empty($report['total_collection']) ? get_floating_point_number($report['total_collection']) : 0;
                        $sum_of_total_collection += $total_collection;
                        $total_incentive = !empty($report['total_incentive']) ? get_floating_point_number($report['total_incentive']) : 0;
                        $sum_of_total_incentive += $total_incentive;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $employee_name; ?></td>
                            <td class="text-right"><?= get_floating_point_number($target_amount, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_sale, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_collection, TRUE) ?></td>
                            <td class="text-right"><?= ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($lubzone_collection, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($repsol_collection, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($usa_collection, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_collection, TRUE) ?></td>

                            <td class="text-right"><?= ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($lubzone_incentive, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($repsol_incentive, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($usa_incentive, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_incentive, TRUE) ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td><strong></strong></td>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_target_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_sale, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= ''; ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_lubzone_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_repsol_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_usa_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= ''; ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_lubzone_incentive, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_repsol_incentive, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_usa_incentive, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_total_incentive, TRUE); ?></strong></td>
                </tr>
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

            $(".monthly-sales-collection-report-table-print-button").click(function () {
                var divContents = $('#monthly-sales-collection-report-table-print-section').html();
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });

        });
    </script>

