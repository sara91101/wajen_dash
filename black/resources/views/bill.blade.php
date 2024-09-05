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
            .bill {float:left !important; font-size: 40px !important;}
            .billImg {float:right !important;}
            .leftt { text-align:left !important;}
            .customers{width:100%; font-size: 15px;line-height: 1.5em;}
            .payment{width:100%; font-size: 35px;line-height: 1.5em;text-align:center;}
            .customers td {width:20%;}
            .payment td {width:50%;}
            .customers .rightt { text-align:right !important;}
            .table {width:100%; text-align:center !important;border-collapse: separate; border-spacing: 0 20px;}
            .table .under { border-bottom: 1px solid #ddd;}
            .thanx {padding-left:15%; font-size: 35px;}
        </style>
    </head>

    <body>
        <br><br>

        <div style="justify-content: space-between !important;">
            <span class="bill">
               ﻓﺎﺗﻮرة ﺿﺮﻳﺒﻴﺔ ﻣﺒﺴﻄﺔ
            </span>

            <span>
                <img src="{!! $info->bill !!}" width="75" height="75" class="billImg">
            </span>
        </div>

        <br><br> <br><br>

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
                        <label>{{ $customer["city"] }} - {{ $customer["governorate"] }} , {{ $customer["tax_number"] }}</label> <br>
                    </td>
                </tr>
            </table>
        </div>

        <div align="center">
            <table class="table" align="center" dir="rtl">
                <thead>
                    <tr>
                        <th class="under">المنتج</th>
                        <th class="under">اﻟﻤﺒﻠﻎ</th>
                        <th class="under">الضريبة({{ number_format($package->taxes,0) }} @if($package->taxes_type == 1) ر.س @else % @endif)</th>
                        @if(!is_null($package->discounts))
                        <th class="under">الخصومات ({{ number_format($package->discounts,0) }}
                            @if($package->discounts_type == 1) ر.س @else % @endif)
                        </th>
                        @endif
                        <th class="under">اﻟﻤﺠﻤﻮع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            if($package->taxes == 2){$taxx = $package->price * $package->taxes / 100;}
                            else{$taxx = $package->price + $package->taxes;}

                            if($package->discounts == 2){$discounts = $package->price * $package->discounts / 100;}
                            else{$discounts = $package->price - $package->discounts;}

                            $sum = $taxx + $package->price - $discounts;
                        @endphp
                        <td class="under">{{ $sys->system_name_ar }}</td>
                        <td class="under">{{ number_format($package->price,0) }} ر.س</td>
                        <td class="under">{{ number_format($package->taxes,0) }} @if($package->taxes_type == 1) ر.س @else % @endif </td>
                        @if(!is_null($package->discounts))
                        <td class="under">{{ number_format($package->discounts,0) }}
                            @if($package->discounts_type == 1) ر.س @else % @endif
                        </td>
                        @endif
                        <td class="under">{{ number_format($package->final_amount,0) }} ر.س </td>
                    </tr>
                    <tr>
                        <td @if(!is_null($package->discounts)) colspan=3 @else colspan=2 @endif></td>
                        <td><b>الصافي </b></td>
                        <td>{{ number_format($package->price,0) }} ر.س </td>
                    </tr>
                    <tr>
                        <td @if(!is_null($package->discounts)) colspan=3 @else colspan=2 @endif></td>
                        <td class="under"><b>الضريبة</b></td>
                        <td class="under">
                            {{ number_format($package->taxes,0) }} @if($package->taxes_type == 1) ر.س @else % @endif
                        </td>
                    </tr>
                    @if(!is_null($package->discounts))
                    <tr>
                        <td @if(!is_null($package->discounts)) colspan=3 @else colspan=2 @endif></td>
                        <td class="under"><b>الخصومات</b></td>
                        <td class="under">
                             {{ number_format($package->discounts,0) }}  @if($package->discounts_type == 1) ر.س @else % @endif
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td @if(!is_null($package->discounts)) colspan=3 @else colspan=2 @endif></td>
                        <td><b>المجموع</b></td>
                        <td><b>{{  number_format($package->final_amount,0) }}</b> ر.س  </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div style="justify-content: space-between !important;">
            <table class="payment" border=0>
                <tr>
                    <td>
                        <h1>شكراً لك</h1> <br>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="rightt">
                        {!! substr(QrCode::encoding('UTF-8')->size(400)->generate("{{ $info->name_ar }}{{ date('d M Y - H:m:s a') }}{{ $sum }}{{ sum }}"),38) !!}
                    </td>
                </tr>
            </table>
        </div>

        <br><br>

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
