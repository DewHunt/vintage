<div class="table-responsive">

    <?php
    $reduce_product_list_table_array;
    ?>

    <table class="table table-striped table-bordered table-hover table-responsive"
           id="product-table">

        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Pack Size</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $amount = 0;
            $total_amount = 0;
            if (!empty($reduce_product_list_table_array)) {
                foreach ($reduce_product_list_table_array as $reduce_product) {
                    ?>
                    <?= $amount = $reduce_product['unit_price'] * $reduce_product['quantity'] ?>
                    <?= $total_amount += $amount ?>
                    <?php
                    $product_name_part_1 = '';
                    $product_name_part_2 = '';
                    $product = $this->Product_Model->get_product($reduce_product['product_id']);
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
                        <td><?= $amount ?></td>
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
                <td><strong><?= number_format((double) $total_amount, 2) ?></strong></td>
            </tr>
        </tbody>

    </table>

</div>
