<div class="modal-content">

    <?php
    $gate_pass_report_by_invoice_id;
    $gate_pass_report_view;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

//    echo '<pre>';
//    print_r($gate_pass_report_by_invoice_id->order_number);
//    echo '</pre>';
//    die();
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Gate Pass Report Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <!--            <div class="col-xs-12">
                            <h4 class="text-align-center"><?= strtoupper($company_information->company_name_1) ?></h4>
                            <h6 class="text-align-center"><?= $company_information->company_address_1 ?></h6>
                            <h6 class="text-align-center">Ware House/Office...................Dhaka</h6>
                        </div>-->

            <div class="col-xs-12">
                <h6 class="text-align-center report-header-font"><strong>GATE PASS</strong></h6>
            </div>

            <table class="" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="left-side-view"></td>
                        <td class="right-side-view">EC: <?= !empty($gate_pass_report_by_invoice_id->employee_code) ? $gate_pass_report_by_invoice_id->employee_code : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view"></td>
                        <td class="right-side-view">DC: <?= !empty($gate_pass_report_by_invoice_id->dealer_code) ? $gate_pass_report_by_invoice_id->dealer_code : '' ?> </td>
                    </tr>
                    <tr>
                        <td class="left-side-view" style="text-align: left"><strong>Invoice No: <?= $gate_pass_report_by_invoice_id->invoice_number ?></strong></td>
                        <td class="right-side-view" style="text-align: right">Order No:<?= !empty($gate_pass_report_by_invoice_id->order_number) ? $gate_pass_report_by_invoice_id->order_number : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view" style="text-align: left"><strong>Challan No: <?= $gate_pass_report_by_invoice_id->challan_number ?></strong></td>
                        <?php
                        $order_date = '';
                        $order_date = date("d-m-Y", strtotime($gate_pass_report_by_invoice_id->order_date));
                        if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                            $order_date = '';
                        }
                        ?>
                        <td class="right-side-view" style="text-align: right">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view" style="text-align: left">Source: <?= $gate_pass_report_by_invoice_id->source ?></td>
                        <?php
                        $date_of_issue = date("d-m-Y", strtotime($gate_pass_report_by_invoice_id->date_of_issue));
                        ?>
                        <td class="right-side-view" style="text-align: right">Date Of Issue: <?= $date_of_issue ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="col-xs-12">

                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Pack Size</th>
                            <th>Quantity</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 1;
                        foreach ($gate_pass_report_view as $gate_pass_report):
                            ?>
                            <?php
                            $product_name_part_1 = '';
                            $product_name_part_2 = '';
                            if (strpos(($gate_pass_report->product_name), '#') !== FALSE) {
                                $product_name = explode("#", ($gate_pass_report->product_name));
                                $product_name_part_1 = $product_name[0];
                                $product_name_part_2 = $product_name[1];
                            } else {
                                $product_name_part_1 = $gate_pass_report->product_name;
                            }
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= ucfirst($product_name_part_1) ?></td>
                                <td><?= $gate_pass_report->pack_size ?></td>
                                <td><?= $gate_pass_report->quantity ?></td>
                                <td><?= $gate_pass_report->gate_pass_remarks ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <button type="button" class="btn btn-primary print-button">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Print
                </button>
                <?php
            }
        }
        ?>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">
            Close
        </button>
    </div>

</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">
    <div class="col-xs-12" style="width: 100%;">
        <table width="100%" border="0px" cellspacing="0" style="background-color: lightgray">
            <tr>
                <!--<td width="10%" style="text-align: left; padding-left: 1%">Logo</td>-->
                <td width="10%" style="text-align: left; padding-left: 1%">
