<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Update Bonus Incentive System</h2>
        </div>
    </div>-->

    <?php
    $bonus_incentive_system;
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Update Sales Incentive System Information</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="update_bonus_incentive_system" name="update_bonus_incentive_system"
                                  action="<?= base_url('bonus_incentive_system/update') ?>" method="post">

                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $bonus_incentive_system->id ?>">
                                <div class="form-group row">
                                    <label for="incentive_type" class="col-sm-2 col-xs-12 col-form-label">Type</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <select id="incentive_type" class="form-control" name="incentive_type" required>
                                            <option value="">Please Select</option>
                                            <option class="import-type-color" value="import" <?= (!empty($bonus_incentive_system->incentive_type) == 'import') ? 'selected' : ''; ?>>Import</option>
                                            <option class="lubzone-type-color" value="lubzone" <?= (!empty($bonus_incentive_system->incentive_type) == 'lubzone') ? 'selected' : ''; ?>>Lubzone</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="from_amount" class="col-sm-2 col-xs-12 col-form-label">From</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="from_amount" name="from_amount"
                                               value="<?= $bonus_incentive_system->from_amount ?>" placeholder="From Amount">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="to_amount" class="col-sm-2 col-xs-12 col-form-label">To</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="to_amount" name="to_amount"
                                               value="<?= $bonus_incentive_system->to_amount ?>" placeholder="To Amount">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="percent_of_incentive" class="col-sm-2 col-xs-12 col-form-label">% of Incentive</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="percent_of_incentive"
                                               name="percent_of_incentive"
                                               value="<?= $bonus_incentive_system->percent_of_incentive ?>" placeholder="% of incentive">
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-default save-button">Update</button>

                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->

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

        $("form[name='update_bonus_incentive_system']").validate({
            rules: {
                incentive_type: "required",
                from_amount: "required",
                to_amount: "required",
                percent_of_incentive: "required"
            },
            messages: {
                incentive_type: "Please Select Type",
                from_amount: "Please Enter From Amount",
                to_amount: "Please Enter To Amount",
                percent_of_incentive: "Please Enter % of Incentive"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

