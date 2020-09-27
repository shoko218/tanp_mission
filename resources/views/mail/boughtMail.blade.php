<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8"> <!-- utf-8 works for most cases -->
	<meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

	<!-- Web Font / @font-face : BEGIN -->
	<!-- NOTE: If web fonts are not required, lines 9 - 26 can be safely removed. -->
	
	<!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
	<!--[if mso]>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>
	<![endif]-->
	
	<!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
	<!--[if !mso]><!-->
		<!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
	<!--<![endif]-->

	<!-- Web Font / @font-face : END -->
	
	<!-- CSS Reset -->
    <style type="text/css">

		/* What it does: Remove spaces around the email design added by some email clients. */
		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
	        margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        
        body{
            font-family: 'TsukuARdGothic-Regular',sans-serif;
            color: #333333;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        
        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
                
        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: separate;
            table-layout: fixed !important;
            Margin: 0 auto;
        }
        table table table {
            table-layout: auto; 
        }
        
        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }
        
        /* What it does: A work-around for iOS meddling in triggered links. */
        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }

        .product_cards{
            border-spacing: 0 20px;
        }
      
    </style>
    
    <!-- Progressive Enhancements -->
    <style>
        
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid,
            .fluid-centered {
                max-width: 100% !important;
                height: auto !important;
                Margin-left: auto !important;
                Margin-right: auto !important;
            }
            /* And center justify these ones. */
            .fluid-centered {
                Margin-left: auto !important;
                Margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }
            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                Margin-left: auto !important;
                Margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
        }

    </style>

</head>

<body bgcolor="#ff9999" width="100%" style="Margin: 0;">
    <center style="width: 100%; background: #ffd1d1;">
        <table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
			<tr>
				<td style="padding: 20px 0; text-align: center">
					<img src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('image/logo.png')))}}" height="80" alt="alt_text" border="0">
				</td>
			</tr>
        </table>
        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" style="margin: auto; padding:20px 20px" class="email-container">
            <tr>
				<td style="margin-bottom:40px; text-align: center">
                    <p>{{ $order->user_last_name.$order->user_first_name }}様、ご注文いただきありがとうございます。</p>
                    <p>ご注文内容をご確認ください。</p>
				</td>
            </tr>
            <tr>
                <td style="margin:0; text-align: center; font-size:24px"><p><b>ご注文内容</b></p></td>
            </tr>
            <tr>
                <td style="font-family: 'TsukuARdGothic-Regular',sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #333;">
                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="width: 90%; padding:0 5%; Margin: auto padding 0 20px 20px" class="product_cards">
                        @foreach ($order_logs as $order_log)
                            <tr class="product_card" style="margin-bottom 10px;">
                                <td style="width: 40%;height: 20vw; max-height:125px;">
                                    <img src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('image/products/'.sprintf('%05d', $order_log->product->id).'.png')))}}" alt="{{ $order_log->product->name }}_img" border="0" style="height: 20vw; width:32vw; max-width:200px; max-height:125px; object-fit: cover;">
                                </td>
                                <td style="width: 60%; height: 20vw; padding-left:15%;" align="left">
                                    <table style="margin: 0;">
                                        <tr><td><p style="font-size:18px; line-height:22px; margin:0;"><b>{{ $order_log->product->name }}</b></p></td></tr>
                                        <tr><td><p style="font-size:16px; line-height:20px; margin:0;">¥{{ number_format($order_log->product->price) }}(+tax)</p></td></tr>
                                        <tr><td><p style="font-size:16px; line-height:20px; margin:0;">数量:{{ $order_log->count }}</p></td></tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr style="font-size: 24px; text-align:center; padding:10px 0;"><td><p><b>合計金額:¥{{ number_format($sum_price) }}</b></p></td></tr>
        </table>

        <table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            <tr>
                <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: 'TsukuARdGothic-Regular',sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #ffffff;">
                    &copy;&nbsp;ninaworks 2020
                    <br><br>
                </td>
            </tr>
        </table>

    </center>
</body>
</html>

