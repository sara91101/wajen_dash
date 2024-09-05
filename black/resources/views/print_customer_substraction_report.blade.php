@extends('printHeader')

@section('content')

<div class="justify-content-between" align="center">
    <span class="text-center" align="center">
        <strong>إحصائية المشتركين بالإشتراك</strong>
    </span>
</div>

<br>

@php $i=1; @endphp
@if(count($systems) > 0)
<table class="table text-center" dir="rtl" id="customers">
        <th class="font-weight-bold">#</th>
        <th class="font-weight-bold"> النظام</th>
        <th class="font-weight-bold"> عدد المشتركين المفعلين</th>
        <th class="font-weight-bold"> عدد المشتركين غير المفعلين</th>

    <tbody>
        @php $i=1; @endphp
    @foreach ($systems as $s)
        <tr>
            <td >{!! $i !!}</td>
            <td>{{ $s->system_name_ar }}</td>
            <td>{{ $s->active}}</td>
            <td>{{ $s->inActive}}</td>
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
