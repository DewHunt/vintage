<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="create-new-button">
            <?php echo anchor(base_url('employee_own_leave_application/employee_own_leave_application'), '<i class=" fa fa-plus" aria-hidden="true"></i> New Leave Application', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">My Leave Application List</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 employee_own_leave_application_form_block">
                        <form class="" id="employee_own_leave_application_form" name="employee_own_leave_application_form" method="post" action="<?= base_url('employee_own_leave_application/employee_own_leave_application_show_in_table') ?>">

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
                                <label for="application_status" class="col-form-label">Status</label>
                                <select class="form-control" name="application_status" id="application_status" class="form-control">
                                    <option value="all">All</option>
                                    <option value="accept">Accept</option>
                                    <option value="reject">Reject</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                            <div class="form-group col-xs-12 col-sm-4 show-button-padding-top" style="padding-top: 40px">
                                <label class="" for=""></label>
                                <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                            </div>
                        </form>

                        <div class="col-xs-12 employee_own_leave_application_table">

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
        $('.employee_own_leave_application_form_block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee_own_leave_application_table").html(data);
            });
        });
    });
</script>










