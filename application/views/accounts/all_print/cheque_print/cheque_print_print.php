<div id="cheque-print-information" class="col-xs-12" style="width: 100%; display: none; margin: 0px;">
    <style type="text/css" media="print">
        @page 
        {
            size: auto;   
            margin: 0mm; 
        }

        .date_font_design{
            font-size: 28px;
        }

    </style>
    <?php
    //var_dump($cheque_print);
    $cheque_date = date('d/m/Y', strtotime($cheque_print->cheque_date));
    $cheque_date = (string) $cheque_date;
//    $amount_in_words = "Nine Corer Nine Lac Ninty N ine Thousand Nine Hundrand Ninty Nine Taka Only";
    $amount_in_words = $cheque_print->amount_in_words;
    $explode_string = explode(" ", $amount_in_words);
    $string = '';
    $new_string = '';
    $max_character_count = 26;
    $isLine = false;
    $isSpace = false;
    foreach ($explode_string as $key => $value) {
        $string1 = $string;
        if (!$isSpace) {
            $string1 .= $value;
        } else {
            $string1 .= ' ' . $value;
        }

        $string_length = strlen($string1);
//                echo $string_length;
        if ($string_length <= $max_character_count) {
            if (!$isSpace) {
                $string .= $value;
            } else {
                $string .= ' ' . $value;
            }
            $isSpace = true;
        } else {
            if (!$isLine) {
                $new_string .= $value;
            } else {
                $new_string .= ' ' . $value;
            }
            $isLine = true;
        }
    }
    ?>
    <div style="width: 100%; margin: 74.5px">
        <span style="width: 100%; margin-left: 750px; font-weight: bold;"><span class="date_font_design" style="padding-left: 4px;"><?= $cheque_date[0] ?></span> <span class="date_font_design" style="padding-left: 8px;"><?= $cheque_date[1] . '/' ?></span> <span class="date_font_design" style="padding-left: 12px;"><?= $cheque_date[3] ?></span> <span class="date_font_design" style="padding-left: 8px; "><?= $cheque_date[4] . '/' ?></span> <span class="date_font_design" style="padding-left: 8px;"><?= $cheque_date[6] ?></span> <span class="date_font_design" style="padding-left: 12px;"><?= $cheque_date[7] ?></span> <span class="date_font_design" style="padding-left: 8px; "><?= $cheque_date[8] ?></span> <span class="date_font_design" style="padding-left: 8px;"><?= $cheque_date[9] ?></span></span><br>

        <span class="date_font_design" style="width: 100%; margin-left: 130px; margin-top: 55px; float: left; font-weight: bold;"><?= $cheque_print->pay_to ?></span>

        <span class="date_font_design" style="width: 100%; margin-left: 210px; margin-top: 12px; float: left; font-weight: bold;"><?= !empty($string) ? $string : '' ?></span>
        <?php if (empty($new_string) || $new_string == '') { ?>
            <span class="date_font_design" style="width: 100%; margin-left: 10px; margin-top: 10px; float: left; font-weight: bold;"><?= !empty($new_string) ? $new_string : '' ?></span>

            <span class="date_font_design" style="width: 100%; margin-left: 745px; margin-top: -45px; float: left; font-weight: bold;"><?= get_floating_point_number($cheque_print->amount, TRUE) . '/=' ?></span>
        <?php } else { ?>
            <span class="date_font_design" style="width: 100%; margin-left: 10px; margin-top: 10px; float: left; font-weight: bold;"><?= !empty($new_string) ? $new_string : '' ?></span>

            <span class="date_font_design" style="width: 100%; margin-left: 740px; margin-top: -90px; float: left; font-weight: bold;"><?= get_floating_point_number($cheque_print->amount, TRUE) . '/=' ?></span>
        <?php }
        ?>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        var result = confirm('Do you want to Print?');
        if (result == true) {
            if (document.getElementById('cheque-print-information') !== null) {
                var printContents = document.getElementById('cheque-print-information').innerHTML;
            }
//        var originalTitle = document.title;
//        document.title = 'new title';
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.replace("<?php echo base_url('accounts/all_print/cheque_print'); ?>");
        } else {
            window.location.replace("<?php echo base_url('accounts/all_print/cheque_print'); ?>");
        }

    });
</script>