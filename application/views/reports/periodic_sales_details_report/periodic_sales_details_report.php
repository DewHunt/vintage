<div id="page-wrapper">
    <?php
        $periodic_report_view_by_date;
        $from_date = date('Y-m-d');
        $user_info = $this->session->userdata('user_session');
        $user_type = $user_info['user_type'];
        $print_access = $user_info['print_access'];

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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 class="">Product Report</h4></div>
            </div>            
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="periodic-sales-details-form-block">
                <form class="" name="order-report" method="post" action="<?= base_url('reports/periodic_sales_details_report/periodic_sale_details_show') ?>">
                    <div class="row">
                        <?php if ($user_type != "Sales Person"): ?>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="padding: 0px 5px;">
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

                        <div class="<?= $outlet_col ?>" style="padding: 0px 5px;">
                            <label for="branch_id">Outlet</label>
                            <div class="form-group">
                                <select class="form-control branch_id select2" name="branch_id" id="branch_id">
                                    <?php if ($user_type != "Sales Person"): ?>
                                        <option value="0">All</option>
                                    <?php endif ?>                                    
                                    <?php if (!empty($branch_list)): ?>
                                        <?php foreach ($branch_list as $branch): ?>
                                            <option value="<?= intval($branch->id) ?>"><?= ucfirst($branch->branch_name) ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-right" style="padding: 0px 5px;">
                            <label for=""></label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                                <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                <!-- <button type="submit" class="btn btn-primary btn-lg stock-transfer-challan-report-button" id="show-button">Show</button> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="periodic-sales-table"></div>
        </div>
    </div>    
</div>
<!-- /#page-wrapper -->


<script type="text/javascript">
    $(document).ready(function () {
        $('.periodic-sales-details-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".periodic-sales-table").html(data);
            });
        });
    });

    $(".print-button").on("click", function () {
        var divContents = $('#print-information').html();

        if (divContents) {
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        } else {
            swal("Error!", "Please Search Product Report!", "error");
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
</script>








