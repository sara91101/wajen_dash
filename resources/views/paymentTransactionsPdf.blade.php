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
              
              table caption {
                  padding: .5em 0;
              }
              
              table.dataTable th,
              table.dataTable td {
                white-space: nowrap;
              }
              
              .p {
                text-align: center;
                padding-top: 140px;
                font-size: 14px;
              }
        </style>

    </head>

    
    
    <br><br>
    <body>
        <div class="justify-content-between"  align="center">
            <div class="text-right headerTitle" align="center">
                <label>{{ $info->name_ar }}</label>
            </div>
            <span class="text-center" align="center">
                <label><b>نظام التحكم بالأنظمة المتعددة</b></label><br>
                <span class="text-center" align="center">
                    <strong>تقرير المدفوعات</strong>
                </span>
            </span>
        </div>
        

        <br><br>
        <table dir="rtl">
            <thead>
                <tr style="text-align: right !important;">
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">الرقم</th>
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">التاريخ</th>
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">رقم العضوية</th>
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">النوع</th>
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">الحالة</th>
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">سعر الخدمة</th>
                    <th style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">سعر التطبيق</th>
                    <th style="text-align: right !important;border-bottom: 1px solid black;">سعر التاجر</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($paymentTransactions as $transaction)
                <tr>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['payment_id'] }}</td>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['datetime'] }}</td>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['membership_no'] }}</td>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['operation_type'] }}</td>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['status'] }}</td>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['service_fee'] }}</td>
                    <td style="text-align: right !important;border-left: 1px solid black;border-bottom: 1px solid black;">{{ $transaction['app_fee'] }}</td>
                    <td style="text-align: right !important;border-bottom: 1px solid black;">{{ $transaction['merchant_amount'] }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </body>



</html>
