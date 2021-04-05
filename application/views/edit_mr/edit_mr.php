<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('save_success_message'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('save_success_message') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('save_error_message'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('save_error_message') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 class="">Edit Money Receipt</h4></div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></div>
            </div>            
        </div>

        <div class="panel-body">
            <div class="error" style="color: red">
                <?php echo validation_errors(); ?>
            </div>

            <form id="mr_details_search_form" name="mr_details_search_form" action="<?= base_url('edit_mr/edit_mr_information_show') ?>" method="post">
                <div class="row">
                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
                        <label for="mr_number" class="col-form-label">MR Number</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="mr_number" name="mr_number" value="" placeholder="MR Number">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                        <label for=""></label>
                        <button type="submit" class="btn btn-default add-product-button left-side-view" id="add-product-button">Search
                        </button>                        
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="edit_mr_information_show_block"></div>
    <div class="client_reduce_product_return_table_block"></div>
</div>
<!-- /#page-wrapper -->

<script>
    $(document).ready(function () {

        $('#mr_details_search_form').validate({
            rules: {
                //mr_number: "required",
            },
            messages: {
                //mr_number: "Please Enter MR Number",
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
                        $('.edit_mr_information_show_block').html(data);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        $("form[name='client_product_return_save_form']").validate({
            rules: {
                return_date: "required",
                branch_id: "required",
                remarks: "required",
            },
            messages: {
                return_date: "Please Select Date",
                branch_id: "Please Select Outlet",
                remarks: "Please Enter Remarks",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>



