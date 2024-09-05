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
            الإسم الأول: {!! $details["friend_first_name"] !!} <br><br>
            الإسم الأخير: {!! $details["friend_last_name"] !!} <br><br>
            رقم الهاتف: {!! $details["friend_phone"] !!} <br><br>
            البريد الإلكتروني: {!! $details["friend_email"] !!} <br><br>

            إسم المشترك : {!! $details["subscriber_fullname"] !!} <br><br>
            إسم العمل : {!! $details["subscriber_business_name"] !!} <br><br>
            نوع النشاط: {!! $details["subscriber_activity"] !!} <br><br>
            رقم الهاتف : {!! $details["subscriber_phone"] !!} <br><br>
            البريد الإلكتروني: {!! $details["subscriber_email"] !!} <br><br>

        </table>
    </div>
</body>
</html>
