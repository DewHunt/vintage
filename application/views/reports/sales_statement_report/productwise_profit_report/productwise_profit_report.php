<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 productwise-profit-report-form-block">
                        <form id="productwise-profit-report-form" class="productwise-profit-report-form" name="branch-stock-report" method="post" action="<?= base_url('reports/sales_statement_report/productwise_profit_report/productwise_profit_report_show') ?>">
                            <div class="form-group row">
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="search-from-date" for="start_date">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= get_current_date(); ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="search-from-date" for="end_date">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= get_current_date(); ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="form-control-label" for="product_id">Product</label>
                                    <select class="form-control" name="product_id" id="product_id"
                                            class="form-control">
                                        <option value="0">All</option>
                                        <?php foreach ($product_list as $product) { ?>
                                            <option value="<?= intval($product->id) ?>"><?= !empty($product->product_name) ? ucfirst($product->product_name) : '' ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-3 show-button-section">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary show-button" id="show-button">Show</button>
                                </div>
                                <div class="col-xs-12 col-sm-3 display-none loading-image" style="padding-top: 40px;"></div>
                            </div>

                        </form>

                        <div class="productwise-profit-report-table">

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
        $('.productwise-profit-report-form-block form').submit(function (event) {
            event.preventDefault();
            var formClassName = 'productwise-profit-report-form';
            var isValid = dateDurationInsideFormValidation(formClassName);
            if (isValid) {
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
                        $(".productwise-profit-report-table").html(data);
                    },
                    error: function () {
                        console.log('Error Occured.');
                    }
                });
            }
        });
    });
</script>
