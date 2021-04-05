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
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><h4 class="">Supplier Report</h4></div>
            </div>
        </div>

        <div class="panel-body custom-panel-body">
            <div class="purchase-statement-form-block">
                <form id="invoice_report_form" name="invoice_report_form" action="<?= base_url('payment_statement/show/') ?>" method="post">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="padding: 0px 5px;">
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

                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="padding: 0px 5px;">
                            <label for="supplier_id">Supplier</label>
                            <div class="form-group">
                                <select name="supplier_id" id="supplier_id" class="form-control select2">
                                    <option value="0">Select A Supplier</option>
                                    <option value="all">All</option>
                                    <?php foreach ($supplierList as $supplier): ?>
                                        <option value="<?= $supplier->id ?>"><?= $supplier->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-right" style="padding: 0px 5px;">
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
            <div class="payment-statement-table"></div>
        </div>
    </div>

    <div class="modal fade" id="paymentProductInfoModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center modal-lg">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
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
        $('.purchase-statement-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".payment-statement-table").html(data.output);
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

    function viewPaymentInfo(supplierId,startDate,endDate) {
        $.ajax({
            type: "POST",
            url: '<?= base_url("payment_statement/view/") ?>',
            data: {supplierId:supplierId,startDate:startDate,endDate:endDate},
            success: function (data) {
                $('.modal-body').html(data.output);
                $('#paymentProductInfoModal').modal('show');
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
