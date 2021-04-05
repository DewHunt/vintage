<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 delivery-itemwise-cost-report-form-block">
                            <form id="delivery-itemwise-cost-report-form" name="delivery-itemwise-cost-report-form" action="<?= base_url('reports/delivery_itemwise_cost_report/delivery_itemwise_cost_report_show_in_table') ?>" method="post">
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="start_date">From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                               value="<?= get_current_date(); ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="end_date">To</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                               value="<?= get_current_date(); ?>">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="delivery_cost_type_id">Delivery Cost Name</label>
                                        <select class="form-control" name="delivery_cost_type_id" id="delivery_cost_type_id">
                                            <option value="0">All</option>
                                            <?php
                                            if (!empty($delivery_cost_type_list)) {
                                                foreach ($delivery_cost_type_list as $delivery_cost_type) {
                                                    ?>
                                                    <option value="<?= !empty($delivery_cost_type->id) ? intval($delivery_cost_type->id) : 0; ?>"><?= !empty($delivery_cost_type->delivery_cost_name) ? $delivery_cost_type->delivery_cost_name : ''; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-3" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 delivery-itemwise-cost-report-table">

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
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {

        $('.delivery-itemwise-cost-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".delivery-itemwise-cost-report-table").html(data);
            });
        });

        $(".print-button").on("click", function () {

            var divContents = $('#print-information').html();

            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });

        //Jquery Data Table
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>
