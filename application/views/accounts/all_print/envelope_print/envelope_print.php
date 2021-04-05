<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Envelope Print</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($this->session->flashdata('envelope_print_error_message'))) { ?>
                        <div class="error error-message text-align-center">
                            <?php echo $this->session->flashdata('envelope_print_error_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <?php if (!empty($this->session->flashdata('envelope_print_save_success_message'))) { ?>
                        <div class="success-message text-align-center">
                            <?php echo $this->session->flashdata('envelope_print_save_success_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form id="envelope_print_form" name="envelope_print_form" action="<?= base_url('accounts/all_print/envelope_print/envelope_print_save') ?>" method="post">

                                <div class="col-xs-12 text-align-center">
                                    <p><span class="text-color-green"><span class="text-color-red">&#x2605;</span> For Small Please Select Paper Size: Envelope Monarch</span></p>
                                    <p><span class="text-color-green"><span class="text-color-red">&#x2605;</span> For Medium Please Select Paper Size: Envelope DL</span></p>
                                    <p><span class="text-color-green"><span class="text-color-red">&#x2605;</span> For Large Please Select Paper Size: Envelope C5</span></p>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="envelope_title" class="col-form-label">Title</label>
                                        <input type="text" class="form-control" id="envelope_title" name="envelope_title" value="" placeholder="Title">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="envelope_size" class="col-form-label">Envelope Size</label>
                                        <select name="envelope_size" id="envelope_size" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="from_envelope_details" class="col-form-label">From</label>
                                        <textarea class="form-control" id="from_envelope_details" name="from_envelope_details" rows="5" placeholder="From"></textarea>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="to_envelope_details" class="col-form-label">To</label>
                                        <textarea class="form-control" id="to_envelope_details" name="to_envelope_details" rows="5" placeholder="To"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <button type="submit" class="btn btn-default save-button div-margin-top">Save</button>
                                    </div>
                                    <div class="col-xs-12 text-align-center error-message">
                                        <span class="envelop_details_error_messsage"></span>
                                    </div>
                                </div>
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

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $("#envelope_print_form").validate({
            rules: {
                envelope_title: "required",
                envelope_size: "required",
            },
            messages: {
                envelope_title: "Please Enter Title",
                envelope_size: "Please Enter Envelope Size",
            },
            submitHandler: function (form) {
                var from_envelope_details = $('#from_envelope_details').val();
                from_envelope_details = from_envelope_details.trim();
                var to_envelope_details = $('#to_envelope_details').val();
                to_envelope_details = to_envelope_details.trim();
                if (from_envelope_details === '' && to_envelope_details === '') {
                    $('.envelop_details_error_messsage').html('Please Enter From Or To Details');
                    $('.envelop_details_error_messsage').fadeIn('slow').delay(1000).fadeOut('slow'); // 1sec = 1000
                } else {
                    var result = confirm('Do you want to Continue?');
                    if (result == true) {
                        form.submit();
                    } else {

                    }
                }
            }
        });
    });
</script>