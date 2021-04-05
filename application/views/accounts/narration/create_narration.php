<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Create New Expense Head</h2>
        </div>
    </div>-->

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Create New Narration</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_narration_form" name="create_narration_form"
                                  action="<?= base_url('accounts/narration/save_narration') ?>" method="post">

                                <div class="form-group row">
                                    <label for="narration" class="col-sm-2 col-xs-12 col-form-label">Narration</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="narration"
                                               name="narration"
                                               value="" placeholder="Narration">
                                    </div>
                                </div>

                                <?php if(!empty($this->session->flashdata('narration_duplicate_error_message'))){ ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $this->session->flashdata('narration_duplicate_error_message') ?>
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
        $("form[name='create_narration_form']").validate({
            // Specify validation rules
            rules: {
                narration: "required",
            },
            messages: {
                narration: "Please Enter Narration",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>