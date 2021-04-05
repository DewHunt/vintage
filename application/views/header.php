<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php
            $company_information = $this->db->query("SELECT * FROM company_info")->row();
            $company_name = !empty($company_information->company_name_1) ? $company_information->company_name_1 : '';
        ?>
        <title><?= ucfirst($company_name) ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendor/metisMenu/metisMenu.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/dist/css/sb-admin-2.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendor/morrisjs/morris.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Gentium+Book+Basic" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/notification.css') ?>">
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Gentium+Book+Basic" rel="stylesheet">

        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">-->
        <!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css">-->
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/jqueryui/dataTables.jqueryui.css">-->

        <link rel="stylesheet" href="<?= base_url('assets/datatable/css/jquery.dataTables.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/datatable/css/dataTables.tableTools.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/datatable/css/dataTables.jqueryui.css') ?>">
        <!-- <link rel="stylesheet" href="<?= base_url('assets/datatable/css/responsive.bootstrap.css') ?>"> -->

        <link href="<?= base_url('assets/fullcalendar/css/fullcalendar.css') ?>" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.print.min.css" rel="stylesheet" media="print">
        <link href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/calendar/css/bootstrap-colorpicker.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/calendar/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
        <link rel="icon" title="favicon" type="image/png" href="<?= base_url('assets/uploads/company_logo/no_company_logo.png') ?>"/>
        <link href="<?= base_url(); ?>assets/vendor/select2-4.0.0/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url(); ?>assets/vendor/monthpicker.jqueryplugin/css/jquery.monthpicker.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/Chart.js/samples/style.css'); ?>">
        <!-- <link href="<?=  base_url(); ?>assets/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" /> -->
        <link href="<?=  base_url(); ?>assets/custom_style.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url(); ?>assets/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url(); ?>assets/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url(); ?>assets/datepicker/css/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url(); ?>assets/switchery/dist/switchery.min.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?=  base_url(); ?>assets/printThis/assets/css/normalize.css" rel="stylesheet" type="text/css" /> -->
        <!-- <link href="<?=  base_url(); ?>assets/printThis/assets/css/skeleton.css" rel="stylesheet" type="text/css" /> -->

        <!-- <link href="<?= base_url() ?>assets/minimal_hexagon_countdown_timer/dist/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
        <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/minimal_hexagon_countdown_timer/dist/svgTimer.min.css"/> -->

        <style type="text/css">
            .svg-test { margin:30px auto; width:200px;}
            table.dataTable thead th, table.dataTable thead td, table.dataTable tfoot th, table.dataTable tfoot td {
                padding: 5px 5px;
            }

            .custom-row { padding: 0px 0px 0px 0px !important; margin: 0px 0px 0px 0px !important; }
            .product-type-mr { margin: 1px 0px; }
            .product-mr { margin: 1px 3px; }
            .nopadding { padding: 0px !important; margin: 0px !important; }
            .custom-padding { padding: 1px !important; margin: 0px !important; }
            .custom-panel-body { padding: 3px; }
            .custom-panel { margin-bottom: 2px; border-radius: 0px; }
            .modal { text-align: center; }
            .flip { display: none; }
            .flip .flip__inner{
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-40%,25%);
                cursor: pointer;
                width: 40px;
                height: 32px;
            }

            .flip__inner{ background-color: transparent; border: 1px solid white; border-radius: 3px; }
            .flip__inner > div{
                width: 30px;
                height: 2px;
                margin: 4px;
                background: #fff;
                position: absolute;
                top: 0;
                left: 0;
            }

            .flip div.two{ top: 10px; }
            .flip div.three{ top: 20px; }

            @media screen and (min-width: 768px) {
                .modal:before { display: inline-block; vertical-align: middle; content: " "; height: 100%; }
                .flip { display: block; }
                .sidebar { display: none; }
                .navbar-header { float: left; width: 155px; }
            }

            #page-wrapper { position: inherit; margin: 0 0 0 0px; padding: 5px 25px 25px 25px; border-left: 1px solid #e7e7e7; }
            .company-name { display: none; }
            .company-short-name { display: contents; }

            /* after adding active class start*/
            #wrapper.active .sidebar{ display: block; margin-top: 52px; }
            #page-wrapper.active { margin: 0 0 0 250px; padding: 5px 25px 25px 25px; }
            .navbar-header.active { width: 250px; }

            .company-name.active { display: contents; }
            .company-short-name.active { display: none; }
            /* after adding active class end*/

            .modal-dialog { display: inline-block; text-align: left; vertical-align: middle; }
            .modal-content{
                position: relative;
                background-color: #ffffff;
                border: 1px solid #999999;
                border: 1px solid rgba(0, 0, 0, 0.2);
                border-radius: 0px; /*<!-- HERE I AM!---*/
                -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
                box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
                background-clip: padding-box;
                outline: none;
            }
            .mendatory { color: red; font-weight: 700; }
            #panel{ float:left; overflow: hidden; }
            .switchery { height: 20px !important; width: 40px !important; }
            .switchery > small { height: 20px !important; width: 20px !important; }

            .loader {
                display : block;
                margin: auto;
                border: 5px solid #f3f3f3;
                border-radius: 50%;
                border-top: 5px solid green;
                width: 50px;
                height: 50px;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
            }

            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

        <!--JS Files-->
        <!-- <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> -->
        <!-- <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script> -->
        <script src="<?= base_url('assets/js/respond.js') ?>"></script>
        <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/vendor/metisMenu/metisMenu.js') ?>"></script>
        <script src="<?= base_url('assets/vendor/raphael/raphael.min.js') ?>"></script>
        <script src="<?= base_url('assets/dist/js/sb-admin-2.js') ?>"></script>
        <script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/validation.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/menu.js') ?>"></script>
        <!-- <script src="<?= base_url(); ?>assets/select2/dist/js/select2.full.min.js" type="text/javascript"></script> -->

        <!-- <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script> -->
        <!-- <script src="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/jqueryui/dataTables.jqueryui.js"></script> -->

        <script src="<?= base_url('assets/datatable/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('assets/datatable/js/dataTables.jqueryui.js') ?>"></script>
        <!-- <script src="<?= base_url('assets/datatable/js/dataTables.responsive.js') ?>"></script> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
        <script src='<?= base_url('assets/fullcalendar/lib/moment.min.js') ?>'></script>
        <script src="<?= base_url('/assets/fullcalendar/js/fullcalendar.js') ?>"></script>
        <script src="<?= base_url('assets/fullcalendar/js/fullcalendar.min.js') ?>"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
        <script src='<?php echo base_url('assets/calendar/js/bootstrap-colorpicker.min.js'); ?>'></script>
        <script src='<?php echo base_url('assets/calendar/js/bootstrap-timepicker.min.js'); ?>'></script>
        <script src='<?php echo base_url('assets/calendar/js/main.js'); ?>'></script>
        <script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/vendor/Chart.js/samples/Chart.bundle.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/vendor/Chart.js/samples/utils.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/vendor/Chart.js/samples/charts/area/analyser.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/vendor/select2-4.0.0/select2.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/vendor/monthpicker.jqueryplugin/js/jquery.monthpicker.js" type="text/javascript"></script>
      	<script src="<?= base_url(); ?>assets/vendor/table2excel/dist/jquery.table2excel.js" type="text/javascript"></script>
        <script src="<?= base_url('assets/js/script.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/jquery.PrintArea.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/sweetalert/jquery.sweet-alert.custom.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/datepicker/js/daterangepicker.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/build/js/custom.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/switchery/dist/switchery.min.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>assets/minimal_hexagon_countdown_timer/dist/svgTimer.min.js"></script>

        <script>
            $(document).ready(function () {
                $(".flip").click(function(){
                    $("#wrapper").toggleClass("active");
                    $("#page-wrapper").toggleClass("active");
                    $(".navbar-header").toggleClass("active");
                    $(".company-name").toggleClass("active");
                    $(".company-short-name").toggleClass("active");
                });

                $('.select2').select2();

                // Switchery
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                // $('.js-switch').each(function() {
                //     new Switchery($(this)[0], $(this).data());
                // });
                
                // For Print Jquery Code
                // $("#print").click(function() {
                //     var mode = 'iframe'; //popup
                //     var close = mode == "popup";
                //     var options = {
                //         mode: mode,
                //         popTitle: "POS",
                //         popClose: close
                //     };
                //     $("div.printableArea").printArea(options);
                // });
            });

            // $(function () {
            //     $('.svg-test').svgTimer();
            // });

            // var _gaq = _gaq || [];
            // _gaq.push(['_setAccount', 'UA-36251023-1']);
            // _gaq.push(['_setDomainName', 'jqueryscript.net']);
            // _gaq.push(['_trackPageview']);

            // (function() {
            //     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            //     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            //     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            // })();
        </script>
    </head>

    <!--<body class="body-frontend" style="background: url(assets/img/background/background.jpg) 50% 0 repeat">-->
    <body class="body-frontend font-selector" style="background-color: #ffffff;">
        <!-- Modal -->
