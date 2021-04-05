<div id="page-wrapper">

    <?php
    $income_head_list;
    $expense_head_list;
    $employee_list;
    $client_list;

    $current_month = date('F');
    $current_year = date('Y');
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Credit Voucher Information</h4>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="success-message text-align-center form-group row">
                            <?php
                            if (!empty($this->session->flashdata('voucher_success_message'))) {
                                echo $this->session->flashdata('voucher_success_message');
                            }
                            ?>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-xs-12">

                            <div class="product-show-part">

                                <form id="voucher_info_form" name="voucher_info_form"
                                      action="<?= base_url('accounts/voucher/get_voucher_info_in_table') ?>"
                                      method="post">

                                    <div class="error" style="color: red">
                                        <?php echo validation_errors(); ?>
                                    </div>

                                    <div class="col-xs-12">

                                        <div class="panel panel-default col-xs-12 col-sm-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4 class="">Income(Cr)</h4>
                                                </div>
                                            </div>
                                            <div class="panel-body">

                                                <div class="col-xs-10">
                                                    <label for="income_head_id" class="col-form-label">Income
                                                        Head</label>
                                                    <select name="income_head_id" id="income_head_id"
                                                            class="form-control">
                                                        <option value="" name="income_head_id"></option>
                                                        <?php foreach ($income_head_list as $income_head) { ?>
                                                            <option class="send" value="<?= $income_head->id ?>"
                                                                    name="income_head_id"><?= $income_head->head_name ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p>&nbsp;</p>
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                               name="head_radio" id="head_radio" value="cr"
                                                               checked>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- /.panel-body -->
                                        </div>

                                        <div class="card panel panel-default col-xs-12 col-sm-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4 class="">Expense(Dr)</h4>
                                                </div>
                                            </div>
                                            <div class="panel-body">

                                                <div class="col-xs-10">
                                                    <label for="expense_head_id" class="col-form-label">Expense
                                                        Head</label>
                                                    <select name="expense_head_id" id="expense_head_id"
                                                            class="form-control">
                                                        <option value="" name="expense_head_id"></option>
                                                        <?php foreach ($expense_head_list as $expense_head) { ?>
                                                            <option class="send" value="<?= $expense_head->id ?>"
                                                                    name="expense_head_id"><?= $expense_head->head_name ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-xs-2">
                                                    <p>&nbsp;</p>
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                               name="head_radio" id="head_radio" value="dr">
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- /.panel-body -->
                                        </div>

                                    </div>

                                    <div class="col-xs-12 panel-resize">
                                        <div class="card panel panel-default col-xs-12">
                                            <div class="panel-body">
                                                <div class="col-xs-12">

                                                    <div class="row col-xs-12">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <label for="total_amount"
                                                                   class="col-form-label">Amount</label>
                                                            <input class="form-control" id="total_amount"
                                                                   name="total_amount" value="" placeholder="Amount">
                                                        </div>

                                                        <div class="col-xs-12 col-sm-6">
                                                            <label for="client_id" class="col-form-label">Client</label>
                                                            <select name="client_id" id="client_id"
                                                                    class="form-control">
                                                                <option value="" name="client_id" label="">
                                                                    <?php foreach ($client_list as $client) { ?>
                                                                        <?php if (strtolower($client->client_type) == 'import') { ?>
                                                                        <option class="import-type-color"
                                                                                value="<?= $client->id ?>"
                                                                                name="client_id"><?= $client->client_name ?>
                                                                        </option>
                                                                    <?php } else { ?>
                                                                        <option class="lubzone-type-color"
                                                                                value="<?= $client->id ?>"
                                                                                name="client_id"><?= $client->client_name ?>
                                                                        </option>
                                                                    <?php } ?>

                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row col-xs-12">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <label for="invoice_number" class="col-form-label">Invoice
                                                                Number</label>
                                                            <input class="form-control" id="invoice_number"
                                                                   name="invoice_number"
                                                                   value="" placeholder="Invoice Number">
                                                        </div>

                                                        <div class="col-xs-12 col-sm-6">
                                                            <label for="mr_number" class="col-form-label">MR
                                                                Number</label>
                                                            <input class="form-control" id="mr_number" name="mr_number"
                                                                   value="" placeholder="MR Number">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" col-xs-12">
                                                    <div class="col-xs-12 col-sm-4">
                                                        <label for="employee_id" class="col-form-label">Employee</label>
                                                        <select name="employee_id" id="employee_id"
                                                                class="form-control">
                                                            <option value="" name="employee_id" label="">
                                                                <?php foreach ($employee_list as $employee) { ?>
                                                                <option value="<?= $employee->id ?>"
                                                                        name="employee_id"><?= $employee->employee_name ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-4">
                                                        <label for="month" class="col-form-label">Month</label>
                                                        <select name="month" id="month" class="form-control">
                                                            <option
                                                                value="<?= strtolower($current_month) ?>" <?= (!empty($current_month)) ? 'selected="selected"' : '' ?>
                                                                name="month"><?= $current_month ?></option>
                                                            <option value="" name="month">Please Select</option>
                                                            <?php
                                                            for ($m = 1; $m <= 12; ++$m) {
                                                                ?>
                                                                <option
                                                                    value="<?= strtolower(date('F', mktime(0, 0, 0, $m, 1))) ?>"
                                                                    name="month"><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-4">
                                                        <label for="year" class="col-form-label">Year</label>
                                                        <select name="year" id="year" class="form-control">
                                                            <option
                                                                value="<?= $current_year ?>" <?= (!empty($current_year)) ? 'selected="selected"' : '' ?>
                                                                name="year"><?= $current_year ?></option>
                                                            <option value="" name="year">Please Select</option>
                                                            <?php
                                                            $start_Year = '2016';
                                                            $current_year = date('Y');
                                                            $diff = ($current_year - $start_Year);
                                                            $lastYear = ($start_Year + $diff);
                                                            if ($start_Year == $current_year) {
                                                                ?>
                                                                <option value="<?= $current_year ?>"
                                                                        name="year"><?= $current_year ?></option>
                                                                        <?php
                                                                    } else {
                                                                        for ($i = $start_Year; $i <= $lastYear; $i++) {
                                                                            ?>
                                                                    <option value="<?= $i ?>"
                                                                            name="year"><?= $i ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12">
                                                    <div class="form-group col-xs-12 col-sm-10">
                                                        <label for="narration"
                                                               class="col-form-label">Narration/Note</label>
                                                        <textarea class="form-control" id="narration" name="narration" rows="1"
                                                                  placeholder="Narration"></textarea>
                                                    </div>

                                                    <div class="form-group col-xs-12 col-sm-2">
                                                        <label for="" class="col-form-label"></label>

                                                        <div class="col-lg-12">
                                                            <div class="modal fade" id="add-narration-modal"
                                                                 tabindex="-1"
                                                                 role="dialog"
                                                                 aria-labelledby="add-narration-modal-label"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <h4 class="modal-title"
                                                                                id="add-narration-modal-label">Narration
                                                                                List</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <?php
                                                                            if (!empty($narration_list)) {
                                                                                foreach ($narration_list as $narration) {
                                                                                    ?>
                                                                                    <div class="radio">
                                                                                        <label>
                                                                                            <input type="radio"
                                                                                                   id="narration_radio"
                                                                                                   name="narration_radio"
                                                                                                   value="<?= $narration->narration ?>">
                                                                                                   <?= $narration->narration ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-danger modal-close-button"
                                                                                    data-dismiss="modal">Close
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <label class="btn btn-primary btn-block add-narration"
                                                                   data-toggle="modal"
                                                                   data-target="#add-narration-modal">Find</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                    </div>

                                    <div class="form-group row col-xs-12">
                                        <button type="submit" class="btn btn-default add-product-button right-side-view"
                                                id="add-product-button">Add
                                        </button>
                                    </div>

                                    <div class="error-message right-side-view">
                                        <?php
                                        if (!empty($this->session->flashdata('voucher_info_table_error_message'))) {
                                            echo $this->session->flashdata('voucher_info_table_error_message');
                                        }
                                        ?>
                                    </div>

                                </form>

                                <div class="form-group row error-message text-align-center">
                                    <?php
                                    if (!empty($this->session->flashdata('debit_credit_error_message'))) {
                                        echo $this->session->flashdata('debit_credit_error_message');
                                    }
                                    ?>
                                </div>

                                <div class="col-xs-12 credit-voucher-info-table-block" id="">
                                    <?php if (!empty($this->session->userdata('voucher_info'))) { ?>
                                        <table class="table table-striped table-bordered table-hover table-responsive"
                                               id="product-table">

                                            <div class="error-message text-align-center">
                                                <?php
                                                if (!empty($this->session->flashdata('head_add_error_message'))) {
                                                    echo $this->session->flashdata('head_add_error_message');
                                                }
                                                ?>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Income Head</th>
                                                    <th>Expense Head</th>
                                                    <th>Amount</th>
                                                    <th>Invoice Number</th>
                                                    <th>MR Number</th>
                                                    <th>Client</th>
                                                    <th>Employee</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            $voucher_info = $this->session->userdata('voucher_info');
                                            ?>

                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($voucher_info as $voucher):
                                                    ?>
                                                    <tr>
                                                        <td><?= $count++ ?></td>
                                                        <td><?= $voucher['income_head_name'] ?></td>
                                                        <td><?= $voucher['expense_head_name'] ?></td>
                                                        <td><?= $voucher['total_amount'] ?></td>
                                                        <td><?= $voucher['invoice_number'] ?></td>
                                                        <td><?= $voucher['mr_number'] ?></td>
                                                        <td><?= $voucher['client_name'] ?></td>
                                                        <td><?= $voucher['employee_name'] ?></td>
                                                        <td><?= $voucher['debit_amount'] ?></td>
                                                        <td><?= $voucher['credit_amount'] ?></td>
                                                        <td>
                                                            <a href="<?= base_url("accounts/voucher/delete_voucher_info/" . $voucher['array_id']) ?>"
                                                               class="btn btn-danger"><i class="fa fa-times"
                                                                                      aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td><?= $this->session->userdata('voucher_debit_amount'); ?></td>
                                                    <td><?= $this->session->userdata('voucher_credit_amount'); ?></td>
                                                    <td></td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    <?php } ?>

                                </div>
                            </div>


                            <form id="save_voucher_info_form" class="save_voucher_info_form"
                                  action="<?= base_url('accounts/voucher/save_voucher') ?>"
                                  method="post">

                                <div class="form-group col-xs-12">

                                    <div class="form-group row">

                                        <div class="form-group col-xs-12 col-sm-6">
                                            <label for="posting_date" class="col-form-label">Date</label>
                                            <input type="date" class="form-control" id="posting_date"
                                                   name="posting_date" value="<?= date('Y-m-d') ?>"
                                                   placeholder="">
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-6">
                                            <label for="voucher_number" class="col-form-label">Voucher
                                                Number</label>
                                            <input readonly="readonly" type="text" class="form-control"
                                                   id="voucher_number"
                                                   name="voucher_number" value="<?= $voucher_number; ?>"
                                                   placeholder="Voucher Number">
                                        </div>

                                    </div>

                                    <div class="col-xs-12">

                                        <div class="form-group row">

                                            <div class="form-group col-xs-12 col-sm-10">
                                                <label for="common_narration"
                                                       class="col-form-label">Narration/Note</label>
                                                <textarea class="form-control" id="common_narration"
                                                          name="common_narration" rows="2"
                                                          placeholder="Narration"></textarea>
                                            </div>

                                            <div class="form-group col-xs-12 col-sm-2">
                                                <label for="" class="col-form-label"></label>

                                                <div class="col-lg-12">
                                                    <div class="modal fade" id="add-common-narration-modal"
                                                         tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="add-common-narration-modal-label"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <h4 class="modal-title"
                                                                        id="add-common-narration-modal-label">Narration
                                                                        List</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php
                                                                    if (!empty($narration_list)) {
                                                                        foreach ($narration_list as $narration) {
                                                                            ?>
                                                                            <div class="radio">
                                                                                <label>
                                                                                    <input type="radio"
                                                                                           id="common_narration_radio"
                                                                                           name="common_narration_radio"
                                                                                           value="<?= $narration->narration ?>">
                                                                                           <?= $narration->narration ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-danger modal-close-button"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <label class="btn btn-primary btn-block add-narration"
                                                           data-toggle="modal"
                                                           data-target="#add-common-narration-modal">Find</label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <button type="submit"
                                        class="btn btn-default save-button confirm-button voucher-print-button">Confirm
                                </button>

                            </form>

                            <div class="col-xs-12">

                                <form class="" id="clear_session" name="clear_session" method="post"
                                      action="<?= base_url('accounts/voucher/clear_voucher_info_table_session') ?>">
                                    <button style="float: right" type="submit"
                                            class="btn btn-default add-product-button cancel-button-color"
                                            id="add-product-button">Clear
                                    </button>
                                </form>

                            </div>
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
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->


<!--Display None For Print-->

<div style="display: none">

    <div id="print-information" onload="">

        <div style="width: 100%">
            <div>
                <h2 style="text-align: center;"><?= strtoupper($company_information->company_name_1) ?></h2>
            </div>

            <div>
                <h4 style="text-align: center;">Cash/Bank Payment & Received voucher</h4>
            </div>

            <div>
                <h4 style="text-align: left;padding-left: 10px">voucher No:</h4>
            </div>

            <div style="width: 100%; padding: 10px">
                <?php
//$voucher_info = $this->session->userdata('voucher_info');
//$voucher_info = $this->session->userdata('voucher_Session_for_print');
//var_dump($voucher_info = $this->session->userdata('voucher_Session_for_print'));
                $voucher_info = $this->session->userdata('voucher_Session_for_print')
                ?>

                <table class="table" border="1px" cellspacing="0" width="100%">
                    <thead class="thead-inverse">
                        <tr>
                            <th style="text-align: center">Date</th>
                            <th style="text-align: center">Particular</th>
                            <th style="text-align: center">DR</th>
                            <th style="text-align: center">CR</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($voucher_info)) {
                        usort($voucher_info, function ($a, $b) {
                            return $a['income_head_id'] - $b['income_head_id'];
                        });
                        foreach ($voucher_info as $voucher) {
                            ?>
                            <tr>
                                <td width="10%"></td>
                                <?php if (!empty($voucher['expense_head_id'])) { ?>
                                    <td width="60%" style="text-align: left">
                                        By <?= $voucher['expense_head_name'] ?></td>
                                    <td width="15%" style="text-align: right"><?= $voucher['debit_amount'] ?></td>
                                    <td width="15%" style="text-align: right"></td>
                                <?php } else { ?>
                                    <td width="60%" style="text-align: right">
                                        To <?= $voucher['income_head_name'] ?></td>
                                    <td width="15%" style="text-align: right"></td>
                                    <td width="15%" style="text-align: right"><?= $voucher['credit_amount'] ?></td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tbody>
                        <tr>
                            <td width="10%"></td>
                            <td width="60%" style="text-align: center; font-weight: bold">Total</td>
                            <td width="15%"
                                style="text-align: right"><?= $this->session->userdata('voucher_debit_amount'); ?></td>
                            <td width="15%"
                                style="text-align: right"><?= $this->session->userdata('voucher_credit_amount'); ?></td>
                        </tr>
                        <tr>
                            <td width="10%"></td>
                            <td width="60%" style="text-align: left">In
                                words: <?= convert_number_to_words((double) ($this->session->userdata('voucher_debit_amount'))) . ' taka only'; ?></td>
                            <td width="15%"></td>
                            <td width="15%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="width: 100%">
                <div style="padding: 10px">
                    Narration
                </div>
            </div>

            <div style="width: 100%;">

                <table width="100%" border="0">
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Received By
                        </td>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Accounts
                        </td>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Director
                        </td>
                        <td style="text-align: center;">
                            <hr width="60%">
                            Managing Director
                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>
    <?php
    if (!empty($this->session->userdata('voucher_Session_for_print'))) {

        var_dump($this->session->userdata('voucher_Session_for_print'));
        //$this->session->unset_userdata('voucher_Session_for_print');
        //echo '<body id="print-information" onload="window.print()">';
        echo '<div id="print-information" onload="window.print()"></div>';
    }
    ?>
</div>


<script>

    $('#voucher_info_form').validate({
        rules: {
            total_amount: "required",
        },
        messages: {
            total_amount: "Please Enter Amount",
        },

        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },

        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                success: function (data) {
                    $('.credit-voucher-info-table-block').html(data);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
            $('#income_head_id').val('');
            $('#expense_head_id').val('');
            $('#total_amount').val('');
            $('#client_id').val('');
            $('#invoice_number').val('');
            $('#mr_number').val('');
            $('#employee_id').val('');
        }
    });

    $('#save_voucher_info_form').validate({

        rules: {
            posting_date: "required",
            voucher_number: "required",
            common_narration: "required",
        },
        messages: {
            posting_date: "Please Select Date",
            voucher_number: "Please Enter Voucher Number",
            common_narration: "Please Enter Narration",
        },
        submitHandler: function (form) {
            var result = confirm('Do you want to submit this voucher ?');
            if (result) {
                if (result == true) {
                    form.submit();
                    location.reload();

                } else {

                }
                //PrintDiv();
            }
        }
    });

    function PrintDiv() {
        var divToPrint = document.getElementById('print-information');
        var popupWin = window.open('', '_blank', 'width=400,height=800');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }

    // for narration
    $('#add-narration-modal .modal-body .radio').on('click', function () {
        var narration_checked_result = $('input[name="narration_radio"]:checked').val();
        $('#narration').val(narration_checked_result);
    });

    // for common narration
    $('#add-common-narration-modal .modal-body .radio').on('click', function () {
        var common_narration_checked_result = $('input[name="common_narration_radio"]:checked').val();
        $('#common_narration').val(common_narration_checked_result);
    });

</script>





