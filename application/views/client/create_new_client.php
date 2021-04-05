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
                <div class="col-md-6"><h4 class="">Create New Customer</h4></div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url('client') ?>" class="btn btn-primary"><i class=" fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <form id="create_new_client_form" name="create_new_client_form" action="<?= base_url('client/save_client') ?>" method="post">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="client_name">Client Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="client_name" name="client_name" value="" placeholder="Client Name" required>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label for="client_code">Client Code</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="client_code" name="client_code" value="" placeholder="Client Code" required>
                            <input type="hidden" class="form-control" id="saveFrom" name="saveFrom" value="inside">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="email">Email</label>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" value="" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="cell_number">Customer For</label>
                        <div class="form-group">
                            <label class="radio-inline"><input type="radio" name="customerFor" value="Factory" required>Factory</label>
                            <label class="radio-inline"><input type="radio" name="customerFor" value="Outlet">Outlet</label>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="cell_number">Cell Number</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="cell_number" name="cell_number" value="" placeholder="Cell Number">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="phone_number">Phone Number</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="" placeholder="Phone Number">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="address">Address</label>
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="address" name="address" placeholder="Address"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="client_area">Client Area</label>
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="client_area" name="client_area" placeholder="Client Area"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="credit_balance">Due Balance</label>
                                <div class="form-group">
                                    <input readonly="readonly" type="text" class="form-control" id="credit_balance" name="credit_balance" value="<?= get_floating_point_number(0, FALSE) ?>" placeholder="Due Balance">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="advance_balance">Advance Balance</label>
                                <div class="form-group">
                                    <input readonly="readonly" type="text" class="form-control" id="advance_balance" name="advance_balance" alue="<?= get_floating_point_number(0, FALSE) ?>" placeholder="Advance Balance">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="total_sale">Total Sale</label>
                                <div class="form-group">
                                    <input readonly="readonly" type="text" class="form-control" id="total_sale" name="total_sale" value="<?= get_floating_point_number(0, FALSE) ?>" placeholder="Total Sale">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="remarks">Remarks</label>
                        <div class="form-group">
                            <textarea class="form-control" id="remarks" name="remarks" value="" rows="5" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // $("form[name='create_new_client_form']").validate({
        //     rules: {
        //         client_name: "required",
        //         client_code: "required",
        //         // customerFor: "required",
        //     },
        //     messages: {
        //         client_name: "Please Enter Client Name",
        //         client_code: "Please Enter Client Code",
        //         // customerFor: "Please Select Client For",
        //     },
        //     submitHandler: function (form) {
        //         form.submit();
        //     }
        // });

    });
</script>