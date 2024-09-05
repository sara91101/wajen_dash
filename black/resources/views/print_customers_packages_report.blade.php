@extends('printHeader')

@section('content')

<div class="justify-content-between" align="center">
    <span class="text-center" align="center">
        <strong>إحصائية المشتركين بالباقات</strong>
    </span>
</div>

<br>

@php $i=1; @endphp
@if(count($packages) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl" id="customers">
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> الباقة</th>
                <th class="font-weight-bold"> عدد المشتركين</th>

            <tbody>
            @foreach ($packages as $p)
             @if( count($p["subscriber"]) > 0)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $p["package_ar"] }}</td>
                    <td>{{ count($p["subscriber"])}}</td>
                </tr>
                @php $i++; @endphp
            @endif
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
