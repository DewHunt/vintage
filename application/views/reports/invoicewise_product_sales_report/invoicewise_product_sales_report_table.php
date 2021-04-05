<div class="card card-boarder">

    <?php
    $company_information;
    $currency_settings;
    $invoice_details_by_product_list;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

    function get_product_name_without_pack_size($product_name = '') {
        $product_name_part_1 = '';
        $product_name_part_2 = '';
        if (strpos(($product_name), '#') !== FALSE) {
            $product_name_1 = explode("#", ($product_name));
            $product_name_part_1 = $product_name_1[0];
            $product_name_part_2 = $product_name_1[1];
        } else {
            $product_name_part_1 = $product_name;
        }
        return $product_name_part_1;
    }

//    echo '<pre>';
//    echo print_r($invoice_details_by_product_list);
//    echo '</pre>';
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label><br>
            <label class="search-from-date">Product: <?= get_product_name_without_pack_size($product_name); ?></label><br>
            <label class="search-from-date">Pack Size: <?= $pack_size ?></label><br>
            <label class="search-from-date">Outlet: <?= !empty($branch_name) ? $branch_name : ''; ?></label>
        </div>
        <div class="col-xs-12">
            <?php $s_date = date("d-m-Y", strtotime($start_date)); ?>
            <?php $e_date = date("d-m-Y", strtotime($end_date)); ?>
            <label class="search-from-date">Period: <?= $s_date ?> To <?= $e_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary invoicewise-product-sales-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Product</th>
                <th>Pack Size</th>
                <th>Client</th>
                <th>Outlet</th>
                <th>Invoice No</th>
                <th>Challan No</th>
                <th>Quantity</th>
                <th><?= 'Price' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total_quantity = 0;
            $total_price = 0;
            foreach ($invoice_details_by_product_list as $invoice_details_by_product):
                ?>
                <?php $sale_date = date("d-m-Y", strtotime($invoice_details_by_product->date_of_issue)); ?>
                <?php
                $price = 0;
                $price = ((double) $invoice_details_by_product->quantity) * ((double) $invoice_details_by_product->unit_price);
                $total_quantity += (int) $invoice_details_by_product->quantity;
                $total_price += (double) $price;
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $sale_date ?></td>
                    <td><?= get_product_name_without_pack_size($invoice_details_by_product->product_name) ?></td>
                    <td><?= $invoice_details_by_product->pack_size ?></td>
                    <td><?= $invoice_details_by_product->client_name ?></td>
                    <td><?= $invoice_details_by_product->branch_name ?></td>
                    <td><?= $invoice_details_by_product->invoice_number ?></td>
                    <td><?= $invoice_details_by_product->challan_number ?></td>
                    <td><?= $invoice_details_by_product->quantity ?></td>
                    <td><?= get_floating_point_number($price, TRUE); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= $total_quantity ?></strong></td>
                <td><strong><?= get_floating_point_number($total_price, TRUE); ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="invoicewise-product-sales-report-print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Invoicewise Product Sales Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Client: <?= ($client_name); ?></label><br>
            <label class="search-from-date">Product: <?= get_product_name_without_pack_size($product_name); ?></label><br>
            <label class="search-from-date">Pack Size: <?= $pack_size ?></label><br>
            <label class="search-from-date">Outlet: <?= !empty($branch_name) ? $branch_name : ''; ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <?php $s_date = date("d-m-Y", strtotime($start_date)); ?>
            <?php $e_date = date("d-m-Y", strtotime($end_date)); ?>
            <label class="search-from-date">Period: <?= $s_date ?> To <?= $e_date ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table class="table table-striped" border="2px" cellspacing="0" style="width: 100%;"
                   id="branch-stock-list-table">

                <thead class="thead-default">
                    <tr style="border: thick">
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Product</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Pack Size</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Outlet</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Invoice No</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Challan No</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Quantity</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Price' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $total_quantity = 0;
                    $total_price = 0;
                    foreach ($invoice_details_by_product_list as $invoice_details_by_product):
                        ?>
                        <?php $sale_date = date("d-m-Y", strtotime($invoice_details_by_product->date_of_issue)); ?>
                        <?php
                        $price = 0;
                        $price = ((double) $invoice_details_by_product->quantity) * ((double) $invoice_details_by_product->unit_price);
                        $total_quantity += (int) $invoice_details_by_product->quantity;
                        $total_price += (double) $price;
                        ?>
                        <tr style="border: thick">
                            <td><?= $count++ ?></td>
                            <td><?= $sale_date ?></td>
                            <td><?= get_product_name_without_pack_size($invoice_details_by_product->product_name) ?></td>
                            <td><?= $invoice_details_by_product->pack_size ?></td>
                            <td><?= $invoice_details_by_product->client_name ?></td>
                            <td><?= $invoice_details_by_product->branch_name ?></td>
                            <td><?= $invoice_details_by_product->invoice_number ?></td>
                            <td><?= $invoice_details_by_product->challan_number ?></td>
                            <td><?= $invoice_details_by_product->quantity ?></td>
                            <td style="text-align: right"><?= get_floating_point_number($price, TRUE); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="border: thick">
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><?= $total_quantity ?></strong></td>
                        <td style="text-align: right"><strong><?= get_floating_point_number($total_price, TRUE); ?></strong></td>
                    </tr>
                <hr>
                </tbody>
            </table>
        </div>

    </div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".invoicewise-product-sales-report-print-button").on("click", function () {

        var divContents = $('#invoicewise-product-sales-report-print-information').html();

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
