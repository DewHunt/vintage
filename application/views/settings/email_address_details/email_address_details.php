<div id="page-wrapper">
    <?php
    $email_address_details;
    $m_email_address_details = new Email_address_details_Model();
    $email_address_details_array = $m_email_address_details->get_email_address_details_column_value($email_address_details);
    $id = !empty($email_address_details_array) ? (array_key_exists('id', $email_address_details_array) ? $email_address_details_array['id'] : '') : '';
    $email_to = !empty($email_address_details_array) ? (array_key_exists('email_to', $email_address_details_array) ? $email_address_details_array['email_to'] : '') : '';
    $email_cc = !empty($email_address_details_array) ? (array_key_exists('email_cc', $email_address_details_array) ? $email_address_details_array['email_cc'] : '') : '';
    $email_bcc = !empty($email_address_details_array) ? (array_key_exists('email_bcc', $email_address_details_array) ? $email_address_details_array['email_bcc'] : '') : '';
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : 'Email Address Details' ?></h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="email_address_details_form" name="email_address_details_form" action="<?= base_url('settings/email_address_details/save_email_address_details') ?>" method="post">
                                <input type="hidden" id="id" name="id" value="<?= $id; ?>">

                                <?php if (!empty($this->session->flashdata('email_address_details_save_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-sm-12 col-xs-12 col-form-label"></label>
                                        <div class="col-md-10 col-sm-12 col-xs-12 success-message text-align-center">
                                            <?php echo $this->session->flashdata('email_address_details_save_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group row">
                                    <label for="email_to" class="col-md-1 col-sm-12 col-xs-12 col-form-label">To</label>
                                    <div class="col-md-11 col-sm-12 col-xs-12">
                                        <textarea class="form-control" rows="2" id="email_to" name="email_to" placeholder="To"><?= $email_to; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_cc" class="col-md-1 col-sm-12 col-xs-12 col-form-label">CC</label>
                                    <div class="col-md-11 col-sm-12 col-xs-12">
                                        <textarea class="form-control" rows="2" id="email_cc" name="email_cc" placeholder="CC"><?= $email_cc; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_bcc" class="col-md-1 col-sm-12 col-xs-12 col-form-label">BCC</label>
                                    <div class="col-md-11 col-sm-12 col-xs-12">
                                        <textarea class="form-control" rows="2" id="email_bcc" name="email_bcc" placeholder="BCC"><?= $email_bcc; ?></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default save-button"><?= !empty($button_text) ? $button_text : 'Save' ?></button>
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
        $("form[name='email_address_details_form']").validate({
            rules: {
                email_to: "required",
//                email_cc: "required",
//                email_bcc: "required",
            },
            messages: {
                email_to: "This field is required.",
//                email_cc: "This field is required.",
//                email_bcc: "This field is required.",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>