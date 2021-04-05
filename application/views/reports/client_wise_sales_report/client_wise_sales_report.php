<div id="page-wrapper">
    <?php
        $client_list;
        $from_date = date('Y-m-d');
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        $employee_id = $user_info['employee_id'];

        if ($user_type == "Sales Person") {
            $outlet_col = "col-lg-10 col-md-10 col-sm-9 col-xs-12";
        }
        else {
            $outlet_col = "col-lg-5 col-md-5 col-sm-4 col-xs-12";
        }
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 class="">Client Wise Sales Report</h4></div>
            </div>            
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="client-wise-sales-report-form-block">
                <form id="client_details_ledger_report_form" name="client_details_ledger_report_form" action="<?= base_url('reports/client_wise_sales_report/client_wise_sales_report_show') ?>" method="post">
                    <div class="row">
                        <?php if ($user_type != "Sales Person"): ?>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="padding: 0px 5px;">
                                <label>Date</label>
                                <div class="form-group">
                                    <div id="reportrange-new" class="pull-left" style="width: 100%; text-align: center; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                        <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                                        <div class="date-to-form">
                                            <input id="from_date_id" type="hidden" name="from_date" value="">
                                            <input id="to_date_id" type="hidden" name="to_date" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        <?php endif ?>

                        <div class="<?= $outlet_col ?>" style="padding: 0px 5px;">
                            <label for="client_id">Client</label>
                            <div class="form-group">
                                <select name="client_id" id="client_id" class="form-control select2">
                                    <option value="0" name="client_id">All</option>
                                    <?php foreach ($client_list as $client): ?>
                                        <option class="lubzone-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-right" style="padding: 0px 5px;">
                            <label for=""></label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                                <button type="button" class="btn btn-primary print-all-report"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="client-wise-sales-report-table"></div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.client-wise-sales-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".client-wise-sales-report-table").html(data);
            });
        });

        $(".print-all-report").on("click", function () {
            var divContents = $('#print-all-information').html();

            if (divContents) {
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            } else {
                swal("Error!", "Please Search Client Wise Sales Report!", "error");
            }

        });

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
    });
</script>


