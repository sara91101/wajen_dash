@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editProperty(minor_id)
    {
        document.getElementById("minor_id").value = minor_id;
        document.getElementById("minor_ar").value = document.getElementById("minorAr"+minor_id).innerHTML;
        document.getElementById("minor_en").value = document.getElementById("minorEn"+minor_id).innerHTML;

        var major = document.getElementById("major_id"+minor_id).innerHTML;
        var majors = document.getElementById("majors");
        for (var i = 0; i < majors.options.length; i++)
        {
            if(majors.options[i].value == parseInt(major))
            {
                majors.options[i].selected = true;
                majors.selectedIndex = i;
            }
        }
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن خاصية</b></h3>
        </div>
        <form method="POST" action="/properties">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         الخاصية
                    </label>
                    <input type="text" name="property" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القائمة الرئيسية
                    </label>
                    <select name="major_id" class="form-select text-right">
                        <option value=0>-</option>
                        @foreach ($majors as $m)
                            <option value={{ $m->id }}>{{ $m->major_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القائمة الفرعية
                    </label>
                    <select name="minor_id" class="form-select text-right">
                        <option value=0>-</option>
                        @foreach ($minors as $n)
                            <option value={{ $n->id }}>{{ $n->minor_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between" align="center">
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
                <a href="{{ url('/allProperties') }}" class="btn btn-primary">إلغاء البحث</a>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b> تحديد النظام  </b></h3>
        </div>
        <div class="modal-body text-right font-weight-bold" dir="rtl">
        <form method="POST" action="/addProperty">
            @csrf
            <div class="form-group">
                <label class="text-primary-purple">النظام</label>
                <select name="system_id" class="form-select" dir="rtl">
                    @foreach ($systms as $s)
                    <option value="{{ $s->id }}">{{ $s->system_name_ar }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <input type="submit" value="إرسال" class="btn btn-primary">
        </div>
    </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                      <li class="breadcrumb-item"><a href="#">    الخصائص</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                       </li>

                      <label class="badge badge-primary text-white">
                        <div class="dropdown dropstart">
                            <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical  text-white"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat" href="#">بحث</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">إضافة</a></li>
                            </ul>
                        </div>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($properties) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> القائمة الفرعية</th>
                <th class="font-weight-bold">الخاصية بالعربية</th>
                <th class="font-weight-bold">الخاصية بالإنجليزية</th>
                <th class="font-weight-bold">العمليات</th>
                <th class="font-weight-bold">الخيارات</th>
            </thead>

            <tbody>
            @foreach ($properties as $p)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $p->minor_ar }}</td>
                    <td id="propertyAr{{ $p->id }}">{{ $p->property_ar }}</td>
                    <td id="propertyEn{{ $p->id }}">{{ $p->property_en }}</td>

                    <td>
                        @php $k=0; @endphp
                        @foreach ($p["operation"] as $o)
                            @if($k != 0 && $k % 2 == 0) <br><br> @endif
                            <label class="badge badge-primary text-white">
                                {{ $o->operation_ar }}
                            </label>
                            @php $k++; @endphp
                        @endforeach
                    </td>

                    <span id="major_id{{ $p->id }}" style="display: none;">{{ $p->major_id }}</span>
                    <td>
                        <a href="/editProperty/{{ $p->id }}" class="btn btn-success btn-sm btn-icon-text me-3">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyProperty', {{ $p->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
            {{ $properties->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection