<div id="page-wrapper">
    <?php
    $from_date = date('Y-m-d');
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Voucher Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 voucher_report_form_block">
                        <form class="" name="employee_details_pf_funds_report_form" method="post"
                              action="<?= base_url('reports/accounts_report/Voucher_report/voucher_report_show') ?>">

                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="search-from-date" for="start_date">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                           value="<?= $from_date ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="search-from-date" for="end_date">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           value="<?= $from_date ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4" style="padding-top: 24px">
                                    <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                                </div>
                            </div>

                        </form>

                        <div class="form-group col-md-12 col-xs-12 voucher_report_table" style="margin-top: 10px">

                        </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
</div>

<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.voucher_report_form_block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".voucher_report_table").html(data);
            });
        });
    });
</script>







