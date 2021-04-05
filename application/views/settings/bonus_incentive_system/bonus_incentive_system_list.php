<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Bonus Incentive System List</h2>
        </div>
    </div>-->

    <?php
    $bonus_incentive_system_list;
    ?>

    <div class="col-xs-12 row card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('bonus_incentive_system/create_bonus_incentive_system'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add Sales Incentive System', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Sales Incentive System Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Type</th>
                                        <th>From Amount</th>
                                        <th>To Amount</th>
                                        <th>% of Incentive</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1;
                                    foreach ($bonus_incentive_system_list as $bonus_incentive_system):
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= !empty($bonus_incentive_system->incentive_type) ? ucfirst($bonus_incentive_system->incentive_type) : ''; ?></td>
                                            <td><?= get_floating_point_number($bonus_incentive_system->from_amount); ?></td>
                                            <td><?= get_floating_point_number($bonus_incentive_system->to_amount); ?></td>
                                            <td><?= get_floating_point_number($bonus_incentive_system->percent_of_incentive).'%'; ?></td>
                                            <td class="action-fixed-width">
                                                <a href="<?= base_url("bonus_incentive_system/update_bonus_incentive_system/$bonus_incentive_system->id") ?>"
                                                   class="btn btn-primary">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a onclick="return delete_confirm();"
                                                   href="<?= base_url("bonus_incentive_system/delete/$bonus_incentive_system->id") ?>"
                                                   class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
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
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->

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

<script>
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>

