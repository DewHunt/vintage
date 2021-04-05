<div id="page-wrapper">

    <div class="card-margin-top">

        <!--<div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Assign Assets Details</h2>
            </div>
        </div>-->

        <div class="create-new-button">
            <?php echo anchor(base_url('assign_assets/create_new_assign_assets'), ' <i class=" fa fa-plus" aria-hidden="true"></i> New Assign', 'class="btn btn-primary create-new-button"') ?>
        </div>

        <?php
        $all_assign_assets_by_employee_list;

        /* echo '<pre>';
          echo print_r($invoice_details_view);
          echo '</pre>'; */
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Assign Assets Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Total Quantity</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1;
                                    foreach ($all_assign_assets_by_employee_list as $all_assign_assets):
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= ucfirst($all_assign_assets->employee_name) ?></td>
                                            <td><?= ucfirst($all_assign_assets->designation) ?></td>
                                            <td><?= $all_assign_assets->total_quantity ?></td>
                                            <td class="action-fixed-width">
                                                <a href="<?= base_url("assign_assets/update_assign_assets/$all_assign_assets->employee_id") ?>"
                                                   class="btn btn-primary" data-toggle="tooltip" title="Update">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                <button class="btn btn-primary assign-assets-view-button"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="View Details"
                                                        data-id="<?= $all_assign_assets->employee_id ?>"
                                                        data-action="<?= base_url('assign_assets/assign_assets_details_view') ?>">
                                                    <i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
<?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>

        <div class="modal fade assign-assets-details-modal">
            <div class="modal-dialog modal-lg assign-modal-show " role="document">
            </div>
        </div>

    </div>

</div>
<!-- /#page-wrapper -->


<script type="text/javascript">

    $(document).ready(function () {
        //Jquery Data Table
        $('#details-table').dataTable({
            //"aoColumnDefs": [{ "bSortable": false, "aTargets": [ -1, -2, -3,-4 ,-5, -6, ,-7, -8 ] }],
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $('.assign-assets-view-button').on('click', function (event) {
            event.preventDefault();
            $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                $('.assign-assets-details-modal .assign-modal-show').html(data)
                $('.assign-assets-details-modal').modal('show');
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




