<div id="wrapper">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_id = $user_info['user_id']; // session user id
    $user_type = $user_info['user_type'];
    $user_name = $user_info['user_name']; // session user name
    $employee_id = $user_info['employee_id']; // session Employee id
    $hr_access = $user_info['hr_access'];
    $accounts_access = $user_info['accounts_access'];
    $sales_access = $user_info['sales_access'];
    $settings_access = $user_info['settings_access'];
    $user_access = $user_info['user_access'];
    $accounts_report_access = $user_info['accounts_report_access'];
    $hr_report_access = $user_info['hr_report_access'];
    $sales_report_access = $user_info['sales_report_access'];
    $product_report_access = $user_info['product_report_access'];
    $money_receipt_report_access = $user_info['money_receipt_report_access'];
    $print_access = $user_info['print_access'];
    $product_access = $user_info['product_access'];
    $client_access = $user_info['client_access'];
    $lock_access = $user_info['lock_access'];
    $edit_mr_access = $user_info['edit_mr_access'];
    $edit_invoice_access = $user_info['edit_invoice_access'];
    $order_sheet_access = $user_info['order_sheet_access'];
    $employee_image = $user_info['employee_image'];
    $default_employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
    $notification_count = count($this->db->query("SELECT * FROM notification_assign WHERE employee_id = $employee_id AND is_show = 0")->result());
    $company_information = $this->db->query("SELECT * FROM company_info")->row();
    $company_name = !empty($company_information->company_name_1) ? $company_information->company_name_1 : '';
    $company_logo = !empty($company_information->company_logo) ? $company_information->company_logo : '';
    $leave_application_count = get_new_leave_application_count();
    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top navigation-design" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-right: 0px; margin: 0px;">
                    <p class="navigation-design-text-color company-name-design" class="navbar-brand" href="<?= base_url(); ?>">
                        <i class="fa fa-home fa-fw"></i>
                        <img class="company-logo-design" src="<?= get_company_logo() ?>">
                        <span><?= ucfirst($company_name) ?></span>
                    </p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 0px; margin: 0px;">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="flip">
                        <div class="flip__inner">
                           <div class="one"></div>
                           <div class="two"></div>
                           <div class="three"></div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li id="notification_li" class="dropdown">
                <a class="navigation-design-text-color" class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw">
                        <?php if ($notification_count > 0) { ?>
                            <span id="notification_count"><?= $notification_count ?></span>
                        <?php }
                        ?>
                        <?php if (strtolower($user_type) == 'admin' || strtolower($user_type) == 'hr') {
                            ?>
                            <?php if ((int) $leave_application_count > 0) { ?>
                                <span id="leave_application_count"><?= $leave_application_count ?></span>
                                <?php
                            }
                        }
                        ?>
                    </i>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a class="navigation-design-text-color" class="text-center" href="<?= base_url('notification') ?>">
                            <strong>See All Notification</strong><i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <?php if (strtolower($user_type) == 'admin' || strtolower($user_type) == 'hr') {
                        ?>
                        <li>
                            <a class="navigation-design-text-color" class="text-center" href="<?= base_url('reports/hr_report/employee_leave_report/employee_leave_report/leave_application_report_show_in_table') ?>">
                                <strong>Leave Application</strong><i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    <?php }
                    ?>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>

            <li class="dropdown">
                <a class="navigation-design-text-color" class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <!--<i class="fa fa-user fa-fw fa-lg"></i>-->
                    <img class="employee-profile-image" src="<?= get_employee_image($employee_id) ?>">
                    <i class="fa fa-caret-down"></i><span><?= ucfirst($user_name); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a class="navigation-design-text-color" href="<?= base_url('user_login/update_my_profile') ?>">
                            <i class="fa fa-user fa-fw"></i>My Profile
                        </a>
                    </li>

                    <li>
                        <a class="navigation-design-text-color" href="<?= base_url('employee_own_leave_application') ?>">
                            <i class="fa fa-plane fa-fw"></i>Leave Application
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li><a class="navigation-design-text-color" href="<?= base_url('user_login/logout') ?>"><i class="fa fa-sign-out fa-fw"></i>Logout</a></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <!--.sidebar ul li a.active-->
        <!--.sidebar nav abc a.active-->
        <div class="navbar-default sidebar navigation-design" role="navigation" id="panel">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <div class="profile clearfix employee-profile-section">
                        <div class="employeee_profile_pic">
                            <img src="<?= get_employee_image($employee_id) ?>" class="img-circle profile_img mCS_img_loaded">
                        </div>
                        <div class="employee-profile_info">
                            <span>Welcome,</span>

                            <h2><?= ucfirst($user_name) ?></h2>
                        </div>
                    </div>

                    <li>
                        <a class="navigation-design-text-color" class="navigation-design-text-color"
                           href="<?= base_url(); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <?php if (!empty($hr_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#">
                                <i class="fa fa-user-plus fa-fw"></i>HR<span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('assets_info') ?>">Assets Details</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('assign_assets') ?>">Assign Assets</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('company/leave_settings') ?>">Leave Settings</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('hr/employee_leave') ?>">Employee Leave</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('settings/weekend_settings') ?>">
                                        Weekend Settings
                                    </a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('settings/holidays_settings') ?>">
                                        Holidays Settings
                                    </a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('settings/currency_settings') ?>">
                                        Currency Settings
                                    </a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('hr/employee_evaluation') ?>">
                                        Employee Evaluation
                                    </a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('hr/warning_letter') ?>">
                                        Warning Letter
                                    </a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('hr/employee_leave/leave_application') ?>">
                                    Leave Application
                                </a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('employee_salary_generate') ?>">
                                        Employee Salary Generate
                                    </a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                    <?php } ?>

                    <?php if (!empty($accounts_access) > 0) { ?>
                        <!-- <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-calculator fa-fw"></i>Accounts<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('accounts/income_head') ?>">Income
                                        Head Detils(Cr)</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('accounts/expense_head') ?>">Expense
                                        Head Details(Dr)</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('accounts/narration') ?>">Narration</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('accounts/voucher') ?>">Voucher</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('accounts/update_closing_balance') ?>">Update Closing Balance</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('accounts/financial_statement_accounts') ?>">Financial Statement Accounts</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('accounts/remove_head') ?>">Unassign Head</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('accounts/yearend_closing_statement_generate') ?>">Yearend Closing Statement Generate</a>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="#"><i class="fa fa-user fa-fw"></i>Loan
                                        Information<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('loan') ?>">Loan</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('loan/partial_loan_payment') ?>">Partial Loan Payment</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="navigation-design-text-color" href="#"><i
                                            class="fa fa-print fa-fw"></i>Print<span
                                            class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('accounts/all_print/cheque_print') ?>">Cheque Print</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('accounts/all_print/envelope_print') ?>">Envelope Print</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                    <?php } ?>
                    <?php if ((string) (strtolower($user_type) == 'marketing') || (!empty($product_access) > 0) || (!empty($client_access) > 0)) { ?>
                        <?php if ((string) (strtolower($user_type) == 'marketing') || (!empty($product_access) > 0 && !empty($settings_access) == 0)) { ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i
                                        class="fa fa-product-hunt fa-fw"></i>Product<span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a class="navigation-design-text-color" href="<?= base_url('product') ?>">Product
                                            Details</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <?php } ?>

                        <?php if ((string) (strtolower($user_type) == 'marketing') || (!empty($client_access) > 0 && !empty($settings_access) == 0)) { ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i class="fa fa-users fa-fw"></i>Client<span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a class="navigation-design-text-color" href="<?= base_url('client') ?>">Client
                                            Details</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if ((!empty($settings_access) <= 0) && (!empty($lock_access) > 0)) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-lock fa-fw"></i>Lock Settings<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('settings/lock_settings') ?>">Lock Settings</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>

                    <?php if (!empty($settings_access) > 0) { ?>

                        <li>
                            <a class="navigation-design-text-color" href="#">
                                <i class="fa fa-wrench fa-fw"></i>Settings
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li><a class="navigation-design-text-color" href="<?= base_url('company') ?>">Company</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('branch') ?>">Outlet</a></li>

                                <?php if (!empty($user_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('employee') ?>">Employee</a></li>
                                <?php } ?>

                                <?php if (!empty($user_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('user') ?>">User</a></li>
                                <?php } ?>

                                <li><a class="navigation-design-text-color" href="<?= base_url('printer_setup') ?>">Printer Setup</a></li>

                                <?php if (!empty($product_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('product_type') ?>">Category</a></li>
                                <?php } ?>

                                <?php if (!empty($product_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('product') ?>">Product</a></li>
                                <?php } ?>

                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#"><i
                                            class="fa fa-user fa-fw"></i>Dealer<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('dealer') ?>">Dealer
                                                Details</a>
                                        </li>
                                    </ul>
                                </li> -->

                                <?php if (!empty($client_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('client') ?>">Customer</a></li>
                                <?php } ?>

                                <?php if (!empty($lock_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('settings/lock_settings') ?>">Lock Settings</a></li>
                                <?php } ?>
                                
                                <?php if ((!empty($user_type) && (strtolower($user_type) === 'admin'))) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('settings/super_password') ?>">Super Password</a></li>
                                <?php } ?>

                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#"><i
                                            class="fa fa-university fa-fw"></i>Bank<span
                                            class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('bank') ?>">Bank
                                                Details</a>
                                        </li>
                                    </ul>
                                </li> -->

                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#"><i class="fa fa-money fa-fw"></i>Sales
                                        Incentive System<span
                                            class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('bonus_incentive_system') ?>">Sales Incentive System
                                                Details</a>
                                        </li>
                                    </ul>
                                </li> -->

                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#"><i class="fa fa-dot-circle-o"></i>Delivery Cost Type<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('settings/delivery_cost_type') ?>">Delivery Cost Type</a>
                                        </li>
                                    </ul>
                                </li> -->

                                <?php if (!empty($user_type) == 'admin') { ?>
                                    <!-- <li>
                                        <a class="navigation-design-text-color" href="#"><i class="fa fa-envelope"></i>Email Address Details<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a class="navigation-design-text-color" href="<?= base_url('settings/email_address_details') ?>">Email Address Details</a>
                                            </li>
                                        </ul>
                                    </li> -->
                                <?php }
                                ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                    <?php } ?>

                    <?php if (!empty($sales_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="<?= base_url('sale_product') ?>">
                                <i class="fa fa-balance-scale fa-fw"></i>Invoice
                            </a>
                        </li>
                    <?php } ?>

                    <li>
                        <a class="navigation-design-text-color" href="#"><i
                                class="fa fa-bar-chart fa-fw"></i>Reports<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">

                            <?php if (!empty($accounts_report_access) > 0) { ?>
                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#">Accounts Report<span
                                            class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/voucher_report') ?>">Voucher
                                                Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"href="<?= base_url('reports/accounts_report/') ?>">Clientwise Accounts Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/employee_benefit_report') ?>">Employee
                                                Details Benefit Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/employee_yearly_benefit_report') ?>">Employee
                                                Yearly Benefit Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/head_report') ?>">Head
                                                Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/head_details_report') ?>">Head
                                                Details Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/head_transaction_report') ?>">Head
                                                Transaction Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/posting_statement') ?>">Posting
                                                Statement</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/accounts_report/clientwise_accounts_individual_details_ledger_report') ?>">Clientwise Individual Details Ledger Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="#">Employee P/F Report<span
                                                    class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employee_total_pf_funds_report') ?>">Employee
                                                        Total P/F Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employee_details_pf_funds_report') ?>">Employee
                                                        P/F Details Report</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="#">Employee Loan Report<span
                                                    class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employee_total_loan_report/employee_current_loan_report') ?>">Employee
                                                        Current Loan Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employee_total_loan_report') ?>">Employee
                                                        Total Loan Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employee_total_loan_report/employee_details_loan_report') ?>">Employee
                                                        Loan Details Report</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/accounts_report/monthly_expences_report') ?>">Monthly Expences Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/accounts_report/monthly_income_report') ?>">Monthly Income Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="#">Account Statement<span
                                                    class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/accounts_report/account_statement_report/trading_account') ?>">Trading Account Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/accounts_report/account_statement_report/profit_and_loss_account') ?>">Profit and Loss Account Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/accounts_report/account_statement_report/profit_and_loss_account_appropriation') ?>">Profit and Loss Appropriation Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/accounts_report/account_statement_report/balance_sheet') ?>">Balance Sheet Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/accounts_report/account_statement/trail_balance_report') ?>">Trail Balance Report</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="#">Print Report<span
                                                    class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li>
                                                    <a class="navigation-design-text-color" href="<?= base_url('reports/accounts_report/all_print_report/cheque_print_report') ?>">Cheque Print Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color" href="<?= base_url('reports/accounts_report/all_print_report/envelope_print_report') ?>">Envelope Print Report</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li> -->
                            <?php } ?>

                            <?php if (!empty($hr_report_access) > 0) { ?>
                                <li>
                                    <a class="navigation-design-text-color" href="#">HR Reports<span
                                            class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/hr_report/employee_leave_report/employee_leave_report') ?>">Employee
                                                Leave Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/hr_report/employee_evaluation_report') ?>">Employee Evaluation Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color"
                                               href="<?= base_url('reports/hr_report/warning_letter_report') ?>">Warning Letter Report</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                            <?php } ?>

                            <?php if (!empty($sales_report_access) > 0) { ?>
                                <li>
                                    <a class="navigation-design-text-color" href="#">Sales Report<span
                                            class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a class="navigation-design-text-color" href="<?= base_url('reports/invoice_report') ?>">Invoice Report</a>  </li>

                                        <li><a class="navigation-design-text-color"href="<?= base_url('reports/periodic_sales_details_report') ?>">Product Sales Details Report</a></li>

                                        <li><a class="navigation-design-text-color" href="<?= base_url('reports/client_wise_sales_report') ?>">ClientWise Sale Report</a></li>

                                        <!-- <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/challan_report') ?>">Challan Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/gate_pass_report') ?>">Gate Pass Report(Sales)</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/gate_pass_transfer_report') ?>">Gate Pass Report(Transfer)</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/client_ledger_report') ?>">ClientWise Ledger
                                                Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/client_details_ledger_report') ?>">ClientWise Details Ledger Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/clientwise_individual_ledger_report') ?>">ClientWise Individual Ledger Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/clientwise_individual_details_ledger_report') ?>">ClientWise Individual Details Ledger Report</a>
                                        </li> -->

                                        <?php if (strtolower($user_type) != 'marketing') { ?>
                                            <!-- <li>
                                                <a class="navigation-design-text-color" href="<?= base_url('reports/dealer_wise_sales_report') ?>">DealerWise Sale Report</a>
                                            </li> -->
                                        <?php } ?>

                                        <!-- <li>
                                            <a class="navigation-design-text-color" href="#">Employee Wise Report<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employeewise_details_ledger_report') ?>">Employeewise Details Ledger Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color"
                                                       href="<?= base_url('reports/employeewise_ledger_report') ?>">Employeewise Ledger Report</a>
                                                </li>
                                            </ul>
                                        </li> -->

                                        <!-- <li>
                                            <a class="navigation-design-text-color"href="<?= base_url('reports/employee_wise_report') ?>">Employee Wise Report</a>
                                        </li> -->
                                        <?php if (strtolower($user_type) != 'marketing') { ?>
                                            <!-- <li>
                                                <a class="navigation-design-text-color" href="#">Damage / Return Reports<span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/damage_or_defect_product_report') ?>">Product (Damage / Defect) Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/return_product_report') ?>">Product (Return) Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/client_product_damage_or_defect_report') ?>">Client Product (Damage / Defect) Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/client_product_return_report') ?>">Client Product (Return) Report</a>
                                                    </li>
                                                </ul>
                                            </li> -->
                                        <?php } ?>

                                        <?php if (TRUE) { ?>
                                            <?php if (strtolower($user_type) != 'marketing') { ?>
                                            <!-- <li>
                                                <a class="navigation-design-text-color" href="#">Sales Department Reports<span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/monthly_sales_collection_report') ?>">Monthly Sales Collection Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/monthly_progress_report') ?>">Monthly Progress Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/itemwise_sales_report') ?>">Item-wise Sales Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/stock_report') ?>">Stock Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/outstanding_report') ?>">Outstanding Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/client_based_credit_reduction_report') ?>">Client Based Credit Reduction Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/employee_based_credit_reduction_report') ?>">Employee Based Credit Reduction Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/employeewise_collection_report') ?>">Employee-wise Collection Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/originwise_sale_collection_report') ?>">Origin-wise Sale Collection Report</a>
                                                    </li>
                                                    <li>
                                                        <a class="navigation-design-text-color" href="<?= base_url('reports/sales_department_reports/incentive_report') ?>">Incentive Report</a>
                                                    </li>
                                                </ul>
                                            </li> -->
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if (!empty($product_report_access) > 0) { ?>
                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#">Products Report<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/product_receive_challan_report') ?>">BranchWise Product Receive Challan Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/stock_transfer_challan_report') ?>">BranchWise Stock Transfer Challan Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/branch_wise_product_receive_report') ?>">BranchWise Product Receive Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/branch_wise_stock_report') ?>">BranchWise Stock Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/stock_transfer_report') ?>">Stock Transfer Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/stock_receive_report') ?>">Stock Receive Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/item_report') ?>">Item Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/branchwise_item_report') ?>">Branchwise Item Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/periodic_item_report') ?>">Periodic Item Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/branchwise_periodic_item_report') ?>">Branchwise Periodic Item Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/invoicewise_product_sales_report') ?>">Invoicewise Product Sales Report</a>
                                        </li>
                                    </ul>
                                </li> -->
                            <?php } ?>

                            <!-- <li>
                                <a class="navigation-design-text-color" href="#">Delivery Expense Report<span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a class="navigation-design-text-color" href="<?= base_url('reports/delivery_cost_report') ?>">Delivery Cost Report</a>
                                    </li>                                        
                                    <li>
                                        <a class="navigation-design-text-color" href="<?= base_url('reports/delivery_itemwise_cost_report') ?>">Item Wise Cost Report</a>
                                    </li>                                        
                                </ul>
                            </li> -->

                            <?php if (!empty($money_receipt_report_access) > 0) { ?>
                                <!-- <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('reports/payment_report') ?>">Money Receipt Report</a>
                                </li> -->
                            <?php } ?>

                            <?php if ((!empty($user_type) && (strtolower($user_type) === 'admin'))) { ?>
                                <!-- <li>
                                    <a class="navigation-design-text-color" href="#">Sales Statement Reports<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/sales_details_statement') ?>">Sales Details Statement Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/sales_commission_report') ?>">Sales Commission Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/') ?>">Sales Profit Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/sales_pfofit_report') ?>">Sales Profit Report (Details)</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/productwise_profit_report') ?>">Productwise Profit Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="#">Sales Analysis Reports<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li>
                                                    <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/sales_analysis_report/product_sales_analysis_report') ?>">Product Sales Analysis Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/sales_analysis_report/clientwise_sales_analysis_report') ?>">Clientwise Sales Analysis Report</a>
                                                </li>
                                                <li>
                                                    <a class="navigation-design-text-color" href="<?= base_url('reports/sales_statement_report/sales_analysis_report/employeewise_sales_analysis_report') ?>">Employeewise Sales Analysis Report</a>
                                                </li>
                                            </ul>
                                        </li> 
                                    </ul>
                                </li> -->
                            <?php } ?>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <?php if (!empty($sales_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i class="fa fa-product-hunt fa-fw"></i>Product Receive<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('product_receive') ?>">Product Receive</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>

                    <?php if (!empty($sales_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i class="fa fa-exchange fa-fw"></i>Stock Transfer<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('stock_transfer') ?>">Stock Transfer</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>
                    <?php if (!empty($sales_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-money fa-fw"></i>Money Receipt<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('payment') ?>">Money Receipt</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>

                    <?php if (!empty($edit_mr_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-edit fa-fw"></i>Edit Money Receipt<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('edit_mr') ?>">Edit Money Receipt</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>

                    <?php if (!empty($edit_invoice_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-edit fa-fw"></i>Edit Invoice<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('client_product_return') ?>">Edit Invoice</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>

                    <li>
                        <a class="navigation-design-text-color" href="#"><i
                                class="fa fa-eraser fa-fw"></i>Damage / Return / Defect<span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="navigation-design-text-color"
                                   href="<?= base_url('damage_or_defect_product') ?>">Product (Damage/Defect)</a>
                            </li>
                            <li>
                                <a class="navigation-design-text-color"
                                   href="<?= base_url('return_product') ?>">Product (Return)</a>
                            </li>
                            <!--                            <li>
                                                            <a class="navigation-design-text-color"
                                                               href="<?= base_url('client_product_damage_or_defect') ?>">Client Product (Damage/Defect)</a>
                                                        </li>-->
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <?php if (!empty($order_sheet_access) > 0) { ?>
                        <!-- <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-globe fa-fw"></i>Order Sheet<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color"
                                       href="<?= base_url('order_sheet') ?>">Order Sheet</a>
                                </li>
                            </ul>
                        </li> -->
                    <?php } ?>
                    <!-- <li>
                        <a class="navigation-design-text-color" href="#"><i
                                class="fa fa-plane fa-fw"></i>Leave Application<span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="navigation-design-text-color" href="<?= base_url('employee_own_leave_application') ?>">Leave Application</a>
                            </li>
                        </ul>
                    </li> -->
                    <?php if (!empty($settings_access) > 0) { ?>
                        <!-- <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-bicycle"></i>Delivery Cost<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('delivery_cost') ?>">Delivery Cost</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i
                                    class="fa fa-balance-scale fa-fw"></i>Client Sales Commission<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="navigation-design-text-color" href="<?= base_url('client_sales_commission') ?>">Client Sales Commission</a>
                                </li>
                            </ul>
                        </li> -->
                    <?php } ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
<!-- </div> -->
<!-- /#wrapper -->

