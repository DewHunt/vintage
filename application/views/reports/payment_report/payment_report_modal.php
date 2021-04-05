<div class="modal-content">
    <?php
    $payment_list;
    $payment_report_by_payment_id;
    /* echo '<pre>';
      print_r($payment_report_by_payment_id);
      echo '</pre>'; */
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Money Receipt Report</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">
            <h4 class="text-align-center"><?= strtoupper($company_information->company_name_1) ?></h4>
            <h6 class="text-align-center"><?= $company_information->company_address_1 ?></h6>
<!--            <table width="100%">
<tr>
<td class="left-side-view">
<h4 class="text-align-center"><?= strtoupper($company_information->company_name_1) ?></h4>
<br>
<h6 class="text-align-center"><?= $company_information->company_address_1 ?></h6>
</td>
<td class="right-side-view">
<button type="button" class="btn btn-primary money-receipt-button"><i class="fa fa-print"
                                                          aria-hidden="true"></i>
Money Receipt
</button>
</td>
</tr>
</table>-->

            <!--<div class="col-xs-12">
                <label class="col-form-label left-side-view">Payment Report</label>
            </div>-->

            <div class="card col-xs-12">

                <div class="col-xs-5 modal-card-payment-info">
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <!--<th>Receipt(MR) No</th>-->
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Receipt(MR) No</td>
                                <td><?= $payment_report_by_payment_id->receipt_mr_no ?></td>
                            </tr>

                            <tr>
                                <td>Receipt Date</td>
                                <?php
                                $receipt_date = date("d-m-Y", strtotime($payment_report_by_payment_id->receipt_date));
                                ?>
                                <td><?= $receipt_date ?></td>
                            </tr>

                            <tr>
                                <td>Rcvd From(Party)</td>
                                <td><?= $payment_report_by_payment_id->client_name ?></td>
                            </tr>

                            <tr>
                                <td>Party Code</td>
                                <td><?= $payment_report_by_payment_id->client_code ?></td>
                            </tr>

                            <tr>
                                <td>Amount Received</td>
                                <td><?= number_format((double) $payment_report_by_payment_id->amount_received, 2) ?></td>
                            </tr>


                        </tbody>
                    </table>
                </div>


                <div class="col-xs-5 modal-card-payment-info">
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <!--<th>Receipt(MR) No</th>-->
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Mode of Payment</td>
                                <?php if ((string) $payment_report_by_payment_id->payment_type == 'tt') { ?>
                                    <td><?= strtoupper($payment_report_by_payment_id->payment_type) ?></td>
                                <?php } else { ?>
                                    <td><?= ucfirst($payment_report_by_payment_id->payment_type) ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td>Cheque No</td>
                                <td><?= $payment_report_by_payment_id->cheque_number ?></td>
                            </tr>

                            <tr>
                                <td>Cheque Date</td>
                                <?php $cheque_date = date("d-m-Y", strtotime($payment_report_by_payment_id->cheque_date)); ?>
                                <td><?= $cheque_date ?></td>
                            </tr>

                            <tr>
                                <td>Bank Name</td>
                                <td><?= $payment_report_by_payment_id->bank_name ?></td>
                            </tr>

                            <tr>
                                <td>Branch Name</td>
                                <td><?= $payment_report_by_payment_id->branch_name ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="col-xs-10 card-block modal-card">
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <!--<th>Receipt(MR) No</th>-->
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Invoice No</td>
                                <td><?= $payment_report_by_payment_id->invoice_number ?></td>
                            </tr>

                            <tr>
                                <td>Purpose</td>
                                <td><?= $payment_report_by_payment_id->purpose ?></td>
                            </tr>

                            <tr>
                                <td>Remarks/Cheque#</td>
                                <td><?= $payment_report_by_payment_id->remarks ?></td>
                            </tr>
                            <tr>
                                <td>Outlet(MR) No</td>
                                <td><?= !empty($payment_report_by_payment_id->branch_mr_no) ? $payment_report_by_payment_id->branch_mr_no : ''; ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
<!--        <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>-->
        <button style="padding: 12px 20px 12px 20px; float: right; margin-left: 1%" type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary money-receipt-button"><i class="fa fa-print" aria-hidden="true"></i> Money Receipt</button>

    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">

    <div class="form-group col-xs-12">

        <div class="col-xs-6">
            <h4 style="text-align: center" class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
            <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>
            <h6 style="text-align: left" class="left-side-view"><strong>Money Receipt Report</strong></h6>
        </div>

        <!--<div class="col-xs-12">
            <label class="col-form-label left-side-view">Money Receipt Report</label>
        </div>-->

        <div class="card col-xs-12" style="">
            <div class="col-xs-5" style="border: 2px solid black; width: 45%; display: inline-block;">
                <table class="table" style="width: 100%">
                    <thead class="thead-default">
                        <tr style="color: white">
                            <th>Receipt(MR) No</th>
                        </tr>
                        <tr style="color: white">
                            <th>Receipt(MR) No</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Receipt(MR) No</td>
                            <td style="border-bottom: 1px solid #ddd; "><?= $payment_report_by_payment_id->receipt_mr_no ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Receipt Date</td>
                            <?php
                            $receipt_date = date("d-m-Y", strtotime($payment_report_by_payment_id->receipt_date));
                            ?>
                            <td style="border-bottom: 1px solid #ddd;"><?= $receipt_date ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Rcvd From(Party)</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->client_name ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Party Code</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->client_code ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Amount Received</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= number_format((double) $payment_report_by_payment_id->amount_received, 2) ?></td>
                        </tr>


                    </tbody>
                </table>
            </div>


            <div class="col-xs-5" style="border: 2px solid black; width: 45%;display: inline-block;">
                <table class="table" style="width: 100%">
                    <thead class="thead-default">
                        <tr>
                            <!--<th>Receipt(MR) No</th>-->
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Mode of Sale</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= ucfirst($payment_report_by_payment_id->payment_type) ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Cheque No</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->cheque_number ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Cheque Date</td>
                            <?php
                            $cheque_date = date("d-m-Y", strtotime($payment_report_by_payment_id->cheque_date));
                            ?>
                            <td style="border-bottom: 1px solid #ddd;"><?= $cheque_date ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Bank Name</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->bank_name ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Branch Name</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->branch_name ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="col-xs-10 modal-card card-block"
                 style="border: 2px solid black; margin: 0px; padding: 10px; width: 88%">
                <table class="table" style="width: 100%">
                    <thead class="thead-default">
                        <tr>
                            <!--<th>Receipt(MR) No</th>-->
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Invoice No</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->invoice_number ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Purpose</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->purpose ?></td>
                        </tr>

                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Remarks/Cheque#</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= $payment_report_by_payment_id->remarks ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #ddd;">Outlet(MR) No</td>
                            <td style="border-bottom: 1px solid #ddd;"><?= !empty($payment_report_by_payment_id->branch_mr_no) ? $payment_report_by_payment_id->branch_mr_no : ''; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<div id="money-receipt-print-information" class="col-xs-12 color-print" style="display: none; width: 100%;">
    <!--    <div class="col-xs-12" style="width: 100%;">
            <table width="100%" border="0px" cellspacing="0" style="background-color: lightgray">
                <tr>
                    <td width="10%" style="text-align: left; padding-left: 1%">Logo</td>
                    <td width="10%" style="text-align: left; padding-left: 1%">
                        <img class="logo-size" src="<?= base_url('assets/img/logo.png') ?>" alt="Logo"
                             style="width:100px; height:70px;">
                    </td>
                    <td width="80%" style="text-align: center">
                        <div style="width: 100%"><strong><?= strtoupper($company_information->company_name_1) ?></strong>
                        </div>
                        <div style="width: 100%">Marketers of Petroleum Products</div>
                        <div style="width: 100%"><?= $company_information->company_address_1 ?></div>
                        <div style="width: 100%">Tel: <?= $company_information->phone ?>, <?= $company_information->phone ?>
                            , Fax: <?= $company_information->fax ?></div>
                    </td>
                    <td width="10%" style="text-align: right;padding-right: 1%">Logo</td>
                    <td width="10%" style="text-align: right;padding-right: 1%">
                        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width:100px; height:70px;">
                    </td>
                </tr>
            </table>
        </div>-->

    <div style="text-align: center; margin-top: 40%; font-size: 20px;"><strong></strong></div>

    <div class="col-xs-12" style="width: 100%">
        <table width="100%" border="0px" cellspacing="0"
               style="background-color: lightgray; margin-top: 2%">
            <tr>
                <td width="100%" style="text-align: center;">
                    <!--<div style="transform: skew(-20deg);">-->
                    <div style="">
                        <strong style="font-weight: bold; color: #ffffff; background-color: #000000; padding: 2px; border: 3px solid white">MONEY RECEIPT</strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="col-xs-12" style="width: 100%;">
        <table width="100%" border="0px" cellspacing="0" style="margin-top: 4%;">
            <tr>
                <td width="100%">
                    <?php
                    $str1 = 'Received with thanks a sum of Tk ';
                    $str2 = !empty($payment_report_by_payment_id->amount_received) ? number_format((double) ($payment_report_by_payment_id->amount_received), 2) : '';
                    $str3 = 'Dated ';
                    $receipt_date = date("d-m-Y", strtotime($payment_report_by_payment_id->receipt_date));
                    $str4 = !empty($receipt_date) ? $receipt_date : '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 40%">' . '&nbsp;&nbsp;' . $str2 . '</div>';
                    echo '<div style="float:left; ">' . $str3 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 20%">' . '&nbsp;&nbsp;' . $str4 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 0px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>

                    <?php
                    $str1 = 'In words Taka ';
                    $str2 = !empty($payment_report_by_payment_id->amount_received) ? ucwords(convert_number_to_words($payment_report_by_payment_id->amount_received)) . ' ' . $currency_settings->currency_name . ' only' : '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 83%">' . '&nbsp;&nbsp;' . ($str2) . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 0px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>

                    <?php
                    $str1 = '';
                    $str2 = !empty($payment_report_by_payment_id->branch_name) ? ucfirst($payment_report_by_payment_id->branch_name) : '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 0px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>

                    <?php
                    $str1 = 'by Cash/Cheque/DD/PO/TT No. ';
                    $str2 = !empty($payment_report_by_payment_id->bank_name) ? ucfirst($payment_report_by_payment_id->bank_name) : '';
                    $str3 = 'Dated ';
                    $cheque_date = date("d-m-Y", strtotime($payment_report_by_payment_id->cheque_date));
                    $str4 = !empty($cheque_date) ? $cheque_date : '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 45%">' . '&nbsp;&nbsp;' . $str2 . '</div>';
                    echo '<div style="float:left; ">' . $str3 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 16%">' . '&nbsp;&nbsp;' . $str4 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 0px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>

                    <?php
                    $str1 = 'From M/S ';
                    $str2 = !empty($payment_report_by_payment_id->client_name) ? ucfirst($payment_report_by_payment_id->client_name) : '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 86%">' . '&nbsp;&nbsp;' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 0px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = !empty($payment_report_by_payment_id->client_address) ? ucfirst($payment_report_by_payment_id->client_address) : '';
                    //$str2 = 'West Ganeshpur, Bus terminal, Rangpur';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = '';
                    $str2 = '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 0px dotted; float:left; padding-left: 1%; width: 95%">' . $str2 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <?php
                    $str1 = 'Against Invoice No ';
                    $str2 = !empty($payment_report_by_payment_id->invoice_number) ? $payment_report_by_payment_id->invoice_number : '';
                    $str3 = 'Dated ';
                    $receipt_date = date("d-m-Y", strtotime($payment_report_by_payment_id->receipt_date));
                    $str4 = !empty($receipt_date) ? $receipt_date : '';
                    echo '<div style ="float:left; padding-left: 1%">' . $str1 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 50%">' . '&nbsp;&nbsp;' . $str2 . '</div>';
                    echo '<div style="float:left; ">' . $str3 . '</div>';
                    echo '<div style="border-bottom: 1px dotted; float:left; width: 22%">' . '&nbsp;&nbsp;' . $str4 . '</div>';
                    ?>
                    <?php echo '<br>' ?>
                    <div style="float: left; width: 100%; font-weight: bold; padding-top: 10%">MR
                        No: <?= !empty($payment_report_by_payment_id->receipt_mr_no) ? $payment_report_by_payment_id->receipt_mr_no : '' ?></div>
                    <div style="float: left; width: 100%; font-weight: bold; padding-top: 2%">Outlet MR
                        No: <?= !empty($payment_report_by_payment_id->branch_mr_no) ? $payment_report_by_payment_id->branch_mr_no : ''; ?></div>

                    <p style="float: right; padding-right: 1%; margin-top: 5%">
                        <a style="border-top: inset;">Authorized Signature</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".money-receipt-button").on("click", function () {
        var divContents = $('#money-receipt-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

//    $(".money-receipt-button").on("click", function () {
//        var divContents = $('#money-receipt-print-information').html();
//        var printWindow = window.open();
//        printWindow.document.write(divContents);
//        printWindow.document.close();
//        setTimeout(function () {
//            printWindow.document.close();
//            printWindow.print();
//            printWindow.close();
//        }, 1);
//    });

    $('.modal-close-button').click(function () {
        $('.modal').modal('hide');
    });
</script>


