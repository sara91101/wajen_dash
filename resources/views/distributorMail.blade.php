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
            إسم الموزع : {!! $details["first_name"] !!}  {!! $details["last_name"] !!}<br><br>
            إسم العمل : {!! $details["business_name"] !!} <br><br>
            المدينة : {!! $details["city"] !!} <br><br>
            رقم الهاتف : {!! $details["phone"] !!} <br><br>
            البريد الإلكتروني: {!! $details["email"] !!} <br><br>
            عدد الفروع: {!! $details["branches_no"] !!} <br><br>

        </table>
    </div>
</body>
</html>
