<h4>Hi,</h4> 
<p>A user logged into the system using super password</p>
<table id="super-password-info-table" class="super-password-info-table" style="width:40%; background: #ddd;">
    <tr>
        <td style="width: 100px;"><strong>User Name</strong></td>
        <td>:&nbsp;<?= $content_details['user_name'] ?></td>
    </tr>
    <tr>
        <td style="width: 100px;"><strong>IP Address</strong></td>
        <td>:&nbsp;<?= $content_details['ip_address'] ?></td>
    </tr>
    <tr>
        <td style="width: 100px;"><strong>Country</strong></td>
        <td>:&nbsp;<?= $content_details['country'] ?></td>
    </tr>
    <?php if (array_key_exists('city', $content_details)) { ?>
        <tr>
            <td style="width: 100px;"><strong>City</strong></td>
            <td>:&nbsp;<?= $content_details['city'] ?></td>
        </tr>
    <?php }
    ?>
    <tr>
        <td style="width: 100px;"><strong>Time</strong></td>
        <td>:&nbsp;<?= $content_details['current_date_time'] ?></td>
    </tr>
    <tr>
        <td style="width: 100px;"><strong>Details</strong></td>
        <td>:&nbsp;<?= $content_details['browser'] ?></td>
    </tr>
</table>