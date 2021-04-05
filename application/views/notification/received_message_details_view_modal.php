<div class="modal-content">

    <?php
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Received Message Details</h4>
    </div>

    <div class="modal-body">

        <div class="col-xs-12">

            <div class="col-xs-12 col-sm-12">

                <div class="form-group col-xs-12">
                    <label for="message"
                           class="col-xs-12 col-form-label date-color"><strong
                            class="head-font">Date:</strong><?= (!empty($creator_by_notification_id)) ? (date('jS M Y h:i A', strtotime(($creator_by_notification_id->notification_date_time)))) : '' ?>
                    </label>
                    <label for="message"
                           class="col-xs-12 col-form-label creator-color"><strong
                            class="head-font">Creator:</strong><?= (!empty($creator_by_notification_id)) ? ucfirst($creator_by_notification_id->user_name) : '' ?>
                    </label>

                </div>

                <div class="form-group col-xs-12">

                    <div class="col-xs-12">
                        <?php
                        $count = 0;
                        if (!empty($employee_by_notification_id)) {
                            foreach ($employee_by_notification_id as $employee_by_notification) {
                                ?>
        <?php if ($count == 5) { ?>
                                    <button class="view_more_button selected-employee-show"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="View More" data-id="<?= $employee_by_notification->id ?>"
                                            data-action="<?= base_url('notification/old_message_view_more_modal_show') ?>">
                                        <i class="fa fa-plus" aria-hidden="true"></i>More
                                    </button>
                                <?php }
                                $count++;
                                ?>
                                <?php
                                if ($count > 5) {
                                    continue;
                                } else {
                                    ?>
                                    <label for="message" class="col-for-label selected-employee-show">
                                    <?= ucfirst($employee_by_notification->employee_name) ?>
                                    </label>
            <?php
        }
    }
}
?>
                    </div>

                </div>

                <div class="form-group col-xs-12">
                    <label for="message_title" class="col-form-label">Title</label>
                    <input readonly="readonly" class="form-control" id="message_title"
                           name="message_title"
                           value="<?= (!empty($creator_by_notification_id)) ? ($creator_by_notification_id->message_title) : '' ?>"
                           placeholder="Message Title">
                </div>

                <div class="form-group col-xs-12">
                    <label for="message_body" class="col-form-label">Message</label>
                    <textarea readonly="readonly" class="form-control" id="message_body"
                              name="message_body" rows="4" placeholder="message">
<?= (!empty($creator_by_notification_id)) ? ($creator_by_notification_id->message_body) : '' ?>
                    </textarea>
                </div>
            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<script language="javascript" type="text/javascript">

    $('.view_more_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.view_more_modal .view_more_show').html(data)
            $('.view_more_modal').modal('show');
        });
    });

</script>




