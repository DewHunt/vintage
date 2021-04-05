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
        $employee_image = $user_info['employee_image'];
        $default_employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
        $notification_count = count($this->db->query("SELECT * FROM notification_assign WHERE employee_id = $employee_id AND is_show = 0")->result());
        $company_information = $this->db->query("SELECT * FROM company_info")->row();
        $company_name = !empty($company_information->company_name_1) ? $company_information->company_name_1 : '';
        $company_logo = !empty($company_information->company_logo) ? $company_information->company_logo : '';
        $leave_application_count = get_new_leave_application_count();

        $allWords = preg_split("/[\s,_-]+/", $company_name);
        $shortName = "";

        foreach ($allWords as $word) {
            $shortName .= $word[0];
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

        <?php
            $root_menu_lists = get_root_menu_list($user_info['user_id'],true);
        ?>
        
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

                    <?php foreach ($root_menu_lists as $root_menu): ?>
                        <?php
                            $menu_icon = 'fa fa-bars';
                            if ($root_menu->menu_icon) {
                                $menu_icon = $root_menu->menu_icon;
                            }
                            $parent_menu_lists = get_menu_list($root_menu->id,$user_info['user_id'],true);
                        ?>
                        <?php if (count($parent_menu_lists) > 0): ?>
                            <li>
                                <a class="navigation-design-text-color" class="navigation-design-text-color" href="javascript:void(0)">
                                    <i class="<?= $menu_icon ?>"></i>&nbsp;<?= $root_menu->menu_name ?><span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <?php foreach ($parent_menu_lists as $parent_menu): ?>
                                        <?php
                                            $menu_icon = 'fa fa-angle-right';
                                            if ($parent_menu->menu_icon) {
                                                $menu_icon = $parent_menu->menu_icon;
                                            }
                                            $child_menu_list =  get_menu_list($parent_menu->id,$user_info['user_id'],true);
                                        ?>
                                        <?php if (count($child_menu_list) > 0): ?>
                                            <li>
                                                <a class="navigation-design-text-color" class="navigation-design-text-color" href="javascript:void(0)">
                                                    <i class="<?= $menu_icon ?>"></i>&nbsp;<?= $parent_menu->menu_name ?><span class="fa arrow"></span>
                                                </a>
                                                <ul class="nav nav-third-level">
                                                    <?php foreach ($child_menu_list as $child_menu): ?>
                                                        <?php
                                                            $menu_id = $child_menu->id;
                                                            $menu_icon = 'fa fa-angle-right';
                                                            if ($child_menu->menu_icon) {
                                                                $menu_icon = $child_menu->menu_icon;
                                                            }
                                                            $menu_list = get_menu_list($child_menu->id,$user_info['user_id'],true);
                                                        ?>
                                                        <?php if (count($menu_list) > 0): ?>
                                                            <li>
                                                                <a class="navigation-design-text-color" class="navigation-design-text-color" href="javascript:void(0)">
                                                                    <i class="<?= $menu_icon ?>"></i>&nbsp;<?= $child_menu->menu_name ?><span class="fa arrow"></span>
                                                                </a>
                                                                <ul class="nav nav-fourth-level">
                                                                    <?php foreach ($menu_list as $menu): ?>
                                                                        <li>
                                                                            <a class="navigation-design-text-color" class="navigation-design-text-color" href="<?= base_url($menu->menu_link); ?>"><i class="<?= $menu_icon ?>"></i>&nbsp;<?= $menu->menu_name ?></a>
                                                                        </li> 
                                                                    <?php endforeach ?>
                                                                </ul>                                                            
                                                            </li> 
                                                        <?php else: ?>
                                                            <li>
                                                                <a class="navigation-design-text-color" class="navigation-design-text-color" href="<?= base_url($child_menu->menu_link); ?>"><i class="<?= $menu_icon ?>"></i>&nbsp;<?= $child_menu->menu_name ?></a>
                                                            </li>  
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </ul>
                                            </li>                                            
                                        <?php else: ?>
                                            <li>
                                                <a class="navigation-design-text-color" class="navigation-design-text-color" href="<?= base_url($parent_menu->menu_link); ?>"><i class="<?= $menu_icon ?>"></i>&nbsp;<?= $parent_menu->menu_name ?></a>
                                            </li>                                            
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </ul>
                            </li>                            
                        <?php else: ?>
                            <li>
                                <a class="navigation-design-text-color" class="navigation-design-text-color" href="<?= base_url($root_menu->menu_link); ?>"><i class="<?= $menu_icon ?>"></i>&nbsp;<?= $root_menu->menu_name ?></a>
                            </li>                            
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
<!-- </div> -->
<!-- /#wrapper -->

