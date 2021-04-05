<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 low-stock-product-list-form-block">
                        <form id="low-stock-product-list-form" class="low-stock-product-list-form" name="low-stock-product-list-form" method="post" action="<?= base_url('product/low_stock_product') ?>">
                            <div class="form-group row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label class="form-control-label" for="branch_id">Outlet</label>
                                    <select class="form-control branch_id" name="branch_id" id="branch_id">
                                        <option value="0">All</option>
                                        <?php
                                        if (!empty($branch_list)) {
                                            foreach ($branch_list as $branch) {
                                                ?>
                                                <option value="<?= intval($branch->id) ?>" <?= (intval($branch_id) === intval($branch->id)) ? 'selected' : '' ?>><?= ucfirst($branch->branch_name) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-4 show-button-section">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary show-button" id="show-button">Show</button>
                                </div>
                                <div class="col-xs-12 col-sm-3 display-none loading-image" style="padding-top: 40px;"></div>
                            </div>

                        </form>

                        <div class="low-stock-product-list-table-section">
                            <?php $this->load->view('product/low_stock_product_list_table', $this->data); ?>
                        </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.low-stock-product-list-form-block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                beforeSend: function () {
                    $('.loading-image').show();
                    $(".show-button-section").hide();
                },
                complete: function () {
                    $('.loading-image').hide();
                    $(".show-button-section").show();
                },
                success: function (data) {
                    $(".low-stock-product-list-table-section").html(data['lowStockProductListTable']);
                },
                error: function () {
                    console.log('Error Occured.');
                }
            });
        });
    });
</script>
