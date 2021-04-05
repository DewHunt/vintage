<div class="card card-boarder">

    <?php
    $company_information;
    $product_information;
    $periodic_item_product_store_report_view;

    /* echo '<pre>';
      echo print_r($periodic_item_product_store_report_view);
      echo '</pre>'; */
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Product: <?= ucfirst($product_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= get_string_to_date_fromat($start_date) ?> To <?= get_string_to_date_fromat($end_date) ?> </label><br>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary periodic-item-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Open Stock</th>
                <th>Receive Stock</th>
                <th>Transfer Stock</th>
                <th>Sale From Stock</th>
                <th>Damage Stock</th>
                <th>Return Stock</th>
                <th>Closing Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $open_stock_sum_total = 0;
            $receive_stock_sum_total = 0;
            $transfer_stock_sum_total = 0;
            $sale_from_stock_total = 0;
            $damage_stock_total = 0;
            $return_stock_total = 0;
            $closing_stock_total = 0;
            foreach ($periodic_item_product_store_report_view as $periodic_item_product_store_report):
                ?>
                <?php
                $open_stock_sum_total += (int) $periodic_item_product_store_report['open_stock'];
                $receive_stock_sum_total += (int) $periodic_item_product_store_report['receive_stock'];
                $transfer_stock_sum_total += (int) $periodic_item_product_store_report['transfer_stock'];
                $sale_from_stock_total += (int) $periodic_item_product_store_report['sale_from_stock'];
                $damage_stock_total += (int) $periodic_item_product_store_report['damage_stock'];
                $return_stock_total += (int) $periodic_item_product_store_report['return_stock'];
                $closing_stock_total += (int) $periodic_item_product_store_report['closing_stock'];
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($periodic_item_product_store_report['product_name']) ?></td>
                    <td><?= $periodic_item_product_store_report['open_stock'] ?></td>
                    <td><?= $periodic_item_product_store_report['receive_stock'] ?></td>
                    <td><?= $periodic_item_product_store_report['transfer_stock'] ?></td>
                    <td><?= $periodic_item_product_store_report['sale_from_stock'] ?></td>
                    <td><?= $periodic_item_product_store_report['damage_stock'] ?></td>
                    <td><?= $periodic_item_product_store_report['return_stock'] ?></td>
                    <td><?= $periodic_item_product_store_report['closing_stock'] ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td><strong>Total</strong></td>
                <td><strong><?= $open_stock_sum_total ?></strong></td>
                <td><strong><?= $receive_stock_sum_total ?></strong></td>
                <td><strong><?= $transfer_stock_sum_total ?></strong></td>
                <td><strong><?= $sale_from_stock_total ?></strong></td>
                <td><strong><?= $damage_stock_total ?></strong></td>
                <td><strong><?= $return_stock_total ?></strong></td>
                <td><strong><?= $closing_stock_total ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="periodic-item-report-print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Periodic Item Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Product: <?= ucfirst($product_name) ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?= get_string_to_date_fromat($start_date) ?> To <?= get_string_to_date_fromat($end_date) ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table border="2px" cellspacing="0" class="table table-striped" id="details-table" style="width: 100%;">
                <thead class="thead-default">
                    <tr style="border: thick">
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Product Name</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Open Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Receive Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Transfer Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Sale From Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Damage Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Return Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Closing Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $open_stock_sum_total = 0;
                    $receive_stock_sum_total = 0;
                    $transfer_stock_sum_total = 0;
                    $sale_from_stock_total = 0;
                    $damage_stock_total = 0;
                    $return_stock_total = 0;
                    $closing_stock_total = 0;
                    foreach ($periodic_item_product_store_report_view as $periodic_item_product_store_report):
                        ?>
                        <?php
                        $open_stock_sum_total += (int) $periodic_item_product_store_report['open_stock'];
                        $receive_stock_sum_total += (int) $periodic_item_product_store_report['receive_stock'];
                        $transfer_stock_sum_total += (int) $periodic_item_product_store_report['transfer_stock'];
                        $sale_from_stock_total += (int) $periodic_item_product_store_report['sale_from_stock'];
                        $damage_stock_total += (int) $periodic_item_product_store_report['damage_stock'];
                        $return_stock_total += (int) $periodic_item_product_store_report['return_stock'];
                        $closing_stock_total += (int) $periodic_item_product_store_report['closing_stock'];
                        ?>
                        <tr style="border: thick">
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: left"><?= ucfirst($periodic_item_product_store_report['product_name']) ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['open_stock'] ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['receive_stock'] ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['transfer_stock'] ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['sale_from_stock'] ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['damage_stock'] ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['return_stock'] ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $periodic_item_product_store_report['closing_stock'] ?></td>

                        </tr>
                    <?php endforeach; ?>
                    <tr style="border: thick">
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong>Total</strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $open_stock_sum_total ?></strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $receive_stock_sum_total ?></strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $transfer_stock_sum_total ?></strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $sale_from_stock_total ?></strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $damage_stock_total ?></strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $return_stock_total ?></strong></td>
                        <td style="padding-top:20px; border-bottom: 1px solid #ddd; text-align: center"><strong><?= $closing_stock_total ?></strong></td>
                    </tr>
                <hr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".periodic-item-report-print-button").on("click", function () {

        var divContents = $('#periodic-item-report-print-information').html();

        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

        //Print Page
        window.print();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });
</script>
