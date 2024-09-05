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
        @php $sum = 0; @endphp
                @foreach ($towns as $t)
                    @if(count($t["subscribers"]) > 0 )
                        @php $sum+= count($t["subscribers"]); @endphp
                        <tr>
                            <td >{!! $i !!}</td>
                            <td>{{ $t["ar_name"] }}</td>
                            <td>{{ count($t["subscribers"]) }}</td>
                        </tr>
                        @php $i++; @endphp
                    @endif
                @endforeach
                    <tr>
                        <td colspan=2><b>المجموع</b></td>
                        <td><b>{{ $sum }}</b></td>
                    </tr>
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
