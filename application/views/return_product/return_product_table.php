<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-responsive" id="product-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th>Product Name</th>
                <th width="150px">Quantity</th>
                <th width="20px">Action</th>
            </tr>
        </thead>

        <?php $return_product_table_array = $this->session->userdata('return_product_table_array'); ?>

        <tbody>
            <?php $count = 1; ?>
            <?php if ($return_product_table_array): ?>
                <?php foreach ($return_product_table_array as $return_product): ?>
                    <?php
                        $product_name_part_1 = '';
                        $product_name_part_2 = '';
                        if (strpos(($return_product['product_name']), '#') !== FALSE) {
                            $product_name = explode("#", ($return_product['product_name']));
                            $product_name_part_1 = $product_name[0];
                            $product_name_part_2 = $product_name[1];
                        } else {
                            $product_name_part_1 = $return_product['product_name'];
                        }
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $product_name_part_1 ?></td>
                        <td><?= $return_product['quantity'] ?></td>
                        <td>
                            <a href="<?= base_url("return_product/delete_return_product_details_from_table/" . $return_product['array_id']) ?>"
                               class="btn btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>
