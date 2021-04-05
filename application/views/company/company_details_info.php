<div id="page-wrapper">
    <?php
        $company_information;
        // echo "<pre>"; print_r($company_information); exit();
        $outlet_access = 0;
        $factory_access = 0;
        $kitchen_room_access = 0;
        $money_receipt_access = 0;
        $edit_money_receipt_access = 0;
        $transaction_access = 0;
        $category_name = '';

        $menu_permission_list = empty($company_information->menu_permission) ? '' : json_decode($company_information->menu_permission,true);

        if ($menu_permission_list != '') {
            $outlet_access = array_key_exists('outlet_access',$menu_permission_list) ? $menu_permission_list['outlet_access'] : 0;
            $factory_access = array_key_exists('factory_access',$menu_permission_list) ? $menu_permission_list['factory_access'] : 0;
            $kitchen_room_access = array_key_exists('kitchen_room_access',$menu_permission_list) ? $menu_permission_list['kitchen_room_access'] : 0;
            $money_receipt_access = array_key_exists('money_receipt_access',$menu_permission_list) ? $menu_permission_list['money_receipt_access'] : 0;
            $edit_money_receipt_access = array_key_exists('edit_money_receipt_access',$menu_permission_list) ? $menu_permission_list['edit_money_receipt_access'] : 0;
            $transaction_access = array_key_exists('transaction_access',$menu_permission_list) ? $menu_permission_list['transaction_access'] : 0;
        }

        // echo "<pre>"; print_r($menu_permission_list->outlet_access); exit();
        $id = empty($company_information->id) ? '' : $company_information->id;
        $company_name_1 = empty($company_information->company_name_1) ? '' : $company_information->company_name_1;
        $company_name_2 = empty($company_information->company_name_2) ? '' : $company_information->company_name_2;
        $phone = empty($company_information->phone) ? '' : $company_information->phone;
        $mobile = empty($company_information->mobile) ? '' : $company_information->mobile;
        $email = empty($company_information->email) ? '' : $company_information->email;
        $website = empty($company_information->website) ? '' : $company_information->website;
        $company_address_1 = empty($company_information->company_address_1) ? '' : $company_information->company_address_1;
        $company_address_2 = empty($company_information->company_address_2) ? '' : $company_information->company_address_2;
        $button_backgound = empty($company_information->button_backgound) ? '' : $company_information->button_backgound;

        if (empty($company_information->category_name)) {
            $category_name =  $company_information->category_name == 1 ? 'Show' : 'Hide';
        }
    ?>

    <div class="col-xs-12 row card-margin-top">
        <div class="clearfix"></div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6"><h4 class="">Company Details</h4></div>
                    <div class="col-md-6 text-right">
                        <?php if ($company_information): ?>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#menuPermissionModal">Set Menu Permission</button>
                            <a href="<?= base_url("company/update_company/$company_information->id") ?>" class="btn btn-primary">
                                <i class=" fa fa-pencil-square-o" aria-hidden="true"></i> Edit Company Information
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('company/create_new_company') ?>" class="btn btn-primary">
                                <i class=" fa fa-plus" aria-hidden="true"></i> Add Company Information
                            </a>                            
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align: center"><h4>Company Information</h4></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="150px">Name 1</th>
                                <td colspan="3"><?= $company_name_1 ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Name 2</th>
                                <td colspan="3"><?= $company_name_2 ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Phone</th>
                                <td><?= $phone ?></td>

                                <th width="150px">Mobile</th>
                                <td><?= $mobile ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Email</th>
                                <td><?= $email ?></td>

                                <th width="150px">Website</th>
                                <td><?= $website ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Addres 1</th>
                                <td colspan="3"><?= $company_address_1 ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Address 2</th>
                                <td colspan="3"><?= $company_address_2 ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Button Background</th>
                                <td><?= $button_backgound ?></td>

                                <th width="150px">Category Name</th>
                                <td><?= $category_name ?></td>
                            </tr>

                            <tr>
                                <th width="150px">Logo</th>
                                <td colspan="3">
                                    <?php if ($company_information->company_logo): ?>
                                        <img width="100px" height="100px" src="<?= base_url($company_information->company_logo) ?>">
                                    <?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="menuPermissionModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Menu Permission</h4>
                            </div>
                            <div class="modal-body">
                                <form id="menu_permission_form" name="menu_permission_form" action="<?= base_url('company/save_menu_permission') ?>" method="post" enctype="multipart/form-data">
                                    <input class="form-control" type="hidden" name="company_id" value="<?= $id ?>">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="checkbox-inline">
                                                <input type="hidden" name="outlet_access" value="0">
                                                <input type="checkbox" name="outlet_access" value="1" <?= $outlet_access == 0 ? '' : 'checked' ?>>Outlet
                                            </label>

                                            <label class="checkbox-inline">
                                                <input type="hidden" name="factory_access" value="0">
                                                <input type="checkbox" name="factory_access" value="1" <?= $factory_access == 0 ? '' : 'checked' ?>>Factory
                                            </label>

                                            <label class="checkbox-inline">
                                                <input type="hidden" name="kitchen_room_access" value="0">
                                                <input type="checkbox" name="kitchen_room_access" value="1" <?= $kitchen_room_access == 0 ? '' : 'checked' ?>>Kitchen Room
                                            </label>

                                            <label class="checkbox-inline">
                                                <input type="hidden" name="money_receipt_access" value="0">
                                                <input type="checkbox" name="money_receipt_access" value="1" <?= $money_receipt_access == 0 ? '' : 'checked' ?>>Money Receipt
                                            </label>
                                            
                                            <label class="checkbox-inline">
                                                <input type="hidden" name="edit_money_receipt_access" value="0">
                                                <input type="checkbox" name="edit_money_receipt_access" value="1" <?= $edit_money_receipt_access == 0 ? '' : 'checked' ?>>Edit Money Receipt
                                            </label>

                                            <label class="checkbox-inline">
                                                <input type="hidden" name="transaction_access" value="0">
                                                <input type="checkbox" name="transaction_access" value="1" <?= $transaction_access == 0 ? '' : 'checked' ?>>Transaction
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-default save-button">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

