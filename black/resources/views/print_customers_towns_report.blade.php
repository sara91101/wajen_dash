@extends('printHeader')

@section('content')

<div class="justify-content-between" align="center">
    <span class="text-center" align="center">
        <strong>إحصائية المشتركين بالمٌدٌن</strong>
    </span>
</div>

<br>

@php $i=1; @endphp
@if(count($towns) > 0)
<div class="table-responsive">
    <table class="table text-center" dir="rtl" id="customers">
        <th class="font-weight-bold">#</th>
        <th class="font-weight-bold"> المدينة</th>
        <th class="font-weight-bold"> عدد المشتركين</th>

    <tbody>
    @foreach ($towns as $t)
        <tr>
            <td >{!! $i !!}</td>
            <td>{{ $t["ar_name"] }}</td>
            <td>{{ $t["customers"] }}</td>
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
