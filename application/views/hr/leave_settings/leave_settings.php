<div id="page-wrapper">
    <?php
    $company;
    ?>

    <form id="generate_employee_leave_form" name="generate_employee_leave_form" action="<?= base_url('company/generate_employee_leave') ?>" method="post">
        <div class="create-new-button">
            <button type="submit" class="btn btn-primary create-new-button">Generate Employee Leave</button>
        </div>
    </form>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Leave Settings</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="leave_settings_form" name="leave_settings_form" action="<?= base_url('company/leave_settings_update') ?>" method="post">

                                <div class="form-group row">
                                    <label for="casual_leave" class="col-sm-2 col-xs-12 col-form-label">Casual Leave</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="number" min="0" class="form-control" id="casual_leave" value="<?= !empty($company->casual_leave) ? $company->casual_leave : 0 ?>" name="casual_leave" placeholder="Casual Leave">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="medical_leave" class="col-sm-2 col-xs-12 col-form-label">Medical Leave</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="number" min="0" class="form-control" id="medical_leave" name="medical_leave" value="<?= !empty($company->medical_leave) ? $company->medical_leave : 0 ?>" placeholder="Medical Leave">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="earn_leave" class="col-sm-2 col-xs-12 col-form-label">Earn Leave</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="number" min="0" class="form-control" id="earn_leave" name="earn_leave" value="<?= !empty($company->earn_leave) ? $company->earn_leave : 0 ?>" placeholder="Earn Leave">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                    <div class="col-sm-10 col-xs-12 success-message">
                                        <?php
                                        if ((!empty($this->session->flashdata('leave_settings_success_message')))) {
                                            echo $this->session->flashdata('leave_settings_success_message');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default save-button">Update</button>
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


<script>
    $(document).ready(function () {

        $("form[name='leave_settings_form']").validate({
            rules: {
                casual_leave: "required",
                medical_leave: "required",
                earn_leave: "required",
            },
            messages: {
                casual_leave: "Please Enter Casual Leave",
                medical_leave: "Please Enter Medical Leave",
                earn_leave: "Please Enter Earn Leave",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        /*$("form[name='generate_employee_leave_form']").validate({
         submitHandler: function (form) {
         var result = confirm('Do you want to Generate Employee Leave ?');
         if (result) {
         if (result == true) {
         form.submit();
         } else {
         }
         }
         }
         });*/

    });
</script>