<div class="form-group div-margin-top">
    <div class="panel panel-default">
        <table class="table table-striped table-bordered table-hover"
               id="product-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Closing Head</th>
                    <th>Opening Head</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($yearend_head_assign_table_list)) {
                    $count = 1;
                    foreach ($yearend_head_assign_table_list as $yearend_head) {
                        $opening_head_details = $this->Head_details_Model->get_head_details($yearend_head->opening_head_id);
                        $closing_head_details = $this->Head_details_Model->get_head_details($yearend_head->closing_head_id);
                        ?>
                        <tr>
                            <td width="5%"><?= $count++; ?></td>
                            <td width="45%"><?= $closing_head_details->head_name . "(" . ucfirst($closing_head_details->head_type) . ")" ?></td>
                            <td width="45%"><?= $opening_head_details->head_name . "(" . ucfirst($closing_head_details->head_type) . ")" ?></td>
                            <td width="5%">
                                <a data-id="<?= $yearend_head->id ?>" class="btn btn-danger yearend_head_assign_delete_button"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    delete_yearend_head_assign_from_table();
    function delete_yearend_head_assign_from_table() {
        $('.yearend_head_assign_delete_button').click(function () {
            var confirm_message = confirm("Are you sure?");
            if (confirm_message != true) {
                return false;
            } else {
                var yearend_head_assign_id = $(this).attr('data-id');
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("settings/yearend_head_assign/delete_yearend_head_assign/") ?>',
                    data: {'yearend_head_assign_id': yearend_head_assign_id},
                    success: function (data) {
                        $('.yearend_head_assign_table_section').html(data);
                        //delete_yearend_head_assign_from_table();
                    },
                    error: function () {

                    }
                });
            }
        });
    }
</script>

