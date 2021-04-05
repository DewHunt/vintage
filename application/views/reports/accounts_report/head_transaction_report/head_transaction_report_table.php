<div class="card card-boarder">

    <?php
    $company_information;
    $head_details_report_by_head_id;

    /* echo '<pre>';
      print_r($head_details_report_by_head_id);
      echo '</pre>';
      die(); */
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Head Name: <?= ucfirst($head_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
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
                <th>Date</th>
                <th>Narration</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($head_details_report_by_head_id)) {
                $first = reset($head_details_report_by_head_id);
                $last = end($head_details_report_by_head_id);
                ?>
                <?php $posting_date_first = date("d-m-Y", strtotime($first->posting_date)); ?>
                <tr>
                    <td><strong><?= $posting_date_first ?></strong></td>
                    <td><strong><?= 'Opening Balance' ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) abs($first->opening_balance), 2) ?></strong></td>
                </tr>

                <?php
                $total_debit_amount = 0;
                $total_credit_amount = 0;
                foreach ($head_details_report_by_head_id as $head_details_report) {
                    ?>
                    <?php $total_debit_amount += (double) $head_details_report->debit_amount; ?>
                    <?php $total_credit_amount += (double) $head_details_report->credit_amount; ?>
                    <?php $posting_date = date("d-m-Y", strtotime($head_details_report->posting_date)); ?>
                    <?php
                    if (($head_details_report->income_head_id > 0)) {
                        $head_id = $head_details_report->income_head_id;
                    } else {
                        $head_id = $head_details_report->expense_head_id;
                    }
                    $head_details = $this->Head_details_Model->get_head_details($head_id);
                    if (!empty($head_details) && !boolval($head_details->is_active)) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?= $posting_date ?></td>
                        <td>
                            <?= $head_details_report->narration ?>
                            <?php
                            if ((!empty($head_details_report->mr_number)) || (!empty($head_details_report->invoice_number))) {
                                if ((empty($head_details_report->mr_number)) && (!empty($head_details_report->invoice_number))) {
                                    echo '(' . 'Invoice - ' . $head_details_report->invoice_number . ')';
                                } elseif ((!empty($head_details_report->mr_number)) && (empty($head_details_report->invoice_number))) {
                                    echo '(MR. - ' . $head_details_report->mr_number . ')';
                                } else {
                                    echo '(MR. - ' . $head_details_report->mr_number . ' , ' . 'Invoice - ' . $head_details_report->invoice_number . ')';
                                }
                            }
                            ?>
                        </td>
                        <td><?= number_format((double) $head_details_report->debit_amount, 2) ?></td>
                        <td><?= number_format((double) $head_details_report->credit_amount, 2) ?></td>
                        <?php if (($head_details_report->closing_balance > 0)) { ?>
                            <td><?= number_format((double) abs($head_details_report->closing_balance), 2) . '(Dr)' ?></td>
                        <?php } elseif ($head_details_report->closing_balance < 0) { ?>
                            <td><?= number_format((double) abs($head_details_report->closing_balance), 2) . '(Cr)' ?></td>
                        <?php } else { ?>
                            <td><?= number_format((double) abs($head_details_report->closing_balance), 2) ?></td>
                        <?php } ?>
                    </tr>

                <?php } ?>
                <tr>
                    <td><strong><?= '' ?></strong></td>
                    <td><strong><?= 'Total' ?></strong></td>
                    <td><strong><?= get_floating_point_number($total_debit_amount, TRUE) ?></strong></td>
                    <td><strong><?= get_floating_point_number($total_credit_amount, TRUE) ?></strong></td>
                    <td><strong><?= '' ?></strong></td>
                </tr>

                <?php $posting_date_last = date("d-m-Y", strtotime($last->posting_date)); ?>
                <tr>
                    <td><strong><?= $posting_date_last ?></strong></td>
                    <td><strong><?= 'Closing Balance' ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) abs($last->closing_balance), 2) ?></strong></td>
                </tr>
            <?php } ?>

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

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date"><strong>Head Transaction Report</strong></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Head Name: <?= ucfirst($head_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Date
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Narration
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Debit
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Credit
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Balance
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($head_details_report_by_head_id)) {
                $first = reset($head_details_report_by_head_id);
                $last = end($head_details_report_by_head_id);
                ?>
                <?php $posting_date_first = date("d-m-Y", strtotime($first->posting_date)); ?>
                <tr style="border: thick">
                    <td><strong><?= $posting_date_first ?></strong></td>
                    <td><strong><?= 'Opening Balance' ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) abs($first->opening_balance), 2) ?></strong></td>
                </tr>

                <?php
                $total_debit_amount = 0;
                $total_credit_amount = 0;
                foreach ($head_details_report_by_head_id as $head_details_report) {
                    ?>
                    <?php $total_debit_amount += (double) $head_details_report->debit_amount; ?>
                    <?php $total_credit_amount += (double) $head_details_report->credit_amount; ?>
                    <?php $posting_date = date("d-m-Y", strtotime($head_details_report->posting_date)); ?>
                    <?php
                    if (($head_details_report->income_head_id > 0)) {
                        $head_id = $head_details_report->income_head_id;
                    } else {
                        $head_id = $head_details_report->expense_head_id;
                    }
                    $head_details = $this->Head_details_Model->get_head_details($head_id);
                    if (!empty($head_details) && !boolval($head_details->is_active)) {
                        continue;
                    }
                    ?>

                    <tr style="border: thick">
                        <td><?= $posting_date ?></td>
                        <td>
                            <?= $head_details_report->narration ?>
                            <?php
                            if ((!empty($head_details_report->mr_number)) || (!empty($head_details_report->invoice_number))) {
                                if ((empty($head_details_report->mr_number)) && (!empty($head_details_report->invoice_number))) {
                                    echo '(' . 'Invoice - ' . $head_details_report->invoice_number . ')';
                                } elseif ((!empty($head_details_report->mr_number)) && (empty($head_details_report->invoice_number))) {
                                    echo '(MR. - ' . $head_details_report->mr_number . ')';
                                } else {
                                    echo '(MR. - ' . $head_details_report->mr_number . ' , ' . 'Invoice - ' . $head_details_report->invoice_number . ')';
                                }
                            }
                            ?>
                        </td>
                        <td><?= number_format((double) $head_details_report->debit_amount, 2) ?></td>
                        <td><?= number_format((double) $head_details_report->credit_amount, 2) ?></td>
                        <?php if (($head_details_report->closing_balance > 0)) { ?>
                            <td><?= number_format((double) abs($head_details_report->closing_balance), 2) . '(Dr)' ?></td>
                        <?php } elseif ($head_details_report->closing_balance < 0) { ?>
                            <td><?= number_format((double) abs($head_details_report->closing_balance), 2) . '(Cr)' ?></td>
                        <?php } else { ?>
                            <td><?= number_format((double) abs($head_details_report->closing_balance), 2) ?></td>
                        <?php } ?>
                    </tr>

                <?php } ?>
                <tr style="border: thick">
                    <td><strong><?= '' ?></strong></td>
                    <td><strong><?= 'Total' ?></strong></td>
                    <td><strong><?= get_floating_point_number($total_debit_amount, TRUE) ?></strong></td>
                    <td><strong><?= get_floating_point_number($total_credit_amount, TRUE) ?></strong></td>
                    <td><strong><?= '' ?></strong></td>
                </tr>
                <?php $posting_date_last = date("d-m-Y", strtotime($last->posting_date)); ?>
                <tr style="border: thick">
                    <td><strong><?= $posting_date_last ?></strong></td>
                    <td><strong><?= 'Closing Balance' ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) 0, 2) ?></strong></td>
                    <td><strong><?= number_format((double) abs($last->closing_balance), 2) ?></strong></td>
                </tr>
            <?php } ?>

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
