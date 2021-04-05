<div id="page-wrapper">
    <?php
    $product_list;
    $branch_list;
    ?>
    <?php if (!empty($this->session->flashdata('return_date_and_remarks_error_message'))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php echo $this->session->flashdata('return_date_and_remarks_error_message'); ?>
        </div>
    <?php } ?>
    <?php if (!empty($this->session->flashdata('client_product_damage_or_defect_save_message'))) { ?>
        <div class="col-xs-12 success-message text-align-center">
            <?php echo $this->session->flashdata('client_product_damage_or_defect_save_message'); ?>
        </div>
    <?php } ?>
    <?php if (!empty($this->session->flashdata('client_product_table_error_message'))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php echo $this->session->flashdata('client_product_table_error_message'); ?>
        </div>
    <?php } ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Client Product (Damage / Defect)</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">

                            <form id="client_product_damage_or_defect_form" name="client_product_damage_or_defect_form"
                                  action="<?= base_url('client_product_damage_or_defect/client_product_damage_or_defect_show_in_table') ?>" method="post">

                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="invoice_number" class="col-form-label">Invoice Number</label>
                                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="" placeholder="Invoice Number">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="challan_number" class="col-form-label">Challan Number</label>
                                        <input type="text" class="form-control" id="challan_number" name="challan_number" value="" placeholder="Challan Number">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="" class="col-form-label"></label>
                                        <button type="submit" class="btn btn-default add-product-button left-side-view"
                                                id="add-product-button">Search
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 client_product_damage_or_defect_table_block">

                            </div>
                            <div class="col-xs-12 client_reduce_product_damage_or_defect_table_block">

                            </div>


                            <form id="client_product_damage_or_defect_save_form" name="client_product_damage_or_defect_save_form" action="<?= base_url('client_product_damage_or_defect/client_product_damage_information_save') ?>" method="post">

                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="return_date" class="col-form-label">Date</label>
                                        <input type="date" class="form-control" id="return_date"
                                               name="return_date" value="">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="remarks" class="col-form-label">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks"
                                                  rows="2" placeholder="Remarks"></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-default save-button">Save</button>

                            </form>
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

        $('#client_product_damage_or_defect_form').validate({
            rules: {
                //product_id: "required",
                //quantity: "required",
            },
            messages: {
                //product_id: "Please Select a Product",
                //quantity: "Please Enter Quantity",
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
                        $('.client_product_damage_or_defect_table_block').html(data);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        $("form[name='client_product_damage_or_defect_save_form']").validate({
            rules: {
                return_date: "required",
                remarks: "required",
            },
            messages: {
                return_date: "Please Select Date",
                remarks: "Please Enter Remarks",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>




