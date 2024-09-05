@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editService(Service_id)
    {
        document.getElementById("service_id").value = Service_id;
        document.getElementById("Service_ar").value = document.getElementById("ServiceAr"+Service_id).innerHTML;
        document.getElementById("Service_en").value = document.getElementById("ServiceEn"+Service_id).innerHTML;
        document.getElementById("price").value = document.getElementById("price"+Service_id).innerHTML;
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة خدمة</b></h3>
        </div>
        <form method="POST" action="/services">
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
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">السعر </label>
                    <input type="text" name="price" class="form-control text-right">
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل  الخدمات</b></h3>
        </div>
        <form method="POST" action="/updateService">
            @csrf
            <input type="hidden" name="service_id" id="service_id">

            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الخدمة بالعربية
                    </label>
                    <input type="text" id="Service_ar" name="ar_service" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">الخدمة بالإنجليزية</label>
                    <input type="text" id="Service_en" name="en_service" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> السعر</label>
                    <input type="text" id="price" name="price" class="form-control text-right">
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
                      <li class="breadcrumb-item"><a href="#">    الإعدادات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  الخدمات </span>
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
                <th class="font-weight-bold"> السعر</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($services as $service)
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="ServiceAr{{ $service->id }}">{{ $service->ar_service }}</td>
                    <td id="ServiceEn{{ $service->id }}">{{ $service->en_service }}</td>
                    <td id="price{{ $service->id }}">{{ $service->price }}</td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editService({{ $service->id }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyService', {{ $service->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                حذف
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
            {{ $services->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
