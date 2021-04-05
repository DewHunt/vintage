<div class="card card-boarder">

    <?php
    $company_information;
    $stock_receive_report_view;
    $branch_information;

    /* echo '<pre>';
      echo print_r($employee_name);
      echo '</pre>'; */
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Received By(Outlet): <?= !empty($branch_name) ? ucfirst($branch_name) : '' ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Received By(Outlet)</th>
                <th>Transferred From(Outlet)</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Challan No</th>
                <!--<th>Reason</th>-->
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($stock_receive_report_view as $stock_receive_report):
                ?>
                <?php $date_of_transfer = date("d-m-Y", strtotime($stock_receive_report->date_of_transfer)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $date_of_transfer ?></td>
                    <td><?= $stock_receive_report->to_branch ?></td>
                    <td><?= $stock_receive_report->from_branch ?></td>
                    <td><?= ucfirst($stock_receive_report->product_name) ?></td>
                    <td><?= $stock_receive_report->quantity ?></td>
                    <td><?= !empty($stock_receive_report->challan_number) ? $stock_receive_report->challan_number : '' ?></td>
                    <!--<td><?= ucfirst($stock_receive_report->transfer_reason) ?></td>-->
                    <td><?= ucfirst($stock_receive_report->user_name) ?></td>
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
        <h4 style="text-align: center" class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Stock Receive Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Received By(Outlet): <?= !empty($branch_name) ? ucfirst($branch_name) : '' ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%; margin-top: 10px;" id="branch-stock-list-table">
                <thead class="thead-default">
                    <tr>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Received By(Outlet)</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Transferred From(Outlet)</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Product Name</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Quantity</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Challan No</th>
<!--                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Reason</th>-->
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($stock_receive_report_view as $stock_receive_report):
                        ?>
                        <?php $date_of_transfer = date("d-m-Y", strtotime($stock_receive_report->date_of_transfer)); ?>
                        <tr style="border: thick">
                            <td style="text-align: center"><?= $count++ ?></td>
                            <td style="text-align: center"><?= $date_of_transfer ?></td>
                            <td style="text-align: center"><?= $stock_receive_report->to_branch ?></td>
                            <td style="text-align: center"><?= $stock_receive_report->from_branch ?></td>
                            <td style="text-align: center"><?= ucfirst($stock_receive_report->product_name) ?></td>
                            <td style="text-align: center"><?= $stock_receive_report->quantity ?></td>
                            <td style="text-align: center"><?= !empty($stock_receive_report->challan_number) ? $stock_receive_report->challan_number : '' ?></td>
                            <!--<td style="text-align: center"><?= ucfirst($stock_receive_report->transfer_reason) ?></td>-->
                            <td style="text-align: center"><?= ucfirst($stock_receive_report->user_name) ?></td>
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

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

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
</script>
