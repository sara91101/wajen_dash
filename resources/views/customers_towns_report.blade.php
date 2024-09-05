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
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة نشاط</b></h3>
        </div>
        <form method="POST" action="/newActivity">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        النشاط بالعربية
                    </label>
                    <input type="text" name="activity_ar" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">النشاط بالإنجليزية</label>
                    <input type="text" name="activity_en" class="form-control text-right">
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="حفظ" class="btn  my-btn btn-lg btn-primary">
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
                            <span class="breadcrumb-item active" aria-current="page"> /  إحصائية المشتركين بالمٌدٌن </span>
                        </li>

                        <a href="/print_customers_towns_report" class="badge badge-primary text-white" style="text-decoration: none;">
                            <i class="mdi mdi-printer"></i>
                            طباعة
                        </a>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($towns) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> المدينة</th>
                <th class="font-weight-bold"> عدد المشتركين </th>
            </thead>

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

</div>

@endsection
