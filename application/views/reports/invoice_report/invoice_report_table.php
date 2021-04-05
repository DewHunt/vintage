<?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="details-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th width="120px">Invoice</th>
                <th width="300px">Outlet</th>
                <th width="140px">Date</th>
                <th width="60px">Payment By</th>
                <th width="90px">Payable Amount</th>
                <th width="20px">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 1;
                $gross_total = 0;
                $paid_amount_total = 0;
                $countPendingOrder = 0;
            ?>
            <?php foreach ($invoice_details_view as $invoice_view): ?>
                <?php
                    $date_of_issue = date("d-m-Y", strtotime($invoice_view->order_date));
                    $gross_total += $invoice_view->gross_payable;
                    $paidAmount = $invoice_view->amount_to_paid;

                    if ($invoice_view->mode_of_payment == 'pending') {
                        $countPendingOrder = $countPendingOrder + 1;
                        $paidAmount = 0;
                    }

                    $paid_amount_total += $paidAmount;
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($invoice_view->invoice_number) ?></td>
                    <td><?= ucfirst($invoice_view->branch_name) ?></td>
                    <td><?= $invoice_view->order_date ?></td>
                    <td><?= ucfirst($invoice_view->mode_of_payment) ?></td>
                    <td align="right"><?= get_floating_point_number($paidAmount, TRUE); ?></td>
                    <td>
                        <button class="btn btn-primary invoice-view-button-<?= $invoice_view->id ?>" data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $invoice_view->id ?>" data-action="<?= base_url('reports/invoice_report/invoice_report_view') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>

                        <script type="text/javascript">
                            $('.invoice-view-button-<?= $invoice_view->id ?>').on('click', function (event) {
                                event.preventDefault();
                                $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                    $('.invoice-details-information-modal .invoice-show').html(data);
                                    $('.invoice-details-information-modal').modal('show');
                                });
                            });
                        </script>
                    </td>
                </tr>                
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" align="right"><strong>Grand Total</strong></td>
                <td align="right"><strong><?= get_floating_point_number($paid_amount_total, TRUE); ?></strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <input class="form-control" type="hidden" id="countPendingOrder" name="countPendingOrder" value="<?= $countPendingOrder ?>">
</div>

<div class="modal fade invoice-details-information-modal">
    <div class="modal-dialog modal-lg invoice-show " role="document"></div>
</div>
<?php $this->load->view('reports/invoice_report/special_notes_modal', $this->data); ?>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="invoice-report-print-section" style="display: none; width: 100%;">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 40%; }
        .middle { width: 30%; }
        .right { width: 30%; }
        .full { width: 100% }
        /* Clear floats after the columns */
        .row:after { content: ""; display: table; clear: both; }
        .text-center { text-align: center }
        .text-right { text-align: right }
    </style>

    <div class="print-content">
        <div class="row">
            <div class="column full text-center">
                <font size="5px"><?= strtoupper($company_information->company_name_1) ?></font>
                <p><?= $company_information->company_address_1 ?></p>
            </div>
        </div>

        <div class="row">
            <div class="column left">
                <label>Period: <?= get_string_to_date_fromat_ymd($start_date) ?> To <?= get_string_to_date_fromat_ymd($end_date) ?> </label>
            </div>

            <div class="column middle">
                <label class="search-from-date">Client : </label> <?= !empty($client_name) ? ucfirst($client_name) : ''; ?>
            </div>

            <div class="column right">
                <label class="search-from-date">Outlet : </label> <?= !empty($branch_name) ? $branch_name : ''; ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table border="1px">
                    <caption><strong>Invoice Report</strong></caption>
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th width="120px">Invoice</th>
                            <th width="170px">Outlet</th>
                            <th width="80px">Date</th>
                            <th width="100px">Payment By</th>
                            <th width="130px">Payable Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            $gross_total = 0;
                            $paid_amount_total = 0;
                        ?>

                        <?php foreach ($invoice_details_view as $invoice_view): ?>
                            <?php
                                $date_of_issue = date("d-m-Y", strtotime($invoice_view->order_date));
                                $gross_total += $invoice_view->gross_payable;
                                $paidAmount = $invoice_view->amount_to_paid;

                                if ($invoice_view->mode_of_payment == 'pending') {
                                    $countPendingOrder = $countPendingOrder + 1;
                                    $paidAmount = 0;
                                }

                                $paid_amount_total += $paidAmount;
                            ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= ucfirst($invoice_view->invoice_number) ?></td>
                                <td><?= ucfirst($invoice_view->branch_name) ?></td>
                                <td><?= $invoice_view->order_date ?></td>
                                <td><?= ucfirst($invoice_view->mode_of_payment) ?></td>
                                <td align="right"><?= get_floating_point_number($paidAmount, TRUE); ?></td>
                            </tr>          
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="5" align="right"><strong>Grand Total</strong></td>
                            <td align="right"><strong><?= get_floating_point_number($paid_amount_total, TRUE); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>



<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

    });
</script>