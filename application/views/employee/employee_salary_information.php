<!--Salary deatails show in a table-->
<div id="page-wrapper">
    <?php
    $employee_list;
    $employee_salary_details;
    ?>
    <div class="col-xs-12 error-message text-align-center">
        <?php
        echo $this->session->flashdata('selected_month_year_error_message');
        ?>
    </div>

    <div class="col-xs-12 success-message text-align-center">
        <?php
        echo $this->session->flashdata('salary_generate_success_message');
        ?>
    </div>

    <div class="row card-margin-top">
        <form id="employee_salary_generate_form" name="employee_salary_generate_form" action="<?= base_url('employee_salary_generate/salary_generate') ?>" method="post">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Employee Salary Generate</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group col-xs-12 col-sm-3">
                            <label for="month" class="col-form-label">Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value="" name="month">Please Select</option>
                                <?php
                                $curr_month_name = (!empty($month)) ? $month : get_current_month_name();
                                foreach (get_months_name_array() as $m) {
                                    ?>
                                    <option <?= strtolower($curr_month_name) == strtolower($m) ? "selected='selectd'" : '' ?> value="<?= strtolower($m) ?>" name="month"><?= $m ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-3">
                            <label for="year" class="col-form-label">Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value="" name="month">Please Select</option>
                                <?php
                                $current_year = (!empty($year)) ? $year : get_current_year();
                                ?>
                                <?php
                                foreach (get_start_year_to_current_year_array() as $year) {
                                    ?>
                                    <option <?= (string) $current_year == (string) $year ? "selected='selected'" : '' ?> value="<?= $year ?>" name="year"><?= $year ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-3">
                            <button type="submit" class="btn btn-default add-product-button salary-generate-confirm-button" id="salary-generate-button">Salary Generate</button>
                        </div>
                        <div class="form-group col-xs-12 col-sm-3">
                            <a style="margin-top: 20px; float: left;" class="btn btn-default save-button" id="salary-preview-button">Preview</a>
                        </div>
                        <div class="form-group col-xs-12 col-sm-3 loading-image" style="padding-top: 40px; display: none;"></div>

                        <!--<div class="form-group col-xs-12 error-message">
                        <?php /* if (!empty($this->session->flashdata('salary_generate_error'))) {
                          echo $this->session->flashdata('salary_generate_error');
                          } */ ?>
                        </div>-->
                        <div id="salary_information_details_list_div">
                            <?= $salary_information_details_list_html; ?>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </form>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).ready(function () {

        employee_salary_generate_form();
        function employee_salary_generate_form() {
            $("#employee_salary_generate_form").validate({
                rules: {
                    month: "required",
                    year: "required",
                },
                messages: {
                    month: "Please Select a Month",
                    year: "Please Select a year",
                },
                submitHandler: function (form) {
                    var month = $("option[name=month]:selected").attr('value');
                    var year = $("option[name=year]:selected").attr('value');
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("employee_salary_generate/is_salary_generate_or_not/") ?>',
                        data: {'month': month, 'year': year},
                        beforeSend: function () {
                            $('.loading-image').show();
                            $("#salary-generate-button").hide();
                            $("#salary-preview-button").hide();
                        },
                        complete: function () {
                            $('.loading-image').hide();
                            $("#salary-generate-button").show();
                            $("#salary-preview-button").show();
                        },
                        success: function (data) {
                            if (data != true) {
                                var salary_generate_confirm_message = confirm("Are you sure to generate salary?");
                                if (salary_generate_confirm_message != true) {
                                    return false;
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url("employee_salary_generate/salary_generate/") ?>',
                                        data: {'month': month, 'year': year},
                                        success: function (data) {
                                            if (data['isGenerate']) {
                                                alert(data['message']);
                                                $('#salary_information_details_list_div').html(data['htmlView']);
                                            } else {
                                                alert(data['message']);
                                                return false;
                                            }
                                        },
                                        error: function () {

                                        }
                                    });
                                }
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: '<?php echo base_url("employee_salary_generate/salary_generate/") ?>',
                                    data: {'month': month, 'year': year},
                                    success: function (data) {
                                        if (data['isGenerate']) {
                                            alert(data['message']);
                                            $('#salary_information_details_list_div').html(data['htmlView']);
                                        } else {
                                            alert(data['message']);
                                            return false;
                                        }
                                    },
                                    error: function () {

                                    }
                                });
                            }

                        },
                        error: function () {

                        }
                    });

                }
            });
        }

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $('#salary-preview-button').click(function (e) {
            e.preventDefault();
            var isValid = salaryGenerateFormValidation();
            if (isValid) {
                var month = $("option[name=month]:selected").attr('value');
                var year = $("option[name=year]:selected").attr('value');
                if (month !== '' || year !== '') {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("employee_salary_generate/salary_details_preview/") ?>',
                        data: {'month': month, 'year': year},
                        success: function (data) {
//                            console.log(data);
//                            alert(data['message']);
                            $('#salary_information_details_list_div').html(data['htmlView']);
                        },
                        error: function () {

                        }
                    });
                } else {
                    alert('Please select month and year.');
                    return false;
                }
            } else {
                return false;
            }
        });

        function salaryGenerateFormValidation() {
            $("#employee_salary_generate_form").validate({
                rules: {
                    month: "required",
                    year: "required",
                },
                messages: {
                    month: "Please Select a Month",
                    year: "Please Select a year",
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
                invalidHandler: function (form, validator) {

                }
            });
            var isValid = $("#employee_salary_generate_form").valid();
            return isValid;
        }
    });
</script>


