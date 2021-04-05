<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 employee-details-ledger-report-form-block">
                            <form id="employee_details_ledger_report_form" name="employee_details_ledger_report_form" action="<?= base_url('reports/employeewise_ledger_report/employeewise_ledger_report_show_in_table') ?>" method="post">
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="start_date">From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= get_current_date(); ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="end_date">To</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= get_current_date(); ?>">
                                    </div>
                                    <?php if (strtolower($user_type) === 'marketing') { ?>
                                        <div class="form-group col-xs-12 col-sm-3">
                                            <label class="" for="employee_id">Employee</label>
                                            <select class="form-control" name="employee_id" id="employee_id" class="form-control">
                                                <option value="<?= intval($employee_info->id) ?>"><?= !empty($employee_info->employee_name) ? $employee_info->employee_name : ''; ?></option>
                                            </select>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group col-xs-12 col-sm-3">
                                            <label class="" for="employee_id">Employee</label>
                                            <select class="form-control" name="employee_id" id="employee_id" class="form-control">
                                                <option value="0">All</option>
                                                <?php foreach ($employee_list as $employee) { ?>
                                                    <option value="<?= intval($employee->id) ?>"><?= !empty($employee->employee_name) ? $employee->employee_name : ''; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group col-xs-12 col-sm-3 show-button-section" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-3 display-none loading-image pull-right" style="padding-top: 40px;"></div>
                                </div>
                            </form>
                            <div class="col-xs-12 employee-details-ledger-report-table">

                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
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
        $('.employee-details-ledger-report-form-block form').submit(function (event) {
            event.preventDefault();
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
                    $(".employee-details-ledger-report-table").html(data);
                },
                error: function () {

                }
            });

        });
    });
</script>