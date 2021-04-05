<?php
    $invoice_details_by_invoice_id;
    $employee;
    $dealer;
    $sale_product_list;
    $sale_product_list_row;
    $company_information;
    $currency_settings;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
?>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="modal-print-information" style="padding: 15px; display: none;">
    <style type="text/css">
        hr.dashed {border-top: 1px dashed black;font-weight: bold;margin: 5px 0px;width: 100%;}
        table {background-color: transparent;}
        caption {padding-top: 0px;padding-bottom: 3px;color: #777;text-align: center;}
        th {text-align: left;}
        .tab {width: 100%;max-width: 100%;margin-bottom: 5px;font-size:12px;}
        .tab > thead > tr > th,.tab > tbody > tr > th,.tab > tfoot > tr > th,
        .tab > thead > tr > td,.tab > tbody > tr > td,
        .tab > tfoot > tr > td {padding: 2px;line-height: 1.42857143;vertical-align: top;border-bottom: 1px dashed black;}
        .tab > thead > tr > th {vertical-align: bottom;border-bottom: 0px dashed black;}';                      
        .tab > caption + thead > tr:first-child > th,.tab > colgroup + thead > tr:first-child > th,
        .tab > thead:first-child > tr:first-child > th,.tab > caption + thead > tr:first-child > td,
        .tab > colgroup + thead > tr:first-child > td,.tab > thead:first-child > tr:first-child > td {border-top: 0;}
        .tab > tbody + tbody {border-top: 0px dashed black;}
        .tab .tab {background-color: #fff;}
        .tab-condensed > thead > tr > th,.tab-condensed > tbody > tr > th,
        .tab-condensed > tfoot > tr > th,.tab-condensed > thead > tr > td,
        .tab-condensed > tbody > tr > td,.tab-condensed > tfoot > tr > td {padding: 5px;}
        .tab-bordered {border: 1px solid black;}
        .tab-bordered > thead > tr > th,.tab-bordered > tbody > tr > th,
        .tab-bordered > tfoot > tr > th,.tab-bordered > thead > tr > td,
        .tab-bordered > tbody > tr > td,.tab-bordered > tfoot > tr > td {border: 1px solid black;}
        .tab-bordered > thead > tr > th,.tab-bordered > thead > tr > td {border-bottom-width: 2px;}
        .tab-striped > tbody > tr:nth-of-type(odd) {background-color: #f9f9f9;}
        .tab-hover > tbody > tr:hover {background-color: #f5f5f5;}
        table col[class*="col-"] {position: static;display: table-column;float: none;}
        table td[class*="col-"],table th[class*="col-"] {position: static;display: table-cell;float: none;}
        .tab > thead > tr > td.active,.tab > tbody > tr > td.active,.tab > tfoot > tr > td.active,
        .tab > thead > tr > th.active,.tab > tbody > tr > th.active,.tab > tfoot > tr > th.active,
        .tab > thead > tr.active > td,.tab > tbody > tr.active > td,.tab > tfoot > tr.active > td,
        .tab > thead > tr.active > th,.tab > tbody > tr.active > th,.tab > tfoot > tr.active > th {background-color: #f5f5f5;}
        .tab-hover > tbody > tr > td.active:hover,.tab-hover > tbody > tr > th.active:hover,
        .tab-hover > tbody > tr.active:hover > td,.tab-hover > tbody > tr:hover > .active,
        .tab-hover > tbody > tr.active:hover > th {background-color: #e8e8e8;}
        .tab > thead > tr > td.success,.tab > tbody > tr > td.success,
        .tab > tfoot > tr > td.success,.tab > thead > tr > th.success,
        .tab > tbody > tr > th.success,.tab > tfoot > tr > th.success,
        .tab > thead > tr.success > td,.tab > tbody > tr.success > td,
        .tab > tfoot > tr.success > td,.tab > thead > tr.success > th,
        .tab > tbody > tr.success > th,.tab > tfoot > tr.success > th {background-color: #dff0d8;}
        .tab-hover > tbody > tr > td.success:hover,.tab-hover > tbody > tr > th.success:hover,
        .tab-hover > tbody > tr.success:hover > td,.tab-hover > tbody > tr:hover > .success,
        .tab-hover > tbody > tr.success:hover > th {background-color: #d0e9c6;}
        .tab > thead > tr > td.info,.tab > tbody > tr > td.info,
        .tab > tfoot > tr > td.info,.tab > thead > tr > th.info,
        .tab > tbody > tr > th.info,.tab > tfoot > tr > th.info,
        .tab > thead > tr.info > td,.tab > tbody > tr.info > td,
        .tab > tfoot > tr.info > td,.tab > thead > tr.info > th,
        .tab > tbody > tr.info > th,.tab > tfoot > tr.info > th {background-color: #d9edf7;}
        .tab-hover > tbody > tr > td.info:hover,.tab-hover > tbody > tr > th.info:hover,
        .tab-hover > tbody > tr.info:hover > td,.tab-hover > tbody > tr:hover > .info,
        .tab-hover > tbody > tr.info:hover > th {background-color: #c4e3f3;}
        .tab > thead > tr > td.warning,.tab > tbody > tr > td.warning,
        .tab > tfoot > tr > td.warning,.tab > thead > tr > th.warning,
        .tab > tbody > tr > th.warning,.tab > tfoot > tr > th.warning,
        .tab > thead > tr.warning > td,.tab > tbody > tr.warning > td,
        .tab > tfoot > tr.warning > td,.tab > thead > tr.warning > th,
        .tab > tbody > tr.warning > th,.tab > tfoot > tr.warning > th {background-color: #fcf8e3;}
        .tab-hover > tbody > tr > td.warning:hover,.tab-hover > tbody > tr > th.warning:hover,
        .tab-hover > tbody > tr.warning:hover > td,.tab-hover > tbody > tr:hover > .warning,
        .tab-hover > tbody > tr.warning:hover > th {background-color: #faf2cc;}
        .tab > thead > tr > td.danger,.tab > tbody > tr > td.danger,
        .tab > tfoot > tr > td.danger,.tab > thead > tr > th.danger,
        .tab > tbody > tr > th.danger,.tab > tfoot > tr > th.danger,
        .tab > thead > tr.danger > td,.tab > tbody > tr.danger > td,
        .tab > tfoot > tr.danger > td,.tab > thead > tr.danger > th,
        .tab > tbody > tr.danger > th,.tab > tfoot > tr.danger > th {background-color: #f2dede;}
        .tab-hover > tbody > tr > td.danger:hover,.tab-hover > tbody > tr > th.danger:hover,
        .tab-hover > tbody > tr.danger:hover > td,.tab-hover > tbody > tr:hover > .danger,
        .tab-hover > tbody > tr.danger:hover > th {background-color: #ebcccc;}
        .tab-responsive {min-height: .01%;overflow-x: auto;}
        .tab>tfoot>tr>td {border-bottom: hidden;}
        .tab>tfoot>tr>th {border-bottom: 1px dashed black;}
    </style>

    <table class="tab">
        <tbody>
            <tr>
                <td align="center"><img width="100px" height="100px" src="<?= base_url($invoice_details->logo) ?>"></td>
            </tr>
            <tr>
                <td align="center"><b><?= $invoice_details->address ?></b></td>
            </tr>
        </tbody>
    </table>

    <table class="tab">
        <tbody>
            <tr>
                <td width="35%">
                    Order Time : <?= $invoice_details->order_date ?><br>
                    Print Time : <?= date("Y-m-d H:i:s") ?><br>
                    Vat Reg. No. : <?= $invoice_details->vat_reg ?><br>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="tab">
        <caption><b>Order Information</b></caption>
        <tbody>
            <tr>
                <td>Item Name</td>
                <td class="text-right">Rate</td>
                <td class="text-right">Qty</td>
                <td class="text-right">Disc</td>
                <td class="text-right">Price</td>
            </tr>

            <?php foreach ($sale_product_list as $product): ?>
                <tr>
                    <td><?= $product->productName ?></td>
                    <td align="right"><?= $product->unit_price ?></td>
                    <td align="right"><?= $product->quantity ?></td>
                    <td align="right"><?= $product->discount_amount ?></td>
                    <td align="right"><?= $product->sales_price_excluding_vat ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4" align="right">Order Total : </td>
                <td align="right"><?= number_format($invoice_details->gross_payable,2,'.','') ?></td>
            </tr>
            <tr>
                <td colspan="4" align="right">Vat Total : </td>
                <td align="right"><?= number_format($invoice_details->total_vat,2,'.','') ?></td>
            </tr>
            <tr>
                <td colspan="4" align="right">Discount : </td>
                <td align="right"><?= number_format($invoice_details->deduction,2,'.','') ?></td>
            </tr>
            <tr>
                <th colspan="4" style="text-align: right;">Total Amount :</th>
                <th style="text-align: right;"><?= number_format($invoice_details->amount_to_paid,2,'.','') ?></th>
            </tr>
        </tfoot>
    </table>

    <table class="tab">
        <tbody>
            <tr>
                <td>
                    Payment Type : <?= $invoice_details->mode_of_payment ?><br>
                    <?php if ($invoice_details->mode_of_payment == 'Cash'): ?>
                        Paid Amount : <?= number_format($invoice_details->paid_amount,2,'.','') ?><br>
                        Change Amount : <?= number_format($invoice_details->change_amount,2,'.','') ?>                            
                    <?php elseif ($invoice_details->mode_of_payment == 'Split'): ?>
                        Cash Amount : <?= number_format($invoice_details->cash_payment,2,'.','') ?><br>
                        Card Amount : <?= number_format($invoice_details->card_payment,2,'.','') ?>
                    <?php endif ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="tab">
        <tbody>
            <tr><td align="center"><?= $invoice_details->footer_text ?></td></tr>
        </tbody>
    </table>

    <table class="tab">
        <tbody>
            <tr><td align="center">Developed By : http://giantssoft.com</td></tr>
        </tbody>
    </table>
</div>

<style type="text/css">
    .tab { width: 250px; max-width: 250px; margin: 5px 30px 5px 30px; font-size:12px; }
    .div-scroll { overflow: scroll; width: 300px; height: 400px; margin: 0px 290px 0px 290px; }
    @media screen and (min-width: 768px) {
        .modal:before { height: auto; }
    }

    @media screen and (max-width: 768px) {
        .div-scroll { overflow: scroll; width: 300px; height: 400px; margin: 0px 140px 0px 140px; }
    }
</style>

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Invoice Details</h4>
    </div>

    <div class="modal-body text-center">
        <div class="div-scroll">
            <div class="row">
                <div class="col-md-12 text-center"><label class="col-form-label">Product Information</label></div>
            </div>

            <div class="row">
                <table class="tab">
                    <tbody>
                        <tr>
                            <td align="center"><img width="100px" height="100px" src="<?= base_url($invoice_details->logo) ?>"></td>
                        </tr>
                        <tr>
                            <td align="center"><b><?= $invoice_details->address ?></b></td>
                        </tr>
                    </tbody>
                </table>

                <table class="tab">
                    <tbody>
                        <tr>
                            <td width="35%" align="left">
                                Order Time : <?= $invoice_details->order_date ?><br>
                                Print Time : <?= date("Y-m-d H:i:s") ?><br>
                                Vat Reg. No. : <?= $invoice_details->vat_reg ?><br>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="tab">
                    <caption><b>Order Information</b></caption>
                    <tbody>
                        <tr>
                            <td class="text-left">Item Name</td>
                            <td class="text-right">Rate</td>
                            <td class="text-right">Qty</td>
                            <td class="text-right">Disc</td>
                            <td class="text-right">Price</td>
                        </tr>

                        <?php foreach ($sale_product_list as $product): ?>
                            <tr>
                                <td align="left"><?= $product->productName ?></td>
                                <td align="right"><?= $product->unit_price ?></td>
                                <td align="right"><?= $product->quantity ?></td>
                                <td align="right"><?= $product->discount_amount ?></td>
                                <td align="right"><?= $product->sales_price_excluding_vat ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4" align="right">Order Total : </td>
                            <td align="right"><?= number_format($invoice_details->gross_payable,2,'.','') ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Vat Total : </td>
                            <td align="right"><?= number_format($invoice_details->total_vat,2,'.','') ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Discount : </td>
                            <td align="right"><?= number_format($invoice_details->deduction,2,'.','') ?></td>
                        </tr>
                        <tr>
                            <th colspan="4" style="text-align: right;">Total Amount :</th>
                            <th style="text-align: right;"><?= number_format($invoice_details->amount_to_paid,2,'.','') ?></th>
                        </tr>
                    </tfoot>
                </table>

                <table class="tab">
                    <tbody>
                        <tr>
                            <td align="left">
                                Payment Type : <?= $invoice_details->mode_of_payment ?><br>
                                <?php if ($invoice_details->mode_of_payment == 'Cash'): ?>
                                    Paid Amount : <?= number_format($invoice_details->paid_amount,2,'.','') ?><br>
                                    Change Amount : <?= number_format($invoice_details->change_amount,2,'.','') ?>                            
                                <?php elseif ($invoice_details->mode_of_payment == 'Split'): ?>
                                    Cash Amount : <?= number_format($invoice_details->cash_payment,2,'.','') ?><br>
                                    Card Amount : <?= number_format($invoice_details->card_payment,2,'.','') ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="tab">
                    <tbody>
                        <tr><td align="center"><?= $invoice_details->footer_text ?></td></tr>
                    </tbody>
                </table>

                <table class="tab">
                    <tbody>
                        <tr><td align="center">Developed By : http://giantssoft.com</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <div class="buttons-div">
            <button type="button" class="btn btn-primary modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</button>
            <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
        </div>
        <div class="col-xs-1 loading-image" style="padding-top: 40px; float: right; display: none;"></div>
    </div>

</div>

 <!-- <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Invoice Details</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h6 class="text-align-center report-header-font"><strong>Invoice</strong></h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="" width="100%">
                    <tbody>
                        <tr>
                            <td width="50%"><strong>Sold To :</strong> <?= $invoice_details->client_name ?></td>
                            <td width="50%" class="text-right"><strong>Invoice :</strong> <?= $invoice_details->invoice_number ?></td>
                        </tr>
                        <tr>
                            <td width="50%"><strong>Outlet :</strong> <?= $invoice_details->branch_name ?></td>
                            <td width="50%" class="text-right"><strong>Order Date :</strong><?= date("d-m-Y", strtotime($invoice_details->order_date)) ?></td>
                        </tr>
                        <tr><td width="50%" colspan="2"><strong>Address :</strong> <?= $invoice_details->address ?></td></tr>
                        <tr>
                            <td width="50%" colspan="2"><strong>Contact :</strong> <?= $invoice_details->cell_number.', '.$invoice_details->phone_number ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 div-margin-top text-center"><label class="col-form-label">Product Information</label></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="thead-default">
                        <tr>
                            <th width="20px">SL</th>
                            <th>Product</th>
                            <th class="text-center" width="50px">QTY</th>
                            <th class="text-center" width="80px"><?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                            <th class="text-center" width="110px"><?= 'Discount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                            <th class="text-center" width="140px"><?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>

                        <?php foreach ($sale_product_list as $sale_product): ?>
                            <tr>
                                <td><?= $sl++; ?></td>
                                <td><?= ucfirst($sale_product->productName) ?></td>
                                <td align="right"><?= $sale_product->quantity ?></td>
                                <td align="right"><?= number_format((double) $sale_product->unit_price, 2) ?></td>
                                <td align="right"><?= number_format((double) $sale_product->discount_amount, 2) ?></td>
                                <td align="right"><?= number_format((double) $sale_product->sales_price_excluding_vat, 2) ?></td>
                            </tr>                            
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <td align="right"> <?= number_format((double) $invoice_details->gross_payable, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">Vat</th>
                            <td align="right"><?= number_format((double) $invoice_details->total_vat, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">Deduction</th>
                            <td align="right"><?= number_format((double) $invoice_details->deduction, 2) ?></td>
                        </tr>

                        <tr>
                            <th colspan="5" class="text-right">Grand Total Price</th>
                            <td align="right"><?= number_format((double) $invoice_details->amount_to_paid, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><label class="col-form-label left-side-view">Payment Information</label></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label left-side-view">Mode of Sale: <?= ucfirst($invoice_details->mode_of_payment) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label left-side-view">
                    <strong class="font-size-ten">AMOUNT IN WORDS : <?= strtoupper(convert_number_to_words($invoice_details_by_invoice_id->amount_to_paid) . ' ' . $currency_settings->currency_name . ' only'); ?>
                    </strong>
                </label>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <div class="buttons-div">
            <button type="button" class="btn btn-primary modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</button>
            <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
        </div>
        <div class="col-xs-1 loading-image" style="padding-top: 40px; float: right; display: none;"></div>
    </div>
</div> -->

<!--For Print-->
<script language="javascript" type="text/javascript">
    $(".modal-print-button").on("click", function () {

        var divContents = $('#modal-print-information').html();

        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

    specialNotesModal();
    function specialNotesModal() {
        $('.report-email-button').click(function (e) {
            e.preventDefault();
            $('.special-notes-modal .special_notes').val('');
            $('.special-notes-modal .special_notes').css('border-color', '');
            $('.send-button-modal').prop("disabled", false);
            $('.special-notes-modal .modal-content .overlay').fadeIn();
            var invoiceDetailsId = 0;
            invoiceDetailsId = $(this).data('id');
            invoiceDetailsId = isNaN(invoiceDetailsId) ? 0 : invoiceDetailsId;
            $('.special-notes-modal .send-button-modal').attr('data-id', invoiceDetailsId);
            $('.special-notes-modal').modal('show');
        });
    }
</script>


