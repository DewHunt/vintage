<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('errorMessage'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6"><h4 class="">Add New Printer</h4></div>
                <div class="col-md-6 text-right">
                    <!-- <div class="create-new-button"> -->
                    <a href="<?= base_url('printer_setup') ?>" class="btn btn-primary btn-lg"><i class="fa fa-reply-all" aria-hidden="true"></i> Go Back</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <form id="create_new_branch_form" name="create_new_branch_form" action="<?= base_url('printer_setup/update') ?>" method="post" enctype="multipart/form-data">
            	<input class="form-control" type="hidden" name="printerId" value="<?= $printerInfo->id ?>">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    	<label for="name">Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $printerInfo->name ?>" placeholder="Printer Name">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="branch_code">Printer Address</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="printerAddress" name="printerAddress" value="<?= $printerInfo->address ?>" placeholder="Printer Address">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group text-right">
                            <a onclick="return delete_confirm();" href="<?= base_url("printer_setup/delete/$printerInfo->id") ?>" class="btn btn-danger">Delete</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->

<script>
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>