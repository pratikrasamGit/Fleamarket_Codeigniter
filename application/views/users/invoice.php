<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Invoice</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>



  <style type="text/css">
  img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }

  a {
    text-decoration: none;
    border: 0;
    outline: none;
    color: #bbbbbb;
  }

  a img {
    border: none;
  }

  /* General styling */





  body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
    font-size: 12px;
  }

  table {
    border-collapse: collapse !important;
  }   
  table td ,table th {
    padding-bottom: 5px;
    padding-top: 5px;
    text-align: left;
  }

 .force-full-width {
  width: 100% !important;
 }
 .force-width-90 {
  width: 90% !important;
 }
</style>


  <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class="w320"] {
        width: 320px !important;
      }

      td[class="mobile-block"] {
        width: 100% !important;
        display: block !important;
      }


    }
  </style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none;" bgcolor="#ffffff" >
<table align="center" cellpadding="0" cellspacing="0" class="force-full-width" height="100%" style="margin-left: 15px;" >
  <tr>
    <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
      <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="595" class="w320">
        <tr>
          <td align="center" valign="top" style="border: 1px solid #E5E5E5;padding: 0;">

            <table cellspacing="0" cellpadding="0" class="force-full-width">
              <tr>
                <td>
                  <table cellspacing="0" cellpadding="0" >
                    <tr>
                      <td>
                        <h4 style="font-weight: bold;font-size: 32px;margin: 0px;">Invoice</h4>
                      </td>
                    </tr>
                  </table>
                  <table cellspacing="0" cellpadding="0" >
                    <tr>
                      <td width="150">
                        <strong>Paid on</strong>
                      </td>
                      <td>
                        <span><?= $details['date'] ?></span>
                      </td>
                    </tr>

                    <tr>
                      <td width="150">
                        <strong>Invoice No</strong>
                      </td>
                      <td>
                        <span><?= $details['invoice_number'] ?></span>
                      </td>
                    </tr>

                    <tr>
                      <td width="150">
                        <strong>Transaction ID</strong>
                      </td>
                      <td>
                        <span><?= $details['transaction_id'] ?></span>
                      </td>
                    </tr>

                    <tr>
                      <td width="150">
                        <strong>Market Name</strong>
                      </td>
                      <td>
                        <span><?= $details['market_name'] ?></span>
                      </td>
                    </tr>
                  </table>
                </td>
                <td>
                  <table style="margin-left: auto;"  cellspacing="0" cellpadding="0" >
                    <tr>
                      <td style="text-align:right;">
                        <br><br><br><br><strong style="font-weight: bold; font-size: 16px;"><?= $details['user_name'] ?></strong> <br>
                        <?= $details['user_location'] ?>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table style="margin:50px auto;" cellspacing="0" cellpadding="0" class="force-full-width">
              <tr>
                <th width="100" style="border-bottom: 1px solid #000000;padding-top: 7px; padding-bottom: 7px;">Table type</th>
                <th width="200" style="border-bottom: 1px solid #000000;padding-top: 7px; padding-bottom: 7px;">Table</th>
                <th width="120" style="border-bottom: 1px solid #000000;padding-top: 7px; padding-bottom: 7px;">Rate (Per Table)</th>
                <th width="90" style="border-bottom: 1px solid #000000; text-align: right;padding-top: 7px; padding-bottom: 7px;">Quantity</th>
                <th width="90" style="border-bottom: 1px solid #000000; text-align: right;padding-top: 7px; padding-bottom: 7px;"> Cost </th>
              </tr>
              <tbody>
                <?php 
                  foreach ($list as $keys => $values) {
                ?>
                <tr>
                  <th style="padding-top: 7px; padding-bottom: 7px;"><?= $values['table_type'] ?></th>
                  <td style="padding-top: 7px; padding-bottom: 7px;"><?= $values['table_sequence_no'] ?></td>
                  <td style="padding-top: 7px; padding-bottom: 7px;"><?= $values['indiviual_price'] ?>DKK</td>
                  <td style="text-align: right;padding-top: 7px; padding-bottom: 7px;"><?= $values['total_table_no'] ?></td>
                  <td style="text-align: right;padding-top: 7px; padding-bottom: 7px;"><?= $values['price'] ?>DKK</td>
                </tr>
                <?php
                  }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5" style="border-top: 1px solid #000000;"></td>
                </tr>
              </tfoot>
            </table>
            <table style="margin-bottom: 50px;" class="force-full-width">
              <tr>
                <td>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img width="150" height="150" src="https://www.loppekortet.dk/uploads/payment/email_invoice_logo.png" alt="">
                </td>
              </tr>
            </table>

          <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" bgcolor="#AFD1AE" class="force-full-width" >
            <tr>
              <td style="background-color:#AFD1AE;" class="force-full-width" >

                <table cellspacing="0" cellpadding="0" class="force-full-width" >
                  <tr>
                    <td colspan="2" width="100%">
                      <hr style="margin-top: 30px; margin-bottom: 0; border: 1px solid #000000;">
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align:left; color:#111118" width="90%">
                      <span style="font-weight: 500;font-size: 12px;">Total Amount</span> 
                    </td>
                    <td style="text-align:right; vertical-align:top; color:#111118;" width="10%">
                      <strong style="font-size: 32px;, monospace;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $details['price'] ?>DKK</strong><br>
                      <strong style="font-size: 14px;line-height: 16px;">Paid</strong>
                    </td>
                  </tr>
                    <tr>
                      <td colspan="2">
                        <hr style="margin: 0; border: 1px solid #000000;">
                      </td>
                    </tr>
                </table>
                
                <table style="margin: 10px  0px 20px 0px" cellspacing="0" cellpadding="0" class="force-full-width">
                  <tr>
                    <td style="text-align:left; color:#111118;line-height: 0; padding: 0;">
                      <div style="display: inline-flex; align-items: center;">
                        <span style="width: 15px;height: 15px;background-color: #111118;border-radius: 50%; display: inline-block; margin-right: 10px;"></span> 
                        <span style="display: inline-block;">Thank you! — Loppekortet@gmail.com</span>
                      </div>
                    </td>
                  </tr>
                </table>

              </td>
            </tr>

          </table>

          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>