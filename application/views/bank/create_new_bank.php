<div id="page-wrapper">
    <!-- <div class="row">
         <div class="col-lg-12">
             <h2 class="page-header">Create New Bank</h2>
         </div>
     </div>-->

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Create Bank</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_new_bank_form" name="create_new_bank_form"
                                  action="<?= base_url('bank/save_bank') ?>" method="post">
                                
                                <?php if (!empty($this->session->flashdata('name_exists_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 error-message text-align-center">
                                            <?= $this->session->flashdata('name_exists_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="bank_name" class="col-sm-2 col-xs-12 col-form-label">Bank
                                        Name</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="bank_name" name="bank_name"
                                               value="" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="branch_name" class="col-sm-2 col-xs-12 col-form-label">Branch
                                        Name</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="branch_name" name="branch_name"
                                               value="" placeholder="Branch Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="branch_location" class="col-sm-2 col-xs-12 col-form-label">Branch
                                        Location</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="branch_location"
                                               name="branch_location"
                                               value="" placeholder="Branch Location">
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-default save-button">Save</button>

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

        $("form[name='create_new_bank_form']").validate({
            rules: {
                bank_name: "required",
                branch_name: "required",
                branch_location: "required",
            },
            messages: {
                bank_name: "Please Enter Bank Name",
                branch_name: "Please Enter Branch Name",
                branch_location: "Please Enter Branch Location",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });


        /* $("#save-button").click(function(){
         if($.isNumeric( $('#input').val()))
         {
         $('#result').html('Value is Numeric');
         }
         else
         {
         $('#result').html('Value is not Numeric');
         }
         });*/

        /*$('#bank_name').keyup(function () {
            var bank_name = $("#bank_name").val();
            $.ajax(
                {
                    type: "post",
                    //url: "<?php echo base_url(); ?>index.php/files/filename_exists",
                    url: "<?php echo base_url('Bank/bank_exists'); ?>",
                    data: {bank_name: bank_name},
                    success: function (response) {
                        if (response == true) {
                            alert('faaa');
                            $('#msg').html('<span style="color: green;">' + msg + "</span>");
                        }
                        else {
                            $('#msg').html('<span style="color:red;">Value does not exist</span>');
                        }
                    }
                });
        });*/

    });
</script>
