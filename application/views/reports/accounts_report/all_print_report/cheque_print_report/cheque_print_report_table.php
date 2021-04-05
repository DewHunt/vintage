<div class="card card-boarder">
    <?php
//    echo '<pre>';
//    print_r($cheque_print_by_date);
//    echo '</pre>';
//    die();
    ?>
    <div>
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary all-cheque-print-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </div>

    <div style="width: 100%;">
        <table class="table table-striped" style="width: 100%" id="details-table">

            <thead class="thead-default">
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Pay To</th>
                    <th>Amount</th>
                    <th>Amount In Words</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total_amount = 0;
                foreach ($cheque_print_by_date as $cheque_print) {
                    ?>
                    <?php $cheque_print_cheque_date = date("d-m-Y", strtotime($cheque_print->cheque_date)); ?>

                    <?php $total_amount += (double) ($cheque_print->amount); ?>

                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $cheque_print_cheque_date ?></td>
                        <td><?= $cheque_print->pay_to ?></td>
                        <td><?= get_floating_point_number($cheque_print->amount, TRUE) ?></td>
                        <td><?= $cheque_print->amount_in_words ?></td>
                        <td><?= !empty($cheque_print->details) ? $cheque_print->details : '' ?></td>
                        <td>
                            <button class="btn btn-primary cheque-print-report-print-button"data-toggle="tooltip" data-placement="bottom" title="Print" data-id="<?= $cheque_print->id ?>" data-action="<?= base_url('reports/accounts_report/all_print_report/cheque_print_report/cheque_print_report_print') ?>">
                                <i class="fa fa-print" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= get_floating_point_number($total_amount, TRUE); ?></strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="all-cheque-print-report-print-information" style="width: 100%; display: none;">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date"><strong>Cheque Print Report</strong></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
        <hr>
    </div>       
    <table width="100%" border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">
        <thead class="thead-default">
            <tr style="border: thick">
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Date
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Pay To
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Amount
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Amount In Words
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Details
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total_amount = 0;
            foreach ($cheque_print_by_date as $cheque_print) {
                ?>
                <?php $cheque_print_cheque_date = date("d-m-Y", strtotime($cheque_print->cheque_date)); ?>

                <?php $total_amount += (double) ($cheque_print->amount); ?>

                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $cheque_print_cheque_date ?></td>
                    <td><?= $cheque_print->pay_to ?></td>
                    <td><?= get_floating_point_number($cheque_print->amount, TRUE) ?></td>
                    <td><?= $cheque_print->amount_in_words ?></td>
                    <td><?= !empty($cheque_print->details) ? $cheque_print->details : '' ?></td>
                </tr>
            <?php } ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= get_floating_point_number($total_amount, TRUE); ?></strong></td>
                <td></td>
                <td></td>
            </tr>
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

    $(".all-cheque-print-report-print-button").on("click", function () {
        var divContents = $('#all-cheque-print-report-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

    cheque_print_report_print();
    function cheque_print_report_print() {
        $(".cheque-print-report-print-button").on("click", function () {
            $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                var divContents = data['value'];
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });
        });
    }



</script>
