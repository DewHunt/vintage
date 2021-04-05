<div id="envelope-report-print-information" style="margin-top: 60%; margin-left: 20%">
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
        <table class="vertical" style="margin-top: 10%">
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

        <table class="vertical">
            <tr>
                <td>
                    <div class="envelope_container text_font_size" style="width: 100%; margin-left: -80%; margin-top: -50%"> <?= !empty($envelope_print->envelope_title) ? $envelope_print->envelope_title : '' ?></div>
                </td>
            </tr>
        </table>

        <table class="vertical" style="margin-top: 10%">
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

        <table class="vertical" style="margin-top:70%">
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
    <?php } ?>
</div>