<div id="page-wrapper">
    <link href="<?= base_url(); ?>assets/vendor/monthpicker.jqueryplugin/css/jquery.monthpicker.css" rel="stylesheet" type="text/css"/>
    <script src="<?= base_url(); ?>assets/vendor/monthpicker.jqueryplugin/js/jquery.monthpicker.js" type="text/javascript"></script>
    <div class="content1">
        <a href="#monthpicker" id="monthpicker"></a>
    </div>


    <table class="table table-bordered">
        <tbody>
            <tr>
                <td rowspan="2" width="20%">1</td>
                <td>2</td>
            </tr>
            <tr>
                <td>3</td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        $(function () {
            $('#monthpicker').monthpicker({
                years: [2016, 2015, 2014, 2013, 2012, 2011],
                topOffset: 6,
                onMonthSelect: function (m, y) {
                    console.log('Month: ' + m + ', year: ' + y);
                }
            });
        });
    </script>

</div>







