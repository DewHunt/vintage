<div id="page-wrapper">
    <?php
    $from_date = date('Y-m-d');
    /* echo '<pre>';
      echo print_r($invoice_details);
      echo '</pre>'; */
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Gate Pass Report (Sales)</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 gate-pass-report-form-block">

                            <form id="invoice_report_form" name="invoice_report_form" action="<?= base_url('reports/gate_pass_report/gate_pass_report_show_in_table') ?>" method="post">

                                <div class="form-group row">

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="start_date">From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $from_date ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="end_date">To</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $from_date ?>">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-3" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 gate-pass-report-table">

                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>

    <!--    <div class="modal fade gate-pass-info-modal">
            <div class="modal-dialog modal-lg invoice-show " role="document">
            </div>
        </div>-->

</div>
<!-- /#page-wrapper -->


<script type="text/javascript">
    $(document).ready(function () {

        $('.gate-pass-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".gate-pass-report-table").html(data);
            });
        });
        //Jquery Data Table
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

//        $('.gate-pass-view-button').on('click', function (event) {
//            event.preventDefault();
//            $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
//                $('.gate-pass-info-modal .invoice-show').html(data)
//                $('.gate-pass-info-modal').modal('show');
//            });
//        });
    });
</script>
