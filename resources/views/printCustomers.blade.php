@extends('printHeader')

@section('content')

<div class="justify-content-between" align="center">
    <span class="text-center" align="center">
        <strong> المشتركين </strong>
    </span>
</div>

<br>

@php $i=1; @endphp
@if(count($customers) > 0)
<table class="table text-center" dir="rtl" id="customers">
    <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> الإسم</th>
                <th class="font-weight-bold"> رقم العضوية</th>
                <th class="font-weight-bold"> المدينة</th>
                <th class="font-weight-bold"> النشاط</th>
                <th class="font-weight-bold"> الباقة</th>
                <th class="font-weight-bold"> إنتهاء الإشتراك</th>

    <tbody>
        @php $i=1; @endphp
    @foreach ($newCollection as $c)
        <tr>
                    <td >{!! $i !!}</td>
                    <td>
                        {{ $c["first_name"] }} {{ $c["last_name"] }}
                    </td>
                    <td>{{ $c["membership_no"] }}</td>
                    <td>{{ $c["city"]}}</td>
                    <td>{{ $c["activity_ar"] }}</td>
                    <td>{{ $c["package_ar"] }}</td>
                    <td>@if(!is_null($c['subscription_end_at'])){{date('Y-m-d', strtotime($c['subscription_end_at'])) }} @endif</td>
        </tr>
        @if($i % 25 == 0 && $i > 0)</tbody> </table>
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
                
                    <div class="justify-content-between" align="center">
                        <span class="text-center" align="center">
                            <strong> المشتركين </strong>
                        </span>
                    </div>
                    
                    <br>
                    <table class="table text-center" dir="rtl" id="customers">
                        <th class="font-weight-bold">#</th>
                        <th class="font-weight-bold"> الإسم</th>
                        <th class="font-weight-bold"> رقم العضوية</th>
                        <th class="font-weight-bold"> المدينة</th>
                        <th class="font-weight-bold"> النشاط</th>
                        <th class="font-weight-bold"> الباقة</th>
                        <th class="font-weight-bold"> إنتهاء الإشتراك</th>
                        <tbody>
        @endif
            @php $i++; @endphp
    @endforeach
    </tbody>
    </table>
</div>
        @else
        <div class="alert alert-fill-primary text-right" role="alert" dir="rtl">
            <i class="typcn typcn-warning"></i>
            لا توجد بيانات
        </div>
        @endif
    </div>


@endsection
