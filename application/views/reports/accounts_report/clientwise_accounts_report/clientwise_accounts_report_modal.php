<div class="modal-content">

    <?php
    $company_information;
    $client_voucher_details_by_voucher_posting_details_id;
    $clientwise_voucher_details_information;

    /*echo '<pre>';
    echo print_r($clientwise_voucher_details_information);
    echo '</pre>';*/
    //die();

    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Clientwise Accounts Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <div class="col-xs-12">
                <h4 class="text-align-center"><?= strtoupper($company_information->company_name_1) ?></h4>
            </div>

            <!--<div class="col-xs-12">
                <h6 class="left-side-view"><? /*= $company_information->company_address_1 */ ?></h6>
            </div>-->

            <div class="col-xs-12">
                <h6 class="left-side-view">Client: <?= $client_information->client_name ?></h6>
            </div>
            <div class="col-xs-12">
                <?php $posting_date = date("d-m-Y", strtotime($client_voucher_details_by_voucher_posting_details_id->posting_date)); ?>
                <h6 class="left-side-view">Date: <?= $posting_date ?></h6>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Information</label>
            </div>

            <div class="col-xs-12">

                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Mr No</th>
                        <th>Invoice No</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $count = 1;
                    foreach ($clientwise_voucher_details_information as $clientwise_voucher): ?>
                        <?php $voucher_posting_date = date("d-m-Y", strtotime($clientwise_voucher->posting_date)); ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $voucher_posting_date ?></td>
                            <td><?= $clientwise_voucher->voucher_number ?></td>
                            <td><?= $clientwise_voucher->mr_number ?></td>
                            <td><?= $clientwise_voucher->invoice_number ?></td>
                            <td><?= number_format((double)$clientwise_voucher->debit_amount, 2) ?></td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">


    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>


    <div class="col-xs-12">
        <label class="col-form-label" style="float: left"><strong>Clientwise Accounts Report</strong></label><br>
    </div>

    <div class="col-xs-12">
        <label class="col-form-label" style="float: left">Client: <?= $client_information->client_name ?> </label><br>
    </div>

    <div class="col-xs-12">
        <?php $posting_date = date("d-m-Y", strtotime($client_voucher_details_by_voucher_posting_details_id->posting_date)); ?>
        <label class="col-form-label"
               style="float: left">Date: <?= $posting_date; ?></label><br>
    </div>
    <br>

    <div class="col-xs-12" style="margin-top: 10px;padding-left: 0px;">

        <table border="2px" cellspacing="0" class="table" width="100%">
            <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Date
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Voucher No
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Mr No
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Invoice No
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Amount
                </th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 1;
            foreach ($clientwise_voucher_details_information as $clientwise_voucher): ?>
                <?php $voucher_posting_date = date("d-m-Y", strtotime($clientwise_voucher->posting_date)); ?>
                <tr style="border: thick">
                    <td style="text-align: center"><?= $count++ ?></td>
                    <td style="text-align: center"><?= $voucher_posting_date ?></td>
                    <td style="text-align: center"><?= $clientwise_voucher->voucher_number ?></td>
                    <td style="text-align: center"><?= $clientwise_voucher->mr_number ?></td>
                    <td style="text-align: center"><?= $clientwise_voucher->invoice_number ?></td>
                    <td style="text-align: center"><?= number_format((double)$clientwise_voucher->debit_amount, 2) ?></td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".print-button").on("click", function () {

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
    $('.modal-close-button').click(function () {
        $('.modal').modal('hide');
    });
</script>


