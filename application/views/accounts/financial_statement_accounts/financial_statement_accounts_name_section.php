<form id="financial_statement_accounts_save_form" name="financial_statement_accounts_save_form" action="<?= base_url('accounts/financial_statement_accounts/save_financial_statement_accounts_assign') ?>" method="post">
    <input class="" type="hidden" id="financial_statement_accounts_id" name="financial_statement_accounts_id" value="<?= !empty($financial_statement_accounts_id) ? $financial_statement_accounts_id : '' ?>">
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
                                <th class="text-align-left">Dr</th>
                                <th class="text-align-left">Cr</th>
                            </tr>
                            <?php
                            $count_dr = 1;
                            foreach ($head_details_list_by_head_type_dr as $head_details_dr) {
                                ?>
                                <tr>
                                    <td width="4%" class="text-align-left"><?= $count_dr++ ?></td>
                                    <td width="80%" class="text-align-left font-size-sixteen"><?= ucfirst($head_details_dr->head_name) ?></td>
                                    <td width="8%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="head_id_list[]" value="<?= $head_details_dr->id ?>" <?= ((int) $head_details_dr->financial_statement_accounts_id == (int) $financial_statement_accounts_id) ? 'checked="checked"' : '' ?>></td>
                                    <td width="4%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="<?= 'dr_' . $head_details_dr->id ?>" value="<?= 'dr' ?>" <?= ((int) $head_details_dr->financial_statement_accounts_id == (int) $financial_statement_accounts_id) && (strtolower($head_details_dr->financial_statement_accounts_type) == 'dr') ? 'checked="checked"' : '' ?>></td>
                                    <td width="4%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="<?= 'cr_' . $head_details_dr->id ?>" value="<?= 'cr' ?>" <?= ((int) $head_details_dr->financial_statement_accounts_id == (int) $financial_statement_accounts_id) && (strtolower($head_details_dr->financial_statement_accounts_type) == 'cr') ? 'checked="checked"' : '' ?>></td>
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
                                <th class="text-align-left">Dr</th>
                                <th class="text-align-left">Cr</th>
                            </tr>
                            <?php
                            $count_cr = 1;
                            foreach ($head_details_list_by_head_type_cr as $head_details_cr) {
                                ?>
                                <tr>
                                    <td width="4%" class="text-align-left"><?= $count_cr++ ?></td>
                                    <td width="80%" class="text-align-left font-size-sixteen"><?= ucfirst($head_details_cr->head_name) ?></td>
                                    <td width="8%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_cr" name="head_id_list[]" value="<?= $head_details_cr->id ?>" <?= ((int) $head_details_cr->financial_statement_accounts_id == (int) $financial_statement_accounts_id) ? 'checked="checked"' : '' ?>></td>
                                    <td width="4%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="<?= 'dr_' . $head_details_cr->id ?>" value="<?= 'dr' ?>" <?= ((int) $head_details_cr->financial_statement_accounts_id == (int) $financial_statement_accounts_id) && (strtolower($head_details_cr->financial_statement_accounts_type) == 'dr') ? 'checked="checked"' : '' ?>></td>
                                    <td width="4%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="<?= 'cr_' . $head_details_cr->id ?>" value="<?= 'cr' ?>" <?= ((int) $head_details_cr->financial_statement_accounts_id == (int) $financial_statement_accounts_id) && (strtolower($head_details_cr->financial_statement_accounts_type) == 'cr') ? 'checked="checked"' : '' ?>></td>
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
                                <th class="text-align-left">Dr</th>
                                <th class="text-align-left">Cr</th>
                            </tr>
                            <?php
                            $count_both = 1;
                            foreach ($head_details_list_by_head_type_both as $head_details_both) {
                                ?>
                                <tr>
                                    <td width="4%" class="text-align-left"><?= $count_both++ ?></td>
                                    <td width="80%" class="text-align-left font-size-sixteen"><?= ucfirst($head_details_both->head_name) ?></td>
                                    <td width="8%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_both" name="head_id_list[]" value="<?= $head_details_both->id ?>" <?= ((int) $head_details_both->financial_statement_accounts_id == (int) $financial_statement_accounts_id) ? 'checked="checked"' : '' ?>></td>
                                    <td width="4%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="<?= 'dr_' . $head_details_both->id ?>" value="<?= 'dr' ?>" <?= ((int) $head_details_both->financial_statement_accounts_id == (int) $financial_statement_accounts_id) && (strtolower($head_details_both->financial_statement_accounts_type) == 'dr') ? 'checked="checked"' : '' ?>></td>
                                    <td width="4%" class="text-align-left font-size-sixteen zoom-two"><input type="checkbox" class="form-check-input head_id_checkbox" id="head_id_dr" name="<?= 'cr_' . $head_details_both->id ?>" value="<?= 'cr' ?>" <?= ((int) $head_details_both->financial_statement_accounts_id == (int) $financial_statement_accounts_id) && (strtolower($head_details_both->financial_statement_accounts_type) == 'cr') ? 'checked="checked"' : '' ?>></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <!--/.Panel 3-->
                </div>
                <button type="submit" class="btn btn-default save-button div-margin-top" style="margin-right: -2%">Save</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $("#financial_statement_accounts_save_form").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form) {
                var salary_generate_confirm_message = confirm("Are you sure?");
                if (salary_generate_confirm_message != true) {
                    return false;
                } else {
                    form.submit();
                }
            }
        });
    });
</script>
