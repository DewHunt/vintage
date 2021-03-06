<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Create New Expense Head</h2>
        </div>
    </div>-->

    <?php

    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Create New Holiday</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_holidays_settings_form" name="create_holidays_settings_form"
                                  action="<?= base_url('settings/holidays_settings/save_holidays_settings') ?>"
                                  method="post">

                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-xs-12 col-form-label">Title</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="title" name="title"
                                               value="" placeholder="Title">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description"
                                           class="col-sm-2 col-xs-12 col-form-label">Description</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <textarea class="form-control" id="description" name="description" rows="3"
                                                  placeholder="Description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="event_date" class="col-sm-2 col-xs-12 col-form-label">Date</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="date" class="form-control" id="event_date" name="event_date"
                                               value="">
                                    </div>
                                </div>

                                <?php if (!empty($this->session->flashdata('holiday_duplicate_error_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>

                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $this->session->flashdata('holiday_duplicate_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <button type="submit" class="btn btn-default save-button">Save</button>

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
        $("form[name='create_holidays_settings_form']").validate({
            // Specify validation rules
            rules: {
                title: "required",
                description: "required",
                event_date: "required",
            },
            messages: {
                title: "Please Enter Title",
                description: "Please Enter Description",
                event_date: "Please Enter Date",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>