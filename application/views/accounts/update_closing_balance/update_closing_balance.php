<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Update Closing Balance</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 update_closing_balance_form_block">
                            <form id="update_closing_balance_form" name="update_closing_balance_form" action="<?= base_url('accounts/update_closing_balance/details_add_into_table') ?>" method="post">
                                <?php if (!empty($this->session->flashdata('update_closing_balance_success_message'))) { ?>
                                <div class="success-message text-align-center" id="success_message"></div>
                                <?php } ?>
                                <div class="form-group row">
                                    <label for="head_id" class="col-sm-2 col-xs-12 col-form-label">Head</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <select name="head_id" id="head_id" class="form-control">
                                            <option value="" name="head_id">Please Select</option>
                                            <?php
                                            if (!empty($head_details_list)) {
                                                foreach ($head_details_list as $head) {
                                                    ?>
                                                    <option class="" value="<?= $head->id ?>" name="head_id"><?= $head->head_name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="amount" class="col-sm-2 col-xs-12 col-form-label">Amount</label>

                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control" id="amount" name="amount" value="" placeholder="Amount">
                                    </div>

                                    <div class="col-sm-4 col-xs-12 balance-type">
                                        <input type="radio" class="form-check-input" name="balance_type" id="balance_type" value="debit"> <label>Debit</label>

                                        <input type="radio" class="form-check-input left-margin-ten" name="balance_type" id="balance_type" value="credit"> <label>Credit</label>
                                        <div class="error"></div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default save-button">Add</button>
                            </form>

                            <div class="col-xs-12 update_closing_balance_table">
                                <?php $this->load->view('accounts/update_closing_balance/update_closing_balance_table', $this->data); ?>
                                <div>
                                    <a href="<?= base_url('accounts/update_closing_balance/update') ?>" type="submit" class="btn btn-default save-button update-closing-balance-save-button">Save</a>
                                    <a href="<?= base_url('accounts/update_closing_balance/update_closing_balance_clear_table_data') ?>" class="btn btn-danger update-closing-balance-close-button" style="float: right; padding: 10px 30px 10px 30px; margin-right: 5px;">Clear</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.update_closing_balance_form_block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
//                    $(".update_closing_balance_table").html(data);
                    location.reload();
                },
                error: function () {

                }
            });
        });

        $('.update-closing-balance-close-button').on("click", function () {
            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                data: $(this).serialize(),
                success: function (data) {
                    location.reload();
                },
                error: function () {

                }
            });
        });
        $('.update-closing-balance-save-button').on("click", function () {
            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                data: $(this).serialize(),
                success: function (data) {
                    alert('information has been saved succcessfully.');
                    location.reload();
//                    $("#success_message").html(data['success_message']);
//                    window.setTimeout(function () {
//                        location.reload()
//                    }, 3000)
                },
                error: function () {

                }
            });
        });


    });
</script>



