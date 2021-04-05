<div class="card card-boarder">

    <?php
    $company_information;
    $branchwise_periodic_item_product_store_report_view;
    $product_information;

//    echo '<pre>';
//    echo print_r($branchwise_periodic_item_product_store_report_view['branch_name']);
//    echo '</pre>';
//    die();
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Branch: <?= ucfirst($branch_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Product: <?= ucfirst($product_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= get_string_to_date_fromat($start_date) ?> To <?= get_string_to_date_fromat($end_date) ?> </label><br>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary branchwise-periodic-item-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Outlet</th>
                <th>Product</th>
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
            //foreach ($branchwise_periodic_item_product_store_report_view as $branchwise_periodic_item_product_store_report):
            ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= ucfirst($branchwise_periodic_item_product_store_report_view['branch_name']) ?></td>
                <td><?= ucfirst($branchwise_periodic_item_product_store_report_view['product_name']) ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['open_stock'] ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['receive_stock'] ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['transfer_stock'] ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['sale_from_stock'] ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['damage_stock'] ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['return_stock'] ?></td>
                <td><?= $branchwise_periodic_item_product_store_report_view['closing_stock'] ?></td>
            </tr>
            <?php //endforeach; ?>
        <hr>
        </tbody>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="branchwise-periodic-item-report-print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 class="left-side-view"><?/*= $company_information->company_address_1 */?></h6>-->
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Branchwise Periodic Item Report</strong></label><br>
        </div>

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Branch: <?= ucfirst($branch_name) ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Product: <?= ucfirst($product_name) ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?= get_string_to_date_fromat($start_date) ?> To <?= get_string_to_date_fromat($end_date) ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
                <thead class="thead-default">
                    <tr style="border: thick">
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">SL</th>
                        <!--<th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Date</th>-->
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Outlet</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Product Name</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Open Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Receive Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Transfer Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Sale From Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Damage Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Return Stock</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Closing Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    //foreach ($branchwise_periodic_item_product_store_report_view as $branchwise_periodic_item_product_store_report):
                    ?>
                    <tr style="border: thick">
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= ucfirst($branchwise_periodic_item_product_store_report_view['branch_name']) ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= ucfirst($branchwise_periodic_item_product_store_report_view['product_name']) ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['open_stock'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['receive_stock'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['transfer_stock'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['sale_from_stock'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['damage_stock'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['return_stock'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $branchwise_periodic_item_product_store_report_view['closing_stock'] ?></td>
                    </tr>
                    <?php //endforeach; ?>
                <hr>
                </tbody>
            </table>
        </div>

    </div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">
    
    $(".branchwise-periodic-item-report-print-button").on("click", function () {
        
        var divContents = $('#branchwise-periodic-item-report-print-information').html();
        
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

