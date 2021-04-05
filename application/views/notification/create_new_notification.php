<div id="page-wrapper">

    <?php
    $employee_list;
    ?>

    <div class="col-xs-12 row card-margin-top">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="text-align-center panel-heading-color">New Message</h4>
            </div>
            <div class="panel-body">

                <form class="form-group" id="send_new_notification_form" name="send_new_notification_form" method="post"
                      action="<?= base_url('notification/send_new_notification') ?>">

                    <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                        <div class="form-group col-xs-12 text-align-center error-message">
                            <?php
                            echo $this->session->flashdata('message_error')
                            ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($this->session->flashdata('employee_error'))) { ?>
                        <div class="form-group col-xs-12 text-align-center error-message">
                            <?php
                            echo $this->session->flashdata('employee_error')
                            ?>
                        </div>
                    <?php } ?>


                    <?php if (!empty($this->session->flashdata('send_success_message'))) { ?>
                        <div class="form-group col-xs-12 text-align-center success-message">
                            <?php
                            echo $this->session->flashdata('send_success_message')
                            ?>
                        </div>
                    <?php } ?>

                    <div class="col-xs-12">

                        <div class="form-group col-xs-8">

                            <div class="form-group col-xs-12">
                                <label for="message_title" class="col-form-label">Message Title</label>
                                <input class="form-control" id="message_title" name="message_title"
                                       value="" placeholder="Message Title">
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="message_body" class="col-form-label">Message</label>
                                <textarea class="form-control" id="message_body" name="message_body"
                                          rows="4" placeholder="Message"></textarea>
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="propose_time" class="col-form-label">Propose Time</label>
                                <input type="date" class="form-control" id="propose_time" name="propose_time"
                                       value="" placeholder="Propose Time">
                            </div>

                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-default save-button"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                            </div>

                            <div id="on_leave_message_section" class="error-message form-group col-xs-12">

                            </div>

                        </div>

                        <div class="col-xs-4 left-side-vertical-border">
                            <span id="employee-id-error-span-section" class="error error-message"></span>
                            <?php foreach ($employee_list as $employee) { ?>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input employee_id_checkbox" id="employee_id" name="employee_id_list[]" value="<?= $employee->id ?>"><?= ucfirst($employee->employee_name) ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </form>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->

<script>
    $(document).ready(function () {

        $("form[name='send_new_notification_form']").validate({
            rules: {
                message_title: "required",
                message_body: "required",
            },
            messages: {
                message_title: "Please Enter Message Title",
                message_body: "Please Enter Message",
            },
            submitHandler: function (form) {
                var result = confirm('Do you want to send this Message ?');
                if (result) {
                    if (result == true) {
                        var res = get_employee_id_select_or_not();
                        if (res == true) {
                            form.submit();
                        } else {
                            $('#employee-id-error-span-section').html('Please Select at least one employee');
                        }
                    } else {

                    }
                }
            }
        });

        function get_employee_id_select_or_not()
        {
            var employee_id = $("input[name='employee_id_list[]']").serializeArray();
            if (employee_id.length == 0) {
//                alert('Please Selcet Employee');
                return false;
            } else {
                return true;
            }
        }

        $('.employee_id_checkbox').click(function () {

            if (!$(this).is(':checked')) {
                //alert('unchecked');
                var employee_id = $(this).attr('value');
                var propose_time = $('#propose_time').val();
                var status = false;
                if (!this.checked) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("notification/get_selected_employee_leave_information/"); ?>',
                        data: {'employee_id': employee_id, 'propose_time': propose_time, 'status': status},
                        success: function (data) {
                            $('#on_leave_message_section').html(data);
                            $('#employee-id-error-span-section').html('');
                        },
                        error: function () {

                        }
                    });
                }
            } else {
                //alert('checked');
                var employee_id = $(this).attr('value');
                var propose_time = $('#propose_time').val();
                var status = true;
                if (this.checked) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("notification/get_selected_employee_leave_information/"); ?>',
                        data: {'employee_id': employee_id, 'propose_time': propose_time, 'status': status},
                        success: function (data) {
                            $('#on_leave_message_section').html(data);
                            $('#employee-id-error-span-section').html('');
                        },
                        error: function () {

                        }
                    });
                }
            }
        });

    });
</script>


