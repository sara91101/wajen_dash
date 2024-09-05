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
    <th class="font-weight-bold"> المحافظة</th>
    {{--  <th class="font-weight-bold"> رقم الهاتف</th>
    <th class="font-weight-bold">البريد الإلكتروني</th>  --}}
    <th class="font-weight-bold"> النشاط</th>
    <th class="font-weight-bold"> النظام</th>
    <th class="font-weight-bold"> إنتهاء الإشتراك	</th>

    <tbody>
        @php $i=1; @endphp
    @foreach ($customers as $c)
        <tr>
            <td >{!! $i !!}</td>
                    <td>
                        {{ $c->first_name }} {{ $c->second_name }}
                    </td>
                    <td>{{ $c->membership_no }}</td>
                    <td>{{ $c->ar_town}}</td>
                    <td>{{ $c->ar_governorate}}</td>
                    {{--  <td dir="ltr">{{ $c->phone }}</td>
                    <td>{{ $c->email }}</td>  --}}
                    <td>{{ $c->activity_ar }}</td>
                    <td>{{ $c->system_name_ar }}</td>
                    <td>{{ $c->end_date }}</td>
        </tr>
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
