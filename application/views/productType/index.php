<div id="page-wrapper">
    <?php
	    $user_info = $this->session->userdata('user_session');
	    $user_type = $user_info['user_type'];
	    $settings_access = $user_info['settings_access'];
	    $product_access = $user_info['product_access'];
	    $client_access = $user_info['client_access'];
    ?>
    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>
    
    <?php if (!empty($this->session->flashdata('errorMessage'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6"><h4 class="">Category Details</h4></div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url('product_type/add') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Category</a>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive table-bordered">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th>Name</th>
                            <th width="100px">Food Type</th>
                            <th width="100px">Availability</th>
                            <th width="100px">Button Color</th>
                            <th>Printer Name</th>
                            <th width="80px">Sort Order</th>
                            <th class="action-fixed-width">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>

                        <?php foreach ($productTypeList as $productType): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td>
                                    <?= $productType->product_type_name ?>
                                    <?php if ($productType->image): ?>
                                        <img width="40px" height="40px" src="<?= $productType->image ?>">
                                    <?php endif ?>
                                </td>
                                <td><?= $productType->food_type ?></td>
                                <td><?= $productType->availability ?></td>
                                <td><?= $productType->button_color ?></td>
                                <td><?= $productType->printerName ?></td>
                                <td><?= $productType->sort_order ?></td>
                                <td class="action-fixed-width">
                                    <a href="<?= base_url("product_type/edit/$productType->id") ?>"
                                       class="btn btn-primary">
                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a onclick="return delete_confirm();"
                                       href="<?= base_url("product_type/delete/$productType->id") ?>"
                                       class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->

<!--Jquery Data Table-->
<script>
    $(document).ready(function () {
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });

    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>
