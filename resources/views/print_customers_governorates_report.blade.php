@extends('printHeader')

@section('content')

<div class="justify-content-between" align="center">
    <span class="text-center" align="center">
        <strong>إحصائية المشتركين بالمحافظات</strong>
    </span>
</div>

<br>

@php $i=1; @endphp
@if(count($governorates) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl" id="customers">
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> المحافظة</th>
                <th class="font-weight-bold"> عدد المشتركين</th>

            <tbody>
            @foreach ($governorates as $g)
            @if(count($g['subscriber']) > 0)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $g["ar_name"] }}</td>
                    <td>{{ count($g['subscriber'])}}</td>
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
