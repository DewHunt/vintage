<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Create New Weekend Day</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_weekend_settings_form" name="create_weekend_settings_form"
                                  action="<?= base_url('settings/weekend_settings/save_weekend_settings') ?>"
                                  method="post">

                                <div class="form-group row">
                                    <label for="weekend_day" class="col-sm-2 col-xs-12 col-form-label">Weekend
                                        Day</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <select name="weekend_day" id="weekend_day" class="form-control">
                                            <option value="" id="weekend_day" name="weekend_day">Please Select</option>
                                            <?php
                                            $timestamp = strtotime('next Friday');
                                            $days = array();
                                            for ($i = 0; $i < 7; $i++) {
                                                $days[] = strftime('%A', $timestamp);
                                                ?>
                                                <option value="<?= strtolower($days[] = strftime('%A', $timestamp)); ?>"
                                                        id="weekend_day" name="weekend_day"><?= $days[] = strftime('%A', $timestamp) ?></option>
                                                        <?php
                                                        $timestamp = strtotime('+1 day', $timestamp);
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if (!empty($this->session->flashdata('weekend_day_duplicate_error_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $this->session->flashdata('weekend_day_duplicate_error_message') ?>
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
        $("form[name='create_weekend_settings_form']").validate({
            rules: {
                weekend_day: "required",
            },
            messages: {
                weekend_day: "Please Select Weekend Day",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>