<!--                    <img class="logo-size" src="<?= base_url('assets/img/logo.png') ?>" alt="Logo"
                         style="width:100px; height:70px;">-->
                </td>
                <td width="80%" style="text-align: center">
                    <div style="width: 100%"><strong><?= strtoupper($company_information->company_name_1) ?></strong>
                    </div>
                    <div style="width: 100%">Marketers of Petroleum Products</div>
                    <div style="width: 100%"><?= $company_information->company_address_1 ?></div>
                    <div style="width: 100%">Tel: <?= $company_information->phone ?>, Mob: <?= $company_information->mobile ?>, Fax: <?= $company_information->fax ?></div>
                </td>
                <!--<td width="10%" style="text-align: right;padding-right: 1%">Logo</td>-->
                <td width="10%" style="text-align: right;padding-right: 1%">
                    <!--<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width:100px; height:70px;">-->
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; font-size: 20px; margin-top: 5px;"><strong>GATE PASS</strong></div>
    <div style="text-align: center; margin-top: 5px;">Delivered From</div>
    <div style="text-align: center; margin-top: 5px;">...........................</div>

    <table class="" width="100%">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left-side-view" style="text-align: left"></td>
                <td class="right-side-view" style="text-align: right">EC: <?= !empty($gate_pass_report_by_invoice_id->employee_code) ? $gate_pass_report_by_invoice_id->employee_code : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left"></td>
                <td class="right-side-view" style="text-align: right">DC: <?= !empty($gate_pass_report_by_invoice_id->dealer_code) ? $gate_pass_report_by_invoice_id->dealer_code : '' ?> </td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left"><strong>Invoice No: <?= $gate_pass_report_by_invoice_id->invoice_number ?></strong></td>
                <td class="right-side-view" style="text-align: right">Order No:<?= !empty($gate_pass_report_by_invoice_id->order_number) ? $gate_pass_report_by_invoice_id->order_number : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left"><strong>Challan No: <?= $gate_pass_report_by_invoice_id->challan_number ?></strong></td>
                <?php
                $order_date = '';
                $order_date = date("d-m-Y", strtotime($gate_pass_report_by_invoice_id->order_date));
                if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                    $order_date = '';
                }
                ?>
                <td class="right-side-view" style="text-align: right">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left">Source: <?= $gate_pass_report_by_invoice_id->source ?></td>
                <?php
                $date_of_issue = date("d-m-Y", strtotime($gate_pass_report_by_invoice_id->date_of_issue));
                ?>
                <td class="right-side-view" style="text-align: right">Date of Issue: <?= $date_of_issue ?></td>
            </tr>
        </tbody>
    </table>

    <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">

        <table class="table" style="border: 1px solid white; width: 100%">
            <thead class="thead-default">
                <tr>
                    <th style="border-bottom: 1px solid #ddd;">SL</th>
                    <th style="border-bottom: 1px solid #ddd;">Product</th>
                    <th style="border-bottom: 1px solid #ddd;">Pack Size</th>
                    <th style="border-bottom: 1px solid #ddd;">Quantity</th>
                    <th style="border-bottom: 1px solid #ddd;">Remarks</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count = 1;
                foreach ($gate_pass_report_view as $gate_pass_report):
                    ?>
                    <?php
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    if (strpos(($gate_pass_report->product_name), '#') !== FALSE) {
                        $product_name = explode("#", ($gate_pass_report->product_name));
                        $product_name_part_1 = $product_name[0];
                        $product_name_part_2 = $product_name[1];
                    } else {
                        $product_name_part_1 = $gate_pass_report->product_name;
                    }
                    ?>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: left"><?= ucfirst($product_name_part_1) ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $gate_pass_report->pack_size ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $gate_pass_report->quantity ?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $gate_pass_report->gate_pass_remarks ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                    <td style="padding-bottom: 20px"></td>
                </tr>
            <hr>

            </tbody>
        </table>

    </div>
    <hr>

    <div style="width: 100%; margin-bottom: 70px;">

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
                <td style="text-align: left; width: 30%">
                    <p style="">
                        <a style="border-top: inset;">Store In-Charge</a>
                    </p>
                </td>
                <td style="text-align: center; width: 30%">
                    <p style="">
                        <a style="border-top: inset;">Security Guard</a>
                    </p>
                </td>
                <td style="text-align: center; width: 40%">
                    <p style="">
                        <a style="border-top: inset;">Delivery In-Charge</a>
                    </p>
                </td>
            </tr>

        </table>

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


