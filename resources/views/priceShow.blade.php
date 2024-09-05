@extends('welcome')

@section('content')
@php
      $i = ($page * $perPage) - $perPage + 1;

@endphp

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">
                            عرض الأسعار</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>

                        <label class="badge badge-primary text-white">
                            <div class="dropdown dropstart">
                                <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical  text-white"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="/createPriceShow">إضافة</a></li>
                                </ul>
                            </div>
                        </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($results))
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <!--th class="font-weight-bold">IP Address</th-->
                <th class="font-weight-bold"> إسم العميل</th>
                <th class="font-weight-bold">إسم النشاط</th>
                <th class="font-weight-bold"> الباقة</th>
                <th class="font-weight-bold"> التكلفة</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($results as $result)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $result["name"] }}</td>
                    <td>{{ $result["activity_name"] }}</td>
                    <td>{{ $result["package_ar"] }}</td>
                    <td>{{ $result["final_price"] }}</td>

                    <td>
                        <a href="/priceShow/{{ $result['id'] }}" class="btn btn-info btn-sm btn-icon-text">
                            <i class="mdi mdi-information btn-icon-append"></i>
                        </a>
                        <a href="/editPriceShow/{{ $result['id'] }}" class="btn btn-warning btn-sm btn-icon-text">
                            <i class="mdi mdi-pencil btn-icon-append"></i>
                        </a>
                        {{--  <a href="/emailPrice/{{ $result['id'] }}" class="btn btn-success btn-sm btn-icon-text">
                            <i class="mdi mdi-gmail btn-icon-append"></i>
                        </a>  --}}
                        <a onclick="destroyItem( 'destroyPriceShow', {{ $result['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                        </a>
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
    <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $results->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
