@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp


<script src="/js/sweetAlert.js"></script>
<script>
    function destroy(sessionId)
    {
        swal({
            title: 'تحذير',
            text: "هل أنت متأكد من الحذف؟",
            icon: 'warning',
            showCancelButton: true,
            customClass: {
        actions: 'vertical-buttons',
        cancelButton: 'top-margin'
        },
            buttons: {
            cancel: {
                text: "لا",
                value: null,
                visible: true,
                className: "btn btn-success",
                closeModal: true,
            },
            confirm: {
                text: "نعم",
                value: true,
                visible: true,
                className: "btn btn-danger",
                closeModal: true
            }
            }
        }).then(okay => {
        if (okay) {
            window.location = "/destroySession/"+sessionId;}
            });
    }
</script>

<style>
    #searchable
    {
        float: left;
        padding: 6px;
        border: none;
        margin-top: 8px;
        margin-right: 16px;
        font-size: 17px;
    }
</style>

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة وحدة قياس</b></h3>
        </div>
        <form method="POST" action="/userSessions" id="searchable">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        إسم الموظف / الرقم الوظيفي
                    </label>
                    <input type="text" name="session" class="form-control text-right" required>
                </div>
            </div>
            <div class="modal-footer" align="left">
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary float-left">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                      <li class="breadcrumb-item"><a href="#">   الإعدادات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  الجلسات النشطة </span>
                       </li>

                        <form method="POST" action="/userSessions" id="searchable">
                            @csrf
                            <input class="width: 90px;" type="text" name="session"  placeholder="إسم الموظف / الرقم الوظيفي">
                            <button type="submit" class="badge badge-primary float-left">
                                <i class="mdi mdi-account-search"></i>
                            </button>
                        </form>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($sessions) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">الرقم الوظيفي</th>
                <th class="font-weight-bold">إسم الموظف</th>
                <th class="font-weight-bold">حذف</th>
            </thead>

            <tbody>
            @foreach ($sessions as $session)
                @if($info != "")
                    @if($info != "" && (($session["staff_no"] == $info) || str_contains($session["user_name"],$info)))
                        <tr>
                                <td >{!! $i !!}</td>
                                <td>{{ $session["user_name"] }}</td>
                                <td>{{ $session["staff_no"] }}</td>
                                <td>
                                    <span href="javacript:;" onclick="destroy({{ $session['id'] }})" class="btn btn-danger btn-sm btn-icon-text">
                                        <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                        تسجيل الخروج
                                    </span>
                                </td>
                        </tr>
                    @endif
                @else
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $session["user_name"] }}</td>
                    <td>{{ $session["staff_no"] }}</td>
                    <td>
                        <span href="javacript:;" onclick="destroy({{ $session['id'] }})" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="mdi mdi-logout btn-icon-append"></i>
                                تسجيل الخروج
                        </span>
                    </td>
                </tr>
                @endif
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
