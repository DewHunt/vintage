<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Total Leave Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 employee_leave_report_form_block">
                        <form class="" name="employee_leave_report_form" method="post"
                              action="<?= base_url('reports/hr_report/employee_leave_report/employee_leave_report/employee_leave_report_show_in_table') ?>">

                            <div class="form-group col-xs-12 col-sm-4">
                                <label for="year" class="col-form-label">Year</label>
                                <select name="year" id="year" class="form-control">
                                    <option value="" name="month">Please Select</option>
                                    <?php
                                    $current_year = get_current_year();
                                    foreach (get_start_year_to_current_year_array() as $year) {
                                        ?>
                                        <option <?= (string) $year == (string) $year ? "selected='selected'" : '' ?> value="<?= $year ?>" name="year"><?= $year ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-4">
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
                            <div class="form-group col-xs-12 col-sm-4 show-button-padding-top">
                                <label class="" for=""></label>
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>
                        </form>

                        <div class="col-xs-12 employee_leave_report_table">

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
        $('.employee_leave_report_form_block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee_leave_report_table").html(data);
            });
        });
    });
</script>










