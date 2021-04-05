<div id="page-wrapper">
    <?php
    $from_date = date('Y-m-d');
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Stock Transfer Challan Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 stock-transfer-challan-report-form-block">

                            <form id="stock_transfer_table_form" name="stock_transfer_table_form"
                                  action="<?= base_url('reports/stock_transfer_challan_report/stock_transfer_challan_report_show_in_table') ?>" method="post">

                                <div class="form-group row">

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
                                        <label class="form-control-label" for="from_branch_id">From Outlet</label>
                                        <select class="form-control" name="from_branch_id" id="from_branch_id"
                                                class="form-control">
                                            <option value="0">All</option>
                                            <?php foreach ($branch_list as $branch) { ?>
                                                <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="form-control-label" for="to_branch_id">To Outlet</label>
                                        <select class="form-control" name="to_branch_id" id="to_branch_id"
                                                class="form-control">
                                            <option value="0">All</option>
                                            <?php foreach ($branch_list as $branch) { ?>
                                                <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary right-side-view stock-transfer-challan-report-button" id="show-button">Show</button>
                            </form>

                            <div class="col-xs-12 branch-wise-stock-transfer-challan-report-table">

                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
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
        $('.stock-transfer-challan-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".branch-wise-stock-transfer-challan-report-table").html(data);
            });
        });
    });
</script>










