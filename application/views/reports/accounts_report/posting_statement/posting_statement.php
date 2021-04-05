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
                    <h4 class="">Posting Statement</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 posting-statement-form-block">
                        <form class="" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/accounts_report/posting_statement/posting_statement_show_in_table') ?>">

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
                                    <option value="0">All</option>
                                    <?php foreach ($head_details_list as $head) { ?>
                                        <option name="head_id" id="head_id"
                                                value="<?= $head->id ?>"><?= $head->head_name ?></option>
                                            <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-2 show-button-section" style="padding-top: 25px">
                                <label class="" for=""></label>
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>
                            <div class="col-xs-12 col-sm-1 display-none loading-image" style="padding-top: 40px;"></div>
                        </form>

                        <div class="col-xs-12 posting_statement_table">

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
        $('.posting-statement-form-block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $(".posting_statement_table").html(data);
                },
                beforeSend: function () {
                    $('.loading-image').show();
                    $(".show-button-section").hide();
                },
                complete: function () {
                    $('.loading-image').hide();
                    $(".show-button-section").show();
                },
                error: function () {

                }
            });
        });
    });
</script>










