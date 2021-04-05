<div class="card card-boarder">

    <?php
    $company_information;
    $currency_settings;
    $from_branch_information;
    $to_branch_information;
    $stock_transfer_details_report_by_date;
//    echo '<pre>';
//    print_r($stock_transfer_details_report_by_date);
//    echo '</pre>';
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Transferred From(Outlet): <?= $from_branch_name ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Received By(Outlet): <?= $to_branch_name ?></label>
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
                <th>From Outlet</th>
                <th>To Outlet</th>
                <th><?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Challan Number</th>
                <th>Reason</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($stock_transfer_details_report_by_date as $stock_transfer):
                $total += abs($stock_transfer->total_amount);
                ?>
                <?php $transfer_date = date("d-m-Y", strtotime($stock_transfer->transfer_date)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $transfer_date ?></td>
                    <td><?= ucfirst($stock_transfer->from_branch_name) ?></td>
                    <td><?= ucfirst($stock_transfer->to_branch_name) ?></td>
                    <td><?= number_format((double) $stock_transfer->total_amount, 2) ?></td>
                    <td><?= $stock_transfer->challan_number ?></td>
                    <td><?= ucfirst($stock_transfer->reason) ?></td>
                    <td><?= ucfirst($stock_transfer->user_name) ?></td>
                    <td>
                        <button class="btn btn-primary stock_transfer_challan_details_view_button"
                                data-toggle="tooltip" data-placement="bottom"
                                title="View Details"
                                data-id="<?= $stock_transfer->id ?>"
                                data-action="<?= base_url('reports/gate_pass_transfer_report/stock_transfer_challan_report_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
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

    <div class="modal fade stock-transfer-challan-details-information-modal">
        <div class="modal-dialog modal-lg stock_transfer_challan_show " role="document">
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
            <label class="search-from-date"><strong>Stock Transfer Challan Report</strong></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Transferred From(Outlet): <?= $from_branch_name ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Received By(Outlet): <?= $to_branch_name ?></label>
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
                    From Outlet
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    To Outlet
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    <?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?>
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Challan Number
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Reason
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
            foreach ($stock_transfer_details_report_by_date as $stock_transfer):
                $total += abs($stock_transfer->total_amount);
                ?>
                <?php $transfer_date = date("d-m-Y", strtotime($stock_transfer->transfer_date)); ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $transfer_date ?></td>
                    <td><?= ucfirst($stock_transfer->from_branch_name) ?></td>
                    <td><?= ucfirst($stock_transfer->to_branch_name) ?></td>
                    <td><?= number_format((double) $stock_transfer->total_amount, 2) ?></td>
                    <td><?= $stock_transfer->challan_number ?></td>
                    <td><?= ucfirst($stock_transfer->reason) ?></td>
                    <td><?= ucfirst($stock_transfer->user_name) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2); ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
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

    $('.stock_transfer_challan_details_view_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.stock-transfer-challan-details-information-modal .stock_transfer_challan_show').html(data)
            $('.stock-transfer-challan-details-information-modal').modal('show');
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

