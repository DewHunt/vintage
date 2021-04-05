<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Wise Sales Details Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 employee-wise-report-form-block">
                        <form class="" name="order-report" method="post" action="<?= base_url('reports/employee_wise_report/employee_wise_report_show') ?>">

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

                            <?php if (strtolower($user_type) === 'marketing') { ?>
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="" for="employee_id">Employee</label>
                                    <select class="form-control" name="employee_id" id="employee_id"
                                            class="form-control">
                                        <option value="<?= $employee_info->id ?>"><?= $employee_info->employee_name ?></option>
                                    </select>
                                </div>

                            <?php } else { ?>

                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="" for="employee_id">Employee</label>
                                    <select class="form-control" name="employee_id" id="employee_id"
                                            class="form-control">
                                        <option value="0">All</option>
                                        <?php foreach ($employee_list as $employee) { ?>
                                            <option value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            <?php } ?>

                            <div class="form-group col-xs-12 col-sm-3" style="padding-top: 25px">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>                           

                        </form>
                        <div class="col-md-12 col-xs-12 employee-wise-report-table">

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
        $('.employee-wise-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee-wise-report-table").html(data);
            });
        });
    });
</script>








