<div id="page-wrapper">

    <?php
    $from_date = date('Y-m-d');
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Product Receive Challan Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 product-receive-challan-report-form-block">
                        <form class="" name="stock-transfer-report" method="post"
                              action="<?= base_url('reports/product_receive_challan_report/product_receive_challan_report_show_in_table') ?>">

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
                                    <option value="0">All</option>
                                    <?php foreach ($branch_list as $branch) { ?>
                                        <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-3 show-button-padding-top">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>

                        </form>

                        <div class="col-xs-12 branch-wise-product-receive-challan-report-table">

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
        $('.product-receive-challan-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".branch-wise-product-receive-challan-report-table").html(data);
            });
        });
    });
</script>










