<div class="card card-boarder">
    <?php
    $company_information;
    $currency_settings;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    $client_individual_ledger;
    
    //echo '<pre>';
    //print_r($client_individual_ledger);
    //echo '</pre>';
    
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Client Code: <?= ucfirst($client_code) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary client-individual-ledger-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th><?= 'Opening Credit Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Total Sale' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Total Payment' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Closing Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $total = 0;
            if (!empty($client_individual_ledger)) {
                foreach ($client_individual_ledger as $individual_ledger):
                    ?>
            <?php $sale_date = date("d-m-Y", strtotime($individual_ledger['sale_date'])); ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $sale_date ?></td>
                        <td><?= number_format((double) $individual_ledger['opening_balance'], 2) ?></td>
                        <td><?= number_format((double) $individual_ledger['total_sale'], 2) ?></td>
                        <td><?= number_format((double) $individual_ledger['total_payment'], 2) ?></td>
                        <td><?= number_format((double) $individual_ledger['closing_amount'], 2) . $individual_ledger['type'] ?></td>
                    </tr>

                    <?php
                endforeach;
            }
            ?>

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

<div id="client-individual-ledger-report-print-section" class="" style="width: 100%; display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
<!--        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div><strong>Client Individual Ledger Report</strong></div>
           <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Client Code: <?= ucfirst($client_code) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr style="border: thick">
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Opening Credit Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Total Sale' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Total Payment' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Closing Balance' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            if (!empty($client_individual_ledger)) {
                foreach ($client_individual_ledger as $individual_ledger):
                    ?>
            <?php $sale_date = date("d-m-Y", strtotime($individual_ledger['sale_date'])); ?>
            <tr style="border: thick">
                        <td><?= $count++ ?></td>
                        <td><?= $sale_date ?></td>
                        <td><?= number_format((double) $individual_ledger['opening_balance'], 2) ?></td>
                        <td><?= number_format((double) $individual_ledger['total_sale'], 2) ?></td>
                        <td><?= number_format((double) $individual_ledger['total_payment'], 2) ?></td>
                        <td><?= number_format((double) $individual_ledger['closing_amount'], 2) . $individual_ledger['type'] ?></td>
                    </tr>

                    <?php
                endforeach;
            }
            ?>

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

    $(".client-individual-ledger-report-print-button").on("click", function () {

        var divContents = $('#client-individual-ledger-report-print-section').html();

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
