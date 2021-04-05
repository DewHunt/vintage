<div class="card card-boarder">
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button sales-pfofit-report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
                    <th>Product Description</th>
                    <th>Invoice/Sales Amount</th>
                    <th>Qty</th>
                    <th>Per Pcs Price</th>
                    <th>Cost Price</th>
                    <th>Gross Margin</th>
                    <th>Commission Paid</th>
                    <th>Delivery Cost</th>
                    <th>Total Expense</th>
                    <th>Total Deduction</th>
                    <th>Net Profit/Loss</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $temp_id = 0;
                $gross_margin = 0;
                $total_expense = 0;
                $net_profit_loss = 0;

                $amount_to_paid_total = 0;
                $quantity_total = 0;
                $unit_price_total = 0;
                $purchase_price_total = 0;
                $gross_margin_total = 0;
                $commission_amount_total = 0;
                $delivery_cost_total_amount_total = 0;
                $total_expense_total = 0;
                $deduction_total = 0;
                $net_profit_loss_total = 0;
                if (!empty($sales_pfofit_report)) {
                    foreach ($sales_pfofit_report as $sales_pfofit) {
                        ?>
                        <?php
                        $id = !empty($sales_pfofit->id) ? intval($sales_pfofit->id) : 0;
                        $date_of_issue = date("d-m-Y", strtotime($sales_pfofit->date_of_issue));
                        $amount_to_paid = !empty($sales_pfofit->amount_to_paid) ? get_floating_point_number($sales_pfofit->amount_to_paid) : 0;
                        $quantity = !empty($sales_pfofit->quantity) ? get_floating_point_number($sales_pfofit->quantity) : 0;
                        $unit_price = !empty($sales_pfofit->unit_price) ? get_floating_point_number($sales_pfofit->unit_price) : 0;
                        $sales_price_excluding_vat = !empty($sales_pfofit->sales_price_excluding_vat) ? get_floating_point_number($sales_pfofit->sales_price_excluding_vat) : 0;
                        $purchase_price = !empty($sales_pfofit->purchase_price) ? get_floating_point_number($sales_pfofit->purchase_price) : 0;
                        $margin = get_floating_point_number($sales_price_excluding_vat - ($quantity * $purchase_price));
                        $gross_margin = ($amount_to_paid - $purchase_price);
                        $commission_amount = !empty($sales_pfofit->commission_amount) ? get_floating_point_number($sales_pfofit->commission_amount) : 0;
                        $delivery_cost_total_amount = !empty($sales_pfofit->delivery_cost_total_amount) ? get_floating_point_number($sales_pfofit->delivery_cost_total_amount) : 0;
                        $deduction = !empty($sales_pfofit->deduction) ? get_floating_point_number($sales_pfofit->deduction) : 0;
                        $total_expense = ($commission_amount + $delivery_cost_total_amount);
                        $net_profit_loss = ($margin - $total_expense);
                        if ($id != $temp_id) {
                            $amount_to_paid_total += $amount_to_paid;
                            $commission_amount_total += $commission_amount;
                            $delivery_cost_total_amount_total += $delivery_cost_total_amount;
                            $total_expense_total += $total_expense;
                            $deduction_total += $deduction;
                            $net_profit_loss_total += $net_profit_loss;
                        }
                        $quantity_total += $quantity;
                        $unit_price_total += $unit_price;
                        $purchase_price_total += $purchase_price;
                        $gross_margin_total += $gross_margin;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $date_of_issue; ?></td>
                            <td><?= !empty($sales_pfofit->employee_code) ? $sales_pfofit->employee_code : ''; ?></td>
                            <td><?= !empty($sales_pfofit->client_name) ? $sales_pfofit->client_name : ''; ?></td>
                            <td><?= !empty($sales_pfofit->invoice_number) ? $sales_pfofit->invoice_number : ''; ?></td>
                            <td><?= !empty($sales_pfofit->product_name) ? $sales_pfofit->product_name : ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($amount_to_paid, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($quantity, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($unit_price, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($purchase_price, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($gross_margin, TRUE); ?></td>
                            <td class="text-right"><?php
                                if ($id != $temp_id) {
                                    echo get_floating_point_number($commission_amount, TRUE);
//                                    $temp_id = $id;
                                } else {
                                    echo '';
                                }
                                ?></td>
                            <td class="text-right"><?php
                                if ($id != $temp_id) {
                                    echo get_floating_point_number($delivery_cost_total_amount, TRUE);
//                                    $temp_id = $id;
                                } else {
                                    echo '';
                                }
                                ?></td>
                            <td class="text-right"><?php
                                if ($id != $temp_id) {
                                    echo get_floating_point_number($total_expense, TRUE);
//                                    $temp_id = $id;
                                } else {
                                    echo '';
                                }
                                ?></td>
                            <td class="text-right"><?php
                                if ($id != $temp_id) {
                                    echo get_floating_point_number($deduction, TRUE);
//                                    $temp_id = $id;
                                } else {
                                    echo '';
                                }
                                ?></td>
                            <td class="text-right"><?php
                                if ($id != $temp_id) {
                                    echo get_floating_point_number($net_profit_loss, TRUE);
                                    $temp_id = $id;
                                } else {
                                    echo '';
                                }
                                ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($amount_to_paid_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($quantity_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($unit_price_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($purchase_price_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($gross_margin_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($commission_amount_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($delivery_cost_total_amount_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_expense_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($deduction_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($net_profit_loss_total, TRUE); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="sales-pfofit-report-print-section" style="display: none; width: 100%" >
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
                <th>Product Description</th>
                <th>Invoice/Sales Amount</th>
                <th>Qty</th>
                <th>Per Pcs Price</th>
                <th>Cost Price</th>
                <th>Gross Margin</th>
                <th>Commission Paid</th>
                <th>Delivery Cost</th>
                <th>Total Expense</th>
                <th>Total Deduction</th>
                <th>Net Profit/Loss</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $temp_id = 0;
            $gross_margin = 0;
            $total_expense = 0;
            $net_profit_loss = 0;

            $amount_to_paid_total = 0;
            $quantity_total = 0;
            $unit_price_total = 0;
            $purchase_price_total = 0;
            $gross_margin_total = 0;
            $commission_amount_total = 0;
            $delivery_cost_total_amount_total = 0;
            $total_expense_total = 0;
            $deduction_total = 0;
            $net_profit_loss_total = 0;
            if (!empty($sales_pfofit_report)) {
                foreach ($sales_pfofit_report as $sales_pfofit) {
                    ?>
                    <?php
                    $id = !empty($sales_pfofit->id) ? intval($sales_pfofit->id) : 0;
                    $date_of_issue = date("d-m-Y", strtotime($sales_pfofit->date_of_issue));
                    $amount_to_paid = !empty($sales_pfofit->amount_to_paid) ? get_floating_point_number($sales_pfofit->amount_to_paid) : 0;
                    $quantity = !empty($sales_pfofit->quantity) ? get_floating_point_number($sales_pfofit->quantity) : 0;
                    $unit_price = !empty($sales_pfofit->unit_price) ? get_floating_point_number($sales_pfofit->unit_price) : 0;
                    $sales_price_excluding_vat = !empty($sales_pfofit->sales_price_excluding_vat) ? get_floating_point_number($sales_pfofit->sales_price_excluding_vat) : 0;
                    $purchase_price = !empty($sales_pfofit->purchase_price) ? get_floating_point_number($sales_pfofit->purchase_price) : 0;
                    $margin = get_floating_point_number($sales_price_excluding_vat - ($quantity * $purchase_price));
                    $gross_margin = ($amount_to_paid - $purchase_price);
                    $commission_amount = !empty($sales_pfofit->commission_amount) ? get_floating_point_number($sales_pfofit->commission_amount) : 0;
                    $delivery_cost_total_amount = !empty($sales_pfofit->delivery_cost_total_amount) ? get_floating_point_number($sales_pfofit->delivery_cost_total_amount) : 0;
                    $deduction = !empty($sales_pfofit->deduction) ? get_floating_point_number($sales_pfofit->deduction) : 0;
                    $total_expense = ($commission_amount + $delivery_cost_total_amount);
                    $net_profit_loss = ($margin - $total_expense);
                    if ($id != $temp_id) {
                        $amount_to_paid_total += $amount_to_paid;
                        $commission_amount_total += $commission_amount;
                        $delivery_cost_total_amount_total += $delivery_cost_total_amount;
                        $total_expense_total += $total_expense;
                        $deduction_total += $deduction;
                        $net_profit_loss_total += $net_profit_loss;
                    }
                    $quantity_total += $quantity;
                    $unit_price_total += $unit_price;
                    $purchase_price_total += $purchase_price;
                    $gross_margin_total += $gross_margin;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $date_of_issue; ?></td>
                        <td><?= !empty($sales_pfofit->employee_code) ? $sales_pfofit->employee_code : ''; ?></td>
                        <td><?= !empty($sales_pfofit->client_name) ? $sales_pfofit->client_name : ''; ?></td>
                        <td><?= !empty($sales_pfofit->invoice_number) ? $sales_pfofit->invoice_number : ''; ?></td>
                        <td><?= !empty($sales_pfofit->product_name) ? $sales_pfofit->product_name : ''; ?></td>
                        <td class="text-right"><?= get_floating_point_number($amount_to_paid, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($quantity, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($unit_price, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($purchase_price, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($gross_margin, TRUE); ?></td>
                        <td class="text-right"><?php
                            if ($id != $temp_id) {
                                echo get_floating_point_number($commission_amount, TRUE);
//                                    $temp_id = $id;
                            } else {
                                echo '';
                            }
                            ?></td>
                        <td class="text-right"><?php
                            if ($id != $temp_id) {
                                echo get_floating_point_number($delivery_cost_total_amount, TRUE);
//                                    $temp_id = $id;
                            } else {
                                echo '';
                            }
                            ?></td>
                        <td class="text-right"><?php
                            if ($id != $temp_id) {
                                echo get_floating_point_number($total_expense, TRUE);
//                                    $temp_id = $id;
                            } else {
                                echo '';
                            }
                            ?></td>
                        <td class="text-right"><?php
                            if ($id != $temp_id) {
                                echo get_floating_point_number($deduction, TRUE);
//                                    $temp_id = $id;
                            } else {
                                echo '';
                            }
                            ?></td>
                        <td class="text-right"><?php
                            if ($id != $temp_id) {
                                echo get_floating_point_number($net_profit_loss, TRUE);
                                $temp_id = $id;
                            } else {
                                echo '';
                            }
                            ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($amount_to_paid_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($quantity_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($unit_price_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($purchase_price_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($gross_margin_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($commission_amount_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($delivery_cost_total_amount_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($total_expense_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($deduction_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($net_profit_loss_total, TRUE); ?></strong></td>
            </tr>
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

        $(".sales-pfofit-report-print-button").click(function () {
            var divContents = $('#sales-pfofit-report-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

