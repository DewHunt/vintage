<div id="page-wrapper">
    <?php
        // echo "<h1>Dew Hunt</h1>"; exit();
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
                <div class="col-md-6"><h4 class="">Production</h4></div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url('production/add') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Production</a>
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
                            <th width="120px">Batch No.</th>
                            <th width="140px">Date</th>
                            <th width="140px">Expire Date</th>
                            <th>Remarks</th>
                            <th class="action-fixed-width">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>

                        <?php foreach ($productionList as $production): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $production->batch_no ?></td>
                                <td><?= $production->date ?></td>
                                <td><?= $production->expire_date ?></td>
                                <td><?= $production->remarks ?></td>
                                <td class="action-fixed-width">
                                    <span class="btn btn-primary" onclick="showProductionProductInfo(<?= $production->id ?>)">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    <!-- <a href="<?= base_url("production/edit/$production->id") ?>" class="btn btn-primary">
                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a> -->
                                    <!-- <a onclick="return delete_confirm();" href="<?= base_url("production/delete/$production->id") ?>" class="btn btn-danger">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a> -->
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

    <div class="modal fade" id="productionInfoModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

    function showProductionProductInfo(productionId) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("production/view/") ?>',
            data: {productionId:productionId},
            success: function (data) {
                $('.modal-body').html(data.output);
                $('#productionInfoModal').modal('show');
            },
            error: function () {

            }
        });
    }

    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>
