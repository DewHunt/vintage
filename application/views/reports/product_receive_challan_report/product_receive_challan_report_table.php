<div class="card card-boarder">

    <?php
    $company_information;
    $currency_settings;
    $branch_information;
    $product_receive_Challan_report_by_date;
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Received By(Outlet): <?= $branch_name ?></label>
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
                <th>Outlet</th>
                <th><?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Challan Number</th>
                <th>Remarks</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($product_receive_Challan_report_by_date as $product_receive_Challan_report):
                $total += abs($product_receive_Challan_report->total_amount);
                ?>
                <?php $product_receive_date = date("d-m-Y", strtotime($product_receive_Challan_report->product_receive_date)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $product_receive_date ?></td>
                    <td><?= ucfirst($product_receive_Challan_report->branch_name) ?></td>
                    <td><?= number_format((double) $product_receive_Challan_report->total_amount, 2) ?></td>
                    <td><?= $product_receive_Challan_report->challan_number ?></td>
                    <td><?= ucfirst($product_receive_Challan_report->remarks) ?></td>
                    <td><?= ucfirst($product_receive_Challan_report->user_name) ?></td>
                    <td>
                        <button class="btn btn-primary product_receive_challan_details_view_button"
                                data-toggle="tooltip" data-placement="bottom"
                                title="View Details"
                                data-id="<?= $product_receive_Challan_report->id ?>"
                                data-action="<?= base_url('reports/product_receive_challan_report/product_receive_challan_report_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2); ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="modal fade product-receive-challan-details-information-modal">
        <div class="modal-dialog modal-lg product_receive_challan_show " role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="width: 100%; display: none;">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date"><strong>Product Receive Challan Report</strong></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Received By(Outlet): <?= $branch_name ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
        <hr>
    </div>

    <table width="100%" border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">
        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Date
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Outlet
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    <?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?>
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Challan Number
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Remarks
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    User Name
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($product_receive_Challan_report_by_date as $product_receive_Challan_report):
                $total += abs($product_receive_Challan_report->total_amount);
                ?>
                <?php $product_receive_date = date("d-m-Y", strtotime($product_receive_Challan_report->product_receive_date)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $product_receive_date ?></td>
                    <td><?= ucfirst($product_receive_Challan_report->branch_name) ?></td>
                    <td><?= number_format((double) $product_receive_Challan_report->total_amount, 2) ?></td>
                    <td><?= $product_receive_Challan_report->challan_number ?></td>
                    <td><?= ucfirst($product_receive_Challan_report->remarks) ?></td>
                    <td><?= ucfirst($product_receive_Challan_report->user_name) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2); ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tr>
        </tbody>
    </table>
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
    
    $('.product_receive_challan_details_view_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.product-receive-challan-details-information-modal .product_receive_challan_show').html(data)
            $('.product-receive-challan-details-information-modal').modal('show');
        });
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
