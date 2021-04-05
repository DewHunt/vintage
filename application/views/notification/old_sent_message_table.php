<div class="card card-boarder">

    <?php
    $employee_all_sent_message;
    ?>
    <div style="width: 100%;">
        <?php $count = 1;
        if (!empty($employee_all_sent_message)) {
            foreach ($employee_all_sent_message as $all_sent_message) { ?>

                <table class="table table-striped" style="width: 100%" id="details-table">
                    <tr>
                        <td>
                            <label class="head-font margin-padding-zero message-title-color">
                                <?= ucfirst((strlen($all_sent_message->message_title) > 10) ? substr($all_sent_message->message_title, 0, 10) . '...' : ($all_sent_message->message_title)); ?>
                            </label>
                            <br>
                            <?= ucfirst($all_sent_message->user_name) ?>
                            <br>
                            <?= (date('jS M Y', strtotime(($all_sent_message->notification_date_time)))) ?>
                        </td>
                        <td class="right-side-view">
                            <button class="btn btn-primary message_details_view_button"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="View Details"
                                    data-id="<?= $all_sent_message->id ?>"
                                    data-action="<?= base_url('notification/sent_message_details_view_modal_show') ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>

                </table>
            <?php }
        }
        ?>

        <button class="btn btn-primary btn-block send_message_view_all_button"
                data-toggle="tooltip" data-placement="bottom"
                title="View Details"
                data-id="<? ?>"
                data-action="<?= base_url('notification/view_all_sent_message_modal_show') ?>">
            <i class="fa fa-eye" aria-hidden="true"></i> View All Sent
        </button>

    </div>

    <div class="modal fade view_all_sent_message_modal">
        <div class="modal-dialog view_all_sent_message_show " role="document">

        </div>
    </div>

    <div class="modal fade sent_message_details_view_modal">
        <div class="modal-dialog sent_message_details_show " role="document">

        </div>
    </div>

</div>


<script language="javascript" type="text/javascript">

    $('.message_details_view_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.sent_message_details_view_modal .sent_message_details_show').html(data)
            $('.sent_message_details_view_modal').modal('show');
        });
    });

    $('.send_message_view_all_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.view_all_sent_message_modal .view_all_sent_message_show').html(data)
            $('.view_all_sent_message_modal').modal('show');
        });
    });

</script>











