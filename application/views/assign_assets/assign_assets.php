<div id="page-wrapper">
    <!-- <div class="row">
         <div class="col-lg-12">
             <h2 class="page-header">Assign Assets</h2>
         </div>
     </div>-->

    <?php
    $assets_info_list;
    $employee_list;

    /* echo '<pre>';
      echo print_r($assets_info_list);
      echo '</pre>';
      die(); */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Assign Assets</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="product-show-part">
                                <form id="assign_assets_info_form" name="assign_assets_info_form" action="<?= base_url('assign_assets/get_assets_in_table') ?>" method="post">
                                    <div class="error" style="color: red">
                                        <?php echo validation_errors(); ?>
                                    </div>

                                    <div class="form-group col-xs-12 row">
                                        <div class="form-group col-xs-12 col-sm-4">
                                            <label for="assets_info_id" class="col-form-label">Asset</label>
                                            <select name="assets_info_id" id="assets_info_id" class="form-control">
                                                <option value="" name="assets_info_id">Please Select</option>
                                                <?php foreach ($assets_info_list as $assets_info) { ?>
                                                    <option value="<?= $assets_info->id ?>" maximum-quantity="<?= $assets_info->assets_quantity ?>" name="assets_info_id"><?= ucfirst($assets_info->assets_name) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-4">
                                            <label for="quantity" class="col-form-label">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" placeholder="">
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-4">
                                            <button type="submit" class="btn btn-default add-product-button"
                                                    id="add-product-button">Add
                                            </button>
                                        </div>

                                    </div>

                                </form>

                                <div class="col-xs-12 assets-info-table-block">
                                    <?php $this->load->view('assign_assets/assets_info_table', $this->data); ?>
                                </div>
                            </div>

                            <form id="assign_assets_info_save_form" name="assign_assets_info_save_form" action="<?= base_url('assign_assets/assign_assets_save') ?>" method="post">

                                <div class="error" style="color: red">
                                    <?php echo validation_errors(); ?>
                                </div>

                                <div class="form-group col-xs-12">
                                    <div class="form-group row">
                                        <div class="form-group col-xs-12 col-sm-6">
                                            <label for="employee_id" class="col-form-label">Employee</label>
                                            <select name="employee_id" id="employee_id" class="form-control">
                                                <option value="" name="employee_id">Please Select</option>
                                                <?php foreach ($employee_list as $employee) { ?>
                                                    <option value="<?= $employee->id ?>" name="assets_info_id"><?= ucfirst($employee->employee_name) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-6">
                                            <button type="submit" class="btn btn-default add-product-button "
                                                    id="add-product-button">Confirm
                                            </button>
                                        </div>

                                    </div>

                                </div>

                            </form>

                            <?php if (!empty($this->session->flashdata('assign_assets_confirm_error_session'))) { ?>
                                <div class="col-xs-12 error-message text-align-center">
                                    <?php echo $this->session->flashdata('assign_assets_confirm_error_session'); ?>
                                </div>
                            <?php } ?>


                            <div class="col-xs-12">
                                <form class="" id="clear_session" name="clear_session" method="post" action="<?= base_url('assign_assets/clear_assign_assets_table_session') ?>">
                                    <button type="submit" class="btn btn-default add-product-button cancel-button-color"
                                            id="add-product-button">Clear
                                    </button>
                                </form>
                            </div>
                        </div>
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

        $('#assign_assets_info_form').validate({
            rules: {
                assets_info_id: "required",
                quantity: "required",
            },
            messages: {
                assets_info_id: "Please Select an Asset",
                quantity: "Please Enter Correct Quantity",
            },

            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
            },

            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    success: function (data) {
                        $('.assets-info-table-block').html(data);
                        delete_single_asset_from_table();
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        $("form[name='assign_assets_info_save_form']").validate({
            rules: {
                employee_id: "required",
            },
            messages: {
                employee_id: "Please Select Employee Name",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        //set min max value
        $('#assets_info_id').change(function () {
            var maximum_quantity = $("option[name=assets_info_id]:selected").attr('maximum-quantity');
            $("#quantity").attr({
                "max": maximum_quantity,
                "min": 1,
            });
        });

        delete_single_asset_from_table();
        function delete_single_asset_from_table() {
            $('.delete-assign-asset-button').click(function () {
                var array_id = $(this).attr('data-id');
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("assign_assets/delete_single_asset_from_table/") ?>',
                    data: {'array_id': array_id},
                    success: function (data) {
                        $('.assets-info-table-block').html(data);
                        delete_single_asset_from_table();
                    },
                    error: function () {

                    }
                });
            });
        }

    });

</script>

<!--<script>
    $('#branch_name').keyup(function(){
        var  branch_name = $(this).val();
        if(branch_name.length >=3){
            $.ajax({
                url:base_url('branch/get_branch_name_exist'),
                method:'post',
                data:{branch_name: branch_name},
                dataType:'json',
                success:function(data){
                    var div_element = $('#div_output');
                    if(data.branch_name){
                        div_element.text(data.branch_name + ' already in use');
                        div_element.css('color','red');
                    }
                    else {
                        div_element.text(data.branch_name + ' available');
                        div_element.css('color','green');
                    }
                },
                error:function(error){
                    alert(error);
                }
            });
        }
    });
</script>-->




