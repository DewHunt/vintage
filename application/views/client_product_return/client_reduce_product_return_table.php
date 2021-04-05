<div class="table-responsive reduce-product-table-block">
    <?php $reduce_product_list_table_array; ?>

    <h5><strong>Return information Details : </strong></h5>
    <table class="table table-striped table-bordered table-hover table-responsive" id="product-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Pack Size</th>
                <th>Quantity</th>
                <!--<th><?= 'Unit Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>-->
                <th><?= 'Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $amount = 0;
            $total_amount = 0;
            $total_return_amount = 0;
            if (!empty($reduce_product_list_table_array)) {
                foreach ($reduce_product_list_table_array as $reduce_product) {
                    ?>
                    <?php $amount = $reduce_product['unit_price'] * $reduce_product['quantity'] ?>
                    <?php $total_amount += (double) $amount ?>
                    <?php $total_return_amount += (double) $reduce_product['return_amount'] ?>
                    <?php
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    $product = $this->Product_Model->getProductById($reduce_product['product_id']);
                    if (strpos(($product->product_name), '#') !== FALSE) {
                        $product_name = explode("#", ($product->product_name));
                        $product_name_part_1 = $product_name[0];
                        $product_name_part_2 = $product_name[1];
                    } else {
                        $product_name_part_1 = $product->product_name;
                    }
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $product_name_part_1 ?></td>
                        <td><?= $product->pack_size ?></td>
                        <td><?= $reduce_product['quantity'] ?></td>
                        <!--<td><?= $reduce_product['unit_price'] ?></td>-->
                        <td><?= number_format((double) $reduce_product['return_amount'], 2) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td><? ?></td>
                <td><??></td>
                <td><??></td>
                <td><strong>Total</strong></td>
                <td><strong><?= get_floating_point_number($total_return_amount); ?></strong></td>
            </tr>
            <?php if (($invoice_amount_to_paid) == 0) { ?>
                <tr>
                    <td><? ?></td>
                    <td><??></td>
                    <td><??></td>
                    <td><strong>Deduction For This Transaction</strong></td>
                    <td><strong><?= get_floating_point_number($total_return_amount); ?></strong></td>
                </tr>
                <tr>
                    <td><? ?></td>
                    <td><??></td>
                    <td><??></td>
                    <td><strong>Return Amount For This Invoice</strong></td>
                    <td><strong><?= get_floating_point_number(0); ?></strong></td>
                </tr>
            <?php }
            ?>
        </tbody>

    </table>
    <?php if (($invoice_amount_to_paid) == 0) { ?>
        <div class="form-group col-xs-12 col-sm-6">
            <label for="current_deduction" class="col-form-label">Current Deduction For This Invoice</label>
            <input readonly="readonly" class="form-control" type="number" min="0" id="current_deduction" name="current_deduction" value="<?= !empty($current_deduction) ? get_floating_point_number($current_deduction) : get_floating_point_number(0); ?>" placeholder="Current Deduction">
        </div>
    <?php }
    ?>
    <button class="pull-right btn btn-danger reduce-product-table-clear-button">Clear</button>
</div>


<script>
    $('.reduce-product-table-clear-button').click(function () {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("client_product_return/get_reduce_product_table_array_clear/") ?>',
            data: {},
            success: function (data) {
                $('.error-message').hide();
                $('.reduce-product-table-block').hide();
                $('.invoice-void-button').removeClass('invoice-void-button-disable');
            },
            error: function () {

            }
        });
    });
</script>