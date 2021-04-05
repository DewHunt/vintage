<div class="card card-boarder">
    <?php
    $company_information;
    $currency_settings;
    $client_details_ledger;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary client-details-ledger-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Client Name</th>
                <th>Client Code</th>
                <th>Dealer Code</th>
                <th>Employee Code</th>
                <th><?= 'Opening Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Total Sale' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Receive Amount' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Closing Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $grand_total_opening_balance = 0;
            $grand_total_sale = 0;
            $grand_total_payment = 0;
            $grand_total_closing_amount = 0;
            foreach ($client_details_ledger as $client_details):
                ?>
                <?php
                $grand_total_opening_balance += (double) $client_details['opening_balance'];
                $grand_total_sale += (double) $client_details['total_sale'];
                $grand_total_payment += (double) $client_details['total_payment'];
                $grand_total_closing_amount += (double) $client_details['closing_amount'];
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $client_details['client_name'] ?></td>
                    <td><?= $client_details['client_code'] ?></td>
                    <td><?= $client_details['dealer_code'] ?></td>
                    <td><?= $client_details['employee_code'] ?></td>
                    <td><?= number_format((double) $client_details['opening_balance'], 2) ?></td>
                    <td><?= number_format((double) $client_details['total_sale'], 2) ?></td>
                    <?php
                    $receive_amount = 0;
                    $receive_amount = (double) $client_details['total_sale'] + ((double) $client_details['total_payment']);
                    ?>
                    <td><?= number_format((double) $client_details['total_payment'], 2) ?></td>
                    <td><?= number_format((double) $client_details['closing_amount'], 2) . $client_details['type'] ?></td>
                </tr>

            <?php endforeach;
            ?>
            <tr>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $grand_total_opening_balance, 2) ?></strong></td>
                <td><strong><?= number_format((double) $grand_total_sale, 2) ?></strong></td>
                <td><strong><?= number_format((double) $grand_total_payment, 2) ?></strong></td>
                <td><strong><?= number_format((double) $grand_total_closing_amount, 2) ?></strong></td>
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

<div id="client-details-ledger-report-print-section" class="" style="width: 100%; display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
<!--        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div><strong>Clientwise Details Ledger Report</strong></div>
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr style="border: thick">
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client Name</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client Code</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Dealer Code</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Employee Code</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Opening Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Total Sale' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Receive Amount' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Closing Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $grand_total_opening_balance = 0;
            $grand_total_sale = 0;
            $grand_total_payment = 0;
            $grand_total_closing_amount = 0;
            foreach ($client_details_ledger as $client_details):
                ?>
                <?php
                $grand_total_opening_balance += (double) $client_details['opening_balance'];
                $grand_total_sale += (double) $client_details['total_sale'];
                $grand_total_payment += (double) $client_details['total_payment'];
                $grand_total_closing_amount += (double) $client_details['closing_amount'];
                ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $client_details['client_name'] ?></td>
                    <td><?= $client_details['client_code'] ?></td>
                    <td><?= $client_details['dealer_code'] ?></td>
                    <td><?= $client_details['employee_code'] ?></td>
                    <td><?= number_format((double) $client_details['opening_balance'], 2) ?></td>
                    <td><?= number_format((double) $client_details['total_sale'], 2) ?></td>
                    <td><?= number_format((double) $client_details['total_payment'], 2) ?></td>
                    <td><?= number_format((double) $client_details['closing_amount'], 2) . $client_details['type'] ?></td>
                </tr>
            <?php endforeach;
            ?>
            <tr style="border: thick">
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $grand_total_opening_balance, 2) ?></strong></td>
                <td><strong><?= number_format((double) $grand_total_sale, 2) ?></strong></td>
                <td><strong><?= number_format((double) $grand_total_payment, 2) ?></strong></td>
                <td><strong><?= number_format((double) $grand_total_closing_amount, 2) ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $('.client-invoice-view-button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.client-invoice-details-information-modal .client-invoice-show').html(data)
            $('.client-invoice-details-information-modal').modal('show');
        });
    });

    $(".client-details-ledger-report-print-button").on("click", function () {

        var divContents = $('#client-details-ledger-report-print-section').html();

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
