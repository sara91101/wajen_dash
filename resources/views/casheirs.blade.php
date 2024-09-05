@extends('welcome')

@section('content')
@php
  $i = ($page * $perPage) - $perPage + 1;

@endphp


<script src="/js/sweetAlert.js"></script>
<script>
    function destroy(casheirId)
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
            window.location = "/destroycasheir/"+casheirId;}
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
            <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن موظف</b></h3>
        </div>
        <form method="POST" action="/casheirs" id="searchable">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        رقم العضوية / إسم الموظف / الرقم الوظيفي
                    </label>
                    <input type="text" name="casheir" class="form-control text-right">
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
                      <li class="breadcrumb-item"><a href="#">   المشتركين</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  طلبيات تفعيل الكاشير </span>
                       </li>

                        <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat">
                            <i class="mdi mdi-magnify"></i>
                        </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        
        @if(count($results) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">رقم العضوية</th>
                    <th class="font-weight-bold">الرقم الوظيفي</th>
                    <th class="font-weight-bold">إسم الموظف</th>
                    <th class="font-weight-bold">تفعيل</th>
                </thead>
    
                <tbody>
                    @foreach ($results as $casheir)
                        <tr>
                            <td >{!! $i !!}</td>
                            <td >{!! $casheir["membership_no"] !!}</td>
                            <td>{{ $casheir["first_name"] }} {{ $casheir["last_name"] }}</td>
                            <td>{{ $casheir["staff_no"] }}</td>
                            <td>
                                <a href="/casheirActivate/{{ $casheir['subscriber_id'] }}/{{ $casheir['first_name'] }}/{{ $casheir['last_name'] }}/{{ $casheir['staff_no'] }}/{{ $casheir['email'] }}/{{ $casheir['id'] }}/1" class="btn btn-success btn-sm btn-icon-text">
                                    تفعيل
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
        <div  dir="rtl" align="center" class="pagination pagination-primary flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $results->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
