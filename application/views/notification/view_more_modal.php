<div class="modal-content">

    <?php
    $employee_by_notification_id;
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

        <div class="col-xs-12">
            <?php
            if (!empty($employee_by_notification_id)) {
                foreach ($employee_by_notification_id as $employee_by_notification) {
                    ?>

                    <label for="message" class="col-for-label view-more-employee-show">
                        <p> <?= ucfirst($employee_by_notification->employee_name) ?></p>
                        <br>
                        <p class="font-size-twelve"><?= ucfirst($employee_by_notification->designation) ?></p>
                    </label>

                <?php }
            }
            ?>
        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>



