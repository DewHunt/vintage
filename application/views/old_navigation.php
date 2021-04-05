<div id="wrapper">
    <?php
        $user_info = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($user_info); exit();
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
        $kitchen_room_access = $user_info['kitchen_room_access'];
        $employee_image = $user_info['employee_image'];
        $default_employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
        $notification_count = count($this->db->query("SELECT * FROM notification_assign WHERE employee_id = $employee_id AND is_show = 0")->result());
        $company_information = $this->db->query("SELECT * FROM company_info")->row();
        $company_name = !empty($company_information->company_name_1) ? $company_information->company_name_1 : '';
        $company_logo = !empty($company_information->company_logo) ? $company_information->company_logo : '';
        $leave_application_count = get_new_leave_application_count();
        $shortName = "";

        if ($company_name) {
            $allWords = preg_split("/[\s,_-]+/", $company_name);

            foreach ($allWords as $word) {
                $shortName .= $word[0];
            }
        }
    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top navigation-design" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="padding-right: 0px; margin: 0px;">
                    <p class="navigation-design-text-color company-name-design" class="navbar-brand">
                        <a href="<?= base_url(); ?>"><img class="company-logo-design" src="<?= get_company_logo() ?>"></a>
                        <span class="company-name"><?= ucwords($company_name) ?></span>
                        <span class="company-short-name"><?= strtoupper($shortName); ?></span>
                    </p>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding: 0px; margin: 0px;">
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
                        <div class="employee-profile_info"><span>Welcome,</span><h2><?= ucfirst($user_name) ?></h2></div>
                    </div>

                    <li>
                        <a class="navigation-design-text-color" class="navigation-design-text-color" href="<?= base_url(); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <?php if (!empty($hr_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i class="fa fa-user-plus fa-fw"></i> HR<span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">
                                <li><a class="navigation-design-text-color" href="<?= base_url('assets_info') ?>">Assets Details</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('assign_assets') ?>">Assign Assets</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('company/leave_settings') ?>">Leave Settings</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('hr/employee_leave') ?>">Employee Leave</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('settings/weekend_settings') ?>">Weekend Settings</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('settings/holidays_settings') ?>">Holidays Settings</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('settings/currency_settings') ?>">Currency Settings</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('hr/employee_evaluation') ?>">Employee Evaluation</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('hr/warning_letter') ?>">Warning Letter</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('hr/employee_leave/leave_application') ?>">Leave Application</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('employee_salary_generate') ?>">Employee Salary Generate</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php } ?>

                    <?php if ((string) (strtolower($user_type) == 'marketing') || (!empty($product_access) > 0) || (!empty($client_access) > 0)) { ?>
                        <?php if ((string) (strtolower($user_type) == 'marketing') || (!empty($product_access) > 0 && !empty($settings_access) == 0)) { ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i class="fa fa-product-hunt fa-fw"></i>Product<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a class="navigation-design-text-color" href="<?= base_url('product') ?>">Product Details</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ((string) (strtolower($user_type) == 'marketing') || (!empty($client_access) > 0 && !empty($settings_access) == 0)) { ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i class="fa fa-users fa-fw"></i>Client<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a class="navigation-design-text-color" href="<?= base_url('client') ?>">Client Details</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if ((!empty($settings_access) <= 0) && (!empty($lock_access) > 0)) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i class="fa fa-lock fa-fw"></i>Lock Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a class="navigation-design-text-color" href="<?= base_url('settings/lock_settings') ?>">Lock Settings</a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (!empty($settings_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i class="fa fa-wrench fa-fw"></i>Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a class="navigation-design-text-color" href="<?= base_url('company') ?>">Company</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('branch') ?>">Outlet</a></li>
                                <li><a class="navigation-design-text-color" href="<?= base_url('table') ?>">Tables</a></li>

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

                                <?php if (!empty($product_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('recipe/add') ?>">Recipe</a></li>
                                <?php } ?>

                                <?php if (!empty($client_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('client') ?>">Customer</a></li>
                                <?php } ?>

                                <?php if (!empty($lock_access) > 0) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('settings/lock_settings') ?>"> Lock Settings</a></li>
                                <?php } ?>
                                
                                <?php if ((!empty($user_type) && (strtolower($user_type) === 'admin'))) { ?>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('settings/super_password') ?>"> Super Password</a></li>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php } ?>

                    <?php if (get_menu_permission('factory_access')): ?>
                        <?php if ((string) (strtolower($user_type) != 'sales person') && (!empty($sales_access) > 0)) { ?>
                            <?php if (!empty($settings_access) > 0) { ?>
                                <li>
                                    <a class="navigation-design-text-color" href="#"><i class="fa fa-industry"></i> Factory<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a class="navigation-design-text-color" href="<?= base_url('product_purchase') ?>">Product Purchase</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('Sale_product/factory_sale') ?>">Factory Sale</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('supplier') ?>">Supplier</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('production') ?>">Production</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('product_transfer') ?>">Product Transfer</a></li>

                                        <li>
                                            <a class="navigation-design-text-color" href="#"><i class="fa fa-eraser fa-fw"></i> Damage / Return / Defect<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li><a class="navigation-design-text-color" href="<?= base_url('damage_or_defect_product') ?>">Product (Damage/Defect)</a></li>
                                                <li><a class="navigation-design-text-color" href="<?= base_url('return_product') ?>">Product (Return)</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    <?php endif ?>

                    <?php if (!empty($sales_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="<?= base_url('sale_product/outlet_sale') ?>"><i class="fa fa-balance-scale fa-fw"></i> Invoice</a>
                        </li>
                    <?php } ?>

                    <?php if (get_menu_permission('kitchen_room_access')): ?>
                        <?php if ($kitchen_room_access > 0): ?>
                            <li>
                                <a class="navigation-design-text-color" href="<?= base_url('kitchen_room') ?>"><i class="fa fa-cutlery"></i> Kitchen Room</a>
                            </li>
                        <?php endif ?>
                    <?php endif ?>

                    <?php if (!empty($hr_report_access) > 0): ?>
                        <?php if (get_menu_permission('transaction_access') == true): ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i class="fa fa-product-hunt fa-fw"></i>Transaction<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a class="navigation-design-text-color" href="<?= base_url('product_receive') ?>">Product Receive</a></li>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('stock_transfer') ?>">Product Transfer</a></li>
                                    <li><a class="navigation-design-text-color" href="<?= base_url('product_return') ?>">Product Return</a></li>
                                </ul>
                            </li>
                        <?php endif ?>

                        <?php if (get_menu_permission('money_receipt_access') == true): ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i class="fa fa-money fa-fw"></i> Money Receipt<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a class="navigation-design-text-color" href="<?= base_url('payment') ?>">Money Receipt</a></li>
                                </ul>
                            </li>
                        <?php endif ?>
                    <?php endif ?>

                    <li>
                        <a class="navigation-design-text-color" href="#"><i class="fa fa-bar-chart fa-fw"></i>Reports<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php if (!empty($hr_report_access) > 0): ?>
                                <li>
                                    <a class="navigation-design-text-color" href="#">HR Reports<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/hr_report/employee_leave_report/employee_leave_report') ?>">Employee Leave Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/hr_report/employee_evaluation_report') ?>">Employee Evaluation Report</a>
                                        </li>
                                        <li>
                                            <a class="navigation-design-text-color" href="<?= base_url('reports/hr_report/warning_letter_report') ?>">Warning Letter Report</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="navigation-design-text-color" href="#">Factory Report<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a class="navigation-design-text-color" href="<?= base_url('transfer_report') ?>">Transfer Report</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('stock_report') ?>">Stock Report</a></li>
                                        <li>
                                            <a class="navigation-design-text-color" href="#">Puchase Report<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li><a class="navigation-design-text-color" href="<?= base_url('purchase_statement') ?>">Purchase Statement</a></li>
                                                <li><a class="navigation-design-text-color" href="<?= base_url('payment_statement') ?>">Payment Statement</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="navigation-design-text-color" href="#">Customer Report<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a class="navigation-design-text-color" href="<?= base_url('customer_balance') ?>">Customer Balance</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('customer_ledger') ?>">Customer Ledger</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('customer_payment') ?>">Customer Payment</a></li>
                                        <li><a class="navigation-design-text-color" href="<?= base_url('customer_bill') ?>">Customer Bill</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="navigation-design-text-color" href="#">Void Report<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a class="navigation-design-text-color" href="<?= base_url('invoice_void_report') ?>">Invoice Void Report</a></li>
                                    </ul>
                                </li>                                
                            <?php endif ?>

                            <?php if (!empty($sales_report_access) > 0): ?>   
                                <li>
                                    <a class="navigation-design-text-color" href="#">Sales Report<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a class="navigation-design-text-color" href="<?= base_url('reports/invoice_report') ?>">Invoice Report</a></li>

                                        <li><a class="navigation-design-text-color"href="<?= base_url('reports/periodic_sales_details_report') ?>">Product Report</a></li>

                                        <?php if ((string) (strtolower($user_type) != 'sales person')): ?>
                                            <li><a class="navigation-design-text-color" href="<?= base_url('reports/client_wise_sales_report') ?>">Client Wise Sales Report</a></li>
                                            <li>
                                                <a class="navigation-design-text-color" href="#">Inventory Report<span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a class="navigation-design-text-color"href="<?= base_url('branch_wise_stock_report') ?>">Stock Report</a></li>
                                                </ul>
                                            </li>
                                        <?php endif ?>
                                    </ul>
                                </li>                                 
                            <?php endif ?>
                        </ul>
                    </li>

                    <?php if (get_menu_permission('edit_money_receipt_access') == true): ?>
                        <?php if (!empty($edit_mr_access) > 0) { ?>
                            <li>
                                <a class="navigation-design-text-color" href="#"><i class="fa fa-edit fa-fw"></i>Edit Money Receipt<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a class="navigation-design-text-color" href="<?= base_url('edit_mr') ?>">Edit Money Receipt</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php endif ?>

                    <?php if (!empty($edit_invoice_access) > 0) { ?>
                        <li>
                            <a class="navigation-design-text-color" href="#"><i class="fa fa-edit fa-fw"></i>Edit Invoice<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a class="navigation-design-text-color" href="<?= base_url('client_product_return') ?>">Edit Invoice</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
<!-- </div> -->
<!-- /#wrapper -->

