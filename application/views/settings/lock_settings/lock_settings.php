<div id="page-wrapper">
    <?php
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_list;
        $lock_user_list;
    ?>

    <?php if (!empty($this->session->flashdata('lock_settings_success_message'))) { ?>
        <div class="form-group col-xs-12 text-align-center success-message">
            <?php echo $this->session->flashdata('lock_settings_success_message'); ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4>Lock Settings</h4></div>
            </div>            
        </div>
        <div class="panel-body">
            <form class="form-group" id="lock_settings_form" name="lock_settings_form" method="post" action="<?= base_url('settings/lock_settings/save_lock_settings') ?>">

                <div class="row">
                    <div class="col-lg-8 col-ms-8 col-sm-12 col-xs-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="100px">Sunday</td>
                                    <td>
                                        <input class="form-control" type="time" id="sunday_start_time" name="sunday_start_time" placeholder="" value="<?= !empty($sunday_lock_time) ? $sunday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="sunday_end_time" name="sunday_end_time" placeholder="" value="<?= !empty($sunday_lock_time) ? $sunday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Monday</td>
                                    <td>
                                        <input class="form-control" type="time" id="monday_start_time" name="monday_start_time" placeholder="" value="<?= !empty($monday_lock_time) ? $monday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="monday_end_time" name="monday_end_time" placeholder="" value="<?= !empty($monday_lock_time) ? $monday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Tuesday</td>
                                    <td>
                                        <input class="form-control" type="time" id="tuesday_start_time" name="tuesday_start_time" placeholder="" value="<?= !empty($tuesday_lock_time) ? $tuesday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="tuesday_end_time" name="tuesday_end_time" placeholder="" value="<?= !empty($tuesday_lock_time) ? $tuesday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Wednesday</td>
                                    <td>
                                        <input class="form-control" type="time" id="wednesday_start_time" name="wednesday_start_time" placeholder="" value="<?= !empty($wednesday_lock_time) ? $wednesday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="wednesday_end_time" name="wednesday_end_time" placeholder="" value="<?= !empty($wednesday_lock_time) ? $wednesday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Thursday</td>
                                    <td>
                                        <input class="form-control" type="time" id="thursday_start_time" name="thursday_start_time" placeholder="" value="<?= !empty($thursday_lock_time) ? $thursday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="thursday_end_time" name="thursday_end_time" placeholder="" value="<?= !empty($thursday_lock_time) ? $thursday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Friday</td>
                                    <td>
                                        <input class="form-control" type="time" id="friday_start_time" name="friday_start_time" placeholder="" value="<?= !empty($friday_lock_time) ? $friday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="friday_end_time" name="friday_end_time" placeholder="" value="<?= !empty($friday_lock_time) ? $friday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Saturday</td>
                                    <td>
                                        <input class="form-control" type="time" id="saturday_start_time" name="saturday_start_time" placeholder="" value="<?= !empty($saturday_lock_time) ? $saturday_lock_time->start_time : '' ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="saturday_end_time" name="saturday_end_time" placeholder="" value="<?= !empty($saturday_lock_time) ? $saturday_lock_time->end_time : '' ?>">
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3"><button type="submit" class="btn btn-default save-button">Save</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-lg-4 col-ms-4 col-sm-12 col-xs-12">
                        <?php
                            if (!empty($user_list)) {
                                $flag = FALSE;
                                foreach ($user_list as $user) {
                                    if ((int) $user->id != (int) $user_id) {
                                        if (!empty($lock_user_list)) {
                                            $flag = FALSE;
                                            foreach ($lock_user_list as $lock_user) {
                                                if ((int) $user->id == (int) $lock_user->user_id) {
                                                    $flag = TRUE;
                                                }
                                            }
                                        }
                        ?>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input <?= ($flag == TRUE) ? "checked='checked'" : '' ?> type="checkbox" class="form-check-input user_id_checkbox" id="user_id" name="user_id_list[]" value="<?= $user->id ?>">
                                                <?= ucfirst($user->user_name) ?>
                                            </label>
                                        </div>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>

            </form>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
<!-- /#page-wrapper -->





