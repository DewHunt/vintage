<div class="card card-boarder">
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button sales-pfofit-report-invoicewise-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>
    <div class="table-responsive table-bordered" style="width: 100%;">
        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>RM Code</th>
                    <th>Party Name</th>
                    <th>Invoice No.</th>
                    <th class="text-right">Invoice/Sales Amount</th>
                    <th class="text-right">Gross Margin</th>
                    <th class="text-right">Commission Paid</th>
                    <th class="text-right">Delivery Cost</th>
                    <th class="text-right">Total Expense</th>
                    <th class="text-right">Total Deduction</th>
                    <th class="text-right">Net Profit/Loss</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($sales_pfofit_report_invoicewise)) {
                    $count = 1;
                    $amount_to_paid_total = 0;
                    $gross_margin_total = 0;
                    $commission_amount_total = 0;
                    $delivery_cost_total_amount_total = 0;
                    $total_expense_total = 0;
                    $deduction_total = 0;
                    $net_profit_loss_total = 0;
                    foreach ($sales_pfofit_report_invoicewise as $sales_pfofit_report) {
                        $id = !empty($sales_pfofit_report->id) ? intval($sales_pfofit_report->id) : 0;
                        $date_of_issue = date("d-m-Y", strtotime($sales_pfofit_report->date_of_issue));
                        $amount_to_paid = !empty($sales_pfofit_report->amount_to_paid) ? get_floating_point_number($sales_pfofit_report->amount_to_paid) : 0;
                        $sum_of_purchase_price = !empty($sales_pfofit_report->sum_of_purchase_price) ? get_floating_point_number($sales_pfofit_report->sum_of_purchase_price) : 0;
                        $gross_margin = ($amount_to_paid - $sum_of_purchase_price);
                        $commission_amount = !empty($sales_pfofit_report->commission_amount) ? get_floating_point_number($sales_pfofit_report->commission_amount) : 0;
                        $delivery_cost_total_amount = !empty($sales_pfofit_report->delivery_cost_total_amount) ? get_floating_point_number($sales_pfofit_report->delivery_cost_total_amount) : 0;
                        $deduction = !empty($sales_pfofit_report->deduction) ? get_floating_point_number($sales_pfofit_report->deduction) : 0;
                        $total_expense = ($commission_amount + $delivery_cost_total_amount);
                        $net_profit_loss = ($gross_margin - $total_expense);

                        $amount_to_paid_total += $amount_to_paid;
                        $gross_margin_total += $gross_margin;
                        $commission_amount_total += $commission_amount;
                        $delivery_cost_total_amount_total += $delivery_cost_total_amount;
                        $total_expense_total += $total_expense;
                        $deduction_total += $deduction;
                        $net_profit_loss_total += $net_profit_loss;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $date_of_issue; ?></td>
                            <td><?= !empty($sales_pfofit_report->employee_code) ? $sales_pfofit_report->employee_code : ''; ?></td>
                            <td><?= !empty($sales_pfofit_report->client_name) ? $sales_pfofit_report->client_name : ''; ?></td>
                            <td><?= !empty($sales_pfofit_report->invoice_number) ? $sales_pfofit_report->invoice_number : ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($amount_to_paid, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($gross_margin, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($commission_amount, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($delivery_cost_total_amount, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_expense, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($deduction, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($net_profit_loss, TRUE); ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($amount_to_paid_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($gross_margin_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($commission_amount_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($delivery_cost_total_amount_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_expense_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($deduction_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($net_profit_loss_total, TRUE); ?></strong></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="sales-pfofit-report-invoicewise-print-section" style="display: none; width: 100%" >
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
        <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>RM Code</th>
                <th>Party Name</th>
                <th>Invoice No.</th>
                <th class="text-right">Invoice/Sales Amount</th>
                <th class="text-right">Gross Margin</th>
                <th class="text-right">Commission Paid</th>
                <th class="text-right">Delivery Cost</th>
                <th class="text-right">Total Expense</th>
                <th class="text-right">Total Deduction</th>
                <th class="text-right">Net Profit/Loss</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sales_pfofit_report_invoicewise)) {
                $count = 1;
                $amount_to_paid_total = 0;
                $gross_margin_total = 0;
                $commission_amount_total = 0;
                $delivery_cost_total_amount_total = 0;
                $total_expense_total = 0;
                $deduction_total = 0;
                $net_profit_loss_total = 0;
                foreach ($sales_pfofit_report_invoicewise as $sales_pfofit_report) {
                    $id = !empty($sales_pfofit_report->id) ? intval($sales_pfofit_report->id) : 0;
                    $date_of_issue = date("d-m-Y", strtotime($sales_pfofit_report->date_of_issue));
                    $amount_to_paid = !empty($sales_pfofit_report->amount_to_paid) ? get_floating_point_number($sales_pfofit_report->amount_to_paid) : 0;
                    $sum_of_purchase_price = !empty($sales_pfofit_report->sum_of_purchase_price) ? get_floating_point_number($sales_pfofit_report->sum_of_purchase_price) : 0;
                    $gross_margin = ($amount_to_paid - $sum_of_purchase_price);
                    $commission_amount = !empty($sales_pfofit_report->commission_amount) ? get_floating_point_number($sales_pfofit_report->commission_amount) : 0;
                    $delivery_cost_total_amount = !empty($sales_pfofit_report->delivery_cost_total_amount) ? get_floating_point_number($sales_pfofit_report->delivery_cost_total_amount) : 0;
                    $deduction = !empty($sales_pfofit_report->deduction) ? get_floating_point_number($sales_pfofit_report->deduction) : 0;
                    $total_expense = ($commission_amount + $delivery_cost_total_amount);
                    $net_profit_loss = ($gross_margin - $total_expense);

                    $amount_to_paid_total += $amount_to_paid;
                    $gross_margin_total += $gross_margin;
                    $commission_amount_total += $commission_amount;
                    $delivery_cost_total_amount_total += $delivery_cost_total_amount;
                    $total_expense_total += $total_expense;
                    $deduction_total += $deduction;
                    $net_profit_loss_total += $net_profit_loss;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $date_of_issue; ?></td>
                        <td><?= !empty($sales_pfofit_report->employee_code) ? $sales_pfofit_report->employee_code : ''; ?></td>
                        <td><?= !empty($sales_pfofit_report->client_name) ? $sales_pfofit_report->client_name : ''; ?></td>
                        <td><?= !empty($sales_pfofit_report->invoice_number) ? $sales_pfofit_report->invoice_number : ''; ?></td>
                        <td class="text-right"><?= get_floating_point_number($amount_to_paid, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($gross_margin, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($commission_amount, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($delivery_cost_total_amount, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($total_expense, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($deduction, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($net_profit_loss, TRUE); ?></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($amount_to_paid_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($gross_margin_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($commission_amount_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($delivery_cost_total_amount_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_expense_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($deduction_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($net_profit_loss_total, TRUE); ?></strong></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
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

        $(".sales-pfofit-report-invoicewise-print-button").click(function () {
            var divContents = $('#sales-pfofit-report-invoicewise-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

