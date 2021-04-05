<?php
$user_info = $this->session->userdata('user_session');
$user_type = $user_info['user_type'];
$print_access = $user_info['print_access'];
?>
<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Outlet: <?= !empty($branch_name) ? ucfirst($branch_name) : ''; ?></label>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button low-stock-product-list-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="table-responsive table-bordered" style="width: 100%;">
        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product</th>
                    <th>Pack Size</th>
                    <th>Outlet</th>
                    <th class="text-right">Stock</th>
                    <th class="text-right">Reorder Level</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total_stock = 0;
                if (!empty($low_stock_product_by_branch_id)) {
                    foreach ($low_stock_product_by_branch_id as $low_stock_product) {
                        $product_name = !empty($low_stock_product->product_name) ? ucfirst($low_stock_product->product_name) : '';
                        $pack_size = !empty($low_stock_product->pack_size) ? ($low_stock_product->pack_size) : '';
                        $name_of_branch = !empty($low_stock_product->branch_name) ? ucfirst($low_stock_product->branch_name) : '';
                        $stock = $low_stock_product->stock;
                        $reorder_level = $low_stock_product->reorder_level;
                        $total_stock += $stock;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $product_name; ?></td>
                            <td><?= $pack_size; ?></td>
                            <td><?= $name_of_branch; ?></td>
                            <td class="text-right"><?= get_floating_point_number($stock, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($reorder_level, TRUE) ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong></strong></td>
                        <td class="text-right"><strong></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_stock, TRUE) ?></strong></td>
                        <td class="text-right"><strong></strong></td>
                    </tr>
                <?php }
                ?>                
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="productwise-profit-report-table-print-section" style="display: none; width: 100%" >
    <style>
        .print-table {
            width: 100%;
            border-collapse: collapse !important;
            border: 2px solid;            
        }
        .print-table th{
            text-align: center; 
            font-weight: bold; 
            background-color: black; 
            color: white; 
            font-size: 18px;
        }
        .print-table th,
        .print-table td {
            border: 1px solid #ddd !important;
        }
        .text-right{
            text-align: right;
        }
    </style>
    <?php $this->load->view('reports/company_info_as_report_header', $this->data); ?>
    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong><?= !empty($page_title) ? $page_title : ''; ?></strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Outlet: <?= !empty($branch_name) ? ucfirst($branch_name) : ''; ?></label>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product</th>
                <th>Pack Size</th>
                <th>Outlet</th>
                <th class="text-right">Stock</th>
                <th class="text-right">Reorder Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total_stock = 0;
            if (!empty($low_stock_product_by_branch_id)) {
                foreach ($low_stock_product_by_branch_id as $low_stock_product) {
                    $product_name = !empty($low_stock_product->product_name) ? ucfirst($low_stock_product->product_name) : '';
                    $pack_size = !empty($low_stock_product->pack_size) ? ($low_stock_product->pack_size) : '';
                    $name_of_branch = !empty($low_stock_product->branch_name) ? ucfirst($low_stock_product->branch_name) : '';
                    $stock = $low_stock_product->stock;
                    $reorder_level = $low_stock_product->reorder_level;
                    $total_stock += $stock;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $product_name; ?></td>
                        <td><?= $pack_size; ?></td>
                        <td><?= $name_of_branch; ?></td>
                        <td class="text-right"><?= get_floating_point_number($stock, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($reorder_level, TRUE) ?></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right"><strong></strong></td>
                    <td class="text-right"><strong></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_stock, TRUE) ?></strong></td>
                    <td class="text-right"><strong></strong></td>
                </tr>
            <?php }
            ?>            
        </tbody>
    </table>
</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $(".low-stock-product-list-table-print-button").click(function () {
            var divContents = $('#productwise-profit-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

