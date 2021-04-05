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
                <div class="col-md-6"><h4 class="">Update Customer Information</h4></div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url('client') ?>" class="btn btn-primary"><i class=" fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form id="create_new_client_form" name="create_new_client_form" action="<?= base_url('client/update') ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $client->id ?>">
                            <input type="text" class="form-control" id="client_name" name="client_name" value="<?= $client->client_name ?>" placeholder="Client Name">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="client_code">Client Code</label>
                            <input type="text" class="form-control" id="client_code" name="client_code" value="<?= $client->client_code ?>" placeholder="Client Code">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $client->email ?>" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="cell_number">Customer For</label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="customerFor" value="Factory" <?= $client->client_type == 'Factory' ? 'checked' : '' ?> required>Factory
                            </label>
                            
                            <label class="radio-inline">
                                <input type="radio" name="customerFor" value="Outlet" <?= $client->client_type == 'Outlet' ? 'checked' : '' ?>>Outlet
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="cell_number">Cell Number</label>
                            <input type="text" class="form-control" id="cell_number" name="cell_number" value="<?= $client->cell_number ?>" placeholder="Cell Number">
                        </div>
                    </div>

                    <div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $client->phone_number ?>" placeholder="Phone Number">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="2" id="address" name="address" placeholder="Address"><?= $client->address ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_area">Client Area</label>
                            <textarea class="form-control" rows="2" id="client_area" name="client_area" placeholder="Client Area"><?= $client->client_area ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_balance">Due Balance</label>
                                    <input readonly="readonly" type="text" class="form-control" id="credit_balance" name="credit_balance" value="<?= !empty($client->credit_balance) ? get_floating_point_number($client->credit_balance, FALSE) : get_floating_point_number(0, FALSE) ?>" placeholder="Due Balance">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="advance_balance">Advance Balance</label>
                                    <input readonly="readonly" type="text" class="form-control" id="advance_balance" name="advance_balance" value="<?= !empty($client->advance_balance) ? get_floating_point_number($client->advance_balance, FALSE) : get_floating_point_number(0, FALSE) ?>" placeholder="Advance Balance">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_sale">Total Sale</label>
                                    <input readonly="readonly" type="text" class="form-control" id="total_sale" name="total_sale" value="<?= !empty($client->total_sale) ? get_floating_point_number($client->total_sale, FALSE) : get_floating_point_number(0, FALSE) ?>" placeholder="Total Sale">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="5" placeholder="Remarks"><?= $client->remarks ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-default save-button">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("form[name='update_client_form']").validate({
            rules: {
                client_name: "required",
                client_code: "required",
                client_type: "required",
            },
            messages: {
                client_name: "Please Enter Client Name",
                client_code: "Please Enter Client Code",
                client_type: "Please Select Client Type",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>