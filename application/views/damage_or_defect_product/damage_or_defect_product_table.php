<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="product-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th>Product Name</th>
                <th width="150px">Quantity</th>
                <th width="20px">Action</th>
            </tr>
        </thead>

        <?php $damage_or_defect_product_table_array = $this->session->userdata('damage_or_defect_product_table_array'); ?>
        <tbody>
            <?php $count = 1; ?>
            <?php if (!empty($damage_or_defect_product_table_array)): ?>
                <?php foreach ($damage_or_defect_product_table_array as $damage_or_defect_product): ?>
                    <?php
                        $product_name_part_1 = '';
                        $product_name_part_2 = '';
                        if (strpos(($damage_or_defect_product['product_name']), '#') !== FALSE) {
                            $product_name = explode("#", ($damage_or_defect_product['product_name']));
                            $product_name_part_1 = $product_name[0];
                            $product_name_part_2 = $product_name[1];
                        } else {
                            $product_name_part_1 = $damage_or_defect_product['product_name'];
                        }
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $product_name_part_1 ?></td>
                        <td><?= $damage_or_defect_product['quantity'] ?></td>
                        <td>
                            <a href="<?= base_url("damage_or_defect_product/delete_damage_or_defect_product_details_from_table/" . $damage_or_defect_product['array_id']) ?>"
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
