<div id="page-wrapper">
    <?php
        $user_list;
        // echo '<pre>'; print_r($user_list); exit();
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">User Details</h4></div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?php echo anchor(base_url('user/create_new_user'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New User', 'class="btn btn-primary create-new-button"') ?>
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
                            <th>User Name</th>
                            <th>User Type</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th width="250px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        if (!empty($user_list)) {
                            foreach ($user_list as $user) {
                                ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= ucfirst($user->name) ?></td>
                                    <td><?= $user->user_name ?></td>
                                    <td><?= ucwords($user->user_type) ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->mobile ?></td>
                                    <td><?= ucfirst($user->address) ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url("user/permission/$user->id") ?>" class="btn btn-success"> Menu Permission</a>
                                        <a href="<?= base_url("user/update_user/$user->id") ?>" class="btn btn-primary"> <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a onclick="return delete_confirm();" href="<?= base_url("user/delete/$user->id") ?>" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<!-- /#page-wrapper -->

<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#details-table').dataTable({
            //"aoColumnDefs": [{ "bSortable": false, "aTargets": [ -1, -2, -3,-4 ,-5, -6, ,-7, -8 ] }],
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
//            "bPaginate": false,
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




