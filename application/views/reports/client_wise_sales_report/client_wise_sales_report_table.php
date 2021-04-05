<?php
    $company_information;
    $client_invoice_details_list;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="details-table">
        <thead class="thead-default">
            <tr>
                <th width="20px">SL</th>
                <th>Date</th>
                <th>Invoice</th>
                <th>Client</th>
                <th>Branch</th>
                <th>User</th>
                <th>Total</th>
                <th width="20px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1; $total = 0; ?>

            <?php foreach ($client_invoice_details_list as $client_invoice): ?>
                <?php
                    $date_of_issue = date("d-m-Y", strtotime($client_invoice->date_of_issue));
                    $paidAmount = $client_invoice->amount_to_paid;

                    if ($client_invoice->mode_of_payment == 'pending') {
                        $paidAmount = 0;
                    }

                    $total += (double) $paidAmount;
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $date_of_issue ?></td>
                    <td><?= $client_invoice->invoice_number ?></td>
                    <td><?= ucfirst($client_invoice->client_name) ?></td>
                    <td><?= ucfirst($client_invoice->branch_name) ?></td>
                    <td><?= ucfirst($client_invoice->user_name) ?></td>
                    <td align="right"><?= number_format($paidAmount,2,'.',',') ?></td>
                    <td>
                        <button class="btn btn-primary client-invoice-view-button" data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $client_invoice->id ?>" data-action="<?= base_url('reports/client_wise_sales_report/client_invoice_report_view') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>                
            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="6" align="right"><strong>Grand Total</strong></td>
                <td align="right"><strong><?= number_format((double) $total, 2) ?></strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<style type="text/css">
    @media screen and (min-width: 768px) {
        .modal:before { height: auto; width: 50%; }
    }
</style>

<div class="modal fade client-invoice-details-information-modal">
    <div class="modal-dialog modal-lg client-invoice-show " role="document">
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-all-information" style="display: none">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 60%; }
        .right { width: 40%; }
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
            <div class="column left"><label>Client :</label> <?= $client_name ?></div>
            <div class="column right" align="right"><label class="search-from-date">Period : </label> <?= $start_date ?> To <?= $end_date ?></div>
        </div>

        <div class="row">
            <div class="column full">
                <table id="branch-stock-list-table">
                    <caption><strong>Clientwise Sales Report</strong></caption>
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th width="60px">Date</th>
                            <th width="60px">Invoice</th>
                            <th>Client</th>
                            <th>Branch</th>
                            <th>User</th>
                            <th width="80px">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; $total = 0; ?>

                        <?php foreach ($client_invoice_details_list as $client_invoice): ?>
                            <?php
                                $date_of_issue = date("d-m-Y", strtotime($client_invoice->date_of_issue));
                                $paidAmount = $client_invoice->amount_to_paid;

                                if ($client_invoice->mode_of_payment == 'pending') {
                                    $paidAmount = 0;
                                }

                                $total += (double) $paidAmount;
                            ?>
                            <tr style="border: thick">
                                <td><?= $count++ ?></td>
                                <td><?= $date_of_issue ?></td>
                                <td><?= $client_invoice->invoice_number ?></td>
                                <td><?= ucfirst($client_invoice->client_name) ?></td>
                                <td><?= ucfirst($client_invoice->branch_name) ?></td>
                                <td><?= ucfirst($client_invoice->user_name) ?></td>
                                <td align="right"><?= number_format((double) $paidAmount,2,'.','') ?></td>
                            </tr>                            
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="6" align="right"><strong>Grand Total</strong></td>
                            <td align="right"><strong><?= number_format($total,2,'.',',') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

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

    // $(".print-button").on("click", function () {

    //     var divContents = $('#print-information').html();

    //     var printWindow = window.open();
    //     printWindow.document.write(divContents);
    //     printWindow.document.close();
    //     printWindow.print();
    //     printWindow.close();
    // });
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
