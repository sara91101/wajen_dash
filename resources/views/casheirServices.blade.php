@extends('welcome')

@section('content')

<script>
    function editService(Service_id)
    {
        document.getElementById("Service_id").value = Service_id;
        document.getElementById("ar_service").value = document.getElementById("ServiceAr"+Service_id).innerHTML;
        document.getElementById("en_service").value = document.getElementById("ServiceEn"+Service_id).innerHTML;
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة خدمة</b></h3>
        </div>
        <form method="POST" action="/newService">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الخدمة بالعربية
                    </label>
                    <input type="text" name="ar_service" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">الخدمة بالإنجليزية</label>
                    <input type="text" name="en_service" class="form-control text-right">
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="حفظ" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل خدمة</b></h3>
        </div>
        <form method="POST" action="/updatecasheirService">
            @csrf
            <input type="hidden" name="Service_id" id="Service_id">
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الخدمة بالعربية
                    </label>
                    <input type="text" name="ar_service" id="ar_service" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">الخدمة بالإنجليزية</label>
                    <input type="text" name="en_service" id="en_service" class="form-control text-right">
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="تعديل" class="btn  my-btn btn-lg btn-primary">
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
                        <span class="breadcrumb-item active" aria-current="page"> /  خدمات الكاشير </span>
                       </li>

                      <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                        <i class="mdi mdi-plus"></i>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($services) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">الخدمة بالعربية</th>
                <th class="font-weight-bold">الخدمة بالإنجليزية</th>
                @if( Session::get('level') != 3)
                <th class="font-weight-bold">العمليات</th>
                @endif
            </thead>

            <tbody>
            @foreach ($services as $t)
                <tr>
                    <td >{!! $loop->index + 1 !!}</td>
                    <td id="ServiceAr{{ $t['id'] }}">{{ $t['ar_service'] }}</td>
                    <td id="ServiceEn{{ $t['id'] }}">{{ $t['en_service'] }}</td>
                    @if( Session::get('level') != 3)
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editService({{ $t['id'] }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroycasheirService', {{ $t['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                حذف
                        </a>
                    </td>
                    @endif

                </tr>
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
