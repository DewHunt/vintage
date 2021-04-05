<div class="card card-boarder">

    <?php
    $company_information;
    $client_voucher_details_list;

    /*echo '<pre>';
    print_r($client_voucher_details_list);
    echo '</pre>';*/

    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= $client_name ?></label>
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
            <th>Voucher No</th>
            <th>MR No</th>
            <th>Invoice No</th>
            <th>Client</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        $total = 0;
        foreach ($client_voucher_details_list as $client_voucher_details): ?>
            <?php $voucher_posting_date = date("d-m-Y", strtotime($client_voucher_details->posting_date)); ?>
            <?php if (!empty($client_voucher_details->income_head_id) && ($client_voucher_details->income_head_id) > 0) {
                $head_id = $client_voucher_details->income_head_id;
            } else {
                $head_id = $client_voucher_details->expense_head_id;
            }
            $head_details_information = $this->Head_details_Model->get_head_details($head_id);
            ?>

            <?php
            $total += $client_voucher_details->client_amount;
            ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $voucher_posting_date ?></td>
                <td><?= $client_voucher_details->voucher_number ?></td>
                <td><?= $client_voucher_details->mr_number ?></td>
                <td><?= $client_voucher_details->invoice_number ?></td>
                <td><?= ucfirst($client_voucher_details->client_name) ?></td>
                <td><?= number_format((double)$client_voucher_details->client_amount, 2) ?></td>
                <td>
                    <button class="btn btn-primary client-voucher-details-view-button"
                            data-toggle="tooltip" data-placement="bottom"
                            title="View Details"
                            data-id="<?= $client_voucher_details->id ?>"
                            data-action="<?= base_url('reports/accounts_report/clientwise_accounts_report/clientwise_voucher_details_report_modal_show') ?>">
                        <i class="fa fa-eye" aria-hidden="true"></i></button>
                </td>
            </tr>

        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Grand Total</strong></td>
            <td><strong><?= number_format((double)$total, 2) ?></strong></td>
            <td></td>
        </tr>
        <hr>
        </tbody>
    </table>
    <div class="modal fade clientwise-voucher-details-information-modal">
        <div class="modal-dialog modal-lg client-voucher-show " role="document">
        </div>
    </div>
</div>


<!--For Print-->
<!--Display None-->

<div id="print-information" style="display: none; width: 100%">
    <div class="col-xs-12">
        <h4 style="text-align: center" class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>
    </div>
    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong>Clientwise Accounts Report</strong></label><br>
    </div>
    <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
        <tr>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Voucher No</th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">MR No</th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Invoice No</th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client</th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        $total = 0;
        foreach ($client_voucher_details_list as $client_voucher_details): ?>
            <?php $voucher_posting_date = date("d-m-Y", strtotime($client_voucher_details->posting_date)); ?>
            <?php if (!empty($client_voucher_details->income_head_id) && ($client_voucher_details->income_head_id) > 0) {
                $head_id = $client_voucher_details->income_head_id;
            } else {
                $head_id = $client_voucher_details->expense_head_id;
            }
            $head_details_information = $this->Head_details_Model->get_head_details($head_id);
            ?>

            <?php
            $total += $client_voucher_details->client_amount;
            ?>
            <tr style="border: thick">
                <td><?= $count++ ?></td>
                <td><?= $voucher_posting_date ?></td>
                <td><?= $client_voucher_details->voucher_number ?></td>
                <td><?= $client_voucher_details->mr_number ?></td>
                <td><?= $client_voucher_details->invoice_number ?></td>
                <td><?= ucfirst($client_voucher_details->client_name) ?></td>
                <td><?= number_format((double)$client_voucher_details->client_amount, 2) ?></td>
            </tr>

        <?php endforeach; ?>
        <tr style="border: thick">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Grand Total</strong></td>
            <td><strong><?= number_format((double)$total, 2) ?></strong></td>
        </tr>
        <hr>
        </tbody>
    </table>
</div>


<script language="javascript" type="text/javascript">

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

    $('.client-voucher-details-view-button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.clientwise-voucher-details-information-modal .client-voucher-show').html(data)
            $('.clientwise-voucher-details-information-modal').modal('show');
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
