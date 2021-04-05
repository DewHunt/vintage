<div class="modal-content">
    <?php
    $company_information;
    $currency_settings;
    $product_receive_challan_details_by_product_receive_challan_id;
    $product_receive_challan_details_by_product_receive_challan_id_single_row;

//    echo '<pre>';
//    print_r($product_receive_challan_details_by_product_receive_challan_id);
//    echo '</pre>';
//    die();
    
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Product Receive Challan Details</h4>
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
                    <?php $product_receive_date = date("d-m-Y", strtotime($product_receive_challan_details_by_product_receive_challan_id_single_row->product_receive_date)); ?>
                    <td class="left-side-view">Date: <?= $product_receive_date ?> </td>
                </tr>
                <tr>
                    <td class="left-side-view">Outlet: <?= ucfirst($product_receive_challan_details_by_product_receive_challan_id_single_row->branch_name) ?> </td>
                </tr>
                <tr>
                    <td class="left-side-view">Challan Number:<?= !empty($product_receive_challan_details_by_product_receive_challan_id_single_row->challan_number) ? $product_receive_challan_details_by_product_receive_challan_id_single_row->challan_number : '' ?></td>
                </tr>
                <tr>
                    <td class="left-side-view">Remarks: <?= !empty($product_receive_challan_details_by_product_receive_challan_id_single_row->remarks) ? $product_receive_challan_details_by_product_receive_challan_id_single_row->remarks : '' ?></td>
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
                        <th><?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                        <th><?= 'Total ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                        <th>Product Source</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 1;
                    if (!empty($product_receive_challan_details_by_product_receive_challan_id)) {
                        foreach ($product_receive_challan_details_by_product_receive_challan_id as $product_receive_challan_details):
                            ?>

                            <?php
                            $product_name_part_1 = '';
                            $product_name_part_2 = '';
                            if (strpos(($product_receive_challan_details->product_name), '#') !== FALSE) {
                                $product_name = explode("#", ($product_receive_challan_details->product_name));
                                $product_name_part_1 = $product_name[0];
                                $product_name_part_2 = $product_name[1];
                            } else {
                                $product_name_part_1 = $product_receive_challan_details->product_name;
                            }
                            ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $product_name_part_1 ?></td>
                                <td><?= $product_receive_challan_details->pack_size ?></td>
                                <td><?= $product_receive_challan_details->quantity ?></td>
                                <td><?= number_format((double) $product_receive_challan_details->purchase_price, 2) ?></td>
                                <td><?= number_format((double) $product_receive_challan_details->total_price, 2) ?></td>
                                <td><?= $product_receive_challan_details->product_source ?></td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><?= number_format((double) $product_receive_challan_details->total_amount, 2) ?></strong></td>
                        <td></td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="width: 100%; display: none">

    <div class="text-align-center" style="text-align: center">
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
                <?php $product_receive_date = date("d-m-Y", strtotime($product_receive_challan_details_by_product_receive_challan_id_single_row->product_receive_date)); ?>
                <td class="left-side-view">Date: <?= $product_receive_date ?> </td>
            </tr>
            <tr>
                <td class="left-side-view">Outlet: <?= ucfirst($product_receive_challan_details_by_product_receive_challan_id_single_row->branch_name) ?> </td>
            </tr>
            <tr>
                <td class="left-side-view">Challan Number:<?= !empty($product_receive_challan_details_by_product_receive_challan_id_single_row->challan_number) ? $product_receive_challan_details_by_product_receive_challan_id_single_row->challan_number : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view">Remarks: <?= !empty($product_receive_challan_details_by_product_receive_challan_id_single_row->remarks) ? $product_receive_challan_details_by_product_receive_challan_id_single_row->remarks : '' ?></td>
            </tr>

        </tbody>
    </table>
    <hr>

    <div class="col-xs-12">

        <table class="table" width="100%" border="2px" cellspacing="0">

            <thead>
                <tr style="border: thick">
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        SL
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Product Name
                    </th>

                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Pack Size
                    </th>

                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Quantity
                    </th>

                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        <?= 'Rate ' . '(' . $currency_settings->currency_symbol . ')' ?>
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        <?= 'Total ' . '(' . $currency_settings->currency_symbol . ')' ?>
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Product Source
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php
                $count = 1;
                if (!empty($product_receive_challan_details_by_product_receive_challan_id)) {
                    foreach ($product_receive_challan_details_by_product_receive_challan_id as $product_receive_challan_details):
                        ?>

                        <?php
                        $product_name_part_1 = '';
                        $product_name_part_2 = '';
                        if (strpos(($product_receive_challan_details->product_name), '#') !== FALSE) {
                            $product_name = explode("#", ($product_receive_challan_details->product_name));
                            $product_name_part_1 = $product_name[0];
                            $product_name_part_2 = $product_name[1];
                        } else {
                            $product_name_part_1 = $product_receive_challan_details->product_name;
                        }
                        ?>
                        <tr style="border: thick">
                            <td><?= $count++ ?></td>
                            <td><?= $product_name_part_1 ?></td>
                            <td><?= $product_receive_challan_details->pack_size ?></td>
                            <td><?= $product_receive_challan_details->quantity ?></td>
                            <td><?= number_format((double) $product_receive_challan_details->purchase_price, 2) ?></td>
                            <td><?= number_format((double) $product_receive_challan_details->total_price, 2) ?></td>
                            <td><?= $product_receive_challan_details->product_source ?></td>
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
                <tr style="border: thick">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double) $product_receive_challan_details->total_amount, 2) ?></strong></td>
                    <td></td>
                </tr>

            </tbody>

        </table>

    </div>

    <div style="width: 100%">

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
                        <a style="border-top: inset;">Delivered By</a>
                    </p>
                </td>
                <td style="text-align: center; width: 40%">
                    <p style="">
                        <a style="border-top: inset;">Received By</a>
                    </p>
                </td>
            </tr>

        </table>

    </div>
</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".modal-print-button").on("click", function () {

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


