<div class="modal-content">

    <?php
    $employee_total_received_message;
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">View All Received Message</h4>
    </div>

    <div class="modal-body col-xs-12">

        <div style="width: 100%;">
            <?php
            $count = 1;
            if (!empty($employee_total_received_message)) {
                foreach ($employee_total_received_message as $all_received_message) {
                    ?>

                    <table class="table table-striped" style="width: 100%" id="details-table">
                        <tr>
                            <!--<td><?/*= $count++; */ ?></td>-->
                            <!--<td><?/*= $all_received_message->message_title */ ?></td>-->
                            <td>
                                <label class="head-font margin-padding-zero message-title-color">
                                <?= ucfirst((strlen($all_received_message->message_title) > 10) ? substr($all_received_message->message_title, 0, 10) . '...' : ($all_received_message->message_title)); ?>
                                </label>
                                <br>
                                <?= ucfirst($all_received_message->employee_name) ?>
                                <br>
        <?= (date('jS M Y', strtotime(($all_received_message->notification_date_time)))) ?>
                            </td>
                            <td class="right-side-view">
                                <button class="btn btn-primary message_details_view_button"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="View Details"
                                        data-id="<?= $all_received_message->id ?>"
                                        data-action="<?= base_url('notification/received_message_details_view_modal_show') ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>

                    </table>
                <?php
                }
            }
            ?>
        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<script language="javascript" type="text/javascript">

    $('.message_details_view_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.received_message_details_view_modal .received_message_details_show').html(data)
            $('.received_message_details_view_modal').modal('show');
        });
    });

</script>




