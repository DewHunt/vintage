<?php
$product_obj = new Product_reorder_level_Model();
$low_stock_product_by_branch_id_result = $product_obj->branchwise_low_stock_prooduct();
?>
<div class="row">
    <?php
    if (!empty($low_stock_product_by_branch_id_result)) {
        foreach ($low_stock_product_by_branch_id_result as $low_stock_product_count) {
            $branch_id = !empty($low_stock_product_count) ? intval($low_stock_product_count['branch_id']) : 0;
            $branch_name = !empty($low_stock_product_count) ? $low_stock_product_count['branch_name'] : '';
            $count_low_stock_product = !empty($low_stock_product_count) ? $low_stock_product_count['count_low_stock_product'] : '';
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 sol-xs-12">
                <div class="panel panel-default">
                    <a href="<?= base_url('product/low_stock_product/' . $branch_id); ?>">
                        <div class="panel-footer">
                            <span class="pull-left"><strong><?= $branch_name; ?><br>Low Stock Products</strong></span>
                            <span class="pull-right"><strong style="line-height: 40px; font-size: 16px;"><?= $count_low_stock_product; ?></strong></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
