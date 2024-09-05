@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editUnit(Unit_id)
    {
        document.getElementById("Unit_id").value = Unit_id;
        document.getElementById("ar_Unit").value = document.getElementById("UnitAr"+Unit_id).innerHTML;
        document.getElementById("en_Unit").value = document.getElementById("UnitEn"+Unit_id).innerHTML;
        document.getElementById("UnitAbbreviation").value = document.getElementById("UnitAbbreviation"+Unit_id).innerHTML;
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة وحدة قياس</b></h3>
        </div>
        <form method="POST" action="/newUnit">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الوحدة بالعربية
                    </label>
                    <input type="text" name="ar_name" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">الوحدة بالإنجليزية</label>
                    <input type="text" name="en_name" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">الإختصار </label>
                    <input type="text" name="abbreviation" class="form-control text-right">
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل وحدة القياس</b></h3>
        </div>
        <form method="POST" action="/updateUnit">
            @csrf
            <input type="hidden" name="Unit_id" id="Unit_id">
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الوحدة بالعربية
                    </label>
                    <input type="text" name="ar_name" id="ar_Unit" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">الوحدة بالإنجليزية</label>
                    <input type="text" name="en_name" id="en_Unit" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> الإختصار</label>
                    <input type="text" name="abbreviation" id="UnitAbbreviation" class="form-control text-right">
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
                        <span class="breadcrumb-item active" aria-current="page"> /   الصلاحيات </span>
                       </li>

                      <a class="badge badge-primary text-white" href="/addLevel">
                        <i class="mdi mdi-plus"></i>
                      </a>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($levels) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">الصلاحية</th>
                <th class="font-weight-bold">التفاصيل</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($levels as $level)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $level->level }}</td>
                    <td>
                        @if($subPages == count($level["levelSubPage"]))
                            <span class="badge badge-primary text-white">
                                الكل
                            </span>
                        @else
                            @php $counter = 0; @endphp
                            @foreach ($level["levelSubPage"] as $levelSubPage)
                                @if($counter != 0 && $counter % 3 == 0) <br><br> @endif
                                <span class="badge badge-primary text-white">
                                    {{ $levelSubPage->page }} - {{ $levelSubPage->sub_page }}
                                </span>
                                @php $counter++; @endphp
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-success btn-sm btn-icon-text me-3" href="/editLevel/{{ $level->id }}">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyLevel', {{ $level->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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

</div>

@endsection
