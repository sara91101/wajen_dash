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
            <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن مشترك</b></h3>
        </div>
        <form method="POST" action="/customers">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        البيانات الأساسية
                    </label>
                    <input type="text" name="customer" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> النظام</label>
                    <select name="systm" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($systems as $s)
                            <option value="{{ $s->id }}">{{ $s->system_name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> المدينة</label>
                    <select name="town" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($towns as $t)
                            <option value="{{ $t['id'] }}">{{ $t['ar_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> المحافظة</label>
                    <select name="governorate" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($governorates as $g)
                            <option value="{{ $g['id'] }}">{{ $g['ar_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> النشاط</label>
                    <select name="activity" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($activities as $a)
                            <option value="{{ $a->id }}">{{ $a->activity_ar }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-between" align="center">
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary foat-left">
                <a href="/allCustomers" class="btn  my-btn btn-lg btn-primary foat-right">إلغاء البحث</a>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  المشتركين </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  الأرشيف </span>
                        </li>

                        {{--  <label class="badge badge-primary text-white">
                            <div class="dropdown dropstart">
                                <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical  text-white"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat" href="javascript:;">بحث</a></li>
                                    <li><a class="dropdown-item" href="/addCustomer">إضافة</a></li>
                                    <li><a class="dropdown-item" href="/printCustomers">طباعة</a></li>
                                </ul>
                            </div>
                        </label>  --}}
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($customers) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> الإسم</th>
                <th class="font-weight-bold"> رقم العضوية</th>
                <th class="font-weight-bold"> المدينة</th>
                <th class="font-weight-bold"> المحافظة</th>
                {{--  <th class="font-weight-bold"> رقم الهاتف</th>
                <th class="font-weight-bold">البريد الإلكتروني</th>  --}}
                <th class="font-weight-bold"> النشاط</th>
                <th class="font-weight-bold"> النظام</th>
                <th class="font-weight-bold"> الباقة</th>
                <th class="font-weight-bold"> إنتهاء الإشتراك	</th>

                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($customers as $c)
            @if($c["is_archived"] == 1)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>
                        {{ $c["first_name"] }} {{ $c["last_name"] }}
                    </td>
                    <td>{{ $c["membership_no"] }}</td>
                    <td>{{ $c["city"]}}</td>
                    <td>{{ $c["governorate"]}}</td>
                    {{--  <td dir="ltr">{{ $c[""]phone }}</td>
                    <td>{{ $c[""]email }}</td>  --}}
                    <td>@if($c["activity_type"] == 0) مقهى @else مطعم @endif </td>
                    <td>{{ $systm["system_name_ar"] }}</td>
                    <td>{{ $c["package_ar"] }}</td>
                    <td>@if(!is_null($c['subscription_end_at'])){{date('Y-m-d', strtotime($c['subscription_end_at'])) }} @endif</td>

                    <td>
                        {{--  <a href="/showCustomer/{{ $c['id'] }}" class="btn btn-info btn-sm btn-icon-text">
                            <i class="typcn typcn-eye btn-icon-append"></i>
                        </a>  --}}
                        {{--  <a href="/CustomerMessages/{{ $c['id'] }}" class="btn btn-primary btn-sm btn-icon-text">
                            <i class="mdi mdi-gmail btn-icon-append"></i>
                        </a>
                        <a href="/editCustomer/{{ $c['id'] }}" class="btn btn-success btn-sm btn-icon-text">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                        </a>  --}}
                        <a  href="/unArchiveCustomer/{{ $c['id'] }}" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="mdi mdi-keyboard-return btn-icon-append"></i>
                        </a>
                    </td>


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
    {{--  <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $customers->links("pagination::bootstrap-5") }}
        </div>
    </div>  --}}

</div>

@endsection
