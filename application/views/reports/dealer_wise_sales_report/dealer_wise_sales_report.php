<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">ClientWise Sale Report</h2>
        </div>
    </div>-->

    <?php
    $dealer_list;
    $from_date = date('Y-m-d');

    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">DealerWise Sale Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 dealer-wise-sales-report-form-block">
                        <form class="" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/dealer_wise_sales_report/dealer_wise_sales_report_show') ?>">


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
                                <label class="" for="end_date">Dealer</label>
                                <label class="dealer_id" for="dealer_id"></label>
                                <select class="form-control" name="dealer_id" id="dealer_id"
                                        class="form-control">
                                    <option value="0">All</option>
                                    <?php foreach ($dealer_list as $dealer) { ?>
                                        <option value="<?= $dealer->id ?>"><?= $dealer->dealer_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-12 col-sm-3" style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>
                        </form>

                        <div class="col-xs-12 dealer-wise-sales-report-table">

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
        $('.dealer-wise-sales-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".dealer-wise-sales-report-table").html(data);
            });
        });
    });
</script>










