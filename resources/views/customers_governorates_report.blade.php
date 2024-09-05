@extends('welcome')

@section('content')
<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  التقارير </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  إحصائية المشتركين بالمحافظات </span>
                        </li>

                        <a href="/print_customers_governorates_report" class="badge badge-primary text-white" style="text-decoration: none;">
                            <i class="mdi mdi-printer"></i>
                            طباعة
                        </a>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($governorates) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> المحافظة</th>
                <th class="font-weight-bold"> عدد المشتركين</th>
            </thead>

            <tbody>
                @php $i=1; @endphp
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

</div>

@endsection
