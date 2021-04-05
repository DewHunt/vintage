<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button money-receipt-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>
    <div class="table-responsive table-bordered">

        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Receipt(MR) No</th>
                    <th>Receipt Date</th>
                    <th>Client</th>
                    <th>Outlet</th>
                    <th>Amount Received</th>
                    <th>Mode of Sale</th>
                    <th>Invoice No</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total = 0;
                foreach ($payment_report_list as $payment_report):
                    ?>
                    <?php $receipt_date = date("d-m-Y", strtotime($payment_report->receipt_date)); ?>
                    <?php $total += $payment_report->amount_received; ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $payment_report->receipt_mr_no ?></td>
                        <td><?= $receipt_date ?></td>
                        <td><?= $payment_report->client_name ?></td>
                        <td><?= $payment_report->branch_name ?></td>
                        <td><?= number_format((double) $payment_report->amount_received, 2) ?></td>
                        <?php if ((string) $payment_report->payment_type == 'tt') { ?>
                            <td><?= strtoupper($payment_report->payment_type) ?></td>
                        <?php } else { ?>
                            <td><?= ucfirst($payment_report->payment_type) ?></td>
                        <?php } ?>
                        <td><?= $payment_report->invoice_number ?></td>
                        <td><?= $payment_report->remarks ?></td>
                        <td>
                            <button class="btn btn-primary payment-report-view-button-<?= $payment_report->id ?>"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="View Details"
                                    data-id="<?= $payment_report->id ?>"
                                    data-action="<?= base_url('reports/payment_report/payment_report_modal_show') ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i></button>
                            <script>
                                $('.payment-report-view-button-<?= $payment_report->id ?>').on('click', function (event) {
                                    event.preventDefault();
                                    $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                        $('.money-receipt-details-information-modal .invoice-show').html(data);
                                        $('.money-receipt-details-information-modal').modal('show');
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="modal fade money-receipt-details-information-modal">
        <div class="modal-dialog modal-lg invoice-show " role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="money-receipt-report-print-section" style="display: none; width: 100%" >

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong>Money Receipt Report</strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
    </div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Receipt(MR) No</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Receipt Date</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Outlet</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Amount Received</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Mode of Sale</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Invoice No</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($payment_report_list as $payment_report):
                ?>
                <?php $receipt_date = date("d-m-Y", strtotime($payment_report->receipt_date)); ?>
                <?php $total += $payment_report->amount_received; ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $payment_report->receipt_mr_no ?></td>
                    <td><?= $receipt_date ?></td>
                    <td><?= $payment_report->client_name ?></td>
                    <td><?= $payment_report->branch_name ?></td>
                    <td><?= number_format((double) $payment_report->amount_received, 2) ?></td>
                    <?php if ((string) $payment_report->payment_type == 'tt') { ?>
                        <td><?= strtoupper($payment_report->payment_type) ?></td>
                    <?php } else { ?>
                        <td><?= ucfirst($payment_report->payment_type) ?></td>
                    <?php } ?>
                    <td><?= $payment_report->invoice_number ?></td>
                    <td><?= $payment_report->remarks ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {
        $(".money-receipt-print-button").on("click", function () {
            var divContents = $('#money-receipt-report-print-section').html();
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

    });
</script>