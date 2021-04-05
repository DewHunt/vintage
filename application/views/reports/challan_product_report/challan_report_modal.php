<div class="modal-content">

    <?php
    $challan_product_view;
    $company_information;
    $challan_product_by_challan_id;
    $challan_product_list;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

//    echo '<pre>';
//    echo print_r($challan_product_by_challan_id);
//    echo '</pre>';
//    die();
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <!--            <div class="col-xs-12">
                            <h4 class="text-align-center"><?= strtoupper($company_information->company_name_1) ?></h4>
                        </div>
                        <div class="col-xs-12">
                            <h6 class="text-align-center"><?= $company_information->company_address_1 ?></h6>
                        </div>-->
            <div class="col-xs-12">
                <h6 class="text-align-center report-header-font"><strong>Challan</strong></h6>
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
                        <td class="right-side-view">EC: <?= !empty($employee->employee_code) ? $employee->employee_code : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view"></td>
                        <td class="right-side-view">DC: <?= !empty($dealer->dealer_code) ? $dealer->dealer_code : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view"></td>
                        <td class="right-side-view"><strong>Invoice: <?= !empty($challan_product_by_challan_id->invoice_number) ? $challan_product_by_challan_id->invoice_number : '' ?></strong></td>
                    </tr>
                    <tr>
                        <td class="left-side-view">Challan Details</td>
                        <td class="right-side-view"><strong>Challan No: <?= !empty($challan_product_by_challan_id->challan_number) ? $challan_product_by_challan_id->challan_number : '' ?></strong></td>
                    </tr>
                    <tr>
                        <td class="left-side-view">
                            <?php
                            $client_name_part_1 = '';
                            $client_name_part_2 = '';
                            if (!empty($challan_product_by_challan_id->client_name)) {
                                if (strpos(($challan_product_by_challan_id->client_name), '(') !== false) {
                                    $client_name = explode("(", ($challan_product_by_challan_id->client_name));
                                    $client_name_part_1 = $client_name[0];
                                    $client_name_part_2 = $client_name[1];
                                } else {
                                    $client_name_part_1 = $challan_product_by_challan_id->client_name;
                                }
                            }
                            ?>
                        <td class="left-side-view" style="text-align: left"><strong>Sold
                                To:</strong> <?= !empty($client_name_part_1) ? $client_name_part_1 : '' ?></td>

                        <td class="right-side-view">Outlet: <?= !empty($challan_product_by_challan_id->branch_name) ? $challan_product_by_challan_id->branch_name : '' ?></td>
                    </tr>
                    <tr>
                        <td class="left-side-view"><strong>Address:</strong> <?= !empty($challan_product_by_challan_id->address) ? ucfirst($challan_product_by_challan_id->address) : '' ?></td>
                        <?php
                        if (!empty($challan_product_by_challan_id->date_of_issue)) {
                            $date_of_issue = date("d-m-Y", strtotime($challan_product_by_challan_id->date_of_issue));
                        } else {
                            $date_of_issue = '';
                        }
                        ?>
                        <td class="right-side-view">Date Of Issue: <?= $date_of_issue ?></td>
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
                        if (!empty($challan_product_by_challan_id->order_date)) {
                            $order_date = date("d-m-Y", strtotime($challan_product_by_challan_id->order_date));
                            if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                                $order_date = '';
                            }
                        }
                        ?>
                        <td class="right-side-view" style="text-align: right">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="col-xs-12 div-margin-top">
                <label class="col-form-label left-side-view">Product Information</label>
            </div>

            <div class="col-xs-12">

                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Pack Size</th>
                            <th>Quantity</th>
                            <!--<th>Price/Pack</th>-->
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 1;
                        foreach ($challan_product_list as $challan_product):
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= ucfirst($challan_product->product_name) ?></td>
                                <td><?= $challan_product->pack_size ?></td>
                                <td><?= $challan_product->quantity ?></td>
                                <!--<td><?= number_format((double) $challan_product->total_price, 2) ?></td>-->
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
                <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
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

<div id="print-information" style="display: none">

    <!--    <div class="col-xs-12">
            <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
            <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
        </div>-->
    <div style="text-align: center; margin-top: 85px; font-size: 20px;"><strong>Challan</strong></div>

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
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">SL</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Product</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Pack Size</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Quantity</th>
                    <!--<th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Price/Pack</th>-->
                </tr>
            </thead>
            <tbody>

                <?php
                $count = 1;
                foreach ($challan_product_list as $challan_product):
                    ?>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
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


