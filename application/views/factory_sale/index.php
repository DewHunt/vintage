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
                <div class="col-md-6"><h4 class="">Product Sale</h4></div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url("sale_product/index/factory_sale") ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Sale New Product</a>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive table-bordered">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Invoice No.</th>
                            <th>Branch Name</th>
                            <th>Client Name</th>
                            <th>Total Item</th>
                            <th>Payment Mode</th>
                            <th>Paid Amount</th>
                            <th class="action-fixed-width">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>

                        <!-- <?php foreach ($receiveProductChallanList as $receiveProductChallan): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $receiveProductChallan->product_receive_date ?></td>
                                <td><?= $receiveProductChallan->challan_number ?></td>
                                <td><?= $receiveProductChallan->branchName ?></td>
                                <td align="right"><?= $receiveProductChallan->total_item ?></td>
                                <td align="right"><?= $receiveProductChallan->total_qty ?></td>
                                <td><?= $receiveProductChallan->remarks ?></td>
                                <td>
                                    <?php if ($receiveProductChallan->status == 0): ?>
                                        Pending
                                    <?php elseif ($receiveProductChallan->status == 1): ?>
                                        Received
                                    <?php else: ?>
                                        Rejected
                                    <?php endif ?>
                                </td>
                                <td class="action-fixed-width">
                                    <span class="btn btn-primary" onclick="showReceiveProductInfo(<?= $receiveProductChallan->id ?>,'FactoryToBranch')">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach ?> -->
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>

    <div class="modal fade" id="receiveProductInfoModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center modal-lg">
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

    function showReceiveProductInfo(receiveChallanId,type) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_receive/view/") ?>',
            data: {receiveChallanId:receiveChallanId,type:type},
            success: function (data) {
                $('.modal-body').html(data.output);
                $('#receiveProductInfoModal').modal('show');
            },
            error: function () {

            }
        });
    }

    $('#receiveProductInfoModal').on('hidden.bs.modal', function () {
        location.reload();
    })

    function receiveProduct(productReceiveId,type) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_receive/receive_product/") ?>',
            data: {productReceiveId:productReceiveId,type:type},
            success: function (data) {
                $('#productReceiveStatus_'+productReceiveId).html(data.msg);
            },
            error: function () {

            }
        });
    }

    function rejectProduct(productReceiveId,type) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_receive/reject_product/") ?>',
            data: {productReceiveId:productReceiveId,type:type},
            success: function (data) {
                $('#productReceiveStatus_'+productReceiveId).html('Rejected');
            },
            error: function () {

            }
        });
    }

    function approveProduct(productReceiveId,type) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_receive/approve_product/") ?>',
            data: {productReceiveId:productReceiveId,type:type},
            success: function (data) {
                $('#productReceiveStatus_'+productReceiveId).html(data.msg);
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
