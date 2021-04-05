<?php
    $company_information;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
?>

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Invoice Details</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h4><?= strtoupper($company_information->company_name_1) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
                <label>Invoice :</label> <?= $invoice_details_by_invoice_id->invoice_number ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12 text-right">
                <label>Branch :</label> <?= $invoice_details_by_invoice_id->branch_name ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
                <?php $date_of_issue = date("d-m-Y", strtotime($invoice_details_by_invoice_id->date_of_issue)); ?>
                <label>Date Of Issue :</label> <?= $date_of_issue ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12 text-right">
                <label>Sold To :</label> <?= $invoice_details_by_invoice_id->client_name ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <label>Order Information</label>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center" width="20px">SL</th>
                            <th class="text-center">Product</th>
                            <th class="text-center" width="100px">Unit Price</th>
                            <th class="text-center" width="100px">Quantity</th>
                            <th class="text-center" width="100px">Discount</th>
                            <th class="text-center" width="100px">Sales Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>

                        <?php foreach ($sale_product_list as $sale_product): ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= ucfirst($sale_product->productName) ?></td>
                                <td align="right"><?= number_format((double) $sale_product->unit_price, 2) ?></td>
                                <td align="right"><?= $sale_product->quantity ?></td>
                                <td align="right"><?= number_format((double) $sale_product->discount_amount, 2) ?></td>
                                <td align="right"><?= number_format((double) $sale_product->sales_price_excluding_vat, 2) ?></td>
                            </tr>                          
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Order Total</th>
                            <td align="right"> <?= number_format((double) $invoice_details_by_invoice_id->gross_payable, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">Vat Total</th>
                            <td align="right"> <?= number_format((double) $invoice_details_by_invoice_id->total_vat, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">Discount</th>
                            <td align="right"><?= number_format((double) $invoice_details_by_invoice_id->deduction, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">Total Amount</th>
                            <td align="right"><?= number_format((double) $invoice_details_by_invoice_id->amount_to_paid, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Amount In word :</label> <?= ucwords(convert_number_to_words($invoice_details_by_invoice_id->amount_to_paid) . ' Taka'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Mode Of Payment :</label> <?= ucfirst($invoice_details_by_invoice_id->mode_of_payment) ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    <?php }
} ?>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->


<div id="print-information" style="display: none;">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 30%; }
        .right { width: 70%; }
        .full { width: 100% }
        /* Clear floats after the columns */
        .row:after { content: ""; display: table; clear: both; }
        .text-center { text-align: center }
        .text-right { text-align: right }
    </style>

    <div class="print-content">
        <div class="row">
            <div class="column full text-center">
                <h4><?= strtoupper($company_information->company_name_1) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="column left">
                <label>Invoice :</label> <?= $invoice_details_by_invoice_id->invoice_number ?>
            </div>
            <div class="column right text-right">
                <label>Branch :</label> <?= $invoice_details_by_invoice_id->branch_name ?>
            </div>
        </div>

        <div class="row">
            <div class="column left">
                <?php $date_of_issue = date("d-m-Y", strtotime($invoice_details_by_invoice_id->date_of_issue)); ?>
                <label>Date Of Issue :</label> <?= $date_of_issue ?>
            </div>
            <div class="column right text-right">
                <label>Sold To :</label> <?= $invoice_details_by_invoice_id->client_name ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table>
                    <caption>Order Information</caption>
                    <thead>
                        <tr>
                            <tr>
                                <th width="20px">SL</th>
                                <th>Product</th>
                                <th width="90px" align="right">Unit Price</th>
                                <th width="80px" align="right">Quantity</th>
                                <th width="80px" align="right">Discount</th>
                                <th width="90px" align="right">Sales Price</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($sale_product_list as $sale_product): ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= ucfirst($sale_product->productName) ?></td>
                                <td align="right"><?= number_format((double) $sale_product->unit_price, 2) ?></td>
                                <td align="right"><?= $sale_product->quantity ?></td>
                                <td align="right"><?= number_format((double) $sale_product->discount_amount, 2) ?></td>
                                <td align="right"><?= number_format((double) $sale_product->sales_price_excluding_vat, 2) ?></td>
                            </tr>                          
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right">Order Total</th>
                            <td align="right"> <?= number_format((double) $invoice_details_by_invoice_id->gross_payable, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right">Vat Total</th>
                            <td align="right"> <?= number_format((double) $invoice_details_by_invoice_id->total_vat, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right">Discount</th>
                            <td align="right"><?= number_format((double) $invoice_details_by_invoice_id->deduction, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right">Total Amount</th>
                            <td align="right"><?= number_format((double) $invoice_details_by_invoice_id->amount_to_paid, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row" style="padding-left: 10px;">
            <div class="column full">
                <p><label>Amount In word :</label> <?= ucwords(convert_number_to_words($invoice_details_by_invoice_id->amount_to_paid) . ' Taka'); ?></p>
                <p><label>Mode Of Payment :</label> <?= ucfirst($invoice_details_by_invoice_id->mode_of_payment) ?></p>
            </div>
        </div>

    </div>
</div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".print-button").on("click", function () {

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
    $('.modal-close-button').click(function () {
        $('.modal').modal('hide');
    });
</script>


