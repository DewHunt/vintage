<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">ClientWise Sale Report</h2>
        </div>
    </div>-->

    <?php
    $from_date = date('Y-m-d');
    $head_details_list;
    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Head Transaction Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 head-transaction-report-form-block">
                        <form class="" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/accounts_report/head_transaction_report/Head_transaction_report_show_in_table') ?>">

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
                                <label for="head_id" class="col-form-label">Head</label>
                                <label class="head_id" for="head_id"></label>
                                <select class="form-control" name="head_id" id="head_id"
                                        class="form-control">
                                    <!--<option value="0">Please Select</option>-->
                                    <?php foreach ($head_details_list as $head) { ?>
                                        <option name="head_id" id="head_id"
                                                value="<?= $head->id ?>"><?= $head->head_name ?></option>
                                            <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-3" style="padding-top: 25px">
                                <label class="" for=""></label>
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>
                        </form>

                        <div class="col-xs-12 head_transaction_report_table">

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
        $('.head-transaction-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".head_transaction_report_table").html(data);
            });
        });
    });
</script>










