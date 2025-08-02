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
            الإسم: {!! $details["name"] !!} <br><br>
            رقم الهاتف: {!! $details["phone"] !!} <br><br>
            البريد الإلكتروني: {!! $details["email"] !!} <br><br>
            المدينة : {!! $details["town"] !!} <br><br>
            إسم النشاط التجاري: {!! $details["activity_name"] !!} <br><br>
            الوقت المفضل للإتصال : {!! $details["contact_time"] !!} <br><br>
            الرسالة : {!! $details["message"] !!} <br><br>
        </table>
    </div>
</body>
</html>
