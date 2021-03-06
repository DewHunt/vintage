<div id="envelope-print-information" style="margin-top: 50%; margin-left: 20%">
    <style>
        @page{
            size: auto;   
            margin: 0mm; 
        }
        .envelope_container {
            display: flex;
        }
        .box {
            width: 100%;
            text-align: left;
        }
        .vertical {
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }
        .text_font_size{
            font-size: 20px;
            font-weight: bold; 
        }
    </style>
    <?php if (empty($envelope_print->from_envelope_details) || $envelope_print->from_envelope_details == NULL) { ?>
        <table class="vertical" style="margin-top: 45%; margin-left: 30%">
            <thead>
            <th></th>
            </thead>
            <tbody>
            <td>
                <div class="box text_font_size">
                    <?= !empty($envelope_print->envelope_title) ? $envelope_print->envelope_title : '' ?><br>
                    <?= str_replace("\n", '<br>', $envelope_print->to_envelope_details) ?>
                </div>
            </td>
            </tbody>
        </table>
    <?php } else { ?>

        <table class="vertical" style="margin-top: 50%; margin-left: 30%">
            <thead>
            <th></th>
            </thead>
            <tbody>
            <td>
                <div class="box text_font_size">
                    <?= str_replace("\n", '<br>', $envelope_print->to_envelope_details) ?>
                </div>
            </td>
            </tbody>
        </table>

        <table class="vertical" style="margin-top:40%; margin-left: 30%">
            <thead>
            <th></th>
            </thead>
            <tbody>
            <td>
                <div class="envelope_container">   
                    <div class="box text_font_size">
                        <?= str_replace("\n", '<br>', $envelope_print->from_envelope_details) ?>
                    </div>
                </div>
            </td>
            </tbody>
        </table>

    <table class="vertical">
            <tr>
                <td>
                    <div class="envelope_container text_font_size" style="width: 100%; margin-left: 50%; margin-top: 10%; padding-left: 50%"> <?= !empty($envelope_print->envelope_title) ? $envelope_print->envelope_title : '' ?></div>
                </td>
            </tr>
        </table>


    <?php } ?>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        var result = confirm('Do you want to Print?');
        if (result === true) {
            if (document.getElementById('envelope-print-information') !== null) {
                var printContents = document.getElementById('envelope-print-information').innerHTML;
            }
//        var originalTitle = document.title;
//        document.title = 'new title';
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.replace("<?php echo base_url('accounts/all_print/envelope_print'); ?>");
        } else {
            window.location.replace("<?php echo base_url('accounts/all_print/envelope_print'); ?>");
        }

    });
</script>