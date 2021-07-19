<!DOCTYPE html>
<html lang="{{ $language ?? 'en' }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    #outlook a {
      padding: 0
    }

    .ReadMsgBody {
      width: 100%
    }

    .ExternalClass {
      width: 100%
    }

    .ExternalClass,
    .ExternalClass div,
    .ExternalClass font,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass td {
      line-height: 100%
    }

    a,
    body,
    table,
    td {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%
    }

    table,
    td {
      mso-table-lspace: 0;
      mso-table-rspace: 0
    }

    img {
      -ms-interpolation-mode: bicubic
    }

    body {
      margin: 0;
      padding: 0
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: 0;
      text-decoration: none
    }

    table {
      border-collapse: collapse !important
    }

    body {
      height: 100% !important;
      margin: 0;
      padding: 0;
      width: 100% !important
    }

    .appleBody a {
      color: #68440a;
      text-decoration: none
    }

    .appleFooter a {
      color: #999;
      text-decoration: none
    }

    @media screen and (max-width:525px) {
      table[class=wrapper] {
        width: 100% !important
      }

      td[class=logo] {
        text-align: left;
        padding: 20px 0 20px 0 !important
      }

      td[class=logo] img {
        margin: 0 auto !important
      }

      td[class=mobile-hide] {
        display: none
      }

      img[class=mobile-hide] {
        display: none !important
      }

      img[class=img-max] {
        max-width: 100% !important;
        height: auto !important
      }

      table[class=responsive-table] {
        width: 100% !important
      }

      td[class=padding] {
        padding: 10px 5% 15px 5% !important
      }

      td[class=padding-copy] {
        padding: 10px 5% 10px 5% !important;
        text-align: center
      }

      td[class=padding-meta] {
        padding: 30px 5% 0 5% !important;
        text-align: center
      }

      td[class=no-pad] {
        padding: 0 0 20px 0 !important
      }

      td[class=no-padding] {
        padding: 0 !important
      }

      td[class=section-padding] {
        padding: 50px 15px 50px 15px !important
      }

      td[class=section-padding-bottom-image] {
        padding: 50px 15px 0 15px !important
      }

      td[class=mobile-wrapper] {
        padding: 10px 5% 15px 5% !important
      }

      table[class=mobile-button-container] {
        margin: 0 auto;
        width: 100% !important
      }

      a[class=mobile-button] {
        width: 80% !important;
        padding: 15px !important;
        border: 0 !important;
        font-size: 16px !important
      }
    }
  </style>
</head>

<body style="margin: 0; padding: 0;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
    <tr>
      <td bgcolor="#ffffff">
        <div align="center" style="padding: 0px 15px 0px 15px;">
          <table border="0" cellpadding="0" cellspacing="0" width="500" class="wrapper">
            <tr>
              <td style="padding: 20px 0px 30px 0px;" class="logo">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td bgcolor="#ffffff" width="100" align="left">
                      <a href="@option('baseurl', '')" target="_blank">
                        <img alt="Logo" src="@option('mail_logo', '')" height="64" style="max-height:64px;max-width:150px;display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px;" border="0">
                      </a>
                    </td>
                    <td bgcolor="#ffffff" width="400" align="right" class="mobile-hide">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="right" style="padding: 0 0 5px 0; font-size: 14px; font-family: Arial, sans-serif; color: #666666; text-decoration: none;"><span style="color: #666666; text-decoration: none;">@option('mail_title', '')</span></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <!-- Content -->
  @yield('content')
  
  <!-- FOOTER -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
    <tr>
      <td bgcolor="#ffffff" align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td style="padding: 20px 0px 20px 0px;">
              <!-- UNSUBSCRIBE COPY -->
              <table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
                <tr>
                  <td align="center" valign="middle" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                    <span class="appleFooter" style="color:#666666;">@option('mail_footer', '')</span>
                    
                    @if(isset($subfooter))
                      <br>{{ $subfooter }}
                    @endif
                    
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