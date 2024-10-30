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
            .bill {float:left !important; font-size: 20px !important;}
            .billImg {float:right !important;}
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
        <script type="module" src="/js/qr.js"></script>
    </head>

    <body onload="createQR()">

        <div style="justify-content: space-between !important;">
            <span class="bill">
               ﻓﺎﺗﻮرة ﺿﺮﻳﺒﻴﺔ
               <br> Tax Invoice
            </span>

            <span>
                <img src="{!! $info->bill !!}" width="140" height="40" class="billImg">
            </span>
        </div>



        <div style="justify-content: space-between !important;">
            <table class="customers" border=0>
                <tr>
                    <td>
                        <label>Invoice No. {{ $package->id }}</label> <br>
                        <label>{{ date('d M Y') }}</label>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="rightt">
                        <label><b>إﻳﺼﺎل ﻓﺎﺗﻮرة ﻟـ  </b></label> <br>
                        <label>{{ $customer["first_name"] }} {{ $customer["last_name"] }}</label> <br>
                        <label>{{ $customer["phone_no"] }}</label> <br>
                        <label>{{ $customer["city"] }} , {{ $customer["tax_number"] }}</label> <br>
                    </td>
                </tr>
            </table>
        </div>

        <div align="center">
            <table class="table" align="center" dir="rtl">
                <thead>
                    <tr>
                        <th class="under">المنتج</th>
                        <th class="under">السعر</th>
                        <th class="under">الخصم</th>
                        <th class="under">الضريبة</th>
                        <th class="under">اﻟﻤﺠﻤﻮع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            if($package->taxes_type == 2){$taxx = $package->price * $package->taxes / 100;}
                            else{$taxx = $package->taxes;}

                            if($package->discounts_type == 2){$discounts = $package->price * $package->discounts / 100;}
                            else{$discounts = $package->discounts;}

                            //$sum = $taxx + $package->price - $discounts;

                            $sum = $package->final_amount;
                        @endphp
                        <td class="under">{{ $sys->appreviation }} - {{ $package->package_ar }}</td>
                        <td class="under">{{ number_format($package->price,0) }}</td>
                        <td class="under">{{ number_format($discounts,0) }}</td>
                        <td class="under">{{ number_format($taxx,0) }}</td>
                        <td class="under">{{ number_format($package->final_amount,0) }}</td>
                    </tr>
                    @foreach ($services as $serve)
                        @if($serve["package_id"] == $package->package_id)
                            <tr>
                                <td class="under">{{ $serve["service"] }}</td>
                                <td class="under">{{ number_format($serve["price"],0) }}</td>
                                <td class="under"></td>
                                <td class="under"></td>
                                <td class="under">{{ $serve["price"] }}</td>
                            </tr>
                            @php $sum += $serve["price"]; @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td colspan=3></td>
                        <td><b>الإجمالي</b></td>
                        <td><b>{{  number_format($sum,0) }} ر.س  </b></td>
                    </tr>





                </tbody>
            </table>
        </div>

        <div style="justify-content: space-between;">


            <table class="payment" border=0>
                <tr>
                     <td class="fontt">
                            <div class="boxed">
                                مدة الإشتراك :{{ \Carbon\Carbon::parse( $customer['subscription_start_at'] )->diffInMonths( $customer['subscription_end_at'] ) }} شهر
                                <br>
                                تاريخ الإشتراك :{{ date('Y-m-d', strtotime($customer['subscription_start_at'])) }}
                                <br>
                                 نهاية الإشتراك : {{ date('Y-m-d', strtotime($customer['subscription_end_at']))}}
                            </div>
                            <br><br><br>
                        <h1>شكراً لك</h1> <br>
                    </td>

                    <td >
                    </td>
                    <td></td>
                    <td class="rightt">
                        @php
                            $name = "$info->name_ar";
                            $date = date('d M Y - H:m:s a');
                        @endphp
                        {!! substr($base64,38) !!}
                        <!--img id="QR" width=25 height=25>
                        <!--{!! substr(QrCode::encoding('UTF-8')->size(400)->generate("{{ $info->name_ar }}{{ date('d M Y - H:m:s a') }}{{ $sum }}{{ sum }}"),38) !!}
                        {!!  substr(QrCode::encoding('UTF-8')->size(400)->generate("$name\n$date\n$sum"),38) !!}-->
                        <br> <center>
                        رمز الإستجابة السريعة مشّفر بحسب متطلبات هيئة الزكاة والضريبة والجمارك للفوترة الإلكترونية <br>
                        This QR code is encoded as per ZATCA e-invoicing requirements
                        </center>
                    </td>
                </tr>


            </table>

        </div>



        <div style="justify-content: space-between !important;">
            <table class="payment" border=0>
                <tr>
                    <td>
                        <h1 style="font-weight:normal !important;">Employee </h1> <br>
                        <h3 style="font-weight:normal !important;text-align:left !important;">{!! $user->name !!}</h3>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="rightt">
                        <label><b>معلومات الدفع  </b></label> <br>
                        <label>{{ $info->name_ar }}</label> <br>
                        <label>{{ $info->address_ar }}</label> <br>
                        <label style="direction:rtl !important;">{{ $info->phone }} </label> <br>
                        <label>{{ $info->email }}</label> <br>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
