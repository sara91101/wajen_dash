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
                            <li class="breadcrumb-item"><a href="#">
                                 الموزعين</a>
                                <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                            </li>
                        </ol>

                    </div>
        </div>

        <div class="card-body">
            @if(count($distributors))
            <div class="table-responsive">
                <table class="table text-center" dir="rtl">
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">الإسم</th>
                    <th class="font-weight-bold">إسم العمل</th>
                    <th class="font-weight-bold">رقم الهاتف</th>
                    <th class="font-weight-bold">البريد الإلكتروني</th>
                    <th class="font-weight-bold"> المدينة</th>
                    <th class="font-weight-bold"> عدد الفروع</th>
                    <th class="font-weight-bold">حذف</th>
                </thead>

                <tbody>
                @foreach ($distributors as $distributor)
                    <tr>
                        <td >{!! $i !!}</td>
                        <td>{{ $distributor->first_name }} {{ $distributor->last_name }}</td>
                        <td>{{ $distributor->business_name }}</td>
                        <td>{{ $distributor->phone }}</td>
                        <td>{{ $distributor->email }}</td>
                        <td>{{ $distributor->city }}</td>
                        <td>{{ $distributor->branches_no }}</td>

                        <td>
                            <a onclick="destroyItem( 'destroyDistributor', {{ $distributor->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
                {{ $distributors->links("pagination::bootstrap-5") }}
            </div>
        </div>

    </div>

@endsection
