<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
            </div>
            <div class="col-xs-12">
                <!--<label class="search-from-date">Employee: <?= ucfirst($employee_name) ?></label>-->
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button productwise-profit-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="table-responsive table-bordered" style="width: 100%;">
        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Claim Date</th>
                    <th>Insert Date</th>
                    <th>Invoice No.</th>
                    <th>Client</th>
                    <th>Commission Record No.</th>
                    <th class="text-right">Amount</th>                    
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($sales_commission_report)) {
                    $count = 1;
                    $commission_amount_total = 0;
                    foreach ($sales_commission_report as $sales_commission) {
                        $claim_date = date("d-m-Y", strtotime($sales_commission->claim_date));
                        $current_date = date("d-m-Y", strtotime($sales_commission->current_date_time));
                        $commission_amount = !empty($sales_commission->commission_amount) ? get_floating_point_number($sales_commission->commission_amount) : 0;
                        $commission_amount_total += $commission_amount;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $claim_date; ?></td>
                            <td><?= $current_date; ?></td>
                            <td><?= !empty($sales_commission->invoice_number) ? $sales_commission->invoice_number : '' ?></td>
                            <td><?= !empty($sales_commission->client_name) ? $sales_commission->client_name : '' ?></td>
                            <td><?= !empty($sales_commission->commission_record_number) ? $sales_commission->commission_record_number : '' ?></td>
                            <td class="text-right"><?= get_floating_point_number($commission_amount, TRUE); ?></td>                                                        
                            <td><?= !empty($sales_commission->name) ? $sales_commission->name : '' ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($commission_amount_total, TRUE); ?></strong></td>                                                        
                        <td></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="productwise-profit-report-table-print-section" style="display: none; width: 100%" >
    <style>
        .print-table {
            width: 100%;
            border-collapse: collapse !important;
            border: 2px solid;            
        }
        .print-table th{
            text-align: center; 
            font-weight: bold; 
            background-color: black; 
            color: white; 
            font-size: 18px;
        }
        .print-table th,
        .print-table td {
            border: 1px solid #ddd !important;
        }
        .text-right{
            text-align: right;
        }
    </style>
    <?php $this->load->view('reports/company_info_as_report_header', $this->data); ?>
    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong><?= !empty($report_title) ? $report_title : ''; ?></strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Client: <?= ucfirst($client_name) ?></label>
    </div>
    <div class="col-xs-12">
        <!--<label class="search-from-date">Employee: <?= ucfirst($employee_name) ?></label>-->
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Claim Date</th>
                <th>Insert Date</th>
                <th>Invoice No.</th>
                <th>Client</th>
                <th>Commission Record No.</th>
                <th class="text-right">Amount</th>                    
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sales_commission_report)) {
                $count = 1;
                $commission_amount_total = 0;
                foreach ($sales_commission_report as $sales_commission) {
                    $claim_date = date("d-m-Y", strtotime($sales_commission->claim_date));
                    $current_date = date("d-m-Y", strtotime($sales_commission->current_date_time));
                    $commission_amount = !empty($sales_commission->commission_amount) ? get_floating_point_number($sales_commission->commission_amount) : 0;
                    $commission_amount_total += $commission_amount;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $claim_date; ?></td>
                        <td><?= $current_date; ?></td>
                        <td><?= !empty($sales_commission->invoice_number) ? $sales_commission->invoice_number : '' ?></td>
                        <td><?= !empty($sales_commission->client_name) ? $sales_commission->client_name : '' ?></td>
                        <td><?= !empty($sales_commission->commission_record_number) ? $sales_commission->commission_record_number : '' ?></td>
                        <td class="text-right"><?= get_floating_point_number($commission_amount, TRUE); ?></td>                                                        
                        <td><?= !empty($sales_commission->name) ? $sales_commission->name : '' ?></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($commission_amount_total, TRUE); ?></strong></td>                                                        
                    <td></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $(".productwise-profit-report-table-print-button").click(function () {
            var divContents = $('#productwise-profit-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

