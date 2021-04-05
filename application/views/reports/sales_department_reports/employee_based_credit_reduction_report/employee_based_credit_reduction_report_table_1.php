<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= $start_month_year; ?> To <?= $end_month_year; ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button employee-based-credit-reduction-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="table-responsive table-bordered" style="width: 100%;">
        <?php
        if (!empty($employee_based_credit_reduction_report)) {
            foreach ($employee_based_credit_reduction_report as $credit_reduction_report) {
                $client = $credit_reduction_report['client'];
                $report_array = $credit_reduction_report['report_array'];
                ?>
                <table class="table table-striped" id="details-table1">
                    <thead>
                        <tr>
                            <th><?= !empty($client->client_name) ? $client->client_name : ''; ?></th>
                            <th class="text-right">Opening</th>
                            <th class="text-right">Sale</th>
                            <th class="text-right">Collection</th>
                            <th class="text-right">Closing</th>
                            <th class="text-right">Credit Reduction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $sum_of_opening_balance = 0;
                        $sum_of_sale_amount = 0;
                        $sum_of_collection_amount = 0;
                        $sum_of_closing_amount = 0;
                        $sum_of_credit_reduction = 0;
                        if (!empty($report_array)) {
                            foreach ($report_array as $report) {
                                $client_id = intval($report['client_id']);
                                $client_name = !empty($report['client_name']) ? $report['client_name'] : '';
                                $client_type = !empty($report['client_type']) ? $report['client_type'] : '';
                                $month_name = !empty($report['month_name']) ? $report['month_name'] : '';
                                $year = !empty($report['year']) ? $report['year'] : '';
                                $month_year = (!empty($month_name) ? $month_name : '') . (!empty($year) ? '-' . $year : '');
                                $opening_balance = !empty($report['opening_balance']) ? get_floating_point_number($report['opening_balance']) : 0;
                                $sum_of_opening_balance += $opening_balance;
                                $sale_amount = !empty($report['sale_amount']) ? get_floating_point_number($report['sale_amount']) : 0;
                                $sum_of_sale_amount += $sale_amount;
                                $collection_amount = !empty($report['collection_amount']) ? get_floating_point_number($report['collection_amount']) : 0;
                                $sum_of_collection_amount += $collection_amount;
                                $closing_amount = !empty($report['closing_amount']) ? get_floating_point_number($report['closing_amount']) : 0;
                                $sum_of_closing_amount += $closing_amount;
                                $credit_reduction = !empty($report['credit_reduction']) ? get_floating_point_number($report['credit_reduction']) : 0;
                                $sum_of_credit_reduction += $credit_reduction;
                                ?>
                                <tr>
                                    <td><?= $month_year; ?></td>
                                    <td class="text-right"><?= get_floating_point_number($opening_balance, TRUE); ?></td>
                                    <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($closing_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($credit_reduction, TRUE) ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td><strong>Overall</strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_opening_balance, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_closing_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_credit_reduction, TRUE); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="employee-based-credit-reduction-report-table-print-section" style="display: none; width: 100%" >
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
    <div class="table-responsive table-bordered" style="width: 100%;">
        <?php
        if (!empty($employee_based_credit_reduction_report)) {
            foreach ($employee_based_credit_reduction_report as $credit_reduction_report) {
                $client = $credit_reduction_report['client'];
                $report_array = $credit_reduction_report['report_array'];
                ?>
        <table class="table table-striped print-table" id="details-table1" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th><?= !empty($client->client_name) ? $client->client_name : ''; ?></th>
                            <th class="text-right">Opening</th>
                            <th class="text-right">Sale</th>
                            <th class="text-right">Collection</th>
                            <th class="text-right">Closing</th>
                            <th class="text-right">Credit Reduction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $sum_of_opening_balance = 0;
                        $sum_of_sale_amount = 0;
                        $sum_of_collection_amount = 0;
                        $sum_of_closing_amount = 0;
                        $sum_of_credit_reduction = 0;
                        if (!empty($report_array)) {
                            foreach ($report_array as $report) {
                                $client_id = intval($report['client_id']);
                                $client_name = !empty($report['client_name']) ? $report['client_name'] : '';
                                $client_type = !empty($report['client_type']) ? $report['client_type'] : '';
                                $month_name = !empty($report['month_name']) ? $report['month_name'] : '';
                                $year = !empty($report['year']) ? $report['year'] : '';
                                $month_year = (!empty($month_name) ? $month_name : '') . (!empty($year) ? '-' . $year : '');
                                $opening_balance = !empty($report['opening_balance']) ? get_floating_point_number($report['opening_balance']) : 0;
                                $sum_of_opening_balance += $opening_balance;
                                $sale_amount = !empty($report['sale_amount']) ? get_floating_point_number($report['sale_amount']) : 0;
                                $sum_of_sale_amount += $sale_amount;
                                $collection_amount = !empty($report['collection_amount']) ? get_floating_point_number($report['collection_amount']) : 0;
                                $sum_of_collection_amount += $collection_amount;
                                $closing_amount = !empty($report['closing_amount']) ? get_floating_point_number($report['closing_amount']) : 0;
                                $sum_of_closing_amount += $closing_amount;
                                $credit_reduction = !empty($report['credit_reduction']) ? get_floating_point_number($report['credit_reduction']) : 0;
                                $sum_of_credit_reduction += $credit_reduction;
                                ?>
                                <tr>
                                    <td><?= $month_year; ?></td>
                                    <td class="text-right"><?= get_floating_point_number($opening_balance, TRUE); ?></td>
                                    <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($closing_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($credit_reduction, TRUE) ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td><strong>Overall</strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_opening_balance, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_closing_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_credit_reduction, TRUE); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>
    </div>
</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $(".employee-based-credit-reduction-report-table-print-button").click(function () {
            var divContents = $('#employee-based-credit-reduction-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

