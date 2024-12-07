<html>
    <head>
        <title>نظام التحكم بالأنظمة المتعددة</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ public_path('styles/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ public_path('styles/style.css') }}">
    </head>

    <body>

        <table style="width: 100%" align="center" dir="rtl">
            <tr>
                <td style="width: 25%">
                    <label class="billSpan"><b> عرض سعر</b></label><br><br>
                <label>{{ date("M d Y") }}</label>
                </td>
                <td style="width:60%"></td>
                <td style="width:15%">
                    <img src="{!! public_path($info->bill) !!}" width="140" height="30" class="billImg">
                </td>
            </tr>
        </table>

        <hr>

        <div>
            <p align="center" style="font-size:16px;"><b>  السادة  </b> : {{ $price["name"] }}</p>
            <p align="center" style="font-size:16px;">تحية طيبة وبعد</p>
        </div>

        <div class="text-end" style="float: right !important;font-size:16px;">بناءً على طلبكم، يسعدنا تقديم لكم عرض السعر التالي </div>

        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table" dir="rtl" style="font-size: 16px;">
                    <thead>
                        <tr class="bg-dark text-white  text-center">
                            <th style="text-align:center !important;">الصنف</th>
                            <th style="text-align:center !important;">السعر</th>
                            <th style="text-align:center !important;">العدد</th>
                            <th style="text-align:center !important;">الخصم</th>
                            <th style="text-align:center !important;">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  style="border-bottom: 1px solid black;">
                            <td class="under">{{ $price["package_ar"] }}</td>
                            <td class="under">{{ $price["final_price"] + $price["discount"] }}</td>
                            <td class="under">1</td>
                            <td class="under">{{ $price["discount"] }}</td>
                            <td class="under">{{ $price["final_price"] }}</td>
                        </tr>
                        @php $final_amount = $price["final_price"]; @endphp
                        @foreach ($price["service"] as $service)
                            <tr class="text-center" style="border-bottom: 1px solid black;">
                                <td class="under">{{ $service["item"] }}</td>
                                <td class="under">{{ $service["price"] }}</td>
                                <td class="under">{{ $service["quantity"] }}</td>
                                <td class="under">{{ $service["discount"] }}</td>
                                <td class="under">{{ $service["final_price"] }}</td>
                            </tr>
                            @php $final_amount += $service["final_price"]; @endphp
                        @endforeach
                        <tr class="text-center bg-dark text-white" style="border-bottom: 1px solid black;">
                            <td><b>المجموع</b></td>
                            <td colspan=3></td>
                            <td><b>{{  number_format($final_amount,2) }} ر.س  </b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

                <div class="text-end">
                    <br><p style="font-size:16px;">هذا العرض صالح لمدة (3) أيام من تاريخ الإصدار</p> <br>
                </div>


                {{--  <div align="left" class="text-start">
                    <p style="font-size:16px;">مع خالص التحية</p><br>
                    <p style="font-size:16px;">سكيل تاكس لأنظمة نقاط البيع</p><br>
                </div>  --}}

                <table style="width: 100%" align="center">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td class="text-start" style="text-align:center;width: 30%;float: right;">
                            <p style="font-size: 16px;">
                                <label>مع خالص التحية</label><br><br>
                                <label>سكيل تاكس لأنظمة نقاط البيع</label><br>
                        </td>
                        <td style="width: 50%;"></td>
                    </tr>
                </table>
        </div>




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


