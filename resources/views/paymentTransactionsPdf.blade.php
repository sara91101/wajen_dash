<html>
    <head>
        <title>نظام التحكم بالأنظمة المتعددة</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
        <style>
            body *{
                font-family: 'Cairo', sans-serif !important;
                direction: "rtl" !important;
                color: #000000;
            }
            h2 {
                text-align: center;
                padding: 20px 0;
              }

              #my-table
              {
                  width:100%;
                  border-collapse:collapse;
              }
              #my-table td, #my-table th
              {
                  font-size:0.8em;
                  border:1px solid #000000;
                  padding:3px 7px 2px 7px;
                  text-align: center;
              }
              #my-table th
              {
                  font-size:0.8em;
                  text-align:center;
                  padding-top:8px;
                  padding-bottom:4px;
                  background-color:#FFFFFF;
                  color:#000000;
              }
              #my-table tr.alt td
              {
                  color:#000000;
                  background-color:#FFFFFF;
              }

              th
              {
                  background-color: grey;
                  color: white;
                  text-align: center;
                  vertical-align: top;
                  height:50px;
                  padding-top: 3px;
                  padding-left: 5px;
                  padding-right: 5px;
              }

              .verticalText
              {
                  text-align: center;
                  vertical-align: middle;
                  width: 20px;
                  margin: 0px;
                  padding: 0px;
                  padding-left: 3px;
                  padding-right: 3px;
                  padding-top: 10px;
                  white-space: nowrap;
                  -webkit-transform: rotate(-90deg);
                  -moz-transform: rotate(-90deg);
              }

              #headerTable
            {
                width: 100%;
                table-layout: fixed;
            }

            .new-section
            {
                height: 2%;
                width: 10%;
                padding-top: 25px;

            }
            .left-side
            {
                margin-left: 0px;
                background-color: rgb(131, 87, 177);
            }
            .right-side
            {
                margin-right: 0px;
                text-align: right;
                background-color: rgb(131, 87, 177);
            }
            .all-div
            {
                margin-right:0px; padding:0px;
            }
            .first
            {
                text-align: left;
            }
        </style>

    </head>




    <br><br>
    <body>

        <table id="headerTable" border="0">
            <tr>
                <td class="new-section left-side first"></td>
                <td style="text-align: left;">
                    @if(file_exists(public_path('imgs/skilltax.png')))
                        <img class="all-div" src="{!! public_path('imgs/skilltax.png') !!}" width="70" height="25">
                    @endif
                </td>

                <td style="text-align: right;">
                    <div class="all-div" align="right">&nbsp;تقرير المدفوعات</div>
                </td>
                <td class="new-section right-side last" align="right"></td>
            </tr>
        </table>
        <hr>



        <div class="justify-content-between" align="right">
            <p style="text-align: right;"><b>{{ $info->name_ar }}</b></p>
            <p style="text-align: right;" dir="rtl">{{ $info->email }}</p>
            <p style="text-align: right;" dir="ltr">{{ $info->phone }}</p>
        </div>

        <div class="justify-content-between"  align="center">
            <div class="text-right headerTitle" align="center">
                {{--  <label>{{ $info->name_ar }}</label>  --}}
            </div>
            <span class="text-center" align="center">
                {{--  <label><b>نظام التحكم بالأنظمة المتعددة</b></label><br>  --}}
                <span class="text-center" align="center">
                    {{--  <strong>تقرير المدفوعات</strong>  --}}
                </span>
            </span>
        </div>


        <br><br>
        @php $i=1; @endphp
        <table dir="rtl" id="my-table">
            <thead>
                <tr>
                    <th>الرقم</th>
                    <th>التاريخ</th>
                    <th>رقم العضوية</th>
                    <th>النوع</th>
                    <th>سعر الخدمة</th>
                    <th>رسوم التطبيق</th>
                    <th>مبلغ التاجر</th>
                    <th>الحالة</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($paymentTransactions['paymentTransactions'] as $transaction)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $transaction['datetime'] }}</td>
                    <td>{{ $transaction['membership_no'] }}</td>

                    <td>
                        @if($transaction['operation_type'] == 'order') طلب
                        @elseif($transaction['operation_type'] == 'gift') هدية
                        @elseif($transaction['operation_type'] == 'reservation') حجز طاولة
                        @else {{ $transaction['operation_type'] }}
                        @endif
                    </td>

                    <td>{{ $transaction['service_fee'] }}</td>
                    <td>{{ $transaction['app_fee'] }}</td>
                    <td>{{ $transaction['merchant_amount'] }}</td>
                    <td>
                        @if($transaction['status'] == 'completed') مكتمل
                        @elseif($transaction['status'] == 'pending') قيد الطلب
                        @elseif($transaction['status'] == 'cancelled' || $transaction['status'] == 'canceled') ملغي
                        @else {{ $transaction['status'] }}
                        @endif
                    </td>

                </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
            <tfooter>
                <tr>
                    <th colspan="4">المجموع</th>
                    <th>{{ $paymentTransactions['totalServiceFee'] }}</th>
                    <th>{{ $paymentTransactions['totalAppFee'] }}</th>
                    <th>{{ $paymentTransactions['totalMerchantAmount'] }}</th>
                    <th></th>
                </tr>
            </tfooter>
        </table>
    </body>



</html>
