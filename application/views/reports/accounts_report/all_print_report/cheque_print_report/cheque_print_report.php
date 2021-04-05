<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Cheque Print Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 cheque-print-report-form-block">
                        <form class="" name="cheque_print_report_form" method="post"
                              action="<?= base_url('reports/accounts_report/all_print_report/cheque_print_report/cheque_print_report_show_in_table') ?>">
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="search-from-date" for="start_date">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                           value="<?= get_current_date() ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="search-from-date" for="end_date">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           value="<?= get_current_date() ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4" style="padding-top: 24px">
                                    <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                                </div>
                            </div>

                        </form>

                        <div class="form-group col-md-12 col-xs-12 cheque-print-report-table" style="margin-top: 10px">

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
        $('.cheque-print-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".cheque-print-report-table").html(data);
            });
        });
    });
</script>







