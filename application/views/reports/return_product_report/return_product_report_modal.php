<div class="modal-content">
    <?php
    $company_information;
    $currency_settings;
    $return_product_info_with_to_branch;
    $return_product_details_by_return_product_info_id;
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
        <h4 class="modal-title">Return Product Details Report</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <div class="col-xs-12">
                <label class="search-from-date">Outlet: <?= ucfirst($return_product_info_with_to_branch->branch_name) ?></label>
            </div>
            <div class="col-xs-12">
                <?php $return_date = date("d-m-Y", strtotime($return_product_info_with_to_branch->return_date)); ?>
                <label class="search-from-date">Date: <?= $return_date ?></label><br>
            </div>

            <div class="col-xs-12">

                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Pack Size</th>
                            <th>Quantity</th>
                            <th class="text-align-center"><?= 'Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 1;
                        $total_amount = 0;

                        foreach ($return_product_details_by_return_product_info_id as $return_product_details) {
                            ?>
                            <?php $total_amount += (double) $return_product_details->purchase_price ?>
                            <?php
                            $product_name_part_1 = '';
                            $product_name_part_2 = '';
                            if (strpos(($return_product_details->product_name), '#') !== false) {
                                $product_name = explode("#", ($return_product_details->product_name));
                                $product_name_part_1 = $product_name[0];
                                $product_name_part_2 = $product_name[1];
                            } else {
                                $product_name_part_1 = $return_product_details->product_name;
                            }
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $product_name_part_1 ?></td>
                                <td><?= $return_product_details->packsize ?></td>
                                <td><?= $return_product_details->quantity ?></td>
                                <td><?= number_format((double) $return_product_details->purchase_price, 2) ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Grand Total</strong></td>
                            <td><strong><?= number_format((double) $total_amount, 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <button type="button" class="btn btn-primary return-product-info-details-modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>
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

<div id="return-product-info-details-modal-print-section" style="width: 100%; display: none;">

    <div class="col-xs-12">
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
<!--        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div><strong>Product (Return) Details Report</strong></div>

    <div class="col-xs-12">
        <label class="search-from-date">Outlet: <?= ucfirst($return_product_info_with_to_branch->branch_name) ?></label>
    </div>
    <div class="col-xs-12">
        <?php $return_date = date("d-m-Y", strtotime($return_product_info_with_to_branch->return_date)); ?>
        <label class="search-from-date">Date: <?= $return_date ?></label><br>
    </div>

    <hr>

    <table style="width: 100%" border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Product</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Pack Size</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Quantity</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $count = 1;
            $total_amount = 0;

            foreach ($return_product_details_by_return_product_info_id as $return_product_details) {
                ?>
                <?php $total_amount += (double) $return_product_details->purchase_price ?>
                <?php
                $product_name_part_1 = '';
                $product_name_part_2 = '';
                if (strpos(($return_product_details->product_name), '#') !== false) {
                    $product_name = explode("#", ($return_product_details->product_name));
                    $product_name_part_1 = $product_name[0];
                    $product_name_part_2 = $product_name[1];
                } else {
                    $product_name_part_1 = $return_product_details->product_name;
                }
                ?>
                <tr style="border: thick">
                    <td><?= $count++; ?></td>
                    <td><?= $product_name_part_1 ?></td>
                    <td><?= $return_product_details->packsize ?></td>
                    <td><?= $return_product_details->quantity ?></td>
                    <td><?= $return_product_details->purchase_price ?></td>
                </tr>
            <?php } ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total_amount, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".return-product-info-details-modal-print-button").on("click", function () {

        var divContents = $('#return-product-info-details-modal-print-section').html();

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
