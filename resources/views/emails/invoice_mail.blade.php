
@php
    use App\Helpers\AppHelper;
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice From {{ AppHelper::site_name() }}</title>
    <style type="text/css" media="screen">
        /* Linked Styles */
        body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#333545; -webkit-text-size-adjust:none }
        a { color:#ffaa33FF; text-decoration:none }
        p { padding:0 !important; margin:0 !important }
        img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
        .mcnPreviewText { display: none !important; }
        .text-footer a { color: #7e7e7e !important; }
        .text-footer2 a { color: #c3c3c3 !important; }

        /* Mobile styles */
        @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
            .mobile-shell { width: 100% !important; min-width: 100% !important; }

            .m-center { text-align: center !important; }
            .m-left { margin-right: auto !important; }

            .center { margin: 0 auto !important; }

            .td { width: 100% !important; min-width: 100% !important; }

            .m-br-15 { height: 15px !important; }
            .m-separator { border-bottom: 1px solid #000000; }
            .small-separator { border-top: 1px solid #333333 !important; padding-bottom: 20px !important; }

            .m-td,
            .m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }

            .m-block { display: block !important; }

            .fluid-img img { width: 100% !important; max-width: 100% !important;
                height: auto !important;
            }

            .content-middle { width: 140px !important; padding: 0px !important; }

            .text-white { font-size: 12px !important; }

            .h2-white { font-size: 46px !important; line-height: 50px !important; }
            .h3-white { font-size: 24px !important; line-height: 30px !important; }

            .mpb15 { padding-bottom: 15px; }
            .content { padding: 20px 15px !important; }

            .section-inner { padding: 0px !important; }

            .content-2 { padding: 30px 15px 30px 15px !important; }
            .pt30 { padding-top: 20px !important; }
            .main { padding: 0px !important; }
            .section { padding: 30px 15px 30px 15px !important; }
            .section2 { padding: 0px 15px 30px 15px !important; }
            .section4 { padding: 30px 15px !important; }
            .section-inner2 { padding: 30px 15px !important; }

            .separator-outer { padding-bottom: 30px !important; }
            .section3 { padding: 30px 15px !important; }
            .mpb10 { padding-bottom: 10px !important; padding-top: 5px !important; }
            .preheader { padding-bottom: 20px !important; }

            .column,
            .column-dir,
            .column-top,
            .column-empty,
            .column-empty2,
            .column-bottom,
            .column-dir-top,
            .column-dir-bottom { float: left !important; width: 100% !important; display: block !important; }
            .column-empty { padding-bottom: 30px !important; }
            .column-empty2 { padding-bottom: 10px !important; }
            .content-spacing { width: 15px !important; }
        }
        .ii a[href] {
            color: #ffaa33FF !important;
        }
    </style>
</head>
<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:white; -webkit-text-size-adjust:none;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white">
    <tr>
        <td align="center" valign="top">
            <!-- Main -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 30px;">
                <tr>
                    <td align="center" class="main" style="padding:0px 0px 20px 0px;">
                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                            <tr>
                                <td class="td" style="width:650px; border-top: 4px solid #ffaa33FF; border-radius: 8px; box-shadow: #ffaa33FF  0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                    <!-- logo -->
                                    <div style="padding:0px 30px; height:auto;">
                                        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="padding:10px; border-radius: 15px; padding-bottom: 20px;" dir="rtl" style="direction: ltr;">
                                            <tr>
                                                <td>
                                                <th class="column-dir"   width="100%" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                    <table  width="100%"  align="center" border="0" cellspacing="0" cellpadding="0">
                                                        <tr align="right">
                                                            <td class="fluid-img" style="font-size:0pt; line-height:0pt;  padding-top: 35px;  text-align:center;">
                                                                <img src="{{ asset('assets/logo/'.AppHelper::dark_logo()) }}"  width="200" height="70">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- END logo -->

                                    <!-- detail -->
                                    <div style="padding:0px 20px; height:auto;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0px 10px; border-radius: 15px;" dir="ltr" style="direction: ltr;">
                                            <tr>
                                                <td class="p30-15" style="padding:10px; ">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <th class="column-top" width="147" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #494949; background-color: white; border-radius: 5px;">
                                                                                    <td class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:13px; font-weight:700; line-height:15px; text-align:left;">Invoice Number </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th class="column-top" width="450" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #494949; background-color: white; border-radius: 5px;">
                                                                                    <td class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:13px; font-weight:700; line-height:15px; text-align:left; padding-bottom:5px;">{{ $myinvoice['stripe_invoice_number'] }} </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="column-top" width="147" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #494949; background-color: white; border-radius: 5px;">
                                                                                    <td width="50%" class="h4 center pb5" style="color:#494949; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:10px; text-align:left; padding-top: 5px;">Date of issue</td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th class="column-top" width="450" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #494949; background-color: white; border-radius: 5px;">
                                                                                    <td width="50%" class="h4 center pb5" style="color:#494949; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:10px; text-align:left; padding-top: 5px; padding-bottom:5px;">
                                                                                    @php $period_start = date('d M Y', strtotime($myinvoice['period_start']));@endphp
                                                                                    @php $period_end = date('d M Y', strtotime($myinvoice['period_end']));@endphp
                                                                                    {{ $period_start }}
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="column-top" width="147" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #494949; background-color: white; border-radius: 5px;">
                                                                                    <td width="50%" class="h4 center pb5" style="color:#494949; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:10px; text-align:left; padding-bottom:5px;">Date due</td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th class="column-top" width="450" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #494949; background-color: white; border-radius: 5px;">
                                                                                    <td width="50%" class="h4 center pb5" style="color:#494949; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:10px; text-align:left; padding-bottom:5px;">{{ $period_end }} </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- End detail -->


                                    <!-- sendor stripe -->
                                    <div style="padding:0px 20px; height:auto;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:10px; border-radius: 15px;" dir="ltr" style="direction: ltr;">
                                            <tr>
                                                <td class="p30-15" style="padding:10px; ">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td>
                                                                        <th class="column-top" width="100%" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #005add; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:13px; font-weight:700; line-height:15px; text-align:left;">Invoice From </td>
                                                                                </tr>
                                                                                <tr style="padding:5px; border-bottom:2px dashed #005add; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left;">{{ AppHelper::site_name() }}</td>
                                                                                </tr>

                                                                                <tr style="padding:5px; border-bottom:2px dashed #005add; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left;">{{ $senderName }}</td>
                                                                                </tr>

{{--                                                                                <tr style="padding:5px; border-bottom:2px dashed #005add; background-color: white; border-radius: 5px;">--}}
{{--                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left;">{{ $senderEmail }}</td>--}}
{{--                                                                                </tr>--}}

                                                                            </table>
                                                                        </th>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- End sendor stripe -->

                                    <!-- shop stripe -->
                                    <div style="padding:0px 20px; height:auto;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:10px; border-radius: 15px;" dir="ltr" style="direction: ltr;">
                                            <tr>
                                                <td class="p30-15" style="padding:10px; ">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td>
                                                                        <th class="column-top" width="100%" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:13px; font-weight:700; line-height:15px; text-align:left;">Bill to </td>
                                                                                </tr>
                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left;">{{ $firstName }} {{ $lastName }},</td>
                                                                                </tr>
                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left; padding-bottom:5px;">{{ $email }}</td>
                                                                                </tr>
                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left; padding-bottom:5px;">{{ $phone }}</td>
                                                                                </tr>

                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td width="100%" class="h4 center pb5" style="color:#494949; padding-top: 5px; border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight:550; line-height:15px; text-align:left; padding-bottom:5px;">{{ $address }}</td>
                                                                                </tr>

                                                                            </table>
                                                                        </th>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- End shop stripe -->


                                    <!-- note -->
                                    <div style="padding:0px 20px; height:auto;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0px 10px; border-radius: 15px;" dir="ltr" style="direction: ltr;">
                                            <tr>
                                                <td class="p30-15" style="padding:0px 10px; ">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <th class="column-top" width="147" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td class="h4 center pb5" style="border-radius: 5px; font-family: Arial, Helvetica, sans-serif; font-size:18px; font-weight: bold; line-height:25px; text-align:left; padding-bottom:10px;">${{ $myinvoice['amount'] }} due {{ $period_end }} </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="column-top" width="147" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr style="padding:5px; border-bottom:2px dashed #ffaa33FF; background-color: white; border-radius: 5px;">
                                                                                    <td class="h4 center pb5" style="border-radius: 5px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:11px; font-weight: 400; line-height:18px; text-align:left; padding-top:15px;">
                                                                                        <b>Note:</b>   {{ $myinvoice['note'] }}
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- End note -->

                                    <!-- button -->
                                    <div style="padding:10px; height:auto;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:10px;  border-radius: 15px;" dir="ltr" style="direction: ltr;">
                                            <tr>
                                                <td class="p30-15" style="padding:10px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <th class="column-top" width="450" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; margin-bottom:10px; font-weight:normal; vertical-align:top;">
                                                                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td class="price" style="border: 2px solid #ffaa33FF; border-radius: 8px; color: #ffaa33FF; font-family: Arial, Helvetica, sans-serif; font-size:13px; line-height:15px; padding:15px 15px; font-weight: 700;">
                                                                                        <a href="{{ $myinvoice['stripe_invoice_pdf_url'] }}">Download invoice</a>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th class="column-top" width="450" bgcolor="#ffffff" style="font-size:0pt; line-height:0pt; padding:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td class="price" style="border: 2px solid #ffaa33FF; border-radius: 8px; color: #ffaa33FF; font-family: Arial, Helvetica, sans-serif; font-size:13px; line-height:15px; padding:15px 15px; font-weight: 700;">
                                                                                        <a href="{{ $myinvoice['stripe_invoice_url'] }}">Pay Now</a>
                                                                                    </td>
                                                                                </tr>

                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                <td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- End button -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- END Main -->
        </td>
    </tr>

</table>
</body>
</html>
