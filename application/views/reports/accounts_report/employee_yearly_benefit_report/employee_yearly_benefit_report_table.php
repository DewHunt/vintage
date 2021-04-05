<div class="card card-boarder">

    <?php
    $company_information;
    $employee_list;
    $salary_details_by_year;

    function get_benefit($month, $year, $employee_id) {
        $m_benefit = new Employee_benefit_Model();
        $res = $m_benefit->get_employee_benefit_by_month_year($month, $year, $employee_id);
        if (!empty($res)) {
            return $res->sum_of_amount;
        } else {
            return 0;
        }
    }
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Employee: <?= ucfirst($employee_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Year: <?= $year ?></label>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary employee-yearly-benefit-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i>
            Print
        </button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>Name</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $january_total = 0;
            $february_total = 0;
            $march_total = 0;
            $april_total = 0;
            $may_total = 0;
            $june_total = 0;
            $july_total = 0;
            $august_total = 0;
            $september_total = 0;
            $october_total = 0;
            $november_total = 0;
            $december_total = 0;
            foreach ($employee_list as $employee) {
                ?>
                <?php $january_total += (double) get_benefit('january', $year, $employee->id); ?>
                <?php $february_total += (double) get_benefit('feruary', $year, $employee->id); ?>
                <?php $march_total += (double) get_benefit('march', $year, $employee->id); ?>
                <?php $april_total += (double) get_benefit('april', $year, $employee->id); ?>
                <?php $may_total += (double) get_benefit('may', $year, $employee->id); ?>
                <?php $june_total += (double) get_benefit('june', $year, $employee->id); ?>
                <?php $july_total += (double) get_benefit('july', $year, $employee->id); ?>
                <?php $august_total += (double) get_benefit('august', $year, $employee->id); ?>
                <?php $september_total += (double) get_benefit('september', $year, $employee->id); ?>
                <?php $october_total += (double) get_benefit('october', $year, $employee->id); ?>
                <?php $november_total += (double) get_benefit('november', $year, $employee->id); ?>
                <?php $december_total += (double) get_benefit('december', $year, $employee->id); ?>
                <tr>
                    <td><?= ucfirst($employee->employee_name) ?></td>
                    <td><?= number_format((double) get_benefit('january', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('feruary', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('march', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('april', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('may', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('june', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('july', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('august', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('september', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('october', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('november', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('december', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('', $year, $employee->id), 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $january_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $february_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $march_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $april_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $may_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $june_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $july_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $august_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $september_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $october_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $november_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $december_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) get_benefit('', $year, 0), 2); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="modal fade clientwise-voucher-details-information-modal">
        <div class="modal-dialog modal-lg client-voucher-show " role="document">
        </div>
    </div>
</div>

<!--For Print-->
<!--Display None-->

<div id="employee-yearly-benefit-report-print-information" style="display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date"><strong>Employee Yearly Benefit Report</strong></label>
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date">Employee: <?= ucfirst($employee_name) ?></label>
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date">Year: <?= $year ?></label>
    </div>


    <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Name
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Jan
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Feb
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Mar
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    April
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    May
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    June
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    July
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Aug
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Sep
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Oct
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Nov
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Dec
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Total
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $january_total = 0;
            $february_total = 0;
            $march_total = 0;
            $april_total = 0;
            $may_total = 0;
            $june_total = 0;
            $july_total = 0;
            $august_total = 0;
            $september_total = 0;
            $october_total = 0;
            $november_total = 0;
            $december_total = 0;
            foreach ($employee_list as $employee) {
                ?>
                <?php $january_total += (double) get_benefit('january', $year, $employee->id); ?>
                <?php $february_total += (double) get_benefit('feruary', $year, $employee->id); ?>
                <?php $march_total += (double) get_benefit('march', $year, $employee->id); ?>
                <?php $april_total += (double) get_benefit('april', $year, $employee->id); ?>
                <?php $may_total += (double) get_benefit('may', $year, $employee->id); ?>
                <?php $june_total += (double) get_benefit('june', $year, $employee->id); ?>
                <?php $july_total += (double) get_benefit('july', $year, $employee->id); ?>
                <?php $august_total += (double) get_benefit('august', $year, $employee->id); ?>
                <?php $september_total += (double) get_benefit('september', $year, $employee->id); ?>
                <?php $october_total += (double) get_benefit('october', $year, $employee->id); ?>
                <?php $november_total += (double) get_benefit('november', $year, $employee->id); ?>
                <?php $december_total += (double) get_benefit('december', $year, $employee->id); ?>
                <tr style="border: thick">
                    <td><?= ucfirst($employee->employee_name) ?></td>
                    <td><?= number_format((double) get_benefit('january', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('feruary', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('march', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('april', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('may', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('june', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('july', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('august', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('september', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('october', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('november', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('december', $year, $employee->id), 2); ?></td>
                    <td><?= number_format((double) get_benefit('', $year, $employee->id), 2); ?></td>
                </tr>
            <?php } ?>
            <tr style="border: thick">
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $january_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $february_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $march_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $april_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $may_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $june_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $july_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $august_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $september_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $october_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $november_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $december_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) get_benefit('', $year, 0), 2); ?></strong></td>
            </tr>
        </tbody>
    </table>

</div>


<script language="javascript" type="text/javascript">
    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

    $('.client-voucher-details-view-button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.clientwise-voucher-details-information-modal .client-voucher-show').html(data)
            $('.clientwise-voucher-details-information-modal').modal('show');
        });
    });

    $(".employee-yearly-benefit-report-print-button").on("click", function () {

        var divContents = $('#employee-yearly-benefit-report-print-information').html();

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

</script>

<!--<script>
    $(document).ready(function(){
        var table = $('#details-table').dataTable();
        var tableTools = new $.fn.dataTable.TableTools(table,{
            'sSwfPath':'//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf',
            'aButtons':['copy',{
                'sExtends':'print',
                'bShowAll': false
            },
                'csv',
                {
                    'sExtends': 'xls',
                    'sFileName':'*.xls',
                    'sButtonText':'Save to Excel'
                },
                {
                    'sExtends': 'pdf',
                    'bFooter':false
                }
            ]
        });
        $(tableTools.fnContainer()).insertBefore('#details-table_wrapper');
    });
</script>-->
