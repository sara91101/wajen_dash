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
                                الأسئلة والإستفسارات</a>
                                <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                            </li>
                        </ol>

                    </div>
        </div>

        <div class="card-body">
            @if(count($inquires))
            <div class="table-responsive">
                <table class="table text-center" dir="rtl">
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">رقم الهاتف</th>
                    <th class="font-weight-bold">البريد الإلكتروني</th>
                    <th class="font-weight-bold"> الإستفسار</th>
                    <th class="font-weight-bold"> الرد</th>
                    <th class="font-weight-bold">العمليات</th>
                </thead>

                <tbody>
                @foreach ($inquires as $inquiry)
                    <tr>
                        <td >{!! $i !!}</td>
                        <td>{{ $inquiry->phone }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->message }}</td>

                        <td>
                            @if(count($inquiry->reply) > 0)
                            <i class="mdi mdi-check-circle text-success"></i>
                            @else
                            <i class="mdi mdi-close-circle text-warning"></i>
                            @endif
                        </td>

                        <td>
                            <a href="/inquiries/{{ $inquiry->id }}" class="btn btn-info btn-sm btn-icon-text me-3">
                                <i class="mdi mdi-information btn-icon-append"></i>

                            </a>
                            &nbsp;&nbsp;

                            <a onclick="destroyItem( 'destroyInquiry', {{ $inquiry->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
                {{ $inquires->links("pagination::bootstrap-5") }}
            </div>
        </div>

    </div>

@endsection
