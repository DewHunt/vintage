<div id="page-wrapper">
    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
//    echo '<pre>';
//    echo print_r($print_access);
//    echo '</pre>';
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Warning Letter Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 warning-letter-report-form-block">

                            <form id="warning_letter_report_form" name="warning_letter_report_form" action="<?= base_url('reports/hr_report/warning_letter_report/warning_letter_report_show_in_table') ?>" method="post">

                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label class="" for="employee_id">Employee</label>
                                        <select class="form-control" name="employee_id" id="employee_id"
                                                class="form-control">
                                            <option value="0">All</option>
                                            <?php foreach ($employee_list as $employee) { ?>
                                                <option value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 warning-letter-report-table">

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

        $('.warning-letter-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".warning-letter-report-table").html(data);
            });
        });

        $(".print-button").on("click", function () {

            var divContents = $('#invoice-report-print-section').html();

            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
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
</script>
