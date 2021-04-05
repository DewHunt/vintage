<div class="card card-boarder">

    <?php
    $company_information;
    $branch_wise_stock_report_view;
    $branch_information;
    $total = 0;
    //foreach ($branch_wise_stock_report_view as $branch_wise_stock_report) {
        //$total += $branch_wise_stock_report->product_total;
    //}

//     echo '<pre>';
//     echo print_r($branch_wise_stock_report_view);
//     echo '</pre>';
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Outlet: <?= ucfirst($branch_name) ?></label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Stock</th>
                <?php if (!empty(strtolower($branch_name) != 'all')) { ?>
                    <th>Outlet</th>
                    <th>Outlet Area</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($branch_wise_stock_report_view as $branch_wise_stock_report):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($branch_wise_stock_report->product_name) ?></td>
                    <td><?= $branch_wise_stock_report->stock ?></td>
                    <?php if (!empty(strtolower($branch_name) != 'all')) { ?>
                        <td><?= ucfirst($branch_wise_stock_report->branch_name) ?></td>
                        <td><?= $branch_wise_stock_report->branch_area ?></td>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
        <hr>
        </tbody>
    </table>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 class="left-side-view"><?/*= $company_information->company_address_1 */?></h6>-->
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Branchwise Stock Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Outlet: <?= ucfirst($branch_name) ?></label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table border ="2px sloid black" cellspacing="0" class="table table-striped" style="width: 100%; margin-top: 10px;" id="branch-stock-list-table">

                <thead class="thead-default">
                    <tr>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">SL</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Product Name</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Stock</th>
                        <?php if (!empty(strtolower($branch_name) != 'all')) { ?>
                            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Outlet</th>
                            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Outlet Area</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($branch_wise_stock_report_view as $branch_wise_stock_report):
                        ?>
                        <tr style="border: thick">
                            <td style="border-bottom: 1px solid #ddd; text-align: left"><?= $count++ ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: left"><?= ucfirst($branch_wise_stock_report->product_name) ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: left"><?= $branch_wise_stock_report->stock ?></td>
                            <?php if (!empty(strtolower($branch_name) != 'all')) { ?>
                                <td style="border-bottom: 1px solid #ddd; text-align: left"><?= ucfirst($branch_wise_stock_report->branch_name) ?></td>
                                <td style="border-bottom: 1px solid #ddd; text-align: left"><?= $branch_wise_stock_report->branch_area ?></td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
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
