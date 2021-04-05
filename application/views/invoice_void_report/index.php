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
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><h4 class="">Invoice Void Report</h4></div>
            </div>
        </div>

        <div class="panel-body custom-panel-body">
            <div class="form-block">
                <form id="invoice_void_report_form" name="invoice_void_report_form" action="<?= base_url('invoice_void_report/show/') ?>" method="post">
                    <div class="row">
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

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0px 5px;">
                            <label for="customer">Factory</label>
                            <div class="form-group">
                                <select name="factory_id" id="factory_id" class="form-control select2">
                                    <option value="">Select A Factory</option>
                                    <?php foreach ($factoryList as $factory): ?>
                                        <option value="<?= $factory->id ?>"><?= $factory->branch_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0px 5px;">
                            <label for="customer">Outlet</label>
                            <div class="form-group">
                                <select name="branch_id" id="branch_id" class="form-control select2">
                                    <option value="">Select A Outlet</option>
                                    <option value="all">All</option>
                                    <?php foreach ($outletList as $outlet): ?>
                                        <option value="<?= $outlet->id ?>"><?= $outlet->branch_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right" style="padding: 0px 5px;">
                            <label for=""></label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="show-button" style="padding-right: 14px; padding-left: 14px">Show</button>
                                <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="invoice-void-report-table"></div>
        </div>
    </div>

    <div class="modal fade" id="invoiceVoidReportModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center modal-lg">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary view-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
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
        $('.form-block form').submit(function (event) {
            event.preventDefault();

            if ($('#client_id').val() == "") { swal('Error!','Please Select A Customer','error'); return false; }

            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".invoice-void-report-table").html(data.output);
            });
        });

        $(".print-button").on("click", function () {
            var divContents = $('#print-all-information').html();

            if (divContents) {
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            }
            else {
                swal("Error!", "Please Search Report At First!", "error");
            }
        });

        $(".view-print-button").on("click", function () {
            var divContents = $('#print-view-information').html();

            if (divContents) {
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            }
            else {
                swal("Error!", "Please Search Report At First!", "error");
            }
        });
    });

    $('#factory_id').change(function () {
        var factoryId = $( "#factory_id" ).val();
        if (factoryId != "") {
            $( "#branch_id" ).val("").trigger('change');
        }
    });

    $('#branch_id').change(function () {
        var branchId = $( "#branch_id" ).val();
        if (branchId != "") {
            $( "#factory_id" ).val("").trigger('change');
        }
    });

    function viewInvoiceVoidInfo(invoiceVoidId,startDate,endDate) {
        $.ajax({
            type: "POST",
            url: '<?= base_url("invoice_void_report/view/") ?>',
            data: {invoiceVoidId:invoiceVoidId,startDate:startDate,endDate:endDate},
            success: function (data) {
                $('.modal-body').html(data.output);
                $('#invoiceVoidReportModal').modal('show');
            },
            error: function () {

            }
        });
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
