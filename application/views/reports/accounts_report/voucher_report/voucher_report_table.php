<div class="card card-boarder">
    <?php
    $voucher_posting_details_by_date;
    $company_information;
    ?>

    <div>
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary voucher-report-print-button report-print-button"><i
                class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </div>

    <div style="width: 100%;">
        <table class="table table-striped" style="width: 100%" id="details-table">

            <thead class="thead-default">
                <tr>
                    <th>SL</th>
                    <th>Posting Date</th>
                    <th>Voucher Number</th>
                    <th>Total Amount</th>
                    <th>Narration</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total = 0;
                foreach ($voucher_posting_details_by_date as $voucher_posting):
                    ?>
                    <?php $voucher_posting_date = date("d-m-Y", strtotime($voucher_posting->posting_date)); ?>

                    <?php $total += abs($voucher_posting->total_debit_amount); ?>

                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $voucher_posting_date ?></td>
                        <td><?= $voucher_posting->voucher_number ?></td>
                        <td><?= number_format((double) $voucher_posting->total_debit_amount, 2) ?></td>
                        <td><?= $voucher_posting->common_narration ?></td>
                        <td>
                            <button id="voucher_details_view_button-<?= $voucher_posting->id ?>" class="btn btn-primary voucher_details_view_button"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="View Details"
                                    data-id="<?= $voucher_posting->id ?>"
                                    data-action="<?= base_url('reports/accounts_report/voucher_report/voucher_details_report_modal_show') ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double) $total, 2); ?></strong></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <script type="text/javascript">
                $('.voucher_details_view_button').on('click', function (event) {
                    event.preventDefault();
                    $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                        $('.voucher-details-information-modal .voucher_show').html(data)
                        $('.voucher-details-information-modal').modal('show');
                    });
                });
            </script>
        </table>
    </div>
    <div class="modal fade voucher-details-information-modal">
        <div class="modal-dialog modal-lg voucher_show " role="document">
        </div>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="voucher-report-print-information" style="width: 100%; display: none;">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date"><strong>Voucher Report</strong></label>
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
                    Posting Date
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Voucher Number
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Total Amount
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Narration
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($voucher_posting_details_by_date as $voucher_posting):
                ?>
                <?php $voucher_posting_date = date("d-m-Y", strtotime($voucher_posting->posting_date)); ?>

                <?php $total += abs($voucher_posting->total_debit_amount); ?>

                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $voucher_posting_date ?></td>
                    <td><?= $voucher_posting->voucher_number ?></td>
                    <td><?= number_format((double) $voucher_posting->total_debit_amount, 2) ?></td>
                    <td><?= $voucher_posting->common_narration ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2); ?></strong></td>
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

    $(".voucher-report-print-button").on("click", function () {

        var divContents = $('#voucher-report-print-information').html();

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



