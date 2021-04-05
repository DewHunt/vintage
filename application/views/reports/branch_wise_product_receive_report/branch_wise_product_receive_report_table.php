<div class="card card-boarder">

    <?php
    $company_information;
    $branch_wise_product_receive_report_view_by_date;
    $start_date;
    $end_date;
    $branch_information;
    $user_information;
    $user_name;

    $total = 0;
    foreach ($branch_wise_product_receive_report_view_by_date as $product_receive_report) {
        //$total += (double)$product_receive_report->product_total;
    }

    /* echo '<pre>';
      echo print_r($employee_name);
      echo '</pre>'; */
    ?>


    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Branch: <?= ucfirst($branch_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">User: <?= ucfirst($user_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i>
            Print
        </button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Product</th>
                <th>Quantity</th>
                <th><?= 'Total Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Outlet</th>
                <th>Branch Area</th>
                <th>Product Source</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($branch_wise_product_receive_report_view_by_date as $product_receive_report):
                ?>
                <?php $product_receive_date = date("d-m-Y", strtotime($product_receive_report->product_receive_date)); ?>
                <?php $total += $product_receive_report->total_price ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $product_receive_date ?></td>
                    <td><?= ucfirst($product_receive_report->product_name) ?></td>
                    <td><?= $product_receive_report->quantity ?></td>
                    <td><?= number_format((double) $product_receive_report->total_price, 2) ?></td>
                    <td><?= ucfirst($product_receive_report->branch_name) ?></td>
                    <td><?= $product_receive_report->branch_area ?></td>
                    <td><?= $product_receive_report->product_source ?></td>
                    <td><?= ucfirst($product_receive_report->user_name) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 class="left-side-view"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Branchwise Product Receive Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Branch: <?= $branch_name ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">User: <?= $user_name ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%; margin-top: 10px;"
                   id="product-receive-list-table">

                <thead class="thead-default">
                    <tr>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            SL
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            Date
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            Product
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            Quantity
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            <?= 'Total Price ' . '(' . $currency_settings->currency_symbol . ')' ?>
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            Outlet
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            Branch Area
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            Product Source
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                            User
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $total = 0;
                    foreach ($branch_wise_product_receive_report_view_by_date as $product_receive_report):
                        ?>
                        <?php $product_receive_date = date("d-m-Y", strtotime($product_receive_report->product_receive_date)); ?>
                        <?php $total += $product_receive_report->total_price ?>
                        <tr style="border: thick">
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product_receive_date ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= ucfirst($product_receive_report->product_name) ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product_receive_report->quantity ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double) $product_receive_report->total_price, 2) ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= ucfirst($product_receive_report->branch_name) ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product_receive_report->branch_area ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product_receive_report->product_source ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= ucfirst($product_receive_report->user_name) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="border: thick">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <hr>
                </tbody>
            </table>
        </div>

    </div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".report-print-button").on("click", function () {

        var divContents = $('#print-information').html();

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
