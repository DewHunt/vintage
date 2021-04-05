<div id="page-wrapper">
    <?php
    $currency_settings;
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Currency Settings</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="currency_settings_form" name="currency_settings_form" action="<?= base_url('settings/currency_settings/save_currency_settings') ?>" method="post">
                                <input type="hidden" id="id" name="id" value="<?= !empty($currency_settings->id) ? $currency_settings->id : '' ?>">

                                <?php if (!empty($this->session->flashdata('currency_settings_save_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 success-message text-align-center">
                                            <?php echo $this->session->flashdata('currency_settings_save_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group row">
                                    <label for="currency_symbol" class="col-sm-2 col-xs-12 col-form-label">Currency Symbol</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input class="form-control" type="text" id="currency_symbol" name="currency_symbol" value="<?= !empty($currency_settings->currency_symbol) ? $currency_settings->currency_symbol : '' ?>" placeholder="Currency Symbol">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="currency_name" class="col-sm-2 col-xs-12 col-form-label">Currency Name</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input class="form-control" type="text" id="currency_name" name="currency_name" value="<?= !empty($currency_settings->currency_name) ? $currency_settings->currency_name : '' ?>" placeholder="Currency Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="placement" class="col-sm-2 col-xs-12 col-form-label">Placement</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <select name="placement" class="form-control" id="placement">
                                            <option value="">Please Select</option>
                                            <option value="left" <?= (!empty($currency_settings->placement) == 'left') ? 'selected' : '' ?>>Left</option>
                                            <option value="right" <?= (!empty($currency_settings->placement) == 'right') ? 'selected' : '' ?>>Right</option>
                                        </select>
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
        $("form[name='currency_settings_form']").validate({
            rules: {
                currency_symbol: "required",
                currency_name: "required",
                placement: "required",
            },
            messages: {
                currency_symbol: "Please Enter a Symbol",
                currency_name: "Please Enter a Symbol",
                placement: "Please Select Placement",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>