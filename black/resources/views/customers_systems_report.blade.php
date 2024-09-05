@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="/customers_systems_report">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        تاريخ بداية الإشتراك
                    </label>
                    <input type="date" name="fromm" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        تاريخ نهاية الإشتراك</label>
                    <input type="date" name="too" class="form-control text-right">
                </div>

            </div>
            <div class="modal-footer justify-content-between" align="center" dir="rtl">
                <a href="/cancelSearch" class="btn  my-btn btn-lg btn-primary">إلغاء البحث</a>
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  التقارير </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  إحصائية المشتركين بالنظام </span>
                        </li>

                        <a href="/print_customers_systems_report" class="badge badge-primary text-white" style="text-decoration: none;">
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
                <th class="font-weight-bold"> عدد المشتركين</th>
            </thead>

            <tbody>
            @foreach ($systems as $s)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $s->system_name_ar }}</td>
                    <td>{{ $s->customer}}</td>
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
