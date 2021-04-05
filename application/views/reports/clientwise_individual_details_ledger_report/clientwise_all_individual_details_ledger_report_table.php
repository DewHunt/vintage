<div class="card card-boarder">

    <?php
    $company_information;
    $currency_settings;
    $all_client_individual_details_ledger_report;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

//    echo '<pre>';
//    print_r($all_client_individual_details_ledger_report);
//    echo '</pre>';
//   // die();
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Client Code: <?= ucfirst($client_code) ?></label>
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
                <button type="button" class="btn btn-primary client-individual-details-ledger-report-print-button report-print-button all-client-individual-ledger-report-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Client</th>
                <!--debit change into credit and credit change into debit-->
                <th><?= 'Opening' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Debit' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Credit' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Closing' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $total = 0;
            $all_total_opening_balance = 0;
            $all_total_closing_balance = 0;
            $all_total_debit_balance = 0;
            $all_total_credit_balance = 0;
            // if (!empty($all_client_individual_details_ledger_report)) {
            ?>
            <?php foreach ($all_client_individual_details_ledger_report as $all_client_individual_details) { ?>

                <?php $all_total_opening_balance += ((double) $all_client_individual_details['opening_balance']) ?>
                <?php $all_total_closing_balance += ((double) $all_client_individual_details['closing_balance']) ?>
                <?php $all_total_debit_balance += ((double) $all_client_individual_details['total_debit_amount']) ?>
                <?php $all_total_credit_balance += ((double) $all_client_individual_details['total_credit_amount']) ?>

                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $all_client_individual_details['client_name'] ?></td>
                    <td><?= number_format((double) abs($all_client_individual_details['opening_balance']), 2) ?></td>
                    <!--debit change into credit and credit change into debit-->
                    <td><?= number_format((double) $all_client_individual_details['total_credit_amount'], 2) ?></td>
                    <td><?= number_format((double) $all_client_individual_details['total_debit_amount'], 2) ?></td> 
                    <?php if ((double) $all_client_individual_details['closing_balance'] < 0) { ?>
                        <td class="text-color-red"><?= number_format((double) abs($all_client_individual_details['closing_balance']), 2) ?></td>
                    <?php } else { ?>
                        <td><?= number_format((double) abs($all_client_individual_details['closing_balance']), 2) ?></td>
                    <?php } ?>
                </tr>

            <?php } ?>
            <?php //}
            ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format(abs($all_total_opening_balance), 2) ?></strong></td>
                <td><strong><?= number_format(abs($all_total_credit_balance), 2) ?></strong></td>
                <td><strong><?= number_format(abs($all_total_debit_balance), 2) ?></strong></td>
                <?php if ((double) ($all_total_closing_balance) < 0) { ?>
                <td class="text-color-red"><strong><?= number_format(abs($all_total_closing_balance), 2) . '(Dr)' ?></strong></td>
                <?php } else { ?>
                <td><strong><?= number_format(abs($all_total_closing_balance), 2) . '(Cr)' ?></strong></td>
                <?php } ?>
            </tr>
        <hr>
        </tbody>

    </table>
    <div class="modal fade client-invoice-details-information-modal">
        <div class="modal-dialog modal-lg client-invoice-show " role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="all-client-individual-details-ledger-report-print-section" class="" style="width: 100%; display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
<!--        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div><strong>Client Individual Ledger Details Report</strong></div>
    <hr>

    <div class="col-xs-12">
        <label class="search-from-date">Client: <?= $client_name ?></label>
    </div>
    <div class="col-xs-12">
        <?php $s_date = date("d-m-Y", strtotime($start_date)); ?>
        <?php $e_date = date("d-m-Y", strtotime($end_date)); ?>
        <label class="search-from-date">Period: <?= $s_date ?> To <?= $e_date ?> </label><br>
    </div>

    <table width="100%" border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr style="border: thick">
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Opening' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Debit' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Credit' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Closing' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>        
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            $all_total_opening_balance = 0;
            $all_total_closing_balance = 0;
            $all_total_debit_balance = 0;
            $all_total_credit_balance = 0;
            // if (!empty($all_client_individual_details_ledger_report)) {
            ?>
            <?php foreach ($all_client_individual_details_ledger_report as $all_client_individual_details) { ?>

                <?php $all_total_opening_balance += ((double) $all_client_individual_details['opening_balance']) ?>
                <?php $all_total_closing_balance += ((double) $all_client_individual_details['closing_balance']) ?>
                <?php $all_total_debit_balance += ((double) $all_client_individual_details['total_debit_amount']) ?>
                <?php $all_total_credit_balance += ((double) $all_client_individual_details['total_credit_amount']) ?>

                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $all_client_individual_details['client_name'] ?></td>
                    <td><?= number_format((double) abs($all_client_individual_details['opening_balance']), 2) ?></td>
                    <!--debit change into credit and credit change into debit-->
                    <td><?= number_format((double) $all_client_individual_details['total_credit_amount'], 2) ?></td>
                    <td><?= number_format((double) $all_client_individual_details['total_debit_amount'], 2) ?></td> 
                    <?php if ((double) $all_client_individual_details['closing_balance'] < 0) { ?>
                        <td style="color: red" class="text-color-red"><?= number_format((double) abs($all_client_individual_details['closing_balance']), 2) ?></td>
                    <?php } else { ?>
                        <td><?= number_format((double) abs($all_client_individual_details['closing_balance']), 2) ?></td>
                    <?php } ?>
                </tr>

            <?php } ?>
            <?php //}
            ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format(abs($all_total_opening_balance), 2) ?></strong></td>
                <td><strong><?= number_format(abs($all_total_credit_balance), 2) ?></strong></td>
                <td><strong><?= number_format(abs($all_total_debit_balance), 2) ?></strong></td>
                <?php if ((double) ($all_total_closing_balance) < 0) { ?>
                <td class="text-color-red"><strong><?= number_format(abs($all_total_closing_balance), 2) . '(Dr)' ?></strong></td>
                        <?php } else { ?>
                    <td><strong><?= number_format(abs($all_total_closing_balance), 2) . '(Cr)' ?></strong></td>
                <?php } ?>
            </tr>
        <hr>
        </tbody>
    </table>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

//    $('.client-invoice-view-button').on('click', function (event) {
//        event.preventDefault();
//        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
//            $('.client-invoice-details-information-modal .client-invoice-show').html(data)
//            $('.client-invoice-details-information-modal').modal('show');
//        });
//    });

    $(".all-client-individual-ledger-report-button").on("click", function () {

        var divContents = $('#all-client-individual-details-ledger-report-print-section').html();

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
