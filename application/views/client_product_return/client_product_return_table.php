<div class="table-responsive">
    <?php
        $invoice_details;
        $sale_product_list;
        $sale_product_list_row;
    ?>

    <?php if (!empty($invoice_details)) { ?>
        <input type="hidden" id="invoice_number_for_invoice_void" name="invoice_number_for_invoice_void" value="<?= $invoice_details->invoice_number ?>"> 
        <table class="" width="100%">
            <tbody>
                <tr>
                    <td class="left-side-view">Invoice Details</td>
                    <td class="right-side-view"><strong>Invoice: <?= $invoice_details->invoice_number ?></strong></td>
                </tr>
                <tr>
                    <?php
                        $client_name_part_1 = '';
                        $client_name_part_2 = '';
                        $client = $this->Client_Model->get_client($invoice_details->client_id);
                        if ($client) {
                            if (strpos(($client->client_name), '(') !== false) {
                                $client_name = explode("(", ($client->client_name));
                                $client_name_part_1 = $client_name[0];
                                $client_name_part_2 = $client_name[1];
                            } else {
                                $client_name_part_1 = $client->client_name;
                            }
                        }
                    ?>
                    <td class="left-side-view"><strong>Sold To:</strong> <?= $client_name_part_1 ?></td>
                    <?php $branch = $this->Branch_Model->get_Branch($invoice_details->branch_id); ?>
                    <td class="right-side-view">Outlet:<?= $branch->branch_name ?></td>
                </tr>
                <tr>
                    <td class="left-side-view">Order No:<?= !empty($invoice_details->order_number) ? $invoice_details->order_number : '' ?></td>
                    <?php
                        $order_date = '';
                        $order_date = date("d-m-Y", strtotime($invoice_details->order_date));
                        if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                            $order_date = '';
                        }
                    ?>
                    <td class="right-side-view">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
                </tr>
            </tbody>
        </table>

    <?php } ?>
    <table class="table table-striped table-bordered table-hover table-responsive" id="product-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th>Product Name</th>
                <th width="120px"><?= 'Unit Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th width="100px">Quantity</th>
                <th width="100px">Discount</th>
                <th width="100px"><?= 'Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <!-- <th width="100px">Action</th> -->
            </tr>
        </thead>      
        <tbody>
            <?php
            $count = 1;
            if (!empty($sale_product_list)) {
                foreach ($sale_product_list as $sale_product):
                    ?>
                    <?php
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    $product = $this->Product_Model->getProductById($sale_product->product_id);
                    if (strpos(($product->product_name), '#') !== FALSE) {
                        $product_name = explode("#", ($product->product_name));
                        $product_name_part_1 = $product_name[0];
                        $product_name_part_2 = $product_name[1];
                    } else {
                        $product_name_part_1 = $product->product_name;
                    }
                    ?>
                    <tr id="row-<?= $sale_product->id ?>">
                        <td><?= $count++ ?></td>
                        <td><?= $product_name_part_1 ?></td>
                        <td><?= $sale_product->unit_price ?></td>
                        <td>
                            <input class="form-control" style="width: 60px" type="number" max="<?= $sale_product->quantity ?>" id="quantity-<?= $sale_product->id ?>" name="quantity" value="<?= $sale_product->quantity ?>" readonly>
                        </td>
                        <td style="display: none"><input type="hidden" id="new_quantity" name="new_quantity" value=""></td>
                        <td><?= $sale_product->discount_amount ?></td>
                        <?php
                            $amount = 0;
                            $amount = (double) $sale_product->quantity * (double) $sale_product->unit_price;
                            $amount = (double) $sale_product->sales_price_excluding_vat;
                        ?>
                        <td><input class="form-control" style="width: 80px" type="text" id="amount-<?= $sale_product->id ?>" name="amount" value="<?= $amount ?>" readonly></td>
                        <td style="display: none"><input type="hidden" id="new_amount" name="new_amount" value=""></td>
                        <td style="display: none"><input class="form-control" type="text" id="<?= $sale_product->id ?>" name="id" value="<?= $sale_product->id ?>"></td>
                        <!-- <td>
                            <a id="reduce-<?= $sale_product->id ?>" status="reduce" quantity="<?= $sale_product->quantity ?>" sale_product_id="<?= $sale_product->id ?>" invoice_id ="<?= $sale_product->invoice_id ?>" product_id="<?= $sale_product->product_id ?>" class="btn btn-default" style="border: 1px solid black">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </a>
                            <script>
                                $('#reduce-<?= $sale_product->id ?>').click(function () {
                                    var deduction = $('#deduction').val();
                                    var quantity = $('#quantity-<?= $sale_product->id ?>').val();
                                    $('#new_quantity').val(quantity);

                                    var amount = $('#amount-<?= $sale_product->id ?>').val();
                                    $('#new_amount').val(amount);

                                    var sale_product_id = $(this).attr('sale_product_id');
                                    var invoice_id = $(this).attr('invoice_id');
                                    var product_id = $(this).attr('product_id');
                                    var new_quantity = $('#new_quantity').val();
                                    var new_amount = $('#new_amount').val();
                                    var status = $(this).attr('status');
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url("client_product_return/return_quantity_from_table/") ?>',
                                        data: {'sale_product_id': sale_product_id, 'new_quantity': new_quantity, 'invoice_id': invoice_id, 'product_id': product_id, 'status': status, 'new_amount': new_amount, 'deduction': deduction},
                                        success: function (data) {
                                            // alert(data);
                                            $('.client_reduce_product_return_table_block').html(data);
                                            $('.invoice-void-button').addClass('invoice-void-button-disable');
                                        },
                                        error: function () {

                                        }
                                    });
                                });
                            </script>
                            <a id="remove-<?= $sale_product->id ?>" status="remove" quantity="<?= $sale_product->quantity ?>" sale_product_id="<?= $sale_product->id ?>" invoice_id ="<?= $sale_product->invoice_id ?>" product_id="<?= $sale_product->product_id ?>" class="btn btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>                           
                            <script>
                                $('#remove-<?= $sale_product->id ?>').click(function () {
                                    var deduction = $('#deduction').val();
                                    var amount = $('#amount-<?= $sale_product->id ?>').val();
                                    $('#new_amount').val(amount);
                                    var sale_product_id = $(this).attr('sale_product_id');
                                    var invoice_id = $(this).attr('invoice_id');
                                    var product_id = $(this).attr('product_id');
                                    var new_quantity = $('#quantity-<?= $sale_product->id ?>').val();
                                    var new_amount = $('#new_amount').val();
                                    var status = $(this).attr('status');
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url("client_product_return/return_quantity_from_table/") ?>',
                                        data: {'sale_product_id': sale_product_id, 'new_quantity': new_quantity, 'invoice_id': invoice_id, 'product_id': product_id, 'status': status, 'new_amount': new_amount, 'deduction': deduction},
                                        success: function (data) {
                                            //alert(data);
                                            $('.client_reduce_product_return_table_block').html(data);
                                            $("#row-<?= $sale_product->id ?>").hide();
                                            $('#invoice-void-button').attr('disabled', true);
                                            $('.invoice-void-button').addClass('invoice-void-button-disable');
                                        },
                                        error: function () {

                                        }
                                    });
                                });
                            </script>
                        </td> -->
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>
    <?php
    $amt = !empty($invoice_details->amount_to_paid) ? get_floating_point_number($invoice_details->amount_to_paid) : 0;
    if (($amt == 0)) {
        ?>
        <div class="form-group col-xs-12 col-sm-6">
            <label for="deduction" class="col-form-label">Deduction</label>
            <input readonly="readonly" class="form-control" type="number" min="0" id="deduction" name="deduction" value="<?= !empty($invoice_details->deduction) ? get_floating_point_number($invoice_details->deduction) : 0; ?>" placeholder="Deduction">
        </div> 
    <?php }
    ?>

    <?php if (!empty($invoice_details->remarks)) { ?>
        <div class="form-group col-xs-12">
            <?php echo '<strong><span class="error-message">*</span>Remarks:</strong> ' . ucfirst($invoice_details->remarks); ?>
        </div>
    <?php } ?>
</div>


