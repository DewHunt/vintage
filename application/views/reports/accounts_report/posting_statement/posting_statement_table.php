<div class="card card-boarder">

    <?php
    $company_information;
    $posting_statement_details;
    $head_id;

    /* echo '<pre>';
     print_r($posting_statement_details);
     echo '</pre>';
     die();*/
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
            <th>SL</th>
            <th>Header</th>
            <th>Opening Balance</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Closing Balance</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        $debit_total = 0;
        $credit_total = 0;
        $closing_total = 0;
        if ((strtolower($head_name) == 'all') || ($head_id <= 0)) {  // for all head
            $head_details_list = $this->Head_details_Model->get_head_details();
            if (!empty($head_details_list)) {
                foreach ($head_details_list as $head) {
                    $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing($start_date, $end_date, $head->id);
                    if (!empty($opening_and_closing)) {
                        $first = reset($opening_and_closing);
                        $last = end($opening_and_closing);
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= ucfirst($first->head_name) ?></td>
                            <td><?= number_format((double)abs($last->opening_balance), 2); ?></td>
                            <td>
                                <?php $sum = 0;
                                foreach ($opening_and_closing as $key => $value) {
                                    if (isset($value->debit_amount))
                                        $sum += $value->debit_amount;
                                }
                                $debit_total += $sum;
                                echo number_format((double)abs($sum), 2); ?>
                            </td>
                            <td>
                                <?php $sum = 0;
                                foreach ($opening_and_closing as $key => $value) {
                                    if (isset($value->credit_amount))
                                        $sum += $value->credit_amount;
                                }
                                $credit_total += $sum;
                                echo number_format((double)abs($sum), 2); ?>
                            </td>
                            <?php if ($first->closing_balance > 0) { ?>
                                <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                            <?php } elseif ($first->closing_balance < 0) { ?>
                                <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                            <?php } else { ?>
                                <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                            <?php } ?>
                            <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                        </tr>
                    <?php } else {
                        $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing_for_lower_check($start_date, $end_date, $head->id);// don't use this $end_date because of checking lower limit
                        if (!empty($opening_and_closing)) {
                            $first = reset($opening_and_closing);
                            $last = end($opening_and_closing);
                            ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= ucfirst($first->head_name) ?></td>
                                <td><?= number_format((double)abs($first->closing_balance), 2); ?></td>
                                <td><?= number_format((double)0, 2) ?></td>
                                <td><?= number_format((double)0, 2) ?></td>
                                <?php if ($first->closing_balance > 0) { ?>
                                    <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                                <?php } elseif ($first->closing_balance < 0) { ?>
                                    <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                                <?php } else { ?>
                                    <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                                <?php } ?>
                                <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                            </tr>
                        <?php } else { ?>

                        <?php }
                    }
                } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double)$debit_total, 2); ?></strong></td>
                    <td><strong><?= number_format((double)$credit_total, 2); ?></strong></td>
                    <td>
                        <!--<strong>
                            <?php
                        /*                            if ($debit_total > $credit_total) {
                                                        $closing_total = ($debit_total - $credit_total);
                                                        echo number_format((double)abs($closing_total), 2) . '(Dr)';
                                                    } elseif ($debit_total < $credit_total) {
                                                        $closing_total = ($credit_total - $debit_total);
                                                        echo number_format((double)abs($closing_total), 2) . '(Cr)';
                                                    } else {
                                                        echo number_format((double)0, 2);
                                                    }
                                                    */ ?>
                        </strong>-->
                    </td>
                </tr>

            <?php }
        } else { // for single head
            $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing($start_date, $end_date, $head_id);
            if (!empty($opening_and_closing)) {
                $first = reset($opening_and_closing);
                $last = end($opening_and_closing);
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($first->head_name) ?></td>
                    <td><?= number_format((double)abs($last->opening_balance), 2); ?></td>
                    <td>
                        <?php $sum = 0;
                        foreach ($opening_and_closing as $key => $value) {
                            if (isset($value->debit_amount))
                                $sum += $value->debit_amount;
                        }
                        $debit_total += $sum;
                        echo number_format((double)abs($sum), 2); ?>
                    </td>
                    <td>
                        <?php $sum = 0;
                        foreach ($opening_and_closing as $key => $value) {
                            if (isset($value->credit_amount))
                                $sum += $value->credit_amount;
                        }
                        $credit_total += $sum;
                        echo number_format((double)abs($sum), 2); ?>
                    </td>
                    <?php if ($first->closing_balance > 0) { ?>
                        <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                    <?php } elseif ($first->closing_balance < 0) { ?>
                        <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                    <?php } else { ?>
                        <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                    <?php } ?>
                    <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                </tr>
            <?php } else {
                $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing_for_lower_check($start_date, $end_date, $head_id);
                if (!empty($opening_and_closing)) {
                    $first = reset($opening_and_closing);
                    $last = end($opening_and_closing);
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= ucfirst($first->head_name) ?></td>
                        <td><?= number_format((double)abs($first->closing_balance), 2); ?></td>
                        <td><?= number_format((double)0, 2) ?></td>
                        <td><?= number_format((double)0, 2) ?></td>
                        <?php if ($first->closing_balance > 0) { ?>
                            <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                        <?php } elseif ($first->closing_balance < 0) { ?>
                            <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                        <?php } else { ?>
                            <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                        <?php } ?>
                        <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                    </tr>
                <?php } else { ?>

                <?php }
            } ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double)$debit_total, 2); ?></strong></td>
                <td><strong><?= number_format((double)$credit_total, 2); ?></strong></td>
                <td>
                    <!-- <strong>
                        <?php
                    /*                        if ($debit_total > $credit_total) {
                                                $closing_total = ($debit_total - $credit_total);
                                                echo number_format((double)abs($closing_total), 2) . '(Dr)';
                                            } elseif ($debit_total < $credit_total) {
                                                $closing_total = ($credit_total - $debit_total);
                                                echo number_format((double)abs($closing_total), 2) . '(Cr)';
                                            } else {
                                                echo number_format((double)0, 2);
                                            }
                                            */ ?>
                    </strong>-->
                </td>
            </tr>
        <?php }
        ?>
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
            <label class="search-from-date"><strong>Posting Statement</strong></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Head Name: <?= ucfirst($head_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>

    <table width="100%" border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
        <tr>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                SL
            </th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                Header
            </th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                Opening Balance
            </th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                Debit
            </th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                Credit
            </th>
            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                Closing Balance
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        $debit_total = 0;
        $credit_total = 0;
        $closing_total = 0;
        if ((strtolower($head_name) == 'all') || ($head_id <= 0)) {  // for all head
            $head_details_list = $this->Head_details_Model->get_head_details();
            if (!empty($head_details_list)) {
                foreach ($head_details_list as $head) {
                    $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing($start_date, $end_date, $head->id);
                    if (!empty($opening_and_closing)) {
                        $first = reset($opening_and_closing);
                        $last = end($opening_and_closing);
                        ?>
                        <tr style="border: thick">
                            <td><?= $count++ ?></td>
                            <td><?= ucfirst($first->head_name) ?></td>
                            <td><?= number_format((double)abs($last->opening_balance), 2); ?></td>
                            <td>
                                <?php $sum = 0;
                                foreach ($opening_and_closing as $key => $value) {
                                    if (isset($value->debit_amount))
                                        $sum += $value->debit_amount;
                                }
                                $debit_total += $sum;
                                echo number_format((double)abs($sum), 2); ?>
                            </td>
                            <td>
                                <?php $sum = 0;
                                foreach ($opening_and_closing as $key => $value) {
                                    if (isset($value->credit_amount))
                                        $sum += $value->credit_amount;
                                }
                                $credit_total += $sum;
                                echo number_format((double)abs($sum), 2); ?>
                            </td>
                            <?php if ($first->closing_balance > 0) { ?>
                                <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                            <?php } elseif ($first->closing_balance < 0) { ?>
                                <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                            <?php } else { ?>
                                <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                            <?php } ?>
                            <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                        </tr>
                    <?php } else {
                        $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing_for_lower_check($start_date, $end_date, $head->id);
                        if (!empty($opening_and_closing)) {
                            $first = reset($opening_and_closing);
                            $last = end($opening_and_closing);
                            ?>
                            <tr style="border: thick">
                                <td><?= $count++ ?></td>
                                <td><?= ucfirst($first->head_name) ?></td>
                                <td><?= number_format((double)abs($first->closing_balance), 2); ?></td>
                                <td><?= number_format((double)0, 2) ?></td>
                                <td><?= number_format((double)0, 2) ?></td>
                                <?php if ($first->closing_balance > 0) { ?>
                                    <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                                <?php } elseif ($first->closing_balance < 0) { ?>
                                    <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                                <?php } else { ?>
                                    <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                                <?php } ?>
                                <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                            </tr>
                        <?php } else { ?>

                        <?php }
                    }
                } ?>
                <tr style="border: thick">
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double)$debit_total, 2); ?></strong></td>
                    <td><strong><?= number_format((double)$credit_total, 2); ?></strong></td>
                    <td>
                        <!-- <strong>
                            <?php
                        /*                            if ($debit_total > $credit_total) {
                                                        $closing_total = ($debit_total - $credit_total);
                                                        echo number_format((double)abs($closing_total), 2) . '(Dr)';
                                                    } elseif ($debit_total < $credit_total) {
                                                        $closing_total = ($credit_total - $debit_total);
                                                        echo number_format((double)abs($closing_total), 2) . '(Cr)';
                                                    } else {
                                                        echo number_format((double)0, 2);
                                                    }
                                                    */ ?>
                        </strong>-->
                    </td>
                </tr>
            <?php }
        } else { // for single head
            $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing($start_date, $end_date, $head_id);
            if (!empty($opening_and_closing)) {
                $first = reset($opening_and_closing);
                $last = end($opening_and_closing);
                ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($first->head_name) ?></td>
                    <td><?= number_format((double)abs($last->opening_balance), 2); ?></td>
                    <td>
                        <?php $sum = 0;
                        foreach ($opening_and_closing as $key => $value) {
                            if (isset($value->debit_amount))
                                $sum += $value->debit_amount;
                        }
                        $debit_total += $sum;
                        echo number_format((double)abs($sum), 2); ?>
                    </td>
                    <td>
                        <?php $sum = 0;
                        foreach ($opening_and_closing as $key => $value) {
                            if (isset($value->credit_amount))
                                $sum += $value->credit_amount;
                        }
                        $credit_total += $sum;
                        echo number_format((double)abs($sum), 2); ?>
                    </td>
                    <?php if ($first->closing_balance > 0) { ?>
                        <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                    <?php } elseif ($first->closing_balance < 0) { ?>
                        <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                    <?php } else { ?>
                        <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                    <?php } ?>
                    <!--<td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                </tr>
            <?php } else {
                $opening_and_closing = $this->Daywise_head_posting_Model->get_opening_and_closing_for_lower_check($start_date, $end_date, $head_id);
                if (!empty($opening_and_closing)) {
                    $first = reset($opening_and_closing);
                    $last = end($opening_and_closing);
                    ?>
                    <tr style="border: thick">
                        <td><?= $count++ ?></td>
                        <td><?= ucfirst($first->head_name) ?></td>
                        <td><?= number_format((double)abs($first->closing_balance), 2); ?></td>
                        <td><?= number_format((double)0, 2) ?></td>
                        <td><?= number_format((double)0, 2) ?></td>
                        <?php if ($first->closing_balance > 0) { ?>
                            <td><?= number_format((double)abs($first->closing_balance), 2) . '(Dr)' ?></td>
                        <?php } elseif ($first->closing_balance < 0) { ?>
                            <td><?= number_format((double)abs($first->closing_balance), 2) . '(Cr)' ?></td>
                        <?php } else { ?>
                            <td><?= number_format((double)abs($first->closing_balance), 2) ?></td>
                        <?php } ?>
                        <!-- <td><? /*= number_format((double)abs($first->closing_balance), 2); */ ?></td>-->
                    </tr>
                <?php } else { ?>

                <?php }
            } ?>

            <tr style="border: thick">
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double)$debit_total, 2); ?></strong></td>
                <td><strong><?= number_format((double)$credit_total, 2); ?></strong></td>
                <td>
                    <!--<strong>
                        <?php
                    /*                        if ($debit_total > $credit_total) {
                                                $closing_total = ($debit_total - $credit_total);
                                                echo number_format((double)abs($closing_total), 2) . '(Dr)';
                                            } elseif ($debit_total < $credit_total) {
                                                $closing_total = ($credit_total - $debit_total);
                                                echo number_format((double)abs($closing_total), 2) . '(Cr)';
                                            } else {
                                                echo number_format((double)0, 2);
                                            }
                                            */ ?>
                    </strong>-->
                </td>
            </tr>
        <?php }
        ?>
        <hr>
        </tbody>
    </table>

</div>

<script language="javascript" type="text/javascript">

    $('.client-voucher-details-view-button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.clientwise-voucher-details-information-modal .client-voucher-show').html(data);
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

