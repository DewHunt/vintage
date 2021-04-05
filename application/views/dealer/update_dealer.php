<div id="page-wrapper">
    <?php
    $dealer;
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Update Dealer Information</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="update_dealer_form" name="update_dealer_form" action="<?= base_url('dealer/update') ?>" method="post">

                                <?php if (!empty($this->session->flashdata('dealer_name_duplicate_error_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>

                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $this->session->flashdata('dealer_name_duplicate_error_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $dealer->id ?>">
                                <div class="form-group row">
                                    <label for="dealer_name" class="col-sm-2 col-xs-12 col-form-label">Dealer Name</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="dealer_name" name="dealer_name" value="<?= $dealer->dealer_name ?>" placeholder="Dealer Name">
                                    </div>
                                    <label for="dealer_code" class="col-sm-2 col-xs-12 col-form-label">Dealer Code</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="dealer_code" name="dealer_code" value="<?= $dealer->dealer_code ?>" placeholder="Dealer Code">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cell_number" class="col-sm-2 col-xs-12 col-form-label">Cell Number</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="cell_number" name="cell_number" value="<?= $dealer->cell_number ?>" placeholder="Cell Number">
                                    </div>
                                    <label for="phone_number" class="col-sm-2 col-xs-12 col-form-label">Phone Number</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $dealer->phone_number ?>" placeholder="Phone Number">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-xs-12 col-form-label">Email</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $dealer->email ?>" placeholder="Email">
                                    </div>
                                    <label for="address" class="col-sm-2 col-xs-12 col-form-label">Address</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <textarea class="form-control" rows="3" id="address" name="address" placeholder="Address"><?= $dealer->address ?></textarea>
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

        $("form[name='update_dealer_form']").validate({
            rules: {
                dealer_name: "required"
            },
            messages: {
                dealer_name: "Please Enter Dealer Name"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });
</script>