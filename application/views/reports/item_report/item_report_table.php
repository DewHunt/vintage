<div class="card card-boarder">

    <?php
    $company_information;
    $item_product_store_report_view;
    $product_information;

    /* echo '<pre>';
      echo print_r($employee_name);
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
        <button type="button" class="btn btn-primary report-print-button item-report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Product Name</th>
                <th>Open Stock</th>
                <th>Receive Stock</th>
                <th>Transfer Stock</th>
                <th>Sale From Stock</th>
                <th>Damage Stock</th>
                <th>Closing Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total_receive_stock = 0;
            $total_transfer_stock = 0;
            $total_sale_from_stock = 0;
            $total_damage_stock = 0;
            $total_closing_stock = 0;
            $current_closing_stock = 0;
            $current_closing_stock = !empty($item_product_store_report_view) ? end($item_product_store_report_view)->closing_stock : 0;
            foreach ($item_product_store_report_view as $item_product_store_report):
                ?>
                <?php
                $product_store_date = date("d-m-Y", strtotime($item_product_store_report->product_store_date));
                $total_receive_stock += (int) $item_product_store_report->receive_stock;
                $total_transfer_stock += (int) $item_product_store_report->transfer_stock;
                $total_sale_from_stock += (int) $item_product_store_report->sale_from_stock;
                $total_damage_stock += (int) $item_product_store_report->damage_stock;
                $total_closing_stock += (int) $item_product_store_report->closing_stock;
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $product_store_date ?></td>
                    <td><?= $item_product_store_report->product_name ?></td>
                    <td><?= $item_product_store_report->open_stock ?></td>
                    <td><?= $item_product_store_report->receive_stock ?></td>
                    <td><?= $item_product_store_report->transfer_stock ?></td>
                    <td><?= $item_product_store_report->sale_from_stock ?></td>
                    <td><?= $item_product_store_report->damage_stock ?></td>
                    <td><?= $item_product_store_report->closing_stock ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td><? ?></td>
                <td><? ?></td>
                <td><strong><?= 'Total:' ?></strong></td>
                <td><? ?></td>
                <td><strong><?= $total_receive_stock ?></strong></td>
                <td><strong><?= $total_transfer_stock ?></strong></td>
                <td><strong><?= $total_sale_from_stock ?></strong></td>
                <td><strong><?= $total_damage_stock ?></strong></td>
                <td><strong><?= $current_closing_stock ?></strong></td>
                <!--<td><strong><?= $total_closing_stock ?></strong></td>-->
            </tr>
        <hr>
        </tbody>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="item-report-print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Item Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Product: <?= $product_name ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?= get_string_to_date_fromat($start_date) ?> To <?= get_string_to_date_fromat($end_date) ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
                <thead class="thead-default">
                    <tr style="border: thick">
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Product Name</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Open Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Receive Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Transfer Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Sale From Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Damage Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Closing Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $total_receive_stock = 0;
                    $total_transfer_stock = 0;
                    $total_sale_from_stock = 0;
                    $total_damage_stock = 0;
                    $total_closing_stock = 0;
                    $current_closing_stock = 0;
                    $current_closing_stock = !empty($item_product_store_report_view) ? end($item_product_store_report_view)->closing_stock : 0;
                    foreach ($item_product_store_report_view as $item_product_store_report):
                        ?>
                        <?php
                        $product_store_date = date("d-m-Y", strtotime($item_product_store_report->product_store_date));
                        $total_receive_stock += (int) $item_product_store_report->receive_stock;
                        $total_transfer_stock += (int) $item_product_store_report->transfer_stock;
                        $total_sale_from_stock += (int) $item_product_store_report->sale_from_stock;
                        $total_damage_stock += (int) $item_product_store_report->damage_stock;
                        $total_closing_stock += (int) $item_product_store_report->closing_stock;
                        ?>
                        <tr style="border: thick">
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product_store_date ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->product_name ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->open_stock ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->receive_stock ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->transfer_stock ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->sale_from_stock ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->damage_stock ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $item_product_store_report->closing_stock ?></td>

                        </tr>
                    <?php endforeach; ?>
                    <tr style="border: thick">
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><? ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><? ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= 'Total:' ?></strong></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><? ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= $total_receive_stock ?></strong></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= $total_transfer_stock ?></strong></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= $total_sale_from_stock ?></strong></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= $total_damage_stock ?></strong></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= $current_closing_stock ?></strong></td>
                        <!--<td style="border-bottom: 1px solid #ddd; text-align: center"><strong><?= $total_closing_stock ?></strong></td>-->
                    </tr>
                <hr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".item-report-print-button").on("click", function () {

        var divContents = $('#item-report-print-information').html();

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
