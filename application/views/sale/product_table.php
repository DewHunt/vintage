<div id="product_table_div" class="table-responsive">
    <table class="table table-striped table-bordered table-hover"
           id="product-table">
        <input type="hidden" value="<?= $this->session->userdata('product_total_price') ?>" id="total_session" name="total_session">
        <thead>
            <tr>
                <th>Product</th>
                <th><?= 'Unit Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Quantity</th>
                <th><?= 'Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        $products = $this->session->userdata('products');
        $product_total_price_session = $this->session->userdata('product_total_price');

        /* $product_total_price = 0;

          foreach($products as $product) {
          $product_total_price += $product['price'];
          }
          $this->session->set_userdata('product_total_price',$product_total_price); */
        /* echo '<pre>';
          echo print_r($products);
          echo '</pre>'; */
        ?>
        <tbody>
            <?php
            if (!empty($products)) {
                foreach ($products as $product):
                    ?>
                    <tr>
                        <td><?= $product['product_name'] ?></td>
                        <td><?= get_floating_point_number($product['unit_price'], TRUE) ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td><?= get_floating_point_number($product['price'], TRUE) ?></td>
                        <td>
                            <a data-id="<?= $product['array_id'] ?>" class="btn btn-danger delete-invoice-product-button"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Total</strong></td>
                <td id="total_session"><?= get_floating_point_number($product_total_price_session, TRUE) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>



