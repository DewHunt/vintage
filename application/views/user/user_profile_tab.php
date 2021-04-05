<?php
$last_uri_segment = get_last_uri_segment();
?>
<style>
    .user-profile-tab{
        background-color: darkgray;
        padding: 10px 10px 0px 0px;
    }
    .user-profile-tab ul li a{
        padding: 10px;
        color: white;
    }
    .user-profile-tab ul li a.active{
        background: gray;
    }
</style>
<div class="col-xs-12 user-profile-tab">
    <ul class="list-inline">
        <li><a class="<?= ($last_uri_segment == 'update_my_profile') ? 'active' : ''; ?>" href="<?= base_url('user_login/update_my_profile'); ?>">Update Profile</a></li>
        <li><a class="<?= ($last_uri_segment == 'password_change') ? 'active' : ''; ?>" href="<?= base_url('user_login/password_change'); ?>">Change Password</a></li>
    </ul>
</div>