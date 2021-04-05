<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button sales-details-statement-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
                    <th>Date</th>
                    <th>Invoice No.</th>
                    <th>Party Name</th>
                    <th>Product</th>
                    <th>Pack Size</th>
                    <th>Mode of pay</th>
                    <th>Rate</th>
                    <th>Qty(Pcs)</th>
                    <th>Amount</th>
                    <th>Cost Price</th>
                    <th>Margin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $sales_price_excluding_vat_total = 0;
                $purchase_price_total = 0;
                $margin_total = 0;
                if (!empty($sales_details_statement_report)) {
                    foreach ($sales_details_statement_report as $sales_details_statement) {
                        ?>
                        <?php
                        $date_of_issue = date("d-m-Y", strtotime($sales_details_statement->date_of_issue));
                        $quantity = !empty($sales_details_statement->quantity) ? get_floating_point_number($sales_details_statement->quantity) : 0;
                        $unit_price = !empty($sales_details_statement->unit_price) ? get_floating_point_number($sales_details_statement->unit_price) : 0;
                        $sales_price_excluding_vat = !empty($sales_details_statement->sales_price_excluding_vat) ? get_floating_point_number($sales_details_statement->sales_price_excluding_vat) : 0;
                        $purchase_price = !empty($sales_details_statement->purchase_price) ? get_floating_point_number($sales_details_statement->purchase_price) : 0;
                        $margin = get_floating_point_number($sales_price_excluding_vat - ($quantity * $purchase_price));
                        $sales_price_excluding_vat_total += $sales_price_excluding_vat;
                        $purchase_price_total += $purchase_price;
                        $margin_total += $margin;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $date_of_issue; ?></td>
                            <td><?= !empty($sales_details_statement->invoice_number) ? $sales_details_statement->invoice_number : ''; ?></td>
                            <td><?= !empty($sales_details_statement->client_name) ? $sales_details_statement->client_name : ''; ?></td>
                            <td><?= !empty($sales_details_statement->product_name) ? $sales_details_statement->product_name : ''; ?></td>
                            <td><?= !empty($sales_details_statement->pack_size) ? $sales_details_statement->pack_size : ''; ?></td>
                            <?php if ((string) $sales_details_statement->mode_of_payment == 'tt') { ?>
                                <td><?= strtoupper($sales_details_statement->mode_of_payment) ?></td>
                            <?php } else { ?>
                                <td><?= ucfirst($sales_details_statement->mode_of_payment) ?></td>
                            <?php } ?>
                            <td class="text-right"><?= get_floating_point_number($unit_price, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($quantity, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($sales_price_excluding_vat, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($purchase_price, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($margin, TRUE) ?></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><strong>Grand Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sales_price_excluding_vat_total, TRUE) ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($purchase_price_total, TRUE) ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($margin_total, TRUE) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="sales-details-statement-table-print-section" style="display: none; width: 100%" >
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
                <th>Invoice No.</th>
                <th>Party Name</th>
                <th>Product</th>
                <th>Pack Size</th>
                <th>Mode of pay</th>
                <th>Rate</th>
                <th>Qty(Pcs)</th>
                <th>Amount</th>
                <th>Cost Price</th>
                <th>Margin</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sales_price_excluding_vat_total = 0;
            $purchase_price_total = 0;
            $margin_total = 0;
            if (!empty($sales_details_statement_report)) {
                foreach ($sales_details_statement_report as $sales_details_statement) {
                    ?>
                    <?php
                    $date_of_issue = date("d-m-Y", strtotime($sales_details_statement->date_of_issue));
                    $quantity = !empty($sales_details_statement->quantity) ? get_floating_point_number($sales_details_statement->quantity) : 0;
                    $unit_price = !empty($sales_details_statement->unit_price) ? get_floating_point_number($sales_details_statement->unit_price) : 0;
                    $sales_price_excluding_vat = !empty($sales_details_statement->sales_price_excluding_vat) ? get_floating_point_number($sales_details_statement->sales_price_excluding_vat) : 0;
                    $purchase_price = !empty($sales_details_statement->purchase_price) ? get_floating_point_number($sales_details_statement->purchase_price) : 0;
                    $margin = get_floating_point_number($sales_price_excluding_vat - ($quantity * $purchase_price));
                    $sales_price_excluding_vat_total += $sales_price_excluding_vat;
                    $purchase_price_total += $purchase_price;
                    $margin_total += $margin;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $date_of_issue; ?></td>
                        <td><?= !empty($sales_details_statement->invoice_number) ? $sales_details_statement->invoice_number : ''; ?></td>
                        <td><?= !empty($sales_details_statement->client_name) ? $sales_details_statement->client_name : ''; ?></td>
                        <td><?= !empty($sales_details_statement->product_name) ? $sales_details_statement->product_name : ''; ?></td>
                        <td><?= !empty($sales_details_statement->pack_size) ? $sales_details_statement->pack_size : ''; ?></td>
                        <?php if ((string) $sales_details_statement->mode_of_payment == 'tt') { ?>
                            <td><?= strtoupper($sales_details_statement->mode_of_payment) ?></td>
                        <?php } else { ?>
                            <td><?= ucfirst($sales_details_statement->mode_of_payment) ?></td>
                        <?php } ?>
                        <td class="text-right"><?= get_floating_point_number($unit_price, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($quantity, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($sales_price_excluding_vat, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($purchase_price, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($margin, TRUE) ?></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sales_price_excluding_vat_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($purchase_price_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($margin_total, TRUE) ?></strong></td>
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

        $(".sales-details-statement-table-print-button").click(function () {
            var divContents = $('#sales-details-statement-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

