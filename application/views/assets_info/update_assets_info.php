<div id="page-wrapper">
    <?php
    //$entry_date = date('Y-m-d');
    $assets_info;
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Update Asset Information</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="update_assets_info_form" name="update_assets_info_form" action="<?= base_url('assets_info/update') ?>" method="post">

                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $assets_info->id ?>">
                                <div class="form-group row">
                                    <label for="assets_name" class="col-sm-2 col-xs-12 col-form-label">Asset Name</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="assets_name" name="assets_name" value="<?= $assets_info->assets_name ?>" placeholder="Asset Name">
                                    </div>
                                </div>

                                <?php if (!empty($this->session->flashdata('assets_name_duplicate_error_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?php echo $this->session->flashdata('assets_name_duplicate_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="assets_code" class="col-sm-2 col-xs-12 col-form-label">Asset Code</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="assets_code" name="assets_code" value="<?= $assets_info->assets_code ?>" placeholder="Asset Code">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="assets_quantity" class="col-sm-2 col-xs-12 col-form-label">Quantity</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="number" min="0" class="form-control" id="assets_quantity"
                                               name="assets_quantity" value="<?= $assets_info->assets_quantity ?>" placeholder="Quantity">
                                    </div>
                                </div>

                                <?php if (!empty($this->session->flashdata('assets_quantity_error_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?php echo $this->session->flashdata('assets_quantity_error_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="entry_date" class="col-sm-2 col-xs-12 col-form-label">Entry Date</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <?php $entry_date = date("Y-m-d", strtotime($assets_info->entry_date)); ?>
                                        <input type="date" min="0" class="form-control" id="entry_date" name="entry_date" value="<?= !empty($entry_date) ? $entry_date : get_current_date() ?>">
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

        $("form[name='update_assets_info_form']").validate({
            rules: {
                assets_name: "required",
                assets_quantity: "required",
                entry_date: "required",
            },
            messages: {
                assets_name: "Please Enter Name",
                assets_quantity: "Please Enter Quantity",
                entry_date: "Please Enter Date",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>