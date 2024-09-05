@extends('welcome')

@section('content')
<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  التقارير </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  إحصائية المشتركين بالإشتراك </span>
                        </li>

                        <a href="/print_customer_substraction_report" class="badge badge-primary text-white" style="text-decoration: none;">
                            <i class="mdi mdi-printer"></i>
                            طباعة
                        </a>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($systems) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> النظام</th>
                <th class="font-weight-bold"> عدد المشتركين المفعلين</th>
                <th class="font-weight-bold"> عدد المشتركين غير المفعلين</th>
            </thead>

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

</div>

@endsection
