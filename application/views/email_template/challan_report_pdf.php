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

                <!--    <div class="col-xs-12">
                        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
                        <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
                    </div>-->
                <div style="height: 85px;"></div>
                <div style="text-align: center; font-size: 20px;"><strong>Challan</strong></div>

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
                            <td class="right-side-view" style="text-align: right">EC: <?= !empty($employee->employee_code) ? $employee->employee_code : '' ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left"></td>
                            <td class="right-side-view" style="text-align: right">DC: <?= !empty($dealer->dealer_code) ? $dealer->dealer_code : '' ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left"></td>
                            <td class="right-side-view" style="text-align: right"><strong>Invoice: <?= $challan_product_by_challan_id->invoice_number ?></strong></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left">Challan Details</td>
                            <td class="right-side-view" style="text-align: right"><strong>Challan No: <?= $challan_product_by_challan_id->challan_number ?></strong></td>
                        </tr>
                        <tr>
                            <?php
                            $client_name_part_1 = '';
                            $client_name_part_2 = '';
                            if (strpos(($challan_product_by_challan_id->client_name), '(') !== false) {
                                $client_name = explode("(", ($challan_product_by_challan_id->client_name));
                                $client_name_part_1 = $client_name[0];
                                $client_name_part_2 = $client_name[1];
                            } else {
                                $client_name_part_1 = $challan_product_by_challan_id->client_name;
                            }
                            ?>
                            <td class="left-side-view" style="text-align: left"><strong>Sold
                                    To:</strong> <?= $client_name_part_1 ?></td>

                            <td class="right-side-view" style="text-align: right">Outlet: <?= $challan_product_by_challan_id->branch_name ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left"><strong>Address:</strong> <?= !empty($challan_product_by_challan_id->address) ? ucfirst($challan_product_by_challan_id->address) : '' ?></td>
                            <?php
                            $date_of_issue = date("d-m-Y", strtotime($challan_product_by_challan_id->date_of_issue));
                            ?>
                            <td class="right-side-view" style="text-align: right">Date Of Issue: <?= $date_of_issue ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left">
                                <strong>Delivery Address:</strong> <?= !empty($challan_product_by_challan_id->delivery_address) ? ucfirst($challan_product_by_challan_id->delivery_address) : '' ?>
                            </td>
                            <td class="right-side-view" style="text-align: right">Order No:<?= !empty($challan_product_by_challan_id->order_number) ? $challan_product_by_challan_id->order_number : '' ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view" style="text-align: left">
                                <strong>Contact:
                                    <?php
                                    $contact_number = '';
                                    $client_cell_number = !empty($challan_product_by_challan_id->cell_number) ? $challan_product_by_challan_id->cell_number : '';
                                    $client_phone_number = !empty($challan_product_by_challan_id->phone_number) ? $challan_product_by_challan_id->phone_number : '';
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
                            $order_date = date("d-m-Y", strtotime($challan_product_by_challan_id->order_date));
                            if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                                $order_date = '';
                            }
                            ?>
                            <td class="right-side-view" style="text-align: right">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="col-xs-12 div-margin-top" style="margin-top: 2%">
                    <br> <label class="col-form-label left-side-view" style="float: left">
                        <strong>Product Information</strong>
                    </label>
                    <br>
                </div>


                <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">

                    <table class="table" style="border: 1px solid white; width: 100%">
                        <thead class="thead-default">
                            <tr>
                                <th style="border-bottom: 1px solid #ddd; text-align: left">SL</th>
                                <th style="border-bottom: 1px solid #ddd;">Product</th>
                                <th style="border-bottom: 1px solid #ddd; text-align: center;">Pack Size</th>
                                <th style="border-bottom: 1px solid #ddd;">Quantity</th>
                                <!--<th style="border-bottom: 1px solid #ddd;">Price/Pack</th>-->
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $count = 1;
                            foreach ($challan_product_list as $challan_product):
                                ?>
                                <tr>
                                    <td style="border-bottom: 1px solid #ddd; text-align: left"><?= $count++ ?></td>
                                    <td style="border-bottom: 1px solid #ddd; text-align: left"><?= ucfirst($challan_product->product_name) ?></td>
                                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $challan_product->pack_size ?></td>
                                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $challan_product->quantity ?></td>
                                    <!--<td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double) $challan_product->total_price, 2) ?></td>-->
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

                <div style="width: 100%; margin-bottom: 70px">

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
                                <!--AUTHORIZED BY-->
                                <p style="">
                                    <a style="border-top: inset;">Store In-Charge</a>
                                </p>
                            </td>
                            <td style="text-align: center; width: 30%">
                                <!--STORE-->
                                <p style="">
                                    <a style="border-top: inset;">Delivery In-Charge</a>
                                </p>
                            </td>
                            <td style="text-align: center; width: 40%">
                                <!--RECEIVED BY-->
                                <p style="padding-top: 15px">
                                    <a style="border-top: inset;">Customer acknowledgment</a><br>with Seal & Signature
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <!-- // PDF Section -->
    </body>
</html>
