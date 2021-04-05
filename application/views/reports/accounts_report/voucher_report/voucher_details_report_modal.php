<div class="modal-content">
    <?php
    $company_information;
    $voucher_details_information_by_voucher_posting_details_id;
    $voucher_details_information_by_voucher_posting_details_id_row;
    /* echo '<pre>';
      print_r($voucher_details_information_by_voucher_posting_details_id);
      echo '</pre>';
      die(); */
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Voucher Details</h4>
    </div>

    <div class="modal-body">

        <div class="col-xs-12">

            <div class="text-align-center">
                <h3><?= strtoupper($company_information->company_name_1) ?></h3>
            </div>
            <div class="text-align-center">
                <h4>Cash/Bank Payment & Received voucher</h4>
            </div>

            <div class="col-xs-12">
                <h4>Voucher
                    No:<?= $voucher_details_information_by_voucher_posting_details_id_row->voucher_number ?></h4>
            </div>

            <div class="col-xs-12">

                <table border="1px" cellspacing="0" class="table table-responsive modal-table-border">
                    <thead class="thead-inverse">
                        <tr class="text-align-center">
                            <th>Date</th>
                            <th>Particular</th>
                            <th>DR</th>
                            <th>CR</th>
                        </tr>
                    </thead>
                    <?php
                    $count = 1;

                    if (!empty($voucher_details_information_by_voucher_posting_details_id)) {
                        usort($voucher_details_information_by_voucher_posting_details_id, function ($a, $b) {
                            return $a->income_head_id - $b->income_head_id;
                        });
                        foreach ($voucher_details_information_by_voucher_posting_details_id as $voucher) {
                            ?>
                            <tr>
                                <?php $voucher_posting_date = date("d-m-Y", strtotime($voucher_details_information_by_voucher_posting_details_id_row->posting_date)); ?>

                                <?php if ($count == 1) { ?>
                                    <td class="td-width-small">
                                        <?=
                                        $voucher_posting_date;
                                        $count++;
                                        ?>
                                    </td>
                                <?php } else { ?>
                                    <td class="td-width-small"></td>
                                <?php } ?>

                                <?php if (!empty($voucher->expense_head_id) && ((int) ($voucher->expense_head_id) > 0)) { ?>
                                    <?php $head_information = $this->Head_details_Model->get_head_details($voucher->expense_head_id);
                                    ?>
                                    <td class="td-width-medium" style="text-align: left">
                                        By <?= $head_information->head_name ?>
                                        <?php
                                        if ((!empty($voucher->mr_number)) || (!empty($voucher->invoice_number))) {
                                            if ((empty($voucher->mr_number)) && (!empty($voucher->invoice_number))) {
                                                echo '(' . 'Invoice - ' . $voucher->invoice_number . ')';
                                            } elseif ((!empty($voucher->mr_number)) && (empty($voucher->invoice_number))) {
                                                echo '(MR. - ' . $voucher->mr_number . ')';
                                            } else {
                                                echo '(MR. - ' . $voucher->mr_number . ' , ' . 'Invoice - ' . $voucher->invoice_number . ')';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="td-width-small"
                                        style="text-align: right"><?= number_format((double) $voucher->debit_amount, 2) ?></td>
                                    <td class="td-width-small" style="text-align: right"></td>
                                <?php } else { ?>
                                    <td class="td-width-medium" style="text-align: right">
                                        <?php if (!empty($voucher->income_head_id) && ((int) ($voucher->income_head_id) > 0)) { ?>
                                            <?php $head_information = $this->Head_details_Model->get_head_details($voucher->income_head_id); ?>
                                            To <?= $head_information->head_name ?>
                                            <?php
                                            if ((!empty($voucher->mr_number)) || (!empty($voucher->invoice_number))) {
                                                if ((empty($voucher->mr_number)) && (!empty($voucher->invoice_number))) {
                                                    echo '(' . 'Invoice - ' . $voucher->invoice_number . ')';
                                                } elseif ((!empty($voucher->mr_number)) && (empty($voucher->invoice_number))) {
                                                    echo '(MR. - ' . $voucher->mr_number . ')';
                                                } else {
                                                    echo '(MR. - ' . $voucher->mr_number . ' , ' . 'Invoice - ' . $voucher->invoice_number . ')';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="td-width-small" style="text-align: right"></td>
                                        <td class="td-width-small"
                                            style="text-align: right"><?= number_format((double) $voucher->credit_amount, 2) ?></td>
                                            <?php
                                        }
                                    }
                                    ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tbody>
                        <tr>
                            <td class="td-width-small"></td>
                            <td class="td-width-medium" style="text-align: center; font-weight: bold">Total</td>
                            <td class="td-width-small"
                                style="text-align: right"><?= number_format((double) $voucher_details_information_by_voucher_posting_details_id_row->total_debit_amount, 2) ?></td>
                            <td class="td-width-small"
                                style="text-align: right"><?= number_format((double) $voucher_details_information_by_voucher_posting_details_id_row->total_credit_amount, 2) ?></td>
                        </tr>
                        <tr>
                            <td class="td-width-small"></td>
                            <td class="td-width-medium" style="text-align: left">
                                <strong>
                                    IN WORDS:
                                    <?= strtoupper(convert_number_to_words($voucher_details_information_by_voucher_posting_details_id_row->total_credit_amount) . ' ' . $currency_settings->currency_name . ' only'); ?>
                                </strong>
                            </td>
                            <td class="td-width-small"></td>
                            <td class="td-width-small"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-xs-12">
                <strong>Narration
                    :</strong> <?= $voucher_details_information_by_voucher_posting_details_id_row->common_narration; ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->


<div style="display: none">

    <div id="print-information">

        <div style="width: 100%">
            <div>
                <h2 style="text-align: center;"><?= strtoupper($company_information->company_name_1) ?></h2>
            </div>

            <div>
                <h4 style="text-align: center;">Cash/Bank Payment & Received voucher</h4>
            </div>

            <div>
                <h4 style="text-align: left;padding-left: 10px">Voucher No:
                    <?= $voucher_details_information_by_voucher_posting_details_id_row->voucher_number ?>
                </h4>
            </div>

            <div style="width: 100%; padding: 10px">

                <table class="table" border="2px" cellspacing="0" width="100%">
                    <thead class="thead-inverse">
                        <tr>
                            <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">
                                Date
                            </th>
                            <th style="text-align: center;  font-weight: bold; background-color: black; color: white; font-size: 20px">
                                Particular
                            </th>
                            <th style="text-align: center;  font-weight: bold; background-color: black; color: white; font-size: 20px">
                                DR
                            </th>
                            <th style="text-align: center;  font-weight: bold; background-color: black; color: white; font-size: 20px">
                                CR
                            </th>
                        </tr>
                    </thead>
                    <?php
                    $count = 1;

                    if (!empty($voucher_details_information_by_voucher_posting_details_id)) {
                        usort($voucher_details_information_by_voucher_posting_details_id, function ($a, $b) {
                            return $a->income_head_id - $b->income_head_id;
                        });
                        foreach ($voucher_details_information_by_voucher_posting_details_id as $voucher) {
                            ?>
                            <tr style="border: thick">
                                <?php if ($count == 1) { ?>
                                    <td width="10%">
                                        <?=
                                        $voucher_posting_date;
                                        $count++;
                                        ?>
                                    </td>
                                <?php } else { ?>
                                    <td width="10%"></td>
                                <?php } ?>

                                <?php if (!empty($voucher->expense_head_id) && ((int) ($voucher->expense_head_id) > 0)) { ?>
                                    <?php $head_information = $this->Head_details_Model->get_head_details($voucher->expense_head_id);
                                    ?>
                                    <td width="60%" style="text-align: left">
                                        By <?= $head_information->head_name ?>
                                        <?php
                                        if ((!empty($voucher->mr_number)) || (!empty($voucher->invoice_number))) {
                                            if ((empty($voucher->mr_number)) && (!empty($voucher->invoice_number))) {
                                                echo '(' . 'Invoice - ' . $voucher->invoice_number . ')';
                                            } elseif ((!empty($voucher->mr_number)) && (empty($voucher->invoice_number))) {
                                                echo '(MR. - ' . $voucher->mr_number . ')';
                                            } else {
                                                echo '(MR. - ' . $voucher->mr_number . ' , ' . 'Invoice - ' . $voucher->invoice_number . ')';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td width="15%"
                                        style="text-align: right"><?= number_format((double) $voucher->debit_amount, 2) ?></td>
                                    <td width="15%" style="text-align: right"></td>
                                <?php } else { ?>
                                    <td width="60%" style="text-align: right">
                                        <?php if (!empty($voucher->income_head_id) && ((int) ($voucher->income_head_id) > 0)) { ?>
                                            <?php $head_information = $this->Head_details_Model->get_head_details($voucher->income_head_id); ?>
                                            To <?= $head_information->head_name ?>
                                            <?php
                                            if ((!empty($voucher->mr_number)) || (!empty($voucher->invoice_number))) {
                                                if ((empty($voucher->mr_number)) && (!empty($voucher->invoice_number))) {
                                                    echo '(' . 'Invoice - ' . $voucher->invoice_number . ')';
                                                } elseif ((!empty($voucher->mr_number)) && (empty($voucher->invoice_number))) {
                                                    echo '(MR. - ' . $voucher->mr_number . ')';
                                                } else {
                                                    echo '(MR. - ' . $voucher->mr_number . ' , ' . 'Invoice - ' . $voucher->invoice_number . ')';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td width="15%" style="text-align: right"></td>
                                        <td width="15%"
                                            style="text-align: right"><?= number_format((double) $voucher->credit_amount, 2) ?></td>
                                            <?php
                                        }
                                    }
                                    ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tbody>
                        <tr style="border: thick">
                            <td width="10%"></td>
                            <td width="60%" style="text-align: center; font-weight: bold">Total</td>
                            <td width="15%"
                                style="text-align: right; font-weight: bold"><?= number_format((double) $voucher_details_information_by_voucher_posting_details_id_row->total_debit_amount, 2) ?></td>
                            <td width="15%"
                                style="text-align: right; font-weight: bold"><?= number_format((double) $voucher_details_information_by_voucher_posting_details_id_row->total_credit_amount, 2) ?></td>
                        </tr>
                        <!-- <tr>
                            <td width="10%"></td>
                            <td width="60%" style="text-align: left">
                                <strong>
                                    IN WORDS:
                                    <? /*= strtoupper(convert_number_to_words((double)($voucher_details_information_by_voucher_posting_details_id_row->total_debit_amount)) . ' taka only'); */ ?>
                                </strong>
                            </td>
                            <td width="15%"></td>
                            <td width="15%"></td>
                        </tr>-->
                    </tbody>
                </table>
                <strong style="border: 0px solid black; margin-top: 5px; padding-top: 5px">
                    IN WORDS:
                    <?= strtoupper(convert_number_to_words((double) ($voucher_details_information_by_voucher_posting_details_id_row->total_debit_amount)) . ' ' . $currency_settings->currency_name . ' only'); ?>
                </strong>
            </div>

            <div style="width: 100%">
                <div style="padding: 10px">
                    <strong
                        style="font-weight: bold;">Narration:</strong> <?= $voucher_details_information_by_voucher_posting_details_id_row->common_narration; ?>
                </div>
            </div>

            <div style="width: 100%;">

                <table width="100%" border="0">
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Received By
                        </td>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Accounts
                        </td>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Director
                        </td>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Managing Director
                        </td>
                    </tr>

                </table>

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


