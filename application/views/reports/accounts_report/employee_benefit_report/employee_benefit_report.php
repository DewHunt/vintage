<div id="page-wrapper">
    <div class="clearfix"></div>

    <?php
    $company_information;
    $employee_list;
    $head_details_list;
    $from_date = date('Y-m-d');

    $first_day_current_month = date('Y-m-01'); // hard-coded '01' for first day
    $last_day_current_month = date('Y-m-t');

    $current_month = date('F');
    $current_year = date('Y');
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Benefit Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 employee-benefit-report-form-block">
                            <form class="" name="branch-stock-report" method="post"
                                  action="<?= base_url('reports/accounts_report/employee_benefit_report/employee_benefit_report_show') ?>">
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="start_date">From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                               value="<?= $first_day_current_month; ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="end_date">To</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                               value="<?= $last_day_current_month; ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label for="employee_id" class="col-form-label">Employee</label>
                                        <label class="employee_id" for="employee_id"></label>
                                        <select class="form-control" name="employee_id" id="employee_id"
                                                class="form-control">
                                            <option value="0">All</option>
                                            <?php foreach ($employee_list as $employee) { ?>
                                                <option name="employee_id" id="employee_id"
                                                        value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                                    <?php } ?>
                                        </select>
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
                                    <div class="form-group row">
                                        <button type="submit" class="btn btn-primary save-button employee-benefit-show-button" id="show-button">Show </button>
                                    </div>

                                </div>

                            </form>

                            <div class="col-xs-12 employee_benefit_report_table">

                            </div>
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
</div>
<!-- /#page-wrapper -->


<script type="text/javascript">
    $(document).ready(function () {
        $('.employee-benefit-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee_benefit_report_table").html(data);
            });
        });
    });
</script>
