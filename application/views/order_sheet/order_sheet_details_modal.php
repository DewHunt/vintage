<div class="modal-content">
    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

    /* echo '<pre>';
      echo print_r($sale_product_list);
      echo '</pre>'; */
    //die();
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Order Sheet Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <div class="col-xs-12">
                <h5 class="text-align-center report-header-font"><strong>ORDER SHEET</strong></h5>
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
                        <td class="left-side-view">Order Issue Received Time: <?= strtoupper((string) get_string_to_time_fromat($order_sheet->issue_time)) ?></td>
                        <td class="right-side-view">Issue Date:<?= get_string_to_date_fromat($order_sheet->issue_date) ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view">Client Name: <?= !empty($client_information->client_name) ? ucfirst($client_information->client_name) : '' ?></td>
                        <td class="right-side-view">Client Code:<?= !empty($client_information->client_code) ? ucfirst($client_information->client_code) : '' ?></td>
                    </tr>
                    <tr>
                        <?php
                        $contact_number = '';
                        $client_cell_number = !empty($client_information->cell_number) ? $client_information->cell_number : '';
                        $client_phone_number = !empty($client_information->phone_number) ? $client_information->phone_number : '';
                        if ((empty($client_cell_number)) && (!empty($client_phone_number))) {
                            $contact_number = $client_phone_number;
                        } else {
                            $contact_number = $client_cell_number;
                        }
                        ?>
                        <td class="left-side-view">Client Cell No.: <?= !empty($contact_number) ? $contact_number : '' ?></td>
                        <td class="right-side-view">Dealer Code:<?= (!empty($dealer_information) || $dealer_information != NULL) ? $dealer_information->dealer_code : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view">Delivery Address: <?= !empty($order_sheet->delivery_address) ? ucfirst($order_sheet->delivery_address) : '' ?></td>
                        <td class="right-side-view">Emp. Code:<?= (!empty($employee_information) || $employee_information != NULL) ? $employee_information->employee_code : '' ?></td>
                    </tr>
                    <tr>
                        <?php
                        $delivery_date = '';
                        $delivery_date = !empty($order_sheet->delivery_date) ? get_string_to_date_fromat($order_sheet->delivery_date) : '';
                        if (($delivery_date == NULL) || ($delivery_date == '01-01-1970')) {
                            $delivery_date = '';
                        }

                        $work_order_date = '';
                        $work_order_date = !empty($order_sheet->work_order_date) ? get_string_to_date_fromat($order_sheet->work_order_date) : '';
                        if (($work_order_date == NULL) || ($work_order_date == '01-01-1970')) {
                            $work_order_date = '';
                        }
                        ?>
                        <td class="left-side-view">Delivery Date: <?= !empty($delivery_date) ? $delivery_date : '' ?></td>
                        <td class="right-side-view">W/O No:<?= !empty($order_sheet->delivery_address) ? ucfirst($order_sheet->work_order_number) : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view"></td>
                        <td class="right-side-view">W/O Date:<?= !empty($work_order_date) ? $work_order_date : '' ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="col-xs-12">
                <p class="text-align-center report-header-font"><strong style="border: 2px solid black; font-size: 16px">ORDER DESCRIPTION</strong></p>
            </div>

            <div class="col-xs-12">

                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Pack Size</th>
                            <th class="text-align-center"><?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                            <th>Quantity</th>
                            <th class="text-align-center"><?= 'Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $total = 0;
                        foreach ($order_sheet_details_by_order_sheet_id as $order):
                            ?>
                            <?php $total += (double) $order->amount; ?>
                            <?php
                            $product_name_part_1 = '';
                            $product_name_part_2 = '';
                            $product = $this->Product_Model->get_product($order->product_id);
                            if (strpos(($product->product_name), '#') !== false) {
                                $product_name = explode("#", ($product->product_name));
                                $product_name_part_1 = $product_name[0];
                                $product_name_part_2 = $product_name[1];
                            } else {
                                $product_name_part_1 = $product->product_name;
                            }
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= ucfirst($product_name_part_1) ?></td>
                                <td><?= $product->pack_size ?></td>
                                <td><?= $order->quantity ?></td>
                                <td><?= number_format((double) $order->unit_price, 2) ?></td>
                                <td><?= number_format((double) $order->amount, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
<!--                        <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Total</td>
        <td><?= number_format($total, 2) ?></td>
    </tr>-->
                        <tr>
                            <td></td>
                            <td><strong>Add : Freight Charge</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong><?= number_format($order_sheet->freight_charge, 2) ?></strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Less : Discount</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong><?= number_format($order_sheet->discount, 2) ?></strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Less : Bonus</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong><?= number_format($order_sheet->bonus, 2) ?></strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>TOTAL</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong><?= number_format($order_sheet->total, 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <strong>REMARKS</strong>
                    <div><?= !empty($order_sheet->remarks) ? $order_sheet->remarks : '' ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <button type="button" class="btn btn-primary order-sheet-details-modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>
                    Print
                </button>
                <?php
            }
        }
        ?>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="order-sheet-details-modal-print-information" style="display: none">

    <!--<div class="col-xs-12">
        <h4 style="text-align: center"><? /*= strtoupper($company_information->company_name_1) */ ?></h4>
        <h6 style="text-align: center"><? /*= $company_information->company_address_1 */ ?></h6>
    </div>-->

    <div style="text-align: center; margin-top: 85px; font-size: 20px;"><strong>ORDER SHEET</strong></div>

    <table class="" width="100%" style="width: 100%">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left-side-view" style="text-align: left">Order Issue Received Time: <?= strtoupper((string) get_string_to_time_fromat($order_sheet->issue_time)) ?></td>
                <td class="right-side-view" style="text-align: right">Issue Date:<?= get_string_to_date_fromat($order_sheet->issue_date) ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left">Client Name: <?= !empty($client_information->client_name) ? ucfirst($client_information->client_name) : '' ?></td>
                <td class="right-side-view" style="text-align: right">Client Code:<?= !empty($client_information->client_code) ? ucfirst($client_information->client_code) : '' ?></td>
            </tr>
            <tr>
                <?php
                $contact_number = '';
                $client_cell_number = !empty($client_information->cell_number) ? $client_information->cell_number : '';
                $client_phone_number = !empty($client_information->phone_number) ? $client_information->phone_number : '';
                if ((empty($client_cell_number)) && (!empty($client_phone_number))) {
                    $contact_number = $client_phone_number;
                } else {
                    $contact_number = $client_cell_number;
                }
                ?>
                <td class="left-side-view" style="text-align: left">Client Cell No.: <?= !empty($contact_number) ? $contact_number : '' ?></td>
                <td class="right-side-view" style="text-align: right">Dealer Code:<?= (!empty($dealer_information) || $dealer_information != NULL) ? $dealer_information->dealer_code : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left">Delivery Address: <?= !empty($order_sheet->delivery_address) ? ucfirst($order_sheet->delivery_address) : '' ?></td>
                <td class="right-side-view" style="text-align: right">Emp. Code:<?= (!empty($employee_information) || $employee_information != NULL) ? $employee_information->employee_code : '' ?></td>
            </tr>
            <tr>
                <?php
                $delivery_date = '';
                $delivery_date = !empty($order_sheet->delivery_date) ? get_string_to_date_fromat($order_sheet->delivery_date) : '';
                if (($delivery_date == NULL) || ($delivery_date == '01-01-1970')) {
                    $delivery_date = '';
                }

                $work_order_date = '';
                $work_order_date = !empty($order_sheet->work_order_date) ? get_string_to_date_fromat($order_sheet->work_order_date) : '';
                if (($work_order_date == NULL) || ($work_order_date == '01-01-1970')) {
                    $work_order_date = '';
                }
                ?>
                <td class="left-side-view" style="text-align: left">Delivery Date: <?= !empty($delivery_date) ? $delivery_date : '' ?></td>
                <td class="right-side-view" style="text-align: right">W/O No:<?= !empty($order_sheet->delivery_address) ? ucfirst($order_sheet->work_order_number) : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left"></td>
                <td class="right-side-view" style="text-align: right">W/O Date:<?= !empty($work_order_date) ? $work_order_date : '' ?></td>
            </tr>
        </tbody>
    </table>
    <div class="col-xs-12" style="text-align: center">
        <p class="text-align-center report-header-font" style="text-align: center"><strong style="border: 2px solid black; font-size: 16px; text-align: center">ORDER DESCRIPTION</strong></p>
    </div>

    <div class="col-xs-12">

        <table class="table" width="100%" border="2px solid black" cellspacing="0">
            <thead class="thead-default">
                <tr style="border: thick">
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Product</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Pack Size</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px" class="text-align-center"><?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Quantity</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px" class="text-align-center"><?= 'Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total = 0;
                foreach ($order_sheet_details_by_order_sheet_id as $order):
                    ?>
                    <?php $total += (double) $order->amount; ?>
                    <?php
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    $product = $this->Product_Model->get_product($order->product_id);
                    if (strpos(($product->product_name), '#') !== false) {
                        $product_name = explode("#", ($product->product_name));
                        $product_name_part_1 = $product_name[0];
                        $product_name_part_2 = $product_name[1];
                    } else {
                        $product_name_part_1 = $product->product_name;
                    }
                    ?>
                    <tr style="border: thick">
                        <td><?= $count++; ?></td>
                        <td><?= ucfirst($product_name_part_1) ?></td>
                        <td><?= $product->pack_size ?></td>
                        <td><?= $order->quantity ?></td>
                        <td><?= number_format((double) $order->unit_price, 2) ?></td>
                        <td><?= number_format((double) $order->amount, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
<!--                <tr style="border: thick">
<td></td>
<td></td>
<td></td>
<td></td>
<td>Total</td>
<td><?= number_format($total, 2) ?></td>
</tr>-->
                <tr style="border: thick">
                    <td></td>
                    <td><strong>Add : Freight Charge</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong><?= number_format($order_sheet->freight_charge, 2) ?></strong></td>
                </tr>
                <tr style="border: thick">
                    <td></td>
                    <td><strong>Less : Discount</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong><?= number_format($order_sheet->discount, 2) ?></strong></td>
                </tr>
                <tr style="border: thick">
                    <td></td>
                    <td><strong>Less : Bonus</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong><?= number_format($order_sheet->bonus, 2) ?></strong></td>
                </tr>
                <tr style="border: thick">
                    <td></td>
                    <td><strong>TOTAL</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong><?= number_format($order_sheet->total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>
        <div style="padding-top:20px">
            <strong>REMARKS</strong>
            <div><?= !empty($order_sheet->remarks) ? $order_sheet->remarks : '' ?></div>
        </div>
    </div>

    <div style="width: 100%; margin-bottom: 70px">

    </div>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".order-sheet-details-modal-print-button").on("click", function () {

        var divContents = $('#order-sheet-details-modal-print-information').html();

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

