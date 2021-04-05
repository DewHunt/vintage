<div id="page-wrapper">
    <?php
    $from_date = date('Y-m-d');

    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Branchwise Periodic Item Stock Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 branchwise-item-stock-report-form-block">
                        <form class="" name="stock-transfer-report" method="post"
                              action="<?= base_url('reports/branchwise_periodic_item_report/branchwise_periodic_item_report_show') ?>">

                            <div class="form-group col-xs-12 col-sm-3">
                                <label class="search-from-date" for="start_date">From</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                       value="<?= $from_date ?>">
                            </div>

                            <div class="form-group col-xs-12 col-sm-3">
                                <label class="search-from-date" for="end_date">To</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                       value="<?= $from_date ?>">
                            </div>

                            <div class="form-group col-xs-12 col-sm-3">
                                <label class="branch_id" for="branch_id">Outlet</label>
                                <select class="form-control" name="branch_id" id="branch_id"
                                        class="form-control">
                                    <option value="0">Please Select</option>
                                    <?php foreach ($branch_list as $branch) { ?>
                                        <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-3">
                                <label class="product_id" for="product_id">Product</label>
                                <select class="form-control" name="product_id" id="product_id"
                                        class="form-control">
                                     <option value="0">Please Select</option>
                                    <?php foreach ($product_list as $product) { ?>
                                        <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-primary right-side-view" id="show-button">Show</button>
                            </div>

                        </form>

                        <div class="col-xs-12 branchwise-item-stock-report-table">

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
        $('.branchwise-item-stock-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".branchwise-item-stock-report-table").html(data);
            });
        });
    });
</script>
