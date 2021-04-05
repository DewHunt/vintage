<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 itemwise-sales-report-form-block">
                        <form id="itemwise-sales-report-form" class="itemwise-sales-report-form" name="itemwise-sales-report" method="post" action="<?= base_url('reports/sales_department_reports/itemwise_sales_report/itemwise_sales_report_show_in_table') ?>">
                            <div class="form-group row">
                                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                    <label class="search-from-date" for="start_date">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= get_current_date(); ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                    <label class="search-from-date" for="end_date">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= get_current_date(); ?>">
                                </div>
                                <?php if (strtolower($user_type) === 'marketing') { ?>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-10">
                                        <label class="" for="employee_id">Employee</label>
                                        <select class="form-control" name="employee_id[]" id="employee_id" class="form-control">
                                            <option value="<?= intval($employee_info->id) ?>"><?= !empty($employee_info->employee_name) ? $employee_info->employee_name : ''; ?></option>
                                        </select>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-10">
                                        <label class="" for="employee_id">Employee</label>
                                        <select name="employee_id[]" id="employee_id" class="form-control select2" multiple="multiple">
                                            <?php
                                            if (!empty($employee_list)) {
                                                foreach ($employee_list as $employee) {
                                                    $emp_id = intval($employee->id);
                                                    if (!in_array($emp_id, remove_employee_ids())) {
                                                        ?>
                                                        <option value="<?= $emp_id ?>"><?= !empty($employee->employee_name) ? $employee->employee_name : ''; ?></option>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-xs-12 col-sm-12 col-md-2 show-button-section">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary show-button" id="show-button">Show</button>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 display-none loading-image" style="padding-top: 40px;"></div>
                            </div>
                        </form>
                        <div class="itemwise-sales-report-table">

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

        $(function () {
            $('#start_month_year').monthpicker({
                className: '.start-month-picker',
                years: [<?= (implode(',', array_reverse(get_start_year_to_current_year_array()))) ?>],
                topOffset: 6,
                onMonthSelect: function (m, y) {
//                    console.log('Month: ' + m + ', year: ' + y);
                    $('#start_month_year').val('' + GetMonthName(m) + '- ' + y);
                }
            });
            $('#end_month_year').monthpicker({
                className: '.end-month-picker',
                years: [<?= (implode(',', array_reverse(get_start_year_to_current_year_array()))) ?>],
                topOffset: 6,
                onMonthSelect: function (m, y) {
//                    console.log('Month: ' + m + ', year: ' + y);
                    $('#end_month_year').val('' + GetMonthName(m) + '- ' + y);
                }
            });
        });

        $(".select2").select2({
            placeholder: "All",
        });

        $('.itemwise-sales-report-form-block form').submit(function (event) {
            event.preventDefault();
            var formClassName = 'itemwise-sales-report-form';
            var isValid = dateDurationInsideFormValidation(formClassName);
            if (isValid) {
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function () {
                        $('.loading-image').show();
                        $(".show-button-section").hide();
                    },
                    complete: function () {
                        $('.loading-image').hide();
                        $(".show-button-section").show();
                    },
                    success: function (data) {
                        $(".itemwise-sales-report-table").html(data);
                    },
                    error: function () {
                        console.log('Error Occured.');
                    }
                });
            }
        });

    });
</script>
