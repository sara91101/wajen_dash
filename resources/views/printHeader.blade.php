<head>
    <title>نظام التحكم بالأنظمة المتعددة</title>
    <link rel="stylesheet" href="/css/dark.css">

    <style type="text/css" >
        *{
            font-family: "Droid Arabic Kufi";
            color: #000000;
        }

        /*  .headerTitle::after {
            content: '';
            position: absolute;
            width: 100vw;
            height: 1px;
            left: 0;
            display: block;
            clear: both;
            background-color: black;
        }  */

        #customers
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
        page-break-after: always;
        }
        #customers td, #customers th
        {
        font-size:0.8em;
        border:1px solid #000000;
        padding:3px 7px 2px 7px;
        text-align: center;

        }
        #customers td
        {height:30px;}
        #customers th
        {
        font-size:0.8em;
        text-align:center;
        padding-top:8px;
        padding-bottom:4px;
        background-color:#FFFFFF;
        color:#000000;
        }
        #customers tr.alt td
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
                    };


    </style>

    <link href="/kufi/kufi.css" rel="stylesheet">

</head>
@php $info = Session("infos"); @endphp
<div class="justify-content-between" align="center">
    <span class="text-right headerTitle" style="float: right !important; text-align:right !important">
        <label>{{ $info->name_ar }}</label><br>
        <label>رقم الهاتف : {{ $info->phone }}</label><br>
        <label dir="rtl">البريد الإلكتروني : {{ $info->email }}</label>
    </span>
    <span class="text-center" align="center">
        <label><b>نظام التحكم بالأنظمة المتعددة</b></label>
    </span>
    <span class="text-left headerTitle" style="float: left !important; text-align:left !important">
        <label>{{ $info->name_en }}</label><br>
        <label> Phone Number : {{ $info->phone }}</label><br>
        <label> E-mail : {{ $info->email }}</label>
    </span>
</div>
<br>
@yield('content')
