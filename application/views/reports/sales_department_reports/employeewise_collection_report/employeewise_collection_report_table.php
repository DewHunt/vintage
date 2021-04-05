<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button outstanding-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <div class="col-xs-12">
                    <button type="button" class="right-side-view btn btn-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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
                        <th>Client Name</th>
                        <th class="text-right">Opening</th>
                        <th class="text-right">Sale</th>
                        <th class="text-right">Collection</th>
                        <th class="text-right">Closing</th>
                        <th class="text-right">Oldest Unpaid Bill</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $employee_obj = new Employee_Model();
                    $count = 1;
                    $sum_of_opening_balance = 0;
                    $sum_of_sale_amount = 0;
                    $sum_of_collection_amount = 0;
                    $sum_of_average_sale_amount = 0;
                    $sum_of_credit_month = 0;
                    $sum_of_closing_amount = 0;
                    if (!empty($outstanding_report)) {
                        foreach ($outstanding_report as $report) {
                            $employee_id = intval($report->employee_id);
                            if (in_array($employee_id, remove_employee_ids())) {
                                continue;
                            }
                            $employee_name = !empty($report->employee_name) ? $report->employee_name : '';
                            $client_id = !empty($report->client_id) ? intval($report->client_id) : 0;
                            $client_name = !empty($report->client_name) ? $report->client_name : '';
                            $opening_balance = !empty($report->opening_balance) ? get_floating_point_number((get_floating_point_number($report->opening_balance) * (-1))) : 0;
                            $sum_of_opening_balance += $opening_balance;
                            $sale_amount = !empty($report->sale_amount) ? get_floating_point_number($report->sale_amount) : 0;
                            $sum_of_sale_amount += $sale_amount;
                            $collection_amount = !empty($report->collection_amount) ? get_floating_point_number($report->collection_amount) : 0;
                            $sum_of_collection_amount += $collection_amount;
                            $closing_amount = get_floating_point_number(($opening_balance + $sale_amount) - $collection_amount);
                            $sum_of_closing_amount += $closing_amount;
                            $average_sale_amount = ($sale_amount > 0) ? ($sale_amount / $month_duration_count) : 0;
                            $sum_of_average_sale_amount += $average_sale_amount;
                            $credit_month = ($average_sale_amount > 0) ? ($closing_amount / $average_sale_amount) : 0;
                            $sum_of_credit_month += $credit_month;
                            $oldest_unpaid_bill_date = $employee_obj->get_oldest_unpaid_bill_date($client_id);
                            $oldest_unpaid_bill = ($oldest_unpaid_bill_date != NULL) ? get_month_diff($oldest_unpaid_bill_date, get_current_date()) : 0;
                            if (($oldest_unpaid_bill_date != NULL) && (strtotime($oldest_unpaid_bill_date)) > (strtotime(get_end_date_format($end_date)))) {
                                $oldest_unpaid_bill = 0;
                            }
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $client_name; ?></td>
                                <td class="text-right"><?= get_floating_point_number(abs($opening_balance), TRUE); ?></td>
                                <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number(abs($closing_amount), TRUE) ?></td>
                                <td class="text-right"><?= $oldest_unpaid_bill . ' Months(s)'; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td><strong></strong></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number(abs($sum_of_opening_balance), TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number(abs($sum_of_closing_amount), TRUE); ?></strong></td>
                        <td class="text-right"><strong></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="outstanding-report-table-print-section" style="display: none; width: 100%" >
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
                <th>Client Name</th>
                <th class="text-right">Opening</th>
                <th class="text-right">Sale</th>
                <th class="text-right">Collection</th>
                <th class="text-right">Closing</th>
                <th class="text-right">Oldest Unpaid Bill</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $employee_obj = new Employee_Model();
            $count = 1;
            $sum_of_opening_balance = 0;
            $sum_of_sale_amount = 0;
            $sum_of_collection_amount = 0;
            $sum_of_average_sale_amount = 0;
            $sum_of_credit_month = 0;
            $sum_of_closing_amount = 0;
            if (!empty($outstanding_report)) {
                foreach ($outstanding_report as $report) {
                    $employee_id = intval($report->employee_id);
                    if (in_array($employee_id, remove_employee_ids())) {
                        continue;
                    }
                    $employee_name = !empty($report->employee_name) ? $report->employee_name : '';
                    $client_id = !empty($report->client_id) ? intval($report->client_id) : 0;
                    $client_name = !empty($report->client_name) ? $report->client_name : '';
                    $opening_balance = !empty($report->opening_balance) ? get_floating_point_number((get_floating_point_number($report->opening_balance) * (-1))) : 0;
                    $sum_of_opening_balance += $opening_balance;
                    $sale_amount = !empty($report->sale_amount) ? get_floating_point_number($report->sale_amount) : 0;
                    $sum_of_sale_amount += $sale_amount;
                    $collection_amount = !empty($report->collection_amount) ? get_floating_point_number($report->collection_amount) : 0;
                    $sum_of_collection_amount += $collection_amount;
                    $closing_amount = get_floating_point_number(($opening_balance + $sale_amount) - $collection_amount);
                    $sum_of_closing_amount += $closing_amount;
                    $average_sale_amount = ($sale_amount > 0) ? ($sale_amount / $month_duration_count) : 0;
                    $sum_of_average_sale_amount += $average_sale_amount;
                    $credit_month = ($average_sale_amount > 0) ? ($closing_amount / $average_sale_amount) : 0;
                    $sum_of_credit_month += $credit_month;
                    $oldest_unpaid_bill_date = $employee_obj->get_oldest_unpaid_bill_date($client_id);
                    $oldest_unpaid_bill = ($oldest_unpaid_bill_date != NULL) ? get_month_diff($oldest_unpaid_bill_date, get_current_date()) : 0;
                    if (($oldest_unpaid_bill_date != NULL) && (strtotime($oldest_unpaid_bill_date)) > (strtotime(get_end_date_format($end_date)))) {
                        $oldest_unpaid_bill = 0;
                    }
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $client_name; ?></td>
                        <td class="text-right"><?= get_floating_point_number(abs($opening_balance), TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number(abs($closing_amount), TRUE) ?></td>
                        <td class="text-right"><?= $oldest_unpaid_bill . ' Month(s)'; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number(abs($sum_of_opening_balance), TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number(abs($sum_of_closing_amount), TRUE); ?></strong></td>
                <td class="text-right"><strong></strong></td>
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

        $(".outstanding-report-table-print-button").click(function () {
            var divContents = $('#outstanding-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

