<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                /*font-family: Arial, Helvetica, sans-serif;*/
                font-family: Helvetica, Arial, sans-serif;
                width: 600px;
                background: #F3F3F3;
            }

            /* Style the header */
            header {
                /*background-color: #2F2F2F;*/
                background: rgba(52, 73, 94, 0.94) none repeat scroll 0 0;
                padding: 20px 10px 20px 10px;
                /*text-align: center;*/
                /*font-size: 35px;*/
                color: #FFFFFF;
            }

            /* Clear floats after the columns */
            section:after {
                content: "";
                display: table;
                clear: both;
            }
            section {
                background-color: #FFFFFF;
                margin-top: 0;
                padding-top: 10px;
                padding-left: 10px;
            }
            section p{
                color: #555;
            }

            /* Style the footer */
            footer {
                /*background-color: #2F2F2F;*/
                background: rgba(52, 73, 94, 0.94) none repeat scroll 0 0;
                padding: 0px 10px 0px 10px;
                color: #FFFFFF;
            }
            .footer-right {
                color: #FFFFFF;
            }
            .footer-right i{
                color: #FFFFFF;
            }
            .develop-by-section a{
                color: #FFFFFF;
                cursor: pointer;
            }

            .text-left {
                float: left;
            }
            .text-right {
                float: right;
            }
            .clear-both{
                clear: both;
            }

            .title{
                /*font-size: 16px;*/
                font-weight: bold; 
            }

            .text-bold{
                font-weight: bold; 
            }
            /* Style all font awesome icons */
            .fa {
                padding: 5px 12px 5px 12px;
                text-align: center;
                text-decoration: none;
            }

            /* Add a hover effect if you want */
            .fa:hover {
                opacity: 0.7;
            }

            /* Set a specific color for each brand */

            /* Facebook */
            .fa-facebook {
                background: #3B5998;
                color: white;
            }
            .margin-bottom-0{
                margin-bottom: 0;
            }
            .margin-top-0{
                margin-top: 0;
            }

        </style>
    </head>
    <body style="">
        <?php
//        $content_array = array(
//            'header_title' => '',
//            'header_body' => '',
//            'name' => '',
//            'body_content' => '',
//        );
        ?>
        <div style="background: #F3F3F3;">
            <div  style="margin: 5px auto; width: 600px; padding: 2px 0; ">
                <header>
                    <span class="title"><?= (array_key_exists('header_title', $content_array)) ? $content_array['header_title'] : ''; ?></span><span> <small class="text-bold"><?= (array_key_exists('header_body', $content_array)) ? '' . $content_array['header_body'] : ''; ?></small></span>
                </header>

                <section>  
                    <p class="text-bold"><?= (array_key_exists('name', $content_array)) ? (!empty($content_array['name']) ? 'Hi ' . $content_array['name'] . ',' : '') : ''; ?></p>
                    <p><?= (array_key_exists('body_content', $content_array)) ? $content_array['body_content'] : '' ?></p>
                    <!--<p>Thank you for choosing <?= get_company_name(); ?>.</p>-->
                    <br>
                    <p>Kind regards,</p>
                    <p class="margin-bottom-0"><a href="<?= get_company_website(); ?>" target="_blank"></a><?= get_company_name(); ?></p>
                    <p class="margin-top-0" style="margin-bottom: 0; padding-bottom: 10px;"><small class="text-bold"><a style="color: #cd4739;" href="<?= get_company_website(); ?>" target="_blank"><?= get_company_website(); ?></a></small></p>
                </section>

                <footer>
                    <div>
                        <p class="develop-by-section text-left" style="margin-top: 10px;"><small class="text-bold"><a style="color: #FFFFFF" href="<?= get_company_website(); ?>" target="_blank">&copy; <?= date("Y"); ?> - <?= get_company_name(); ?></a></small></p>
<!--                        <p class="text-right"><span class="footer-right"><a href="<?= ''; ?>" target="_blank"><i class="fa fa-facebook">f</i></a></span></p>-->
                    </div>
                    <div class="clear-both"></div>
                </footer>
            </div>  
        </div>
    </body>
</html>



