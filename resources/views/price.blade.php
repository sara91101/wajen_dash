<html lang="ar">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>نظام التحكم بالأنظمة المتعددة</title>
        <link rel="shortcut icon" href="/imgs/logo.jpeg" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Cairo', sans-serif;, sans-serif !important; direction: "rtl" !important;}
            .bill {float:right !important;}
            .bill .billSpan {font-size: 20px !important;}
            .billImg {float:left !important;}
            .leftt { text-align:left !important;}
            .customers{width:100%; font-size: 15px;line-height: 1.5em;}
            .payment{width:100%; font-size: 35px;line-height: 1.5em;text-align:center;}
            /*.customers td {width:20%;}*/
            .payment td {width:50%;}
            .payment .fontt {font-size: 28px !important;}
            .customers .rightt { text-align:right !important;}
            .table {width:100%; text-align:center !important;border-collapse: separate; border-spacing: 0 20px;}
            .table .under { border-bottom: 1px solid #ddd; width:20%;}
            .thanx {padding-left:15%; font-size: 35px;}

            .boxed {
                /*border: 1px solid;*/
                width: 50px;
                height: 50px;
                float: left;
                text-align:right;
            }
        </style>
        <script src="/js/require.js"></script>
        {{--  <script type="module" src="/js/Buffer.min.js"></script>  --}}
        {{--  <script src="https://bundle.run/buffer@6.0.3"></script>  --}}
        <script type="module" src="/js/qr.js"></script>
    </head>

    <body>
        <div style="justify-content: space-between !important;" dir="rtl">
            <span>
                {{--  <img src="{!! $info->bill !!}" width="140" height="40" class="billImg">  --}}
            </span>

            <span class="bill">
                <label class="billSpan"><b> عرض سعر</b></label><br><br>
                <label>{{ date("M d Y") }}</label>
            </span>
        </div>



        <div style="justify-content: space-between !important;">
            <table class="customers" border=0>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center">
                        <div class="rightt">
                            <br><br><label><b>  السادة  </b> : {{ $price["name"] }}</label> <br><br>
                        </div>
                        <label>تحية طيبة وبعد</label> <br><br>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                        <br><br><div style="text-align: right !important;">بناءً على طلبكم، يسعدنا تقديم لكم عرض السعر التالي </div> <br><br>
                    </td>
                </tr>
            </table>
        </div>

        <div align="center">
            <table class="table" align="center" dir="rtl">
                <thead>
                    <tr>
                        <th class="under">الصنف</th>
                        <th class="under">السعر</th>
                        <th class="under">العدد</th>
                        <th class="under">الخصم</th>
                        <th class="under">الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="under">{{ $price["package_ar"] }}</td>
                        <td class="under">{{ $price["package_price"] }}</td>
                        <td class="under">-</td>
                        <td class="under">{{ $price["discount"] }}</td>
                        <td class="under">{{ $price["final_price"] }}</td>
                    </tr>
                    @php $final_amount = $price["final_price"]; @endphp
                    @foreach ($price["service"] as $service)
                        <tr>
                            <td class="under">{{ $service["item"] }}</td>
                            <td class="under">{{ $service["price"] }}</td>
                            <td class="under">{{ $service["quantity"] }}</td>
                            <td class="under">{{ $service["discount"] }}</td>
                            <td class="under">{{ $service["final_price"] }}</td>
                        </tr>
                        @php $final_amount += $service["final_price"]; @endphp
                    @endforeach
                    <tr>
                        <td><b>المجموع</b></td>
                        <td colspan=3></td>
                        <td><b>{{  number_format($final_amount,2) }} ر.س  </b></td>
                    </tr>





                </tbody>
            </table>
        </div>

        <div style="justify-content: space-between;">


            <table class="payment" border=0>
                <tr>
                     <td class="fontt">
                    </td>

                    <td >
                    </td>
                    <td></td>
                    <td class="rightt">
                    </td>
                </tr>


            </table>

        </div>



        <div style="justify-content: space-between !important;">
            <table class="payment" border=0>
                <tr>
                    <td></td>
                    <td>
                    </td>
                    <td class="rightt" colspan="3">
                        <label>هذا العرض صالح لمدة (3) أيام من تاريخ الإصدار</label> <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br><br>
                        <label>مع خالص التحية</label><br>
                        <label>سكيل تاكس لأنظمة نقاط البيع</label><br>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </body>
</html>
