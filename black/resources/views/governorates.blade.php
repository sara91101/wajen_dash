@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editgovernorate(governorate_id)
    {
        document.getElementById("governorate_id").value = governorate_id;
        document.getElementById("ar_governorate").value = document.getElementById("governorateAr"+governorate_id).innerHTML;
        document.getElementById("en_governorate").value = document.getElementById("governorateEn"+governorate_id).innerHTML;

        var governorate_town_id = document.getElementById("governorate_town_id"+governorate_id).innerHTML;
        var towns = document.getElementById("town_id");
        for (var i = 0; i < towns.options.length; i++)
        {
            if(towns.options[i].value == parseInt(governorate_town_id))
            {
                towns.options[i].selected = true;
                towns.selectedIndex = i;
            }
        }


        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة محافظة</b></h3>
        </div>
        <form method="POST" action="/newGovernorate">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        المحافظة بالعربية
                    </label>
                    <input type="text" name="ar_governorate" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">المحافظة بالإنجليزية</label>
                    <input type="text" name="en_governorate" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> المدينة</label>
                    <select name="town_id" class="form-select text-right" dir="rtl">
                        @foreach ($towns as $t)
                            <option value="{{ $t["id"] }}">{{ $t["ar_name"] }}</option>
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل محافظة</b></h3>
        </div>
        <form method="POST" action="/updateGovernorate">
            @csrf
            <input type="hidden" name="governorate_id" id="governorate_id">
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        المحافظة بالعربية
                    </label>
                    <input type="text" name="ar_governorate" id="ar_governorate" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">المحافظة بالإنجليزية</label>
                    <input type="text" name="en_governorate" id="en_governorate" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> المدينة</label>
                    <select name="town_id" id="town_id" class="form-select text-right" dir="rtl">
                        @foreach ($towns as $t)
                            <option value="{{ $t["id"] }}">{{ $t["ar_name"] }}</option>
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
                      <li class="breadcrumb-item"><a href="#">   الإعدادات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  المٌحافظات </span>
                       </li>

                      <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                        <i class="mdi mdi-plus"></i>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(!is_null($governorates))
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">المحافظة بالعربية</th>
                <th class="font-weight-bold">المحافظة بالإنجليزية</th>
                <th class="font-weight-bold">المدينة </th>
                @if( Session::get('level') != 3)
                <th class="font-weight-bold">العمليات</th>
                @endif
            </thead>

            <tbody>
            @foreach ($governorates as $t)
            <span style="display: none;" id="governorate_town_id{{ $t['id']}}">{{ $t['city_id']}}</span>
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="governorateAr{{ $t['id'] }}">{{ $t['ar_name'] }}</td>
                    <td id="governorateEn{{ $t['id'] }}">{{ $t['en_name'] }}</td>
                    <td>{{ $t['city_name'] }}</td>
                    @if( Session::get('level') != 3)
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editgovernorate({{ $t['id'] }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyGovernorate', {{ $t['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                حذف
                        </a>
                    </td>
                    @endif

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
    {{--  <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $governorates->links("pagination::bootstrap-5") }}
        </div>
    </div>  --}}

</div>

@endsection
