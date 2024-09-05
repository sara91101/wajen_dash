@extends('printHeader')

@section('content')

<div class="justify-content-between" align="center">
    <span class="text-center" align="center">
        <strong>إحصائية المشتركين بالنظام</strong>
    </span>
</div>

<br>

@php $i=1; @endphp
        @if(count($systems) > 0)
        <div id="customers">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold"><b>#</b></th>
                <th class="font-weight-bold"> <b>النظام</b></th>
                <th class="font-weight-bold"> <b>عدد المشتركين</b></th>
            </thead>

            <tbody>
            @foreach ($systems as $s)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $s->system_name_ar }}</td>
                    <td>{{ $s->customer }}</td>
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
