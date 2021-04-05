<div id="page-wrapper">
   <!-- <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Branch Wise Stock Report</h2>
        </div>
    </div>-->

    <?php
    $branch_list;
    $from_date = date('Y-m-d');

    /*echo '<pre>';
    echo print_r($periodic_report_list);
    echo '</pre>';*/
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Branch Wise Stock Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 branch-wise-stock-report-form-block">
                        <form class="" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/branch_wise_stock_report/branch_wise_stock_report_show') ?>">

                            <div class="col-xs-12 col-sm-6 report-margin">
                                <select class="form-control" name="branch_id" id="branch_id"
                                        class="form-control">
                                    <option value="0">All</option>
                                    <?php foreach ($branch_list as $branch) { ?>
                                    <option value="<?= $branch->id ?>"><?= ucfirst($branch->branch_name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6 report-margin">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>

                        </form>
                        <div class="col-xs-12 branch-wise-stock-report-table">

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
        $('.branch-wise-stock-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".branch-wise-stock-report-table").html(data);
            });
        });
    });
</script>










