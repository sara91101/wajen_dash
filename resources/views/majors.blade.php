@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editMajor(major_id)
    {
        document.getElementById("major_id").value = major_id;
        document.getElementById("major_ar").value = document.getElementById("majorAr"+major_id).innerHTML;
        document.getElementById("major_en").value = document.getElementById("majorEn"+major_id).innerHTML;

        var system = document.getElementById("system_id"+major_id).innerHTML;
        var systems = document.getElementById("systm_id");
        for (var i = 0; i < systems.options.length; i++)
        {
            if(systems.options[i].value == parseInt(system))
            {
                systems.options[i].selected = true;
                systems.selectedIndex = i;
            }
        }
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة قائمة</b></h3>
        </div>
        <form method="POST" action="/newMajor">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القائمة بالعربية
                    </label>
                    <input type="text" name="major_ar" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">القائمة بالإنجليزية</label>
                    <input type="text" name="major_en" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        النظام
                    </label>
                    <select name="systm_id" class="form-select text-right">
                        @foreach ($systems as $s)
                            <option value={{ $s->id }}>{{ $s->system_name_ar }}</option>
                        @endforeach
                    </select>
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل القائمة الرئيسية</b></h3>
        </div>
        <form method="POST" action="/updateMajor">
            @csrf
            <input type="hidden" name="major_id" id="major_id">

            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القائمة بالعربية
                    </label>
                    <input type="text" id="major_ar" name="major_ar" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">القائمة بالإنجليزية</label>
                    <input type="text" id="major_en" name="major_en" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         النظام
                    </label>
                    <select name="systm_id" id="systm_id" class="form-select text-right">
                        @foreach ($systems as $s)
                            <option value={{ $s->id }}>{{ $s->system_name_ar }}</option>
                        @endforeach
                    </select>
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
                      <li class="breadcrumb-item"><a href="#">   القائمة الرئيسية</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                       </li>

                      <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                        <i class="mdi mdi-plus"></i>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($majors) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> النظام</th>
                <th class="font-weight-bold">القائمة بالعربية</th>
                <th class="font-weight-bold">القائمة بالإنجليزية</th>
                <th class="font-weight-bold">القوائم الفرعية</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($majors as $m)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $m->system_name_ar }}</td>
                    <td id="majorAr{{ $m->id }}">{{ $m->major_ar }}</td>
                    <td id="majorEn{{ $m->id }}">{{ $m->major_en }}</td>

                    <td class="float-right">
                        @php $k=0; @endphp
                        @foreach ($m["minor"] as $n)
                            @if($k != 0 && $k % 3 == 0) <br><br> @endif
                            <label class="badge badge-primary text-white">
                                {{ $n->minor_ar }}
                            </label>
                            @php $k++; @endphp
                        @endforeach
                    </td>

                    <span id="system_id{{ $m->id }}" style="display: none;">{{ $m->systm_id }}</span>
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editMajor({{ $m->id }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyMajor', {{ $m->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
            {{ $majors->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
