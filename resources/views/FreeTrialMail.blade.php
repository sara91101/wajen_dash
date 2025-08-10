<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <div class="container" dir="rtl">
        <table>
            رقم الهاتف: {!! $details["phone"] !!} <br><br>
            البريد الإلكتروني: {!! $details["email"] !!} <br><br>
            رقم العضويه: {!! $details["membership_no"] !!} <br><br>
            بدايه الإشتراك: {!! $details["start_date"] !!} <br><br>
            نهايه الإشتراك: {!! $details["end_date"] !!} <br><br>

        </table>
    </div>
</body>
</html>
