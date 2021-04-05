<div id="order_sheet_table_div" class="table-responsive">
    <table class="table table-striped table-bordered table-hover"
           id="product-table">
        <input type="hidden" value="<?= $this->session->userdata('order_sheet_total_price') ?>" id="total_session" name="total_session">
        <thead>
            <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th><?= 'Price ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        $order_sheet_table_array_info = $this->session->userdata('order_sheet_table_array');
        $order_sheet_total_price_session = $this->session->userdata('order_sheet_total_price');
        ?>

        <tbody>
            <?php foreach ($order_sheet_table_array_info as $product): ?>
                <tr>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= $product['fixed_price'] ?></td>
                    <td><?= $product['quantity'] ?></td>
                    <td><?= $product['total_amount'] ?></td>
                    <td>
                        <a href="<?= base_url("order_sheet/delete_product_in_order_sheet_table/" . $product['array_id']) ?>"
                           class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Total</strong></td>
                <td id="total_session"><?= $order_sheet_total_price_session ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <button class="pull-right btn btn-danger order-sheet-table-clear-button">Clear</button>
</div>

<script>
$('.order-sheet-table-clear-button').click(function () {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("order_sheet/get_order_sheet_table_array_clear/") ?>',
            data: {},
            success: function (data) {
                $('.error-message').hide();
                $('#order_sheet_table_div').hide();
            },
            error: function () {

            }
        });
    });
</script>



