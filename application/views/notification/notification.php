<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Create New Expense Head</h2>
        </div>
    </div>-->

    <?php
    $last_sent_message;
    $employee_by_notification_id;
    $employee_all_received_message;
    $employee_all_sent_message;
    ?>

    <div class="col-xs-12">
        <div class="row card-margin-top">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="text-align-center panel-heading-color">Messages</h4>
                    </div>
                    <div class="panel-body">

                        <div class="col-xs-12">
                            <div class="col-xs-12 col-sm-8 right-side-vertical-border">
                                <div class="create-new-button">
                                    <?php echo anchor(base_url('notification/create_new_notification'), '<i class=" fa fa-plus" aria-hidden="true"></i> New Message', 'class="btn btn-primary create-new-button"') ?>
                                </div>

                                <div class="form-group col-xs-6">
                                    <label for="message"
                                           class="col-xs-12 col-form-label date-color"><strong
                                            class="head-font">Date:</strong><?= (!empty($last_sent_message)) ? (date('jS M Y h:i A', strtotime(($last_sent_message->notification_date_time)))) : '' ?>
                                    </label>
                                    <label for="message"
                                           class="col-xs-12 col-form-label creator-color"><strong class="head-font">Creator:</strong><?= (!empty($last_sent_message)) ? ucfirst($last_sent_message->user_name) : '' ?>
                                    </label>

                                </div>

                                <div class="form-group col-xs-12">

                                    <div class="col-xs-12">
                                        <?php $count = 0;
                                        if (!empty($employee_by_notification_id)) {
                                            foreach ($employee_by_notification_id as $employee_by_notification) { ?>
                                                <?php if ($count == 5) { ?>
                                                    <button class="view_more_button selected-employee-show"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="View More"
                                                            data-action="<?= base_url('notification/view_more_modal_show') ?>">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>More
                                                    </button>
                                                <?php }
                                                $count++; ?>
                                                <?php if ($count > 5) {
                                                    continue;
                                                } else {
                                                    ?>
                                                    <label for="message" class="col-for-label selected-employee-show">
                                                        <?= ucfirst($employee_by_notification->employee_name) ?>
                                                    </label>
                                                    <?php
                                                }
                                            }
                                        } ?>
                                    </div>

                                </div>

                                <div class="form-group col-xs-12">
                                    <label for="message_title" class="col-form-label">Current Message Title</label>
                                    <input readonly="readonly" class="form-control" id="message_title"
                                           name="message_title"
                                           value="<?= (!empty($last_sent_message)) ? ($last_sent_message->message_title) : '' ?>"
                                           placeholder="Message Title">
                                </div>

                                <div class="form-group col-xs-12">
                                    <label for="message_body" class="col-form-label">Current Message</label>
                                    <textarea readonly="readonly" class="form-control" id="message_body"
                                              name="message_body" rows="3"
                                              placeholder="Message"><?= (!empty($last_sent_message)) ? ($last_sent_message->message_body) : '' ?></textarea>
                                </div>

                                <div class="form-group col-xs-12">
                                    <label for="propose_time" class="col-form-label">Propose Time</label>
                                    <?php $propose_time = date("Y-m-d", strtotime(!empty($last_sent_message->propose_time))); ?>
                                    <input readonly="readonly" type="date" class="form-control" id="propose_time"
                                           name="propose_time"
                                           value="<?= !empty($propose_time != '0000-00-00 00:00:00	') ? $propose_time : 'mm/dd/yyyy' ?>"
                                           placeholder="Propose Time">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <h4 class="text-align-center panel-heading-color">Old Messages</h4>


                                <div class="col-xs-12 old-message-design old_message_form_block">
                                    <form class="employee_all_received_message_form"
                                          id="employee_all_received_message_form"
                                          name="employee_all_received_message_form"
                                          action="<?= base_url('notification/employee_all_received_message_show') ?>"
                                          method="post">
                                        <div class="col-sm-6 old-message-design">
                                            <button class="col-xs-12 btn btn-primary text-align-center">Received
                                            </button>
                                        </div>
                                    </form>
                                    <form class="employee_all_sent_message_form" id="employee_all_sent_message_form"
                                          name="employee_all_sent_message_form"
                                          action="<?= base_url('notification/employee_all_sent_message_show') ?>"
                                          method="post">
                                        <div class="col-sm-6 old-message-design">
                                            <button class="col-xs-12 btn btn-primary text-align-center">Sent</button>
                                        </div>
                                    </form>

                                    <div class="old_received_message_table old_received_message_table_margin_top">

                                        <div class="card card-boarder">

                                            <?php
                                            $employee_all_sent_message;
                                            ?>
                                            <div style="width: 100%;">
                                                <?php $count = 1;
                                                if (!empty($employee_all_received_message)) {
                                                    foreach ($employee_all_received_message as $all_received_message) { ?>

                                                        <table class="table table-striped" style="width: 100%" id="details-table">
                                                            <tr>
                                                                <!--<td><?/*= $count++; */ ?></td>-->
                                                                <!--<td><?/*= $all_received_message->message_title */ ?></td>-->
                                                                <td>
                                                                    <label
                                                                        class="head-font margin-padding-zero message-title-color">
                                                                        <?= ucfirst((strlen($all_received_message->message_title) > 10) ? substr($all_received_message->message_title, 0, 10) . '...' : ($all_received_message->message_title)); ?>
                                                                    </label>
                                                                    <br>
                                                                    <?= ucfirst($all_received_message->employee_name) ?>
                                                                    <br>
                                                                    <?= (date('jS M Y', strtotime(($all_received_message->notification_date_time)))) ?>
                                                                </td>
                                                                <td class="right-side-view">
                                                                    <button
                                                                        class="btn btn-primary message_details_view_button"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="View Details"
                                                                        data-id="<?= $all_received_message->id ?>"
                                                                        data-action="<?= base_url('notification/received_message_details_view_modal_show') ?>">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    <?php }
                                                }
                                                ?>

                                                <button
                                                    class="btn btn-primary btn-block received_message_view_all_button"
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    title="View Details"
                                                    data-id="<? ?>"
                                                    data-action="<?= base_url('notification/view_all_received_message_modal_show') ?>">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> View All Received
                                                </button>
                                            </div>

                                            <div class="modal fade view_all_received_message_modal">
                                                <div class="modal-dialog view_all_received_message_show "
                                                     role="document">

                                                </div>
                                            </div>

                                            <div class="modal fade received_message_details_view_modal">
                                                <div class="modal-dialog received_message_details_show "
                                                     role="document">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="old_sent_message_table old_received_message_table_margin_top">

                                    </div>

                                </div>
                                <!-- /.col-lg-12 -->
                            </div>

                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>

    <div class="modal fade view_more_modal">
        <div class="modal-dialog view_more_show " role="document">
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script>

    $('.view_more_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), function (data) {
            $('.view_more_modal .view_more_show').html(data)
            $('.view_more_modal').modal('show');
        });
    });

    $('.old_message_form_block form').submit(function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function (data) {
            $(".old_received_message_table").html(data);
        });
    });

    $('.employee_all_sent_message_form form').submit(function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function (data) {
            $(".old_sent_message_table").html(data);
        });
    });

    $('.message_details_view_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.received_message_details_view_modal .received_message_details_show').html(data)
            $('.received_message_details_view_modal').modal('show');
        });
    });

    $('.received_message_view_all_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.view_all_received_message_modal .view_all_received_message_show').html(data)
            $('.view_all_received_message_modal').modal('show');
        });
    });

</script>