<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">ClientWise Sale Report</h2>
        </div>
    </div>-->

    <?php
    $head_details_list;
    $from_date = date('Y-m-d');

    /*echo '<pre>';
    echo print_r($periodic_report_list);
    echo '</pre>';*/
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Head Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 head-report-form-block">
                        <form class="form-inline form-margin" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/accounts_report/head_report/head_report_show_in_table') ?>">

                            <div class="form-group form-margin">
                                <label class="head_id" for="head_id"></label>
                                <select class="form-control" name="head_id" id="head_id"
                                        class="form-control">
                                    <option value="0">All</option>
                                    <?php foreach ($head_details_list as $head_details) { ?>
                                        <option id="head_id" name="head_id"
                                                value="<?= $head_details->id ?>"><?= $head_details->head_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="" for=""></label>
                            <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                        </form>

                        <div class="col-xs-12 head-report-table">

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
        $('.head-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".head-report-table").html(data);
            });
        });
    });
</script>
