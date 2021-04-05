<div id="page-wrapper">
    <style type="text/css">
        .custom-panel-body {
            padding: 15px 15px 0px 15px;
        }
    </style>
    <?php
        $from_date = date('Y-m-d');
        $user_info = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($user_info); exit();
        $user_type = $user_info['user_type'];
        $print_access = $user_info['print_access'];
        $invoice_details_view;

        if ($user_type == "Sales Person") {
            $client_col = "col-lg-5 col-md-5 col-sm-5 col-xs-12";
            $outlet_col = "col-lg-10 col-md-10 col-sm-8 col-xs-12";
        }
        else {
            $client_col = "col-lg-3 col-md-3 col-sm-5 col-xs-12";
            $outlet_col = "col-lg-3 col-md-3 col-sm-4 col-xs-12";
        }

        // echo '<pre>'; echo print_r($print_access); echo '</pre>';
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><h4 class="">Invoice Details Report</h4></div>
            </div>
        </div>

        <div class="panel-body custom-panel-body">
            <div class="invoice-report-form-block">
                <form id="invoice_report_form" name="invoice_report_form" action="<?= base_url('reports/invoice_report/invoice_report_show_in_table') ?>" method="post">
                    <input class="form-control" type="hidden" id="userType" name="userType" value="<?= $user_info['user_type'] ?>">
                    <div class="row">
                        <?php if ($user_type != "Sales Person"): ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0px 5px;">
                                <label>Date</label>
                                <div class="form-group">
                                    <div id="reportrange-new" class="pull-left" style="width: 100%; text-align: center; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                        <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                                        <div class="date-to-form">
                                            <input id="to_date_id" type="hidden" name="to_date" value="">
                                            <input id="from_date_id" type="hidden" name="from_date" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        <?php endif ?>

                        <?php if ($user_type != "Sales Person"): ?>
                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12" style="padding: 0px 5px;">
                                <label for="client_id">Client</label>
                                <div class="form-group">
                                    <select name="client_id" id="client_id" class="form-control select2">
                                        <option value="0" name="client_id">All</option>
                                        <?php foreach ($client_list as $client): ?>
                                            <option value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="<?= $outlet_col ?>" style="padding: 0px 5px;">
                            <label for="branch_id">Outlet</label>
                            <div class="form-group">
                                <select class="form-control branch_id select2" name="branch_id" id="branch_id">
                                    <?php if ($user_type != "Sales Person"): ?>
                                        <option value="0">All</option>
                                    <?php endif ?>
                                    <?php foreach ($branch_list as $branch): ?>
                                        <option value="<?= intval($branch->id) ?>"><?= ucfirst($branch->branch_name) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-right" style="padding: 0px 5px;">
                            <label for=""></label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="show-button" style="padding-right: 14px; padding-left: 14px">Show</button>
                                <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                <span class="btn btn-primary order_summary_button" style="margin-top: 4px;" onclick="showOrderSummary()"><i class="fa fa-print" aria-hidden="true"></i> Order Summary</span>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="invoice-report-table"></div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="invoice-report-table"></div>
        </div>
    </div>

    <div class="row" style="display: none;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="printableArea" style="padding: 15px;"></div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.invoice-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".invoice-report-table").html(data);
            });
        });

        $(".print-button").on("click", function () {
            var divContents = $('#invoice-report-print-section').html();

            if (divContents) {
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            }
            else {
                swal("Error!", "Please Search Invoice Details Report!", "error");
            }
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

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });

    function showOrderSummary() {
        var from_date = $('#from_date_id').val();
        var to_date = $('#to_date_id').val();
        var branch_id = $('#branch_id').val();
        var userType = $('#userType').val();
        var divContents = $('#invoice-report-print-section').html();

        if (userType == 'Sales Person') {
            if (divContents) {
                var pendingOrder = $('#countPendingOrder').val();
                if (pendingOrder > 0) {
                    swal("Error!", "You Have "+pendingOrder+" Pending Order", "error");
                    return false;
                }
            } else {
                swal("Error!", "Please Search Invoice Details Report!", "error");
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: '<?php echo base_url("reports/invoice_report/get_order_summary/") ?>',
            data: {from_date:from_date,to_date:to_date,branch_id:branch_id},
            success: function (data) {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    popTitle: "Order Summary",
                    mode: mode,
                    popClose: close
                    // popClose: false
                };
                $(".printableArea").html(data.orderSummaryReport);
                $("div.printableArea").printArea(options);
            },
            error: function () {
            }
        })
    }

    var start = moment();
    var end = moment();
    function cb(start, end) {
        $('#reportrange-new .date-to-form input[name="to_date"]').val(end.format('YYYY-MM-DD'));
        $('#reportrange-new .date-to-form input[name="from_date"]').val(start.format('YYYY-MM-DD'));
        $('#reportrange-new span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange-new').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);
</script>
