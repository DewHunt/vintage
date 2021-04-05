<div class="card card-boarder">

    <?php
    $company_information;
    $head_posting_details;

    /* echo '<pre>';
      print_r($head_posting_details);
      echo '</pre>'; */
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Head Name: <?= ucfirst($head_name) ?></label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i>
            Print
        </button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Head Name</th>
                <th>Type</th>
                <th>Debit</th>
                <th>Credit</th>            
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $debit_total = 0;
            $credit_total = 0;
            $balance_total = 0;
            foreach ($head_posting_details as $head_posting) {
                ?>

                <?php
                $debit_total += abs($head_posting->debit_amount);
                $credit_total += abs($head_posting->credit_amount);
                $balance_total += abs($head_posting->total_amount);
                ?>

                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($head_posting->head_name) ?></td>
                    <td><?= ucfirst($head_posting->head_type) ?></td>
                    <td><?= number_format((double) $head_posting->credit_amount, 2) ?></td>
                    <td><?= number_format((double) $head_posting->debit_amount, 2) ?></td>
                    <?php if ($head_posting->total_amount < 0) { ?>
                        <td><?= number_format((double) abs($head_posting->total_amount), 2) . '(Cr)' ?></td>
                    <?php } elseif ($head_posting->total_amount > 0) { ?>
                        <td><?= number_format((double) abs($head_posting->total_amount), 2) . '(Dr)' ?></td>
                    <?php } else { ?>
                        <td><?= number_format((double) abs($head_posting->total_amount), 2) ?></td>
                    <?php } ?>
                </tr>

            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $credit_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $debit_total, 2) ?></strong></td>                
                <td><strong><?= number_format((double) $balance_total, 2) ?></strong></td>
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

<div style="display: none" id="print-information">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date"><strong>Head Report</strong></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Head Name: <?= $head_name ?></label>
        </div>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%">

        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Head Name
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Type
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Debit
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Credit
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Total Amount
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $debit_total = 0;
            $credit_total = 0;
            $balance_total = 0;
            foreach ($head_posting_details as $head_posting) {
                ?>
                <?php
                $debit_total += abs($head_posting->debit_amount);
                $credit_total += abs($head_posting->credit_amount);
                $balance_total += abs($head_posting->total_amount);
                ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($head_posting->head_name) ?></td>
                    <td><?= ucfirst($head_posting->head_type) ?></td>
                    <td><?= number_format((double) $head_posting->credit_amount, 2) ?></td>
                    <td><?= number_format((double) $head_posting->debit_amount, 2) ?></td>
                    <?php if ($head_posting->total_amount < 0) { ?>
                        <td><?= number_format((double) abs($head_posting->total_amount), 2) . '(Cr)' ?></td>
                    <?php } elseif ($head_posting->total_amount > 0) { ?>
                        <td><?= number_format((double) abs($head_posting->total_amount), 2) . '(Dr)' ?></td>
                    <?php } else { ?>
                        <td><?= number_format((double) abs($head_posting->total_amount), 2) ?></td>
                    <?php } ?>
                </tr>

            <?php } ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $credit_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $debit_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $balance_total, 2) ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>

</div>


<script language="javascript" type="text/javascript">

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

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

</script>
