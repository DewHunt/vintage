<!DOCTYPE html>
<html>
    <head>
        <title><?= get_company_name(); ?></title>
    </head>
    <body>
        <?php
        ?>
        <!-- PDF Section -->
        <div class="invoice-details-print-area">
            <style>
                .text-right{
                    text-align: right;
                }
                .text-left{
                    text-align: left;
                }
                .text-center{
                    text-align: center;
                }

                .width-100{
                    width: 100%;
                }
                .print-div-border{
                    border: 1px solid #eee; 
                    /*padding-top: 100px;*/ 
                    padding-bottom: 10px; 
                    background-color: #ffffff;
                    padding-left: 1%;
                    /*padding-right: 5px;*/
                }
                .error{
                    color: red;
                }
                .margin-top-20{
                    margin-top: 20px;
                }
                .width-99{
                    width: 99%;
                }
                .color-border-top{
                    border-top: 2px solid rgba(52, 73, 94, 0.94);
                }
                .line-height-10{
                    line-height: 10px;
                }
                .line-height-15{
                    line-height: 15px;
                }
                .line-height-20{
                    line-height: 20px;
                }
                .float-left{
                    float: left;
                }
                .sales-order-details-table th {
                    background: rgba(52, 73, 94, 0.94) none repeat scroll 0 0;
                    color: #ffffff;
                    height: 30px;
                }
            </style>

            <div id="" style="">

                <!--<div class="col-xs-12">
                    <h4 style="text-align: center"><? /*= strtoupper($company_information->company_name_1) */ ?></h4>
                    <h6 style="text-align: center"><? /*= $company_information->company_address_1 */ ?></h6>
                </div>-->

                <div style="height: 85px;"></div>

                <div style="text-align: center; font-size: 20px;"><strong>Invoice</strong></div>
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
                            <td class="right-side-view" style="text-align: right">
                                EC: <?= !empty($employee->employee_code) ? $employee->employee_code : '' ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left"></td>
                            <td class="right-side-view" style="text-align: right">
                                DC: <?= !empty($dealer->dealer_code) ? $dealer->dealer_code : '' ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left"></td>
                            <td class="right-side-view" style="text-align: right">
                                <strong>Invoice: <?= $invoice_details_by_invoice_id->invoice_number ?></strong></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left">Invoice Details</td>
                            <td class="right-side-view" style="text-align: right">Challan
                                Number:<?= $invoice_details_by_invoice_id->challan_number ?></td>
                        </tr>
                        <tr>
                            <?php
                            $client_name_part_1 = '';
                            $client_name_part_2 = '';
                            if (strpos(($invoice_details_by_invoice_id->client_name), '(') !== false) {
                                $client_name = explode("(", ($invoice_details_by_invoice_id->client_name));
                                $client_name_part_1 = $client_name[0];
                                $client_name_part_2 = $client_name[1];
                            } else {
                                $client_name_part_1 = $invoice_details_by_invoice_id->client_name;
                            }
                            ?>
                            <td class="left-side-view" style="text-align: left"><strong>Sold
                                    To:</strong> <?= $client_name_part_1 ?></td>
                            <td class="right-side-view" style="text-align: right">Outlet:<?= $invoice_details_by_invoice_id->branch_name ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left"><strong>Address:</strong> <?= !empty($invoice_details_by_invoice_id->address) ? $invoice_details_by_invoice_id->address : '' ?>
                            </td>
                            <?php
                            $date_of_issue = date("d-m-Y", strtotime($invoice_details_by_invoice_id->date_of_issue));
                            ?>
                            <td class="right-side-view" style="text-align: right">Date Of Issue:<?= $date_of_issue ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left">
                                <strong>Delivery Address:</strong> <?= !empty($invoice_details_by_invoice_id->delivery_address) ? ucfirst($invoice_details_by_invoice_id->delivery_address) : '' ?>
                            </td>
                            <td class="right-side-view" style="text-align: right">Order No:<?= !empty($invoice_details_by_invoice_id->order_number) ? $invoice_details_by_invoice_id->order_number : '' ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left">
                                <strong>Contact:
                                    <?php
                                    $contact_number = '';
                                    $client_cell_number = !empty($invoice_details_by_invoice_id->cell_number) ? $invoice_details_by_invoice_id->cell_number : '';
                                    $client_phone_number = !empty($invoice_details_by_invoice_id->phone_number) ? $invoice_details_by_invoice_id->phone_number : '';
                                    if ((empty($client_cell_number)) && (!empty($client_phone_number))) {
                                        $contact_number = $client_phone_number;
                                    } else {
                                        $contact_number = $client_cell_number;
                                    }
                                    ?>
                                </strong> <?= !empty($contact_number) ? $contact_number : '' ?>
                            </td>
                            <?php
                            $order_date = '';
                            $order_date = date("d-m-Y", strtotime($invoice_details_by_invoice_id->order_date));
                            if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                                $order_date = '';
                            }
                            ?>
                            <td class="right-side-view" style="text-align: right">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="col-xs-12">
                    <br>
                    <label class="col-form-label left-side-view" style="float: left">
                        <strong>Product Information</strong>
                    </label>
                    <br>
                </div>


                <div class="col-xs-12" style="margin-top: 10px;padding-left: 0px;">
                    <table class="table" width="100%" border="0" cellspacing="0" style="border-collapse: collapse">
                        <thead class="thead-default">
                            <tr style="border: thick">
                                <th class="text-center" style="border-bottom: 1px solid #ddd;">SL</th>
                                <th class="text-center" style="border-bottom: 1px solid #ddd;">Product</th>
                                <th class="text-center" style="border-bottom: 1px solid #ddd;">Pack Size</th>
                                <th class="text-center" style="border-bottom: 1px solid #ddd;">Grade</th>
                                <th class="text-left" style="border-bottom: 1px solid #ddd; text-align: center;">Origin</th>
                                <th class="text-right" style="border-bottom: 1px solid #ddd; text-align: right; padding-left: 5px;">QTY</th>
                                <th class="text-right" style="border-bottom: 1px solid #ddd; width: 80px;"><?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                                <th class="text-right" style="border-bottom: 1px solid #ddd; width: 100px;"><?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $count = 1;
                            $product_sale_total_amount = 0;
                            foreach ($sale_product_list as $sale_product):
                                ?>
                                <?php
                                $product = $this->Product_Model->get_product($sale_product->product_id);
                                if (strpos(($product->product_name), '#') !== false) {
                                    $product_name = explode("#", ($product->product_name));
                                    $product_name_part_1 = $product_name[0];
                                    $product_name_part_2 = $product_name[1];
                                } else {
                                    $product_name_part_1 = $product->product_name;
                                }

                                $grade1 = '';
                                if (!empty($product->api)) {
                                    $grade1 .= 'API: ' . $product->api . '<br>';
                                }
                                if (!empty($grade1) && !empty($product->sae)) {
                                    // $grade1 .= ', ';
                                }
                                if (!empty($product->sae)) {
                                    $grade1 .= 'SAE: ' . $product->sae . '<br>';
                                }
                                if (!empty($grade1) && !empty($product->iso)) {
                                    //   $grade1 .= ', ';
                                }
                                if (!empty($product->iso)) {
                                    $grade1 .= 'ISO: ' . $product->iso;
                                }
                                ?>
                                <tr style="border: thick; border-bottom: 1px solid #b0b0b0; text-align: center">
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: center"><?= $count++ ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: left"><?= ucfirst($product_name_part_1) ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: center"><?= $product->pack_size ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: center"><?= $grade1 ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: center"><?= $product->origin_of_country ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: right;"><?= $sale_product->quantity ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $sale_product->unit_price, 2) ?></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $sale_product->sales_price_including_vat, 2) ?></td>
                                </tr>
                                <?php $product_sale_total_amount += $sale_product->sales_price_including_vat; ?>
                            <?php endforeach; ?>
                            <tr style="border: thick;">
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px"></td>
                            </tr>
                            <tr style="border: thick;">
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <?php
                                $delivery_charge = $invoice_details_by_invoice_id->delivery_charge;
                                $others_charge = $invoice_details_by_invoice_id->others_charge;
                                $deduction = $invoice_details_by_invoice_id->deduction;
                                $vat = 0;
                                $total = $product_sale_total_amount;
                                ?>

                                <td style="margin-top: 50px;border-bottom: 1px solid #b0b0b0; text-align: right;">Total</td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right"> <?= number_format((double) $total, 2) ?></td>
                            </tr>
                            <tr style="border: thick">
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right">Delivery Charge</td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $invoice_details_by_invoice_id->delivery_charge, 2) ?></td>
                            </tr>

                            <tr style="border: thick">
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right">Others Charge</td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $invoice_details_by_invoice_id->others_charge, 2) ?></td>
                            </tr>
                            <?php if (((double) !empty($sale_product_list_row->vat)) > 0) { ?>
                                <tr style="border: thick">
                                    <td style="border: 1px solid white; text-align: center"></td>
                                    <td style="border: 1px solid white; text-align: center"></td>
                                    <td style="border: 1px solid white; text-align: center"></td>
                                    <td style="border: 1px solid white; text-align: center"></td>
                                    <td style="border: 1px solid white; text-align: center"></td>
                                    <td style="border: 1px solid white; text-align: center"></td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: right">Vat</td>
                                    <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $sale_product_list_row->vat, 2) ?></td>
                                </tr>
                            <?php } ?>
                            <tr style="border: thick">
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right">Deduction</td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $invoice_details_by_invoice_id->deduction, 2) ?></td>
                            </tr>

                            <tr style="border: thick">
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border: 1px solid white; text-align: center"></td>
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right">Grand Total</td>
                                <!--Gross Payable-->
                                <td style="border-bottom: 1px solid #b0b0b0; text-align: right"><?= number_format((double) $invoice_details_by_invoice_id->gross_payable, 2) ?></td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="col-xs-12">
                        <label class="col-form-label left-side-view" style="margin-top: 25px;"><strong>Payment Information</strong>
                        </label>
                    </div>

                    <div class="col-xs-12" style="margin-top: 10px">
                        <label class="col-form-label left-side-view" style=" margin-top: 60px">Mode of
                            Sale: <?= ucfirst($invoice_details_by_invoice_id->mode_of_payment) ?></label>
                    </div>

                    <div class="col-xs-12" style="margin-top: 5px">
                        <label class="col-form-label left-side-view">
                            <strong style="font-size: 10px">
                                AMOUNT IN WORDS:
                                <?= strtoupper(convert_number_to_words($invoice_details_by_invoice_id->amount_to_paid) . ' ' . $currency_settings->currency_name . ' only'); ?>
                            </strong>
                        </label>
                    </div>
                    <hr>

                </div>

                <div style="width: 100%; margin-bottom: 70px">
                    <p>
                        This is a computer generated copy and does not require any signature.
                        <br>
                        <!--            (* Should you require signed copy, please call # 01708519907)-->
                    </p>

<!--        <p style="float: right; padding-right: 1%; margin-top: 5%">
            <a style="border-top: inset;">AUTHORIZED BY</a>
        </p>-->
                </div>

            </div>

        </div>
        <!-- // PDF Section -->
    </body>
</html>
