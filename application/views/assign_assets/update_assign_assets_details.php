<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Update Assets Details</h2>
        </div>
    </div>-->

    <?php
    /* echo '<pre>';
      echo print_r($invoice_details_view);
      echo '</pre>'; */
    ?>

    <?php if (!empty($this->session->flashdata('assign_assets_update_error'))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php echo $this->session->flashdata('assign_assets_update_error'); ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('assign_assets_update_success'))) { ?>
        <div class="col-xs-12 success-message text-align-center">
            <?php echo $this->session->flashdata('assign_assets_update_success'); ?>
        </div>
    <?php } ?>
    
    <?php if (!empty($this->session->flashdata('delete_success_message'))) { ?>
        <div class="col-xs-12 success-message text-align-center">
            <?php echo $this->session->flashdata('delete_success_message'); ?>
        </div>
    <?php } ?>
    
    <?php if (!empty($this->session->flashdata('delete_error_message'))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php echo $this->session->flashdata('delete_error_message'); ?>
        </div>
    <?php } ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Update Assign Assets Details of <?= !empty($employee_information->employee_name) ? ucwords(strtolower($employee_information->employee_name)) : '' ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead class="thead-default">
                                    <tr>
                                        <th>SL</th>
                                        <th>Asset Name</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $count = 1;
                                    foreach ($assign_assets_by_employee_id as $assign_assets):
                                        ?>
                                        <tr>
                                            <td><?= $count++; ?></td>
                                            <td><?= ucfirst($assign_assets->assets_name) ?></td>
                                            <td><?= $assign_assets->quantity ?></td>
                                            <td>
                                                <button class="btn btn-primary assign-asset-update-button"
                                                        data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $assign_assets->id ?>" data-action="<?= base_url('assign_assets/update_assets') ?>">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                                                <a onclick="return delete_confirm();" href="<?= base_url("assign_assets/delete/$assign_assets->id") ?>"
                                                   class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                    <!-- <div class="form-group col-xs-12 col-sm-12">
                         <button type="submit" class="btn btn-default add-product-button" style="float: right"
                                 id="add-product-button">Update
                         </button>
                     </div>-->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>

    <div class="modal fade update_assign_assets_details_modal">
        <div class="modal-dialog modal-lg update-assign-modal-show " role="document">
        </div>
    </div>

</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $('.assign-asset-update-button').on('click', function (event) {
            event.preventDefault();
            $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                $('.update_assign_assets_details_modal .update-assign-modal-show').html(data)
                $('.update_assign_assets_details_modal').modal('show');
            });
        });
    });
</script>

<script>
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>





