<div class="modal-content">
    <?php
    $company_information;
    $currency_settings;
    $stock_transfer_challan_details_by_stock_transfer_challan_id;
    $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row;

//    echo '<pre>';
//    print_r($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row);
//    echo '</pre>';
//    die();
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Gate Pass Transfer Details</h4>
    </div>

    <div class="modal-body">
        <div class="text-align-center">
            <h4><strong><?= strtoupper($company_information->company_name_1) ?></strong></h4>
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
                    <?php $stock_transfer_date = date("d-m-Y", strtotime($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->transfer_date)); ?>
                    <td class="left-side-view">Date: <?= $stock_transfer_date ?> </td>
                </tr>
                <tr>
                    <td class="left-side-view">From Outlet: <?= $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->from_branch_name ?> </td>
                </tr>
                <tr>
                    <td class="left-side-view">To Outlet: <?= $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->to_branch_name ?> </td>
                </tr>
                <tr>
                    <td class="left-side-view">Challan Number:<?= !empty($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->challan_number) ? $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->challan_number : '' ?></td>
                </tr>
                <tr>
                    <td class="left-side-view">Remarks: <?= !empty($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->remarks) ? $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->remarks : '' ?></td>
                </tr>

            </tbody>
        </table>
        <hr>

        <div class="col-xs-12">

            <table class="table table-striped table-bordered table-hover table-responsive"
                   id="product-table">

                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Pack Size</th>
                        <th>Quantity</th>
                        <!--<th><?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?></th>-->
                        <!--<th><?= 'Total ' . '(' . $currency_settings->currency_symbol . ')' ?></th>-->
                        <th>Product Source</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 1;
                    if (!empty($stock_transfer_challan_details_by_stock_transfer_challan_id)) {
                        foreach ($stock_transfer_challan_details_by_stock_transfer_challan_id as $stock_transfer_challan_details):
                            ?>
                            <?php
                            $product_name_part_1 = '';
                            $product_name_part_2 = '';
                            if (strpos(($stock_transfer_challan_details->product_name), '#') !== FALSE) {
                                $product_name = explode("#", ($stock_transfer_challan_details->product_name));
                                $product_name_part_1 = $product_name[0];
                                $product_name_part_2 = $product_name[1];
                            } else {
                                $product_name_part_1 = $stock_transfer_challan_details->product_name;
                            }
                            ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $product_name_part_1 ?></td>
                                <td><?= $stock_transfer_challan_details->pack_size ?></td>
                                <td><?= $stock_transfer_challan_details->quantity ?></td>
                                <!--<td><?= number_format((double) $stock_transfer_challan_details->purchase_price, 2) ?></td>-->
                                <!--<td><?= number_format((double) $stock_transfer_challan_details->total_price, 2) ?></td>-->
                                <td><?= $stock_transfer_challan_details->product_source ?></td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    ?>
    <!--<tr>-->
    <!--    <td></td>-->
    <!--    <td></td>-->
    <!--    <td></td>-->
    <!--    <td></td>-->
    <!--    <td><strong>Grand Total</strong></td>-->
    <!--    <td><strong><?= number_format((double) $stock_transfer_challan_details->total_amount, 2) ?></strong></td>-->
    <!--    <td></td>-->
                    <!--</tr>-->

                </tbody>

            </table>

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

    <div style="text-align: center; font-size: 20px; margin-top: 5px;"><strong>GATE PASS (TRANSFER)</strong></div>
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
                <td class="right-side-view" style="text-align: right">EC: <?= !empty($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->employee_code) ? $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->employee_code : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left"></td>
                <td class="right-side-view" style="text-align: right">DC: <?= !empty($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->dealer_code) ? $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->dealer_code : '' ?> </td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left"><strong>Challan No: <?= $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->challan_number ?></strong></td>
                <?php $stock_transfer_date = date("d-m-Y", strtotime($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->transfer_date)); ?>
                <td class="right-side-view" style="text-align: right">Date of Transfer:<?= $stock_transfer_date; ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left">Remarks: <?= !empty($stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->reason) ? $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row->reason : ''; ?></td>
                <td class="right-side-view" style="text-align: right"></td>
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
                if (!empty($stock_transfer_challan_details_by_stock_transfer_challan_id)) {
                    foreach ($stock_transfer_challan_details_by_stock_transfer_challan_id as $stock_transfer_challan_details):
                        ?>
                        <?php
                        $product_name_part_1 = '';
                        $product_name_part_2 = '';
                        if (strpos(($stock_transfer_challan_details->product_name), '#') !== FALSE) {
                            $product_name = explode("#", ($stock_transfer_challan_details->product_name));
                            $product_name_part_1 = $product_name[0];
                            $product_name_part_2 = $product_name[1];
                        } else {
                            $product_name_part_1 = $stock_transfer_challan_details->product_name;
                        }
                        ?>
                        <tr>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product_name_part_1 ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $stock_transfer_challan_details->pack_size ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $stock_transfer_challan_details->quantity ?></td>
                            <!--<td><?= number_format((double) $stock_transfer_challan_details->purchase_price, 2) ?></td>-->
                            <!--<td><?= number_format((double) $stock_transfer_challan_details->total_price, 2) ?></td>-->
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $stock_transfer_challan_details->product_source ?></td>
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
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


