<div id="page-wrapper">
    <?php
    $default_employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_new_target_form" name="create_new_target_form" action="<?= base_url('employee/save_target') ?>" method="post" enctype="multipart/form-data">
                                <div class="col-xs-12 row">
                                    <div class="col-lg-12">
                                        <label for="employee_id" class="col-form-label">Employee</label>
                                        <select class="form-control" id="employee_id" name="employee_id">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($employee_list)) {
                                                foreach ($employee_list as $employee) {
                                                    if (!in_array(intval($employee->id), remove_employee_ids())) {
                                                        ?>
                                                        <option value="<?= intval($employee->id); ?>"><?= $employee->employee_name ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                        <label for="target_start_date" class="col-form-label">Target Start Date</label>
                                        <input type="date" class="form-control target_start_date" id="target_start_date" name="target_start_date" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                        <label for="target_end_date" class="col-form-label">Target End Date</label>
                                        <input type="date" class="form-control target_end_date" id="target_end_date" name="target_end_date" value="" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12">
                                        <label for="target_amount" class="col-form-label">Target Amount</label>
                                        <input type="number" min="0" step="any" class="form-control target_amount" id="target_amount" name="target_amount" value="" placeholder="Target Amount">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4 col-md-2 col-lg-2 right-side-view">
                                        <label for="" class="col-form-label"></label>
                                        <button type="submit" class="btn btn-default save-button">Save</button>
                                    </div>
                                     <div class="form-group col-xs-12 col-sm-4 col-md-2 col-lg-2 right-side-view">
                                        <label for="" class="col-form-label"></label>
                                        <a type="button" href="<?= base_url('employee/employee_target'); ?>" class="btn btn-danger cancel-button">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $("form[name='create_new_target_form']").validate({
            rules: {
                employee_id: "required",
                target_start_date: "required",
                target_amount: {
                    required: true,
                    number: true,
                    min: 0,
                },
            },
            messages: {
                employee_id: "Please Select Employee",
                target_start_date: "Please Select Start Date",
                target_amount: {
                    required: "Please Enter Target Amount",
                    number: "Please Enter valid Tasrget Amount",
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
