@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editBlogDepartment(department_id)
    {
        document.getElementById("department_id").value = department_id;
        document.getElementById("department_ar").value = document.getElementById("departmentAr"+department_id).innerHTML;
        document.getElementById("department_en").value = document.getElementById("departmentEn"+department_id).innerHTML;
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة أقسام المدونة</b></h3>
        </div>
        <form method="POST" action="/blogDepartments">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القسم بالعربية
                    </label>
                    <input type="text" name="ar_department" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">القسم بالإنجليزية</label>
                    <input type="text" name="en_department" class="form-control text-right">
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل أقسام المدونة</b></h3>
        </div>
        <form method="POST" action="/updateBlogDepartment">
            @csrf
            <input type="hidden" name="department_id" id="department_id">

            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القسم بالعربية
                    </label>
                    <input type="text" id="department_ar" name="ar_department" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">القسم بالإنجليزية</label>
                    <input type="text" id="department_en" name="en_department" class="form-control text-right">
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
                      <li class="breadcrumb-item"><a href="#">   أقسام المدونة </a>
                        <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                       </li>

                      <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                        <i class="mdi mdi-plus"></i>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($blog_departments) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">النشاط بالعربية</th>
                <th class="font-weight-bold">النشاط بالإنجليزية</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($blog_departments as $a)
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="departmentAr{{ $a->id }}">{{ $a->ar_department }}</td>
                    <td id="departmentEn{{ $a->id }}">{{ $a->en_department }}</td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editBlogDepartment({{ $a->id }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyBlogDepartment', {{ $a->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
            {{ $blog_departments->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
