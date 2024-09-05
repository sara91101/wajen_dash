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
                                 الوسطاء</a>
                                <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                            </li>
                        </ol>

                    </div>
        </div>

        <div class="card-body">
            @if(count($friends))
            <div class="table-responsive">
                <table class="table text-center" dir="rtl">
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">الإسم</th>
                    <th class="font-weight-bold">رقم الهاتف</th>
                    <th class="font-weight-bold">البريد الإلكتروني</th>
                    <th class="font-weight-bold"> إسم المشترك</th>
                    <th class="font-weight-bold"> إسم العمل</th>
                    <th class="font-weight-bold">نوع لنشاط</th>
                    <th class="font-weight-bold">رقم هاتف المشترك</th>
                    <th class="font-weight-bold">البريد الإلكتروني للمشترك</th>
                    <th class="font-weight-bold">حذف</th>
                </thead>

                <tbody>
                @foreach ($friends as $friend)
                    <tr>
                        <td >{!! $i !!}</td>
                        <td>{{ $friend->friend_first_name }} {{ $friend->friend_last_name }}</td>
                        <td>{{ $friend->friend_phone }}</td>
                        <td>{{ $friend->friend_email }}</td>
                        <td>{{ $friend->subscriber_fullname }}</td>
                        <td>{{ $friend->subscriber_business_name }}</td>
                        <td>{{ $friend->subscriber_activity }}</td>
                        <td>{{ $friend->subscriber_phone }}</td>
                        <td>{{ $friend->subscriber_email }}</td>

                        <td>
                            <a onclick="destroyItem( 'destroyFriend', {{ $friend->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
                {{ $friends->links("pagination::bootstrap-5") }}
            </div>
        </div>

    </div>

@endsection
