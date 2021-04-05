<div class="width-100">
    <form id="product-sales-analysis-form" class="product-sales-analysis-form" method="post" accept-charset="" action="<?= base_url('reports/sales_statement_report/sales_analysis_report/product_sales_analysis_report/analysis_report'); ?>">
        <?php $this->load->view('reports/sales_statement_report/sales_analysis_report/sales_analysis_form_fields', $this->data); ?>
    </form>
    <div id="bar-chart-block" class="col-xs-12">
        <?php $this->load->view('reports/sales_statement_report/sales_analysis_report/product_sales_analysis/product_sales_analysis_bar_chart', $this->data); ?>
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.product-sales-analysis-form').submit(function (event) {
            event.preventDefault();
            var formClassName = 'product-sales-analysis-form';
            var isValid = dateDurationInsideFormValidation(formClassName);
            if (isValid) {
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function () {
                        $('.loading-image').show();
                        $(".show-button-section").hide();
                    },
                    complete: function () {
                        $('.loading-image').hide();
                        $(".show-button-section").show();
                    },
                    success: function (data) {
                        $("#bar-chart-block").html(data['html']);
                    },
                    error: function () {
                        console.log('Error Occured.');
                    }
                });
            }
        });
    });

    $('.canvas-print-button').click(function (e) {
        e.preventDefault();
        var divId = 'bar-chart';
        printCanvas(divId);
    });

    function printCanvas(divId) {
        var dataUrl = document.getElementById(divId).toDataURL(); //attempt to save base64 string to server using this var  
        var reportHeaderSection = '<div class="col-xs-12 text-center" style="text-align: center; font-size: 22px; font-weight: bolder"><label class=""><?php echo!empty(get_company_name()) ? strtoupper(get_company_name()) : ''; ?></label></div><div class="col-xs-12 text-center" style="text-align: center;"><label class=""><?php echo!empty(get_company_address()) ? get_company_address() : ''; ?></label><br></div><div class="col-xs-12" style="text-align: center;"><label class="search-from-date">Period: <?= !empty($start_date) ? display_date($start_date) : ''; ?> To <?= !empty($end_date) ? display_date($end_date) : ''; ?></label><br><br></div>';
        var windowContent = '<!DOCTYPE html>';
        windowContent += '<html>'
        windowContent += '<head><title>Print</title></head>';
        windowContent += '<body>'
        windowContent += reportHeaderSection;
        windowContent += '<img src="' + dataUrl + '">';
        windowContent += '</body>';
        windowContent += '</html>';
        var printWin = window.open('', '', 'width=800,height=400');
        printWin.document.open();
        printWin.document.write(windowContent);
        printWin.document.close();
        printWin.focus();
        printWin.print();
//        printWin.close();
    }

</script>

