
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
                    <label class="text-start">فاتورة ضريبية  <br> Tax Invoice</label>
                </td>
                <td style="width:60%"></td>
                <td style="width:15%">
                    <img src="{{ public_path('imgs/skilltax.png') }}" width="140" height="30" class="billImg">
                </td>
            </tr>
        </table>

        <hr>

        <table dir="rtl" style="width: 100%">
            <tr>
                <td style="width: 25%">
                    <p style="font-size: 16px;" class="text-end"><b>إﻳﺼﺎل ﻓﺎﺗﻮرة ﻟـ  </b></p>
                    <p style="font-size: 16px;">{{ $subscriber_name }}</p>
                    <p style="font-size: 16px;">{{ $subscriber_phone_no }}</p>
                    <p style="font-size: 16px;">{{ $subscriber_tax_number }}</p>
                    <p style="font-size: 16px;">{{ $subscriber_address }}</p>
                </td>
                <td style="width:50%"></td>
                <td style="width:15%;font-size: 15px;text-align:left !important;float: left;">
                    <p style="font-size: 14px;" class="text-start">Invoice No. {{ $invoiceNumber }}</p>
                    <p style="font-size: 16px;" class="text-start">{{ date('d M Y') }}&nbsp;&nbsp;</p>
                </td>
            </tr>
        </table>

        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table" dir="rtl" style="font-size: 16px;">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th style="border-left: 0;border-right:0;">البند</th>
                            <th style="border-left: 0;border-right:0;">فترة الإشتراك</th>
                            <th style="border-left: 0;border-right:0;">الكميه</th>
                            <th style="border-left: 0;border-right:0;">السعر</th>
                            <th style="border-left: 0;border-right:0;">المجموع بدون ضريبه</th>
                            <th style="border-left: 0;border-right:0;">الخصم</th>
                            <th style="border-left: 0;border-right:0;">نسبه الضريبه</th>
                            <th style="border-left: 0;border-right:0;">قيمه الضريبه</th>
                            <th style="border-left: 0;border-right:0;">اﻟﻤﺠﻤﻮع</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr class="text-center" style="border-bottom: 1px solid black;">
                            <td>{{ $item }}</td>
                            <td>{{ $description }}</td>
                            <td>{{ $quantity }}</td>
                            <td>{{ $price }}</td>
                            <td>{{ $sum_before_tax }}</td>
                            <td>{{ $discount }}</td>
                            <td>{{ $tax_percentage }}</td>
                            <td>{{ $tax_value }}</td>
                            <td>{{ $sum_after_tax }}</td>
                            </tr>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div style="width:100%" class="mt-3">
            <div style="border-radius:.90rem;text-align:center !important;width:40%;border:1px ridge black;float: left;" dir="rtl" align="left">
                <p style="font-size: 16px;text-align:center !important;text-float:center;" align="center" class="mb-3"><b>الإجمالي قبل الضريبه : {{  number_format($sum_before_tax,2) }} ر.س </b></p>
                 <p style="font-size: 16px;text-align:center !important;text-float:center;" align="center" class="mb-3"><b>الخصم : {{  number_format($discount,2) }} ر.س &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></p>
                <p style="font-size: 16px;text-align:center !important;" class="mb-3" align="center"><b>ضريبة القيمة المضافة : {{  number_format($tax_value,2) }} ر.س </b></p>
                <p style="font-size: 16px;text-align:center !important;" class="mb-3" align="center"><b>  الإجمالي : {{  number_format($sum_after_tax,2) }} ر.س </b></p>
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
                    مدة الإشتراك :{{ $quantity }} {{ $period }}
                    <br>
                    تاريخ الإشتراك :{{ date('Y-m-d', strtotime($subscription_start_date)) }}
                    <br>
                    نهاية الإشتراك : {{ date('Y-m-d', strtotime($subscription_end_date))}}
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
                        <label>{{ $info->tax_no }} </label>
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
                        <a href="https://www.skilltax.sa" target="blank" style="color:black !important;text-decoration:none;">
                            skilltax.sa
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
