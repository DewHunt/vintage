<div class="table-responsive">

    <?php
    $invoice_details;
    $sale_product_list;
    $sale_product_list_row;

//    echo '<pre>';
//    print_r($sale_product_list);
//    echo '</pre>';
   // die();
    ?>

    <?php if (!empty($invoice_details)) { ?>

        <table class="" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left-side-view">Invoice Details</td>
                    <td class="right-side-view">
                        <strong>Invoice: <?= $invoice_details->invoice_number ?></strong></td>
                </tr>
                <tr>
                    <?php
                    $client_name_part_1 = '';
                    $client_name_part_2 = '';
                    $client = $this->Client_Model->get_client($invoice_details->client_id);
                    if (strpos(($client->client_name), '(') !== false) {
                        $client_name = explode("(", ($client->client_name));
                        $client_name_part_1 = $client_name[0];
                        $client_name_part_2 = $client_name[1];
                    } else {
                        $client_name_part_1 = $client->client_name;
                    }
                    ?>
                    <td class="left-side-view"><strong>Sold
                            To:</strong> <?= $client_name_part_1 ?></td>
                    <td class="right-side-view">Challan Number:<?= $invoice_details->challan_number ?></td>
                </tr>
                <tr>
                    <td class="left-side-view">Order No:<?= !empty($invoice_details->order_number) ? $invoice_details->order_number : '' ?></td>
                    <?php $branch = $this->Branch_Model->get_Branch($invoice_details->branch_id); ?>
                    <td class="right-side-view">Outlet:<?= $branch->branch_name ?></td>
                </tr>
                <tr>
                    <?php
                    $order_date = '';
                    $order_date = date("d-m-Y", strtotime($invoice_details->order_date));
                    if (($order_date == NULL) || ($order_date == '01-01-1970')) {
                        $order_date = '';
                    }
                    ?>
                    <td class="left-side-view">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
                    </td>
                    <?php $date_of_issue = date("d-m-Y", strtotime($invoice_details->date_of_issue)); ?>
                    <td class="right-side-view">Date Of Issue:<?= $date_of_issue ?></td>
                </tr>
                <tr>
                    <td class="left-side-view"></td>
                    <td class="right-side-view"></td>
                </tr>
                <tr>
                    <td class="left-side-view"></td>
                    <td class="right-side-view"></td>
                </tr>
            </tbody>
        </table>

    <?php } ?>
    <table class="table table-striped table-bordered table-hover table-responsive"
           id="product-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Pack Size</th>
                <th>Quantity</th>
                <th>Price</th>
                <!--<th>id</th>-->
                <th>Action</th>
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
                    $product = $this->Product_Model->get_product($sale_product->product_id);
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
                        <td><?= $sale_product->pack_size ?></td>
                        <td><input style="width: 60px" type="number" max="<?= $sale_product->quantity ?>" id="quantity-<?= $sale_product->id ?>" name="quantity" value="<?= $sale_product->quantity ?>">
                            <a id="reduce-<?= $sale_product->id ?>" status="reduce" quantity="<?= $sale_product->quantity ?>" sale_product_id="<?= $sale_product->id ?>" invoice_id ="<?= $sale_product->invoice_id ?>" product_id="<?= $sale_product->product_id ?>" class="btn btn-default">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </a>
                            <script>
                                $('#quantity-<?= $sale_product->id ?>').change(function () {

                                    var quantity = $('#quantity-<?= $sale_product->id ?>').val();
                                    $('#new_quantity').val(quantity);
                                });

                                $('#reduce-<?= $sale_product->id ?>').click(function () {

                                    var sale_product_id = $(this).attr('sale_product_id');
                                    var invoice_id = $(this).attr('invoice_id');
                                    var product_id = $(this).attr('product_id');
                                    var new_quantity = $('#new_quantity').val();
                                    var status = $(this).attr('status');
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url("client_product_damage_or_defect/reduce_quantity_from_table/") ?>',
                                        data: {'sale_product_id': sale_product_id, 'new_quantity': new_quantity, 'invoice_id': invoice_id, 'product_id': product_id, 'status': status},
                                        success: function (data) {
                                            //alert(data);
                                            $('.client_reduce_product_damage_or_defect_table_block').html(data);
                                        },
                                        error: function () {

                                        }
                                    });
                                });
                            </script>
                        </td>
                        <td style="display: none"><input type="hidden" id="new_quantity" name="new_quantity" value=""></td>
                        <td><?= ($sale_product->unit_price) * ($sale_product->quantity) ?></td>
                        <td style="display: none"><input type="text" id="<?= $sale_product->id ?>" name="id" value="<?= $sale_product->id ?>"></td>
                        <td>
                            <a id="remove-<?= $sale_product->id ?>" status="remove" quantity="<?= $sale_product->quantity ?>" sale_product_id="<?= $sale_product->id ?>" invoice_id ="<?= $sale_product->invoice_id ?>" product_id="<?= $sale_product->product_id ?>" class="btn btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                            <script>
                                //                                $('#quantity-<?= $sale_product->id ?>').change(function () {
                                //
                                //                                    var quantity = $('#quantity-<?= $sale_product->id ?>').val();
                                //                                    $('#new_quantity').val(quantity);
                                //                                });

                                $('#remove-<?= $sale_product->id ?>').click(function () {

                                    var sale_product_id = $(this).attr('sale_product_id');
                                    var invoice_id = $(this).attr('invoice_id');
                                    var product_id = $(this).attr('product_id');
                                    var new_quantity = $('#quantity-<?= $sale_product->id ?>').val();
                                    var status = $(this).attr('status');
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url("client_product_damage_or_defect/reduce_quantity_from_table/") ?>',
                                        data: {'sale_product_id': sale_product_id, 'new_quantity': new_quantity, 'invoice_id': invoice_id, 'product_id': product_id, 'status': status},
                                        success: function (data) {
                                            //alert(data);
                                            $('.client_reduce_product_damage_or_defect_table_block').html(data);
                                            $("#row-<?= $sale_product->id ?>").hide();
                                        },
                                        error: function () {

                                        }
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

    <?php if (!empty($invoice_details->remarks)) { ?>
        <div class="">
            <?php echo '<strong><span class="error-message">*</span>Remarks:</strong> ' . ucfirst($invoice_details->remarks); ?>
        </div>
    <?php } ?>
</div>


