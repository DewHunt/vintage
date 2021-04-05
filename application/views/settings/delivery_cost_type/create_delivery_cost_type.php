<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= (!empty($page_title)) ? $page_title : 'Delivery Cost Type' ?></h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_delivery_cost_type_form" name="create_delivery_cost_type_form" action="<?= base_url('settings/delivery_cost_type/save_delivery_cost_type') ?>" method="post">
                                <?php $this->load->view('settings/delivery_cost_type/delivery_cost_form_fields', $this->data); ?>
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
        $("form[name='create_delivery_cost_type_form']").validate({
            rules: {
                delivery_cost_name: "required",
            },
            messages: {
                delivery_cost_name: "Please enter delivery cost name",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>