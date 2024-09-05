@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  طلبات الباقة المجانية </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($demands) > 0)
        <div class="table-responsive-xl">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> الإسم</th>
                <th class="font-weight-bold"> البريد الإلكتروني</th>
                <th class="font-weight-bold"> رقم الهاتف</th>
                <th class="font-weight-bold"> المدينة</th>
                <th class="font-weight-bold"> المحافظة</th>
                <th class="font-weight-bold"> النشاط</th>
                <th class="font-weight-bold">IP Address </th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($demands as $demand => $c)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>
                        {{ $c["first_name"] }} {{ $c["last_name"] }}
                    </td>
                    <td>{{ $c["email"]}}</td>
                    <td>{{ $c["phone_no"]}}</td>
                    <td>{{ $c["city"]}}</td>
                    <td>{{ $c["governorate"]}}</td>
                    <td> {{ $types[$demand] }}</td>
                    <td>{{ $c["ip_address"]}}</td>

                    <td>
                            <div class="input-group text-right" style="text-align: right;">
                              <div class="input-group-prepend">
                                <button class="badge badge-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal  text-white"></i>
                                </button>
                                <div class="dropdown-menu" style="text-align: right;">
                                    <a class="dropdown-item text-right" href="/registerDemand/{{ $c['id'] }}" style="text-decoration: none">
                                        إنشاء الحساب
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-right" onclick="destroyItem( 'destroyDemand', {{ $c['id'] }})"  href="javascript:;" style="text-decoration: none">
                                        حذف
                                    </a>
                                </div>
                              </div>
                            </div>
                    </td>
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
    {{--  <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $demands->links("pagination::bootstrap-5") }}
        </div>
    </div>  --}}

</div>

@endsection
