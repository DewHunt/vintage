<div id="page-wrapper">
    <?php $branch_list; ?>    
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><h4 class="">Outlet Details</h4></div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <?php if (get_menu_permission('outlet_access')): ?>
                        <a href="<?= base_url('branch/create_new_branch') ?>" class="btn btn-primary">
                            <i class=" fa fa-plus" aria-hidden="true"></i> Add Outlet
                        </a>
                    <?php endif ?>
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Factory</th>
                            <th>Hot Kitchen</th>
                            <th>Assined Branches</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th class="action-fixed-width">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($branch_list as $branch): ?>
                            <?php
                                if ($branch->assigned_branches == "") {
                                    $assignedBranches = [];
                                }
                                else {
                                    $assignOutlet = explode(',',$branch->assigned_branches);
                                    $assignedBranches = $this->Branch_Model->getAllBranchById($assignOutlet);
                                }
                            
                                $assignedBranchArray = [];
                                foreach ($assignedBranches as $assignedBranch)
                                {
                                    array_push($assignedBranchArray, $assignedBranch->branch_name);
                                }

                                $branchName = implode(', ', $assignedBranchArray);
                            ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $branch->branch_name ?></td>
                                <td><?= $branch->branch_code ?></td>
                                <td><?= $branch->factory_status == 1 ? 'Yes' : 'No' ?></td>
                                <td><?= $branch->hot_kitchen_status == 1 ? 'Yes' : 'No' ?></td>
                                <td><?= $branchName ?></td>
                                <td><?= $branch->address ?></td>
                                <td><?= $branch->mobile ?></td>
                                <td class="action-fixed-width">
                                    <a href="<?= base_url("branch/update_branch/$branch->id") ?>" class="btn btn-primary">
                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>
