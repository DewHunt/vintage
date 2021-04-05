<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Envelop Print Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <div class="col-xs-12 text-align-center">
                            <p><span class="text-color-green"><span class="text-color-red">&#x2605;</span> For Small Please Select Paper Size: Envelope Monarch</span></p>
                            <p><span class="text-color-green"><span class="text-color-red">&#x2605;</span> For Medium Please Select Paper Size: Envelope DL</span></p>
                            <p><span class="text-color-green"><span class="text-color-red">&#x2605;</span> For Large Please Select Paper Size: Envelope C5</span></p>
                        </div>
                        <div class="col-xs-12">
                            <button type="button" class="right-side-view btn btn-primary report-print-button all-envelope-print-report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                        </div>
                        <table class="table table-striped" style="width: 100%" id="details-table">

                            <thead class="thead-default">
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($all_envelope_print as $envelope_print) {
                                    ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= $envelope_print->envelope_title ?></td>
                                        <td><?= $envelope_print->from_envelope_details ?></td>
                                        <td><?= $envelope_print->to_envelope_details ?></td>
                                        <td>
                                            <button class="btn btn-primary envelope-print-report-print-button"data-toggle="tooltip" data-placement="bottom" title="Print" data-id="<?= $envelope_print->id ?>" data-action="<?= base_url('reports/accounts_report/all_print_report/envelope_print_report/envelope_print_report_print') ?>">
                                                <i class="fa fa-print" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="all-envelope-print-report-print-information" style="width: 100%; display: none;">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date"><strong>Cheque Print Report</strong></label>
        </div>
        <hr>
    </div>       
    <table width="100%" border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">
        <thead class="thead-default">
            <tr style="border: thick">
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Title
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    From
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    To
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($all_envelope_print as $envelope_print) {
                ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $envelope_print->envelope_title ?></td>
                    <td><?= $envelope_print->from_envelope_details ?></td>
                    <td><?= $envelope_print->to_envelope_details ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<style>
    .envelope-size-button{
        padding: 20px 40px 20px 40px;
    }
    .envelope-size-button-color{
        background-color: #00c;
    }
    .envelope-size-button-color:hover{
        background-color: #0000FF;
    }
</style>
<div class="modal fade envelope-size-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Select Envelope Size</h4>
            </div>

            <div class="modal-body" data-id="" data-action="">

                <center>
                    <a class="btn btn-success envelope-size-button" value="small">Small</a>
                    <a class="btn btn-primary envelope-size-button" value="medium">Meduim</a>
                    <a class="btn btn-primary envelope-size-button envelope-size-button-color" value="large">Large</a>
                </center>
            </div>

            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $(".all-envelope-print-report-print-button").on("click", function () {
            var divContents = $('#all-envelope-print-report-print-information').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });

        envelope_print_report_print();
        function envelope_print_report_print() {
            $(".envelope-print-report-print-button").on("click", function () {
                $('.envelope-size-modal').modal('show');
                var id = $(this).attr('data-id');
                var action = $(this).attr('data-action');
                $('.envelope-size-modal .modal-body').attr('data-id', id);
                $('.envelope-size-modal .modal-body').attr('data-action', action);
            });
        }

        print_with_envelope_size();
        function print_with_envelope_size() {
            $('.envelope-size-button').on('click', function (event) {
                event.preventDefault();
                var id = $('.envelope-size-modal .modal-body').attr('data-id');
                var action = $('.envelope-size-modal .modal-body').attr('data-action');
                var envelope_size = $(this).attr('value');
                envelope_size = envelope_size.trim();
                if (envelope_size === '') {
                    return false;
                } else {
                    $('.envelope-size-modal').modal('hide');
                    $.post(action, {'id': id, 'envelope_size': envelope_size}, function (data) {
                        var divContents = data['value'];
                        var printWindow = window.open();
                        printWindow.document.write(divContents);
                        printWindow.document.close();
                        printWindow.print();
                        printWindow.close();
                    });
                }
            });
        }

    });
</script>
