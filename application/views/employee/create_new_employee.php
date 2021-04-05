<div id="page-wrapper">
    <style type="text/css">
        .section-title {
            border-bottom: 1px solid #eee;
            background: #eee;
            padding: 10px;
        }
    </style>

    <?php
        $default_employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
    ?>

    <div class="row card-margin-top">
        <?php if (!empty($this->session->flashdata('image_upload_error_message'))) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Opps!</strong> <?= $this->session->flashdata('image_upload_error_message') ?>
            </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6"><h4 class="">Create New Employee</h4></div>
                    <div class="col-md-6 text-right">
                        <a href="<?= base_url('employee') ?>" class="btn btn-primary"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                    </div>
                </div>                
            </div>

            <div class="panel-body">
                <div class="error" style="color: red">
                    <?php echo validation_errors(); ?>
                </div>
                <form id="create_new_employee_form" name="create_new_employee_form" action="<?= base_url('employee/save_employee') ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="section-title"><strong>Personal Information</strong></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="employee_name" class="col-form-label">Employee Name</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name" value="" placeholder="Employee Name">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="employee_code" class="col-form-label">Employee Code</label>
                                <input type="text" class="form-control" id="employee_code" name="employee_code" value="" placeholder="Employee Code">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="employee_email" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="employee_email" name="employee_email" value="" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="designation" class="col-form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="" placeholder="Designation">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="gender" class="col-form-label">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" id="gender">Please Select</option>
                                    <option value="male" name="male" id="gender">Male</option>
                                    <option value="female" name="female" id="gender">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <?php
                                $bloodGroupArray = array('a+' => 'A+','a-' => 'A-','b+' => 'B+','b-' => 'B+','ab+' => 'AB+','ab-' => 'AB-','o+' => 'O+','o-' => 'O-',);
                            ?>
                            <label for="blood_group" class="col-form-label">Blood Group</label>
                            <select class="form-control" id="blood_group" name="blood_group">
                                <option name="blood_group" id="blood_group" value="">Please Select</option>
                                <?php foreach ($bloodGroupArray as $key => $value): ?>
                                    <option name="blood_group" id="blood_group" value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="Phone">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="mobile" class="col-form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="" placeholder="Mobile">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="address" class="col-form-label">Present Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="Present Address"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="permanent_address" class="col-form-label">Permanent Address</label>
                                <input type="checkbox" class="form-check-input" id="same_as_address_checkbox" name="same_as_address_checkbox">Same as Present Address
                                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2" placeholder="Permanent Address"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="section-title"><strong>Company Profile</strong></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="joining_date" class="col-form-label">Joining Date</label>
                                <input type="date" class="form-control" id="joining_date" name="joining_date" value="">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="closing_date" class="col-form-label">Closing Date</label>
                                <input type="date" class="form-control" id="closing_date" name="closing_date" value="">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sort_order" class="col-form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="" placeholder="Sort Order">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="casual_leave" class="col-form-label">Casual Leave</label>
                                <input type="number" min="0" class="form-control" id="casual_leave" name="casual_leave" value="" placeholder="Casual Leave">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="medical_leave" class="col-form-label">Medical Leave</label>
                                <input type="number" min="0" class="form-control" id="medical_leave" name="medical_leave" value="" placeholder="Medical Leave">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="earn_leave" class="col-form-label">Earn Leave</label>
                                <input type="number" min="0" class="form-control" id="earn_leave" name="earn_leave" value="" placeholder="Earn Leave">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="section-title">
                                <strong style="padding-right: 50px;">Salary Information</strong>
                                <input type="checkbox" class="form-check-input" id="deactivate_employee" name="deactivate_employee"> Deactivate
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="basic_salary" class="col-form-label">Basic Salary</label>
                                <input type="text" class="form-control" id="basic_salary" name="basic_salary" value="" placeholder="Basic Salary">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="phone_allowance" class="col-form-label">Phone Allowance</label>
                                <input type="text" class="form-control" id="phone_allowance" name="phone_allowance" value="" placeholder="Phone Allowance">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="tuition_allowance" class="col-form-label">Tuition Allowance</label>
                                <input type="text" class="form-control" id="tuition_allowance" name="tuition_allowance" value="" placeholder="Tuition Allowance">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="attendance_allowance" class="col-form-label">Attendance Allowance</label>
                                <input type="text" class="form-control" id="attendance_allowance" name="attendance_allowance" value="" placeholder="Attendance Allowance">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="bonus" class="col-form-label">Bonus</label>
                                <input type="text" class="form-control" id="bonus" name="bonus" value="" placeholder="Bonus">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="others" class="col-form-label">Others</label>
                                <input type="text" class="form-control" id="others" name="others" value="" placeholder="Others">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="others_benefit" class="col-form-label">Others Benefit</label>
                                <input type="text" class="form-control" id="others_benefit" name="others_benefit" value="" placeholder="Others Benefit">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pf_contribution_company_part" class="col-form-label">P/F Company Part</label>
                                <input type="text" class="form-control" id="pf_contribution_company_part" name="pf_contribution_company_part" value="" placeholder="P/F Company Part">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="gross_salary_show" class="col-form-label">Gross Salary</label>
                                <input style="background-color: #ffffff" readonly="readonly" type="text" class="form-control" id="gross_salary_show" name="gross_salary_show" value="" placeholder="Gross Salary">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="section-title"><strong>Less</strong></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pf_contribution" class="col-form-label">P/F Contribution(Staff Part)</label>
                                <input type="text" class="form-control" id="pf_contribution" name="pf_contribution" value="" placeholder="P/F Contribution">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="less_others_benefit" class="col-form-label">Less Others Benefit</label>
                                <input type="text" class="form-control" id="less_others_benefit" name="less_others_benefit" value="" placeholder="Less Others Benefit">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="less_others_misc" class="col-form-label">Less Others Misc</label>
                                <input type="text" class="form-control" id="less_others_misc" name="less_others_misc" value="" placeholder="Less Others Misc">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="net_salary_show" class="col-form-label">Net Salary</label>
                                <input style="background-color: #ffffff" readonly="readonly" type="text" class="form-control" id="net_salary_show" name="net_salary_show" placeholder="Net Salary">
                            </div>
                        </div>

                        <!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="loan_installment" class="col-form-label col-xs-6">Loan Installment</label>
                                <div class="col-xs-6">
                                    <input disabled="disabled" type="checkbox" class="form-check-input" id="is_loan" name="is_loan">
                                    <span class="error-message">Is Loan</span>
                                </div>
                                <input type="text" class="form-control" id="loan_installment" name="loan_installment" value="" placeholder="Loan Installment">
                            </div>
                        </div> -->
                        
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="take_home_salary_show" class="col-form-label">Take Home Salary</label>
                                <input style="background-color: #ffffff" readonly="readonly" type="text" class="form-control" id="take_home_salary_show" name="take_home_salary_show" value="" placeholder="Take Home Salary">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="section-title"><strong>Provident Fund</strong></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="previous_provident_fund_amount" class="col-form-label">Previous Provident Fund</label>
                                <input type="text" class="form-control" id="previous_provident_fund_amount" name="previous_provident_fund_amount" value="" placeholder="Previous Provident Fund">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <!--<div class="card" style=" height: 300px; width: 300px; padding-top: 5px;">-->
                                <div class="card">
                                    <img style="margin-left: 10%" height="100px" width="150px" id="employee-image" src="<?= !empty($default_employee_image) ? $default_employee_image : '' ?>" alt="image">
                                    <br><span class="error error-message image-size-error-section"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <i class="fa fa-upload"></i><span>Upload Employee Image</span>
                                <input style="width: 80%" class="btn btn-success" type="file" name="image" id="image" onchange="readURL(this)">
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="section-title"><strong>Marketing-Sales</strong></h4>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="target_amount" class="col-form-label">Target Amount</label>
                                <input readonly type="number" min="0" step="any" class="form-control target_amount" id="target_amount" name="target_amount" value="" placeholder="Target Amount">
                            </div>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-default save-button">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script>

    $(document).ready(function () {
        $('#image').on("click", function () {
            $('.image-size-error-section').text('');
            $('#employee-image').attr('src', '');
        });

        $('#image').on("change", function () {
            var file_size = $('#image')[0].files[0].size;
            if (file_size > (100 * 1024)) {
                var error_message = 'Maximum Image Size: 100 KB';
                $('.image-size-error-section').text(error_message);
            }
        });

        $("form[name='create_new_employee_form']").validate({
            rules: {
                employee_name: "required",
                employee_code: "required",
                /*employee_email: "required",*/
                designation: "required",
                gender: "required",
                mobile: "required",
                joining_date: "required",
                casual_leave: "required",
                medical_leave: "required",
                earn_leave: "required",
                sort_order: "required",
                permanent_address: "required",
                blood_group: "required",
                traget_amount: {
//                    required: true,
                    number: true,
                    min: 0,
                },
            },
            messages: {
                employee_name: "Please Enter Employee Name",
                employee_code: "Please Enter Employee Code",
                /*employee_email: {
                 required: "Please Enter Email Address",
                 email: "Enter a Valid Email Address",
                 },*/
                designation: "Please Enter Designation",
                gender: "Please Select Gender",
                mobile: "Please Enter Mobile",
                joining_date: "Please Enter Joining Date",
                casual_leave: "Please Enter Casual Leave",
                medical_leave: "Please Enter Medical Leave",
                earn_leave: "Please Enter Earn Leave",
                sort_order: "Please Enter Sort Order",
                permanent_address: "Please Enter Permanent Address",
                blood_group: "Please Select Blood Group",
            },
            submitHandler: function (form) {
                var file_size = $('#image')[0].files[0].size;
                if (file_size > (100 * 1024)) {
                    var error_message = 'Maximum Image Size: 100 KB';
                    $('.image-size-error-section').text(error_message);
                    return false;
                } else {
                    form.submit();
                }

            }
        });

        $('#same_as_address_checkbox').click(function () {
            if ($(this).is(":checked")) {
                var address = $('#address').val();
                $('#permanent_address').val(address);
            } else {
                $('#permanent_address').val('');
            }
        });

        $('#basic_salary').keyup(get_gross_total_amount);
        $('#phone_allowance').keyup(get_gross_total_amount);
        $('#tuition_allowance').keyup(get_gross_total_amount);
        $('#attendance_allowance').keyup(get_gross_total_amount);
        $('#bonus').keyup(get_gross_total_amount);
        $('#others').keyup(get_gross_total_amount);
        $('#others_benefit').keyup(get_gross_total_amount);
        $('#pf_contribution_company_part').keyup(get_gross_total_amount);

        function get_gross_total_amount() {
            //basic_salary
            var basic_salary = 0;
            basic_salary = $('#basic_salary').val();
            if (basic_salary == '') {
                basic_salary = 0;
            } else {
                basic_salary = $('#basic_salary').val();
            }
            //phone_allowance
            var phone_allowance = 0;
            phone_allowance = $('#phone_allowance').val();
            if (phone_allowance == '') {
                phone_allowance = 0;
            } else {
                phone_allowance = $('#phone_allowance').val();
            }
            //tuition_allowance
            var tuition_allowance = 0;
            tuition_allowance = $('#tuition_allowance').val();
            if (tuition_allowance == '') {
                tuition_allowance = 0;
            } else {
                tuition_allowance = $('#tuition_allowance').val();
            }
            //tuition_allowance
            var attendance_allowance = 0;
            attendance_allowance = $('#attendance_allowance').val();
            if (attendance_allowance == '') {
                attendance_allowance = 0;
            } else {
                attendance_allowance = $('#attendance_allowance').val();
            }
            //bonus
            var bonus = 0;
            bonus = $('#bonus').val();
            if (bonus == '') {
                bonus = 0;
            } else {
                bonus = $('#bonus').val();
            }
            //others
            var others = 0;
            others = $('#others').val();
            if (others == '') {
                others = 0;
            } else {
                others = $('#others').val();
            }
            //others benefit
            var others_benefit = 0;
            others_benefit = $('#others_benefit').val();
            if (others_benefit == '') {
                others_benefit = 0;
            } else {
                others_benefit = $('#others_benefit').val();
            }
            //pf_contribution
            var pf_contribution_company_part = 0;
            pf_contribution_company_part = $('#pf_contribution_company_part').val();
            if (pf_contribution_company_part == '') {
                pf_contribution_company_part = 0;
            } else {
                pf_contribution_company_part = $('#pf_contribution_company_part').val();
            }
            var gross_salary_show_total = parseFloat(basic_salary) + parseFloat(phone_allowance) + parseFloat(tuition_allowance) + parseFloat(attendance_allowance) + parseFloat(bonus) + parseFloat(others) + parseFloat(others_benefit) + parseFloat(pf_contribution_company_part);
            $('#gross_salary_show').val(gross_salary_show_total.toFixed(2));
        }

        $('#pf_contribution').keyup(get_net_salary_amount);
        $('#less_others_benefit').keyup(get_net_salary_amount);
        $('#less_others_misc').keyup(get_net_salary_amount);
        $('#pf_contribution_company_part').keyup(get_net_salary_amount);
        $('#gross_salary_show').change(get_net_salary_amount);

        $('#basic_salary').keyup(get_net_salary_amount);
        $('#phone_allowance').keyup(get_net_salary_amount);
        $('#tuition_allowance').keyup(get_net_salary_amount);
        $('#attendance_allowance').keyup(get_net_salary_amount);
        $('#bonus').keyup(get_net_salary_amount);
        $('#others').keyup(get_net_salary_amount);
        $('#others_benefit').keyup(get_net_salary_amount);
        $('#pf_contribution_company_part').keyup(get_net_salary_amount);

        function get_net_salary_amount() {
            //gross_salary_show
            var gross_salary_show = 0;
            gross_salary_show = $('#gross_salary_show').val();
            if (gross_salary_show == '' || gross_salary_show == null) {
                gross_salary_show = 0;
            } else {
                gross_salary_show = $('#gross_salary_show').val();
            }
            //pf_contribution
            var pf_contribution = 0;
            pf_contribution = $('#pf_contribution').val();
            if (pf_contribution == '' || pf_contribution == null) {
                pf_contribution = 0;
            } else {
                pf_contribution = $('#pf_contribution').val();
            }
            //less_others_benefit
            var less_others_benefit = 0;
            less_others_benefit = $('#less_others_benefit').val();
            if (less_others_benefit == '' || less_others_benefit == null) {
                less_others_benefit = 0;
            } else {
                less_others_benefit = $('#less_others_benefit').val();
            }
            //less_others_misc
            var less_others_misc = 0;
            less_others_misc = $('#less_others_misc').val();
            if (less_others_misc == '' || less_others_misc == null) {
                less_others_misc = 0;
            } else {
                less_others_misc = $('#less_others_misc').val();
            }
            //pf_contribution_company_part
            var pf_contribution_company_part = 0;
            pf_contribution_company_part = $('#pf_contribution_company_part').val();
            if (pf_contribution_company_part == '' || pf_contribution_company_part == null) {
                pf_contribution_company_part = 0;
            } else {
                pf_contribution_company_part = $('#pf_contribution_company_part').val();
            }
            var net_salary_show_total = parseFloat(gross_salary_show) - parseFloat(pf_contribution) - parseFloat(less_others_benefit) - parseFloat(less_others_misc) - parseFloat(pf_contribution_company_part);
            $('#net_salary_show').val(net_salary_show_total.toFixed(2));
        }

        $('#loan_installment').keyup(get_take_home_salary_amount);
        $('#pf_contribution').keyup(get_take_home_salary_amount);
        $('#less_others_benefit').keyup(get_take_home_salary_amount);
        $('#less_others_misc').keyup(get_take_home_salary_amount);
        $('#pf_contribution_company_part').keyup(get_take_home_salary_amount);
        $('#gross_salary_show').change(get_take_home_salary_amount);
        $('#basic_salary').keyup(get_take_home_salary_amount);
        $('#phone_allowance').keyup(get_take_home_salary_amount);
        $('#tuition_allowance').keyup(get_take_home_salary_amount);
        $('#attendance_allowance').keyup(get_take_home_salary_amount);
        $('#bonus').keyup(get_take_home_salary_amount);
        $('#others').keyup(get_take_home_salary_amount);
        $('#others_benefit').keyup(get_take_home_salary_amount);
        $('#pf_contribution_company_part').keyup(get_take_home_salary_amount);

        function get_take_home_salary_amount() {
            //net_salary_show
            var net_salary_show = 0;
            net_salary_show = $('#net_salary_show').val();
            if (net_salary_show == '' || net_salary_show == null) {
                net_salary_show = 0;
            } else {
                net_salary_show = $('#net_salary_show').val();
            }
            //loan_installment
            var loan_installment = 0;
            loan_installment = $('#loan_installment').val();
            if (loan_installment == '' || loan_installment == null) {
                loan_installment = 0;
            } else {
                loan_installment = $('#loan_installment').val();
            }

            var take_home_salary_show_total = parseFloat(net_salary_show) - parseFloat(loan_installment);
            $('#take_home_salary_show').val(take_home_salary_show_total.toFixed(2));
        }

    });

</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#employee-image').addClass('image-preview');
                $('#employee-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#employee-image').attr('src', '');
        }
    }
</script>
