<!--Edit salary details-->
<div id="page-wrapper">
    <?php
    $employee;
    $employee_salary_details;
    $employee_loan_information;
    $pf_funds_by_employee_id;
    $company_information;

//    echo '<pre>';
//    print_r($employee_salary_details);
//    echo '</pre>';
//    die();
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Salary Generate of <strong><?= ucwords(strtolower($employee_salary_details->employee_name)) ?></strong><?= !empty($employee_salary_details->month) ? ' - ' . ucfirst($employee_salary_details->month) : '' ?>, <?= !empty($employee_salary_details->year) ? $employee_salary_details->year : '' ?></h4>
                </div>
                <div class="error" style="color: red">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="salary_generate_form" name="salary_generate_form"
                                  action="<?= base_url('employee_salary_generate/salary_generate_update') ?>"
                                  method="post">

                                <input type="hidden" id="employee_id" name="employee_id"
                                       value="<?= $employee_salary_details->employee_id ?>">
                                <input type="hidden" id="salary_details_id" name="salary_details_id"
                                       value="<?= $employee_salary_details->id ?>">

                                <div class="col-xs-12 col-sm-6">

                                    <table class="table table-striped" id="employee-details-table"
                                           style="border: 1px solid gray">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Description</th>
                                                <th class="right-side-view">TK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>BASIC</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="basic_salary" name="basic_salary" value="<?= number_format((double) ($employee_salary_details->basic_salary), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>ADD</strong></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>CELL PHONE</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="phone_allowance" name="phone_allowance" value="<?= number_format((double) ($employee_salary_details->phone_allowance), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>TUITION ASSISTANCE</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="tuition_allowance" name="tuition_allowance" value="<?= number_format((double) ($employee_salary_details->tuition_allowance), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4.</td>
                                                <td>ATTENDANCE ASSISTANCE</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="attendance_allowance" name="attendance_allowance" value="<?= number_format((double) ($employee_salary_details->attendance_allowance), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5.</td>
                                                <td>BONUS</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="bonus" name="bonus" value="<?= number_format((double) ($employee_salary_details->bonus), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6.</td>
                                                <td>OTHERS</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="others" name="others" value="<?= number_format((double) ($employee_salary_details->others), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7.</td>
                                                <td>OTHERS BENEFIT</td>
                                                <td class="right-side-view"><input class="right-side-view text-align-right" type="text" id="others_benefit" name="others_benefit" value="<?= number_format((double) ($employee_salary_details->others_benefit), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>8.</td>
                                                <td>P/F CONTRIBUTION COMPANY PART</td>
                                                <td class="right-side-view"><?= number_format((double) ($employee_salary_details->pf_contribution_company_part), 2, '.', '') ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="right-side-view"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><strong>GROSS SALARY</strong></td>
                                                <td class="right-side-view">
                                                    <strong><?= number_format((double) ($employee_salary_details->gross_salary), 2) ?></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>LESS</strong></td>
                                                <td></td>
                                                <td class="right-side-view"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>P/F CONTRIBUTION COMPANY PART</td>
                                                <td class="right-side-view"><?= number_format((double) ($employee_salary_details->pf_contribution_company_part), 2, '.', '') ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>P/F STAFF CONTRIBUTION</td>
                                                <td class="right-side-view"><?= number_format((double) ($employee_salary_details->pf_contribution), 2, '.', '') ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>OTHERS BENEFIT</td>
                                                <td class="right-side-view">
                                                    <input class="text-align-right" type="text" id="less_others_benefit" name="less_others_benefit" value="<?= number_format((double) ($employee_salary_details->less_others_benefit), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>OTHERS MISC</td>
                                                <td class="right-side-view">
                                                    <input class="text-align-right" type="text" id="less_others_misc" name="less_others_misc" value="<?= number_format((double) ($employee_salary_details->less_others_misc), 2, '.', '') ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="text-align: center"><strong>NET SALARY</strong></td>
                                                <td class="right-side-view">
                                                    <strong><?= number_format((double) ($employee_salary_details->net_salary), 2) ?></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>LOAN INSTALLMENT</td>
                                                <td class="right-side-view"><?= number_format((double) ($employee_salary_details->loan_installment), 2, '.', '') ?></td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td style="text-align: center"><strong>TAKE HOME SALARY</strong></td>
                                                <td class="right-side-view">
                                                    <strong><?= number_format((double) ($employee_salary_details->take_home_salary), 2) ?></strong>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>

                                <div class="col-xs-12 col-sm-6">

                                    <div class="col-xs-12">

                                        <table class="table table-striped" id="employee-pf-details-table"
                                               style="border: 1px solid gray">
                                            <thead>
                                                <tr>
                                                    <th>P/F ACCOUNT</th>
                                                    <th class="right-side-view text-align-right">TK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Opening</td>
                                                    <td class="right-side-view text-align-right previous_deposit_amount"><?= number_format((double) ($employee_salary_details->previous_deposit_amount), 2) ?></td>
                                                </tr>
                                                <!--<tr>
                                                    <td>B/F</td>
                                                    <td></td>
                                                </tr>-->
                                                <tr>
                                                    <td>ADD : Monthly P/F</td>
                                                    <td><input class="right-side-view text-align-right" type="text" id="pf_contribution" name="pf_contribution" value="<?= !empty($pf_details_by_salary_details_id->deposit_amount) ? number_format($pf_details_by_salary_details_id->deposit_amount, 2, '.', '') : number_format(0, 2, '.', '') ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>PRESENT P/F BALANCE</td>
                                                    <td class="right-side-view"><?= number_format((double) ($employee_salary_details->deposit_amount_total), 2) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-xs-12">

                                        <table class="table table-striped" id="employee-loan-details-table"
                                               style="border: 1px solid gray">
                                            <thead>
                                                <tr>
                                                    <th>LOAN ACCOUNT</th>
                                                    <th class="right-side-view">TK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Pay</td>
                                                    <td class="right-side-view"><?= number_format((double) ((!empty($employee_loan_information->previous_loan_payment)) ? $employee_loan_information->previous_loan_payment : 0), 2) ?></td>
                                                </tr>
                                                <!--<tr>
                                                    <td>B/F From Last Month</td>
                                                    <td></td>
                                                </tr>-->
                                                <tr>
                                                    <td>Loan Per Installment</td>
                                                    <td><input class="right-side-view text-align-right" type="text" id="loan_per_installment" name="loan_per_installment" value="<?= number_format((double) ((!empty($employee_loan_information->total_loan_payment)) ? ((double) $employee_loan_information->total_loan_payment - (double) $employee_loan_information->previous_loan_payment) : 0), 2, '.', '') ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">LOAN REMAINING</td>
                                                    <td class="right-side-view text-align-right"><?= number_format((double) ((!empty($employee_loan_information->due_loan_amount)) ? $employee_loan_information->due_loan_amount : 0), 2) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <button type="submit"
                                                class="btn btn-default save-button salary-generate-button">Update
                                        </button>

                                        </form>

                                        <form>

                                            <button type="submit"
                                                    class="btn btn-default save-button salary-generate-button print-button-color salary-print-button">
                                                Print
                                            </button>

                                        </form>

                                        <form action="<?= base_url('employee_salary_generate') ?>" method="post">
                                            <button type="submit"
                                                    class="btn btn-default save-button salary-generate-button cancel-button-color">
                                                Back
                                            </button>
                                        </form>

                                    </div>

                                </div>

                        </div>
                        <!-- /.col-lg-6 (nested) -->

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

<!--DISPLAY NONE-->
<!--FOR PRINT-->

<div style="display: none" class="col-xs-12 col-sm-6" id="print-information">

    <div style="margin: 10px">

    </div>

    <div>
        <h2 style="text-align: center;"><?= strtoupper($company_information->company_name_1) ?></h2>
    </div>

    <div>
        <h4 style="text-align: center">PAYSLIP FOR THE MONTH OF &nbsp
            <u><?= strtoupper($employee_salary_details->month) ?></u> &nbsp
            <u><?= strtoupper($employee_salary_details->year) ?></u></h4>
    </div>

    <div style="">
        NAME &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp : &nbsp
        &nbsp<?= strtoupper($employee_salary_details->employee_name) ?>
    </div>

    <div style="">
        <table width="100%">
            <tr>
                <td>DESIGNATION &nbsp &nbsp &nbsp : &nbsp
                    &nbsp<?= strtoupper($employee_salary_details->designation) ?></td>
                <td style="text-align: right">STAFF ID &nbsp &nbsp : &nbsp &nbsp
                    &nbsp<?= strtoupper($employee_salary_details->employee_code) ?></td>
            </tr>
        </table>
    </div>


    <div style="width: 100%">

        <!--<table class="mytable mytable-head" border="1px" cellspacing="0">
            <tr>
                <td width="10%">25</td>
                <td width="80%">50</td>
                <td width="10%">25</td>
            </tr>
        </table>-->


        <div style="width: 49%; float: left">

            <table border="1px" cellspacing="0" class="table table-striped" id="employee-details-table"
                   style="">
                <thead>
                    <tr>
                        <th style="text-align: center;">SL</th>
                        <th style="text-align: center;">DESCRIPTION</th>
                        <th style="text-align: center;">TK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>ADD</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="">1.</td>
                        <td style="">BASIC</td>
                        <td style=""><input style="border: none; text-align: right" type="text" id="basic_salary"
                                            name="basic_salary"
                                            value="<?= number_format((double) ($employee_salary_details->basic_salary), 2) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="">2.</td>
                        <td style="">CELL PHONE</td>
                        <td style=""><input style="border: none; text-align: right" type="text" id="phone_allowance"
                                            name="phone_allowance"
                                            value="<?= number_format((double) ($employee_salary_details->phone_allowance), 2) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="">3.</td>
                        <td style="">TUITION ASSISTANCE</td>
                        <td style=""><input style="border: none; text-align: right" type="text" id="tuition_allowance"
                                            name="tuition_allowance"
                                            value="<?= number_format((double) ($employee_salary_details->tuition_allowance), 2) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="">4.</td>
                        <td style="">ATTENDANCE ASSISTANCE</td>
                        <td style=""><input style="border: none; text-align: right" type="text" id="attendance_allowance"
                                            name="attendance_allowance"
                                            value="<?= number_format((double) ($employee_salary_details->attendance_allowance), 2) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="">5.</td>
                        <td style="">BONUS</td>
                        <td style=""><input style="border: none; text-align: right" type="text" id="bonus" name="bonus"
                                            value="<?= number_format((double) ($employee_salary_details->bonus), 2) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="">6.</td>
                        <td style="">OTHERS</td>
                        <td style=""><input style="border: none; text-align: right" type="text" id="others" name="others"
                                            value="<?= number_format((double) ($employee_salary_details->others), 2) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>OTHERS BENEFIT</td>
                        <td class="right-side-view"><input style="border: none; text-align: right" class="right-side-view text-align-right"
                                                           type="text" id="others_benefit"
                                                           name="others_benefit"
                                                           value="<?= number_format((double) ($employee_salary_details->others_benefit), 2, '.', '') ?>">
                        </td>
                    </tr><tr>
                        <td>8.</td>
                        <td>P/F CONTRIBUTION COMPANY PART</td>
                        <td style="border: none; text-align: right" class="right-side-view"><?= number_format((double) ($employee_salary_details->pf_contribution_company_part), 2, '.', '') ?></td>
                    </tr>

                    <tr>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px"></td>
                        <td style="padding: 10px; text-align: right"></td>
                    </tr>
                    <tr>
                        <td style=""></td>
                        <td style=""><strong>GROSS SALARY</strong></td>
                        <td style="text-align: right"><strong><?= number_format((double) ($employee_salary_details->gross_salary), 2) ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong>LESS</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>P/F CONTRIBUTION COMPANY PART</td>
                        <td style="text-align: right" class="right-side-view"><?= number_format((double) ($employee_salary_details->pf_contribution_company_part), 2, '.', '') ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>P/F STAFF CONTRIBUTION</td>
                        <td style="text-align: right" class="right-side-view"><?= number_format((double) ($employee_salary_details->pf_contribution), 2, '.', '') ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>OTHERS BENEFIT</td>
                        <td style="text-align: right" class="right-side-view">
                            <input style="border: none; text-align: right" class="text-align-right" type="text" id="less_others_benefit"
                                   name="less_others_benefit"
                                   value="<?= number_format((double) ($employee_salary_details->less_others_benefit), 2, '.', '') ?>">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>OTHERS MISC</td>
                        <td style="text-align: right" class="right-side-view">
                            <input style="border: none; text-align: right" class="text-align-right" type="text" id="less_others_misc"
                                   name="less_others_misc"
                                   value="<?= number_format((double) ($employee_salary_details->less_others_misc), 2, '.', '') ?>">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center"><strong>NET SALARY</strong></td>
                        <td style="text-align: right"><strong><?= number_format((double) ($employee_salary_details->net_salary), 2) ?></strong></td>
                    </tr>
                    <tr>
                        <td style=""></td>
                        <td style="">LOAN INSTALLMENT</td>
                        <td style="text-align: right"><?= number_format((double) ($employee_salary_details->loan_installment), 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center"><strong>TAKE HOME SALARY</strong></td>
                        <td style="text-align: right" class="right-side-view">
                            <strong><?= number_format((double) ($employee_salary_details->take_home_salary), 2) ?></strong>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

        <div style="width: 49%; float: right; margin-left: 2px;">

            <div style="width: 100%; float: right">
                <table border="1px" cellspacing="0" class="" id="employee-pf-details-table-print"
                       style="">
                    <thead>
                        <tr>
                            <th style="">P/F ACCOUNT</th>
                            <th style="text-align: right">TK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="70%">Opening</td>
                            <td width="30%"
                                style="text-align: right"><?= number_format((double) ($employee_salary_details->previous_deposit_amount), 2) ?></td>
                        </tr>
                        <tr>
                            <td width="70%">ADD : Monthly P/F</td>
                            <td width="30%" style=""><input style="border: none;text-align: right" type="text"
                                                            id="pf_contribution" name="pf_contribution"
                                                            value="<?= number_format((double) ($employee_salary_details->pf_contribution), 2) ?>">
                            </td>
                        </tr>
                        <tr>
                            <td width="70%">PRESENT P/F BALANCE</td>
                            <td width="30%"
                                style="text-align: right"><?= number_format((double) ($employee_salary_details->p_total_deposit_amount), 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 100%; float: right; margin-top: 30px">
                <table border="1px" cellspacing="0" class="table table-striped" id="employee-loan-details-table"
                       style="">
                    <thead>
                        <tr>
                            <th>LOAN ACCOUNT</th>
                            <th style="text-align: right">TK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total Pay</td>
                            <td style="text-align: right"><?= number_format((double) ((!empty($employee_loan_information->previous_loan_payment)) ? $employee_loan_information->previous_loan_payment : 0), 2) ?></td>
                        </tr>
                        <tr>
                            <td>Loan Per Installment</td>
                            <td><input style="border: none; text-align: right" type="text" id="loan_per_installment"
                                       name="loan_per_installment"
                                       value="<?= number_format((double) ((!empty($employee_loan_information->total_loan_payment)) ? ((double) $employee_loan_information->total_loan_payment - (double) $employee_loan_information->previous_loan_payment) : 0), 2, '.', '') ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>LOAN AMOUNT REMAINING</td>
                            <td style="text-align: right"><?= number_format((double) ((!empty($employee_loan_information->due_loan_amount)) ? $employee_loan_information->due_loan_amount : 0), 2) ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>

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
                <td style="text-align: center;">
                    <hr width="60%">
                    PREPARED BY
                </td>
                <td style="text-align: center;">
                    <hr width="60%">
                    APPROVED BY
                </td>
                <td style="text-align: center;">
                    <hr width="60%">
                    RECEIVED BY
                </td>
            </tr>

        </table>

    </div>

</div>


<script>
    $(document).ready(function () {

        $("form[name='salary_generate_form']").validate({
            rules: {
                basic_salary: "required",
                phone_allowance: "required",
                tuition_allowance: "required",
                attendance_allowance: "required",
                bonus: "required",
                others: "required",
                pf_contribution: "required",
                loan_per_installment: "required",
            },
            messages: {
                basic_salary: "Please Enter Basic Salary",
                phone_allowance: "Please Enter Phone Allowance",
                tuition_allowance: "Please Enter Tuition Allowance",
                attendance_allowance: "Please Enter Attendence Allowance",
                bonus: "Please Enter Bonus",
                others: "Please Enter Others",
                pf_contribution: "Please Enter P/F contribution",
                loan_per_installment: "Please Enter Loan Per Installment",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $(".salary-print-button").on("click", function () {

            var divContents = $('#print-information').html();

            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";

            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
    });
</script>