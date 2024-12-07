
<html>
    <head>
        <title>نظام التحكم بالأنظمة المتعددة</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ public_path('styles/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ public_path('styles/style.css') }}">
    </head>

    <body>

        <table style="width: 100%" align="center">
            <tr>
                <td style="width: 25%">
                    <label class="text-start">فاتورة ضريبية مبسطة <br> Tax Invoice</label>
                </td>
                <td style="width:60%"></td>
                <td style="width:15%">
                    <img src="{!! public_path($info->bill) !!}" width="140" height="30" class="billImg">
                </td>
            </tr>
        </table>

        <hr>

        <table dir="rtl" style="width: 100%">
            <tr>
                <td style="width: 25%">
                    <p style="font-size: 16px;" class="text-end"><b>إﻳﺼﺎل ﻓﺎﺗﻮرة ﻟـ  </b></p>
                    <p style="font-size: 16px;">{{ $customer["first_name"] }} {{ $customer["last_name"] }}</p>
                    <p style="font-size: 16px;">{{ $customer["phone_no"] }}</p>
                </td>
                <td style="width:50%"></td>
                <td style="width:15%;font-size: 15px;text-align:left !important;float: left;">
                    <p style="font-size: 16px;" class="text-start">Invoice No. {{ $package->id }}</p>
                    <p style="font-size: 16px;" class="text-start">{{ date('d M Y') }}&nbsp;&nbsp;</p>
                </td>
            </tr>
        </table>

        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table" dir="rtl" style="font-size: 16px;">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th style="border-left: 0;border-right:0;">المنتج</th>
                            <th style="border-left: 0;border-right:0;">العدد</th>
                            <th style="border-left: 0;border-right:0;">السعر</th>
                            <th style="border-left: 0;border-right:0;">الخصم</th>
                            <th style="border-left: 0;border-right:0;">اﻟﻤﺠﻤﻮع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" style="border-bottom: 1px solid black;">
                            @php
                            if($package->taxes_type == 2){$taxx = $package->price * $package->taxes / 100;}
                            else{$taxx = $package->taxes;}

                            if($package->discounts_type == 2){$discounts = $package->price * $package->discounts / 100;}
                            else{$discounts = $package->discounts;}

                            //$sum = $taxx + $package->price - $discounts;

                            $real_price = $discounts + $package->final_amount;

                            $sum = $package->final_amount;
                        @endphp
                        <td>{{ $sys->appreviation }} - {{ $package->package_ar }}</td>
                        <td>1</td>
                        <td>{{ number_format($real_price,2) }}</td>
                        <td>{{ number_format($discounts,2) }}</td>
                        {{--  <td></td>  --}}
                        <td>{{ number_format($package->final_amount,2) }}</td>
                        </tr>
                        @foreach ($services as $serve)
                            @if($serve["package_id"] == $package->package_id)
                                <tr style="border-bottom: 1px solid black;">
                                    <td>{{ $serve["service"] }}</td>
                                    <td>{{ $serve["quantity"] }}</td>
                                    <td>{{ number_format($serve["price"],2) }}</td>
                                    <td></td>
                                    {{--  <td></td>  --}}
                                    <td>{{ $serve["price"] }}</td>
                                </tr>
                                @php
                                    $sum += $serve["price"];
                                @endphp
                            @endif
                        @endforeach

                        @php
                        if(!is_null($package->taxes)){$vat = $sum * 15 /100;} else {$vat = 0;}
                        $total = $sum + $vat;
                        @endphp
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div style="width:100%" class="mt-3">
            <div style="border-radius:.90rem;text-align:center !important;width:40%;border:1px ridge black;float: left;" dir="rtl" align="left">
                <p style="font-size: 16px;text-align:center !important;text-float:center;" align="center" class="mb-3"><b>المجموع الفرعي : {{  number_format($sum,2) }} ر.س </b></p>
                <p style="font-size: 16px;text-align:center !important;" class="mb-3" align="center"><b>ضريبة القيمة المضافة : {{  number_format($vat,2) }} ر.س </b></p>
                <p style="font-size: 16px;text-align:center !important;" class="mb-3" align="center"><b> المجموع الكُلي : {{  number_format($total,2) }} ر.س </b></p>
            </div>
        </div>

        @php
        $name = "$info->name_ar";
        $date = date('d M Y - H:m:s a');
        @endphp
        <table style="width: 100%" align="center">
            <tr>
                <td class="text-start" style="text-align:right;width: 30%;float: right;">
                    <p style="font-size: 15px;">
                    مدة الإشتراك :{{ \Carbon\Carbon::parse( $customer['subscription_start_at'] )->diffInMonths( $customer['subscription_end_at'] ) }} شهر
                    <br>
                    تاريخ الإشتراك :{{ date('Y-m-d', strtotime($customer['subscription_start_at'])) }}
                    <br>
                    نهاية الإشتراك : {{ date('Y-m-d', strtotime($customer['subscription_end_at']))}}
                    </p>
                    <br><br><br>
                    <h1 style="font-size: 20px;">شكراً لك</h1> <br>
                </td>
                <td style="width: 40%;float: right;"></td>
                <td style="width: 30%; text-align:right;">
                    <p class="text-end" style="font-size: 16px;">
                        {!! substr($base64,38) !!}
                        <br><br>
                        <label><b>معلومات الدفع  </b></label> <br>
                        <label>شركة وجين لتقنية المعلومات</label> <br>
                        <label>المدينة المنورة</label> <br>
                        {{--  <label>P.O BOX 42377 -CR:3550149108</label><br>  --}}
                    </p>
                </td>
            </tr>
        </table>


        <div style="position:fixed;bottom:0;margin-bottom: 0px;">
            <hr>
            <table style="width: 100%;" align="center">
                <tr>
                    <td class="text-start" style="text-align:right;width: 20%;float: right;">
                        P.O BOX 42377
                    </td>
                    <td style="text-align:center;width: 65%;float: right;">
                        <a href="https://www.skilltax.sa" target="blank" style="color:cornflowerblue;">
                            www.skilltax.sa
                        </a>
                    </td>
                    <td class="text-start" style="text-align:left;width: 15%;float: left;">
                        CR:3550149108
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
