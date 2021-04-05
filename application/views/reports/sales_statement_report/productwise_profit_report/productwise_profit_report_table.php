<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Product: <?= ucfirst($product_name) ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button productwise-profit-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
                    <th>Product</th>
                    <th>Pack Size</th>
                    <th class="text-right">Qty(Pcs)</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Cost Price</th>
                    <th class="text-right">Margin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $sum_of_quantity_total = 0;
                $sum_of_sales_price_excluding_vat_total = 0;
                $cost_price_total = 0;
                $margin_total = 0;
                if (!empty($productwise_profit_report)) {
                    foreach ($productwise_profit_report as $productwise_profit) {
                        ?>
                        <?php
                        $sum_of_quantity = !empty($productwise_profit->sum_of_quantity) ? get_floating_point_number($productwise_profit->sum_of_quantity) : 0;
                        $sum_of_sales_price_excluding_vat = !empty($productwise_profit->sum_of_sales_price_excluding_vat) ? get_floating_point_number($productwise_profit->sum_of_sales_price_excluding_vat) : 0;
                        $cost_price = !empty($productwise_profit->cost_price) ? get_floating_point_number($productwise_profit->cost_price) : 0;
                        $margin = !empty($productwise_profit->margin) ? get_floating_point_number($productwise_profit->margin) : 0;
                        $sum_of_quantity_total += $sum_of_quantity;
                        $sum_of_sales_price_excluding_vat_total += $sum_of_sales_price_excluding_vat;
                        $cost_price_total += $cost_price;
                        $margin_total += $margin;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= !empty($productwise_profit->product_name) ? $productwise_profit->product_name : ''; ?></td>
                            <td><?= !empty($productwise_profit->pack_size) ? $productwise_profit->pack_size : ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($sum_of_quantity, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($sum_of_sales_price_excluding_vat, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($cost_price, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($margin, TRUE) ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class=""><strong>Grand Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_quantity_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_sales_price_excluding_vat_total, TRUE) ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($cost_price_total, TRUE) ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($margin_total, TRUE) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="productwise-profit-report-table-print-section" style="display: none; width: 100%" >
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
        <label class="search-from-date">Product: <?= ucfirst($product_name) ?></label>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product</th>
                <th>Pack Size</th>
                <th class="text-right">Qty(Pcs)</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Cost Price</th>
                <th class="text-right">Margin</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sum_of_quantity_total = 0;
            $sum_of_sales_price_excluding_vat_total = 0;
            $cost_price_total = 0;
            $margin_total = 0;
            if (!empty($productwise_profit_report)) {
                foreach ($productwise_profit_report as $productwise_profit) {
                    ?>
                    <?php
                    $sum_of_quantity = !empty($productwise_profit->sum_of_quantity) ? get_floating_point_number($productwise_profit->sum_of_quantity) : 0;
                    $sum_of_sales_price_excluding_vat = !empty($productwise_profit->sum_of_sales_price_excluding_vat) ? get_floating_point_number($productwise_profit->sum_of_sales_price_excluding_vat) : 0;
                    $cost_price = !empty($productwise_profit->cost_price) ? get_floating_point_number($productwise_profit->cost_price) : 0;
                    $margin = !empty($productwise_profit->margin) ? get_floating_point_number($productwise_profit->margin) : 0;
                    $sum_of_quantity_total += $sum_of_quantity;
                    $sum_of_sales_price_excluding_vat_total += $sum_of_sales_price_excluding_vat;
                    $cost_price_total += $cost_price;
                    $margin_total += $margin;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= !empty($productwise_profit->product_name) ? $productwise_profit->product_name : ''; ?></td>
                        <td><?= !empty($productwise_profit->pack_size) ? $productwise_profit->pack_size : ''; ?></td>
                        <td class="text-right"><?= get_floating_point_number($sum_of_quantity, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($sum_of_sales_price_excluding_vat, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($cost_price, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($margin, TRUE) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td class=""><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_quantity_total, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_sales_price_excluding_vat_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($cost_price_total, TRUE) ?></strong></td>
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

        $(".productwise-profit-report-table-print-button").click(function () {
            var divContents = $('#productwise-profit-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

