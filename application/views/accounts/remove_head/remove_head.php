<?php
$remove_array_column = (json_decode(json_encode($remove_head_list), true));
$remove_head_id_array = array_column((array) $remove_array_column, 'head_id');
?>
<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Remove Head</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 update_closing_balance_form_block">
                            <form id="remove_head_form" name="remove_head_form" action="<?= base_url('accounts/remove_head/remove_head_save') ?>" method="post">
                                <?php if (!empty($this->session->flashdata('remove_head_save_success_message'))) { ?>
                                    <div class="text-align-center success-message"><?= $this->session->flashdata('remove_head_save_success_message') ?></div>
                                <?php }
                                ?>
                                <div class="form-group row col-xs-12 div-margin-top">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-justified">
                                                <li class="nav-item active">
                                                    <a class="nav-link active" data-toggle="tab" href="#head-details-dr-panel" role="tab">Dr</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#head-details-cr-panel" role="tab">Cr</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#head-details-both-panel" role="tab">Both</a>
                                                </li>
                                            </ul>
                                            <!-- Tab panels -->
                                            <div class="tab-content card">
                                                <!--Panel 1-->
                                                <div class="tab-pane fade in active" id="head-details-dr-panel" role="tabpanel">
                                                    <table class="div-margin-top table-striped table-responsive" style="width:100%">
                                                        <tr>
                                                            <th class="text-align-left">SL</th>
                                                            <th class="text-align-left">Head Name(Dr)</th>
                                                            <th class="text-align-left">Select</th>
                                                        </tr>
                                                        <?php
                                                        $count_dr = 1;
                                                        foreach ($head_details_list_by_head_type_dr as $head_details_dr) {
                                                            ?>
                                                            <tr>
                                                                <td width="4%" class="text-align-left"><?= $count_dr++ ?></td>
                                                                <td width="80%" class="text-align-left font-size-sixteen"><?= ucfirst($head_details_dr->head_name) ?></td>
                                                                <td width="8%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="head_id_list[]" value="<?= $head_details_dr->id ?>"  <?= (array_search(intval($head_details_dr->id), $remove_head_id_array)) ? 'checked' : '' ?>></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                                <!--/.Panel 1-->
                                                <!--Panel 2-->
                                                <div class="tab-pane fade" id="head-details-cr-panel" role="tabpanel">
                                                    <table class="div-margin-top table-striped table-responsive" style="width:100%">
                                                        <tr>
                                                            <th class="text-align-left">SL</th>
                                                            <th class="text-align-left">Head Name(Cr)</th>
                                                            <th class="text-align-left">Select</th>
                                                        </tr>
                                                        <?php
                                                        $count_cr = 1;
                                                        foreach ($head_details_list_by_head_type_cr as $head_details_cr) {
                                                            ?>
                                                            <tr>
                                                                <td width="4%" class="text-align-left"><?= $count_cr++ ?></td>
                                                                <td width="80%" class="text-align-left font-size-sixteen"><?= ucfirst($head_details_cr->head_name) ?></td>
                                                                <td width="8%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_cr" name="head_id_list[]" value="<?= $head_details_cr->id ?>" <?= (array_search(intval($head_details_cr->id), $remove_head_id_array)) ? 'checked' : '' ?>></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                                <!--/.Panel 2-->
                                                <!--Panel 3-->
                                                <div class="tab-pane fade" id="head-details-both-panel" role="tabpanel">
                                                    <table class="div-margin-top table-striped table-responsive" style="width:100%">
                                                        <tr>
                                                            <th class="text-align-left">SL</th>
                                                            <th class="text-align-left">Head Name(Both)</th>
                                                            <th class="text-align-left">Select</th>
                                                        </tr>
                                                        <?php
                                                        $count_both = 1;
                                                        foreach ($head_details_list_by_head_type_both as $head_details_both) {
                                                            ?>
                                                            <tr>
                                                                <td width="4%" class="text-align-left"><?= $count_both++ ?></td>
                                                                <td width="80%" class="text-align-left font-size-sixteen"><?= ucfirst($head_details_both->head_name) ?></td>
                                                                <td width="8%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_both" name="head_id_list[]" value="<?= $head_details_both->id ?>" <?= (array_search(intval($head_details_both->id), $remove_head_id_array)) ? 'checked' : '' ?>></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-default save-button div-margin-top" style="margin-right: -2%">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
        $("#remove_head_form").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form) {
                var remove_head_confirm_message = confirm("Are you sure?");
                if (remove_head_confirm_message != true) {
                    return false;
                } else {
                    form.submit();
                }
            }
        });
    });
</script>




