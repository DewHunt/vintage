<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">

                            <form id="delivery_cost_show_form" name="delivery_cost_show_form" action="<?= base_url('delivery_cost/delivery_cost_show_in_table') ?>" method="post">
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

                            <div class="col-xs-12 delivery_cost_table_block">

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
        $('#delivery_cost_show_form').validate({
            rules: {

            },
            messages: {

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
                        $('.delivery_cost_table_block').html(data);
                    },
                    error: function (error) {
                        console.log("error occured.");
                    }
                });
            }
        });
    });

</script>



