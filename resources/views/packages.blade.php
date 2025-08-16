@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp
<script>
    function linkMinors(sel)
    {
        var major = sel.value;
        var minors = document.getElementById("minors");
        for (var i = 0; i < minors.options.length; i++)
        {
            if(minors.options[i].className != parseInt(major))
            {
                minors.options[i].style.display = "none";
                minors.options[i].selected = false;
            }
            else
            {
                minors.options[i].style.display = "block";
            }
        }
    }
    </script>

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن باقة</b></h3>
        </div>
        <form method="POST" action="/packages">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        الباقة
                    </label>
                    <input type="text" name="package" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        النظام
                    </label>
                    <select name="systm" class="form-select text-right">
                        <option value=0>-</option>
                        @foreach ($systems as $s)
                            <option value={{ $s->id }}>{{ $s->system_name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        القائمة الرئيسية
                    </label>
                    <select name="major" id="majors" class="form-select text-right" onchange="linkMinors(this)">
                        <option value=0>-</option>
                        @foreach ($majors as $m)
                            <option value={{ $m->id }}>{{ $m->major_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        القائمة الفرعية
                    </label>
                    <select name="minor" id="minors" class="form-select text-right">
                        <option value=0>-</option>
                        @foreach ($minors as $n)
                            <option value={{ $n->id }} class="{{ $n->major_id }}">{{ $n->minor_ar }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-between" align="center">
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
                <a href="{{ url('/allPackages') }}" class="btn btn-primary">إلغاء البحث</a>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">   باقات الإستراك</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>

                        <label class="badge badge-primary text-white">
                            <div class="dropdown dropstart">
                                <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical  text-white"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat" href="#">بحث</a></li>
                                    <li><a class="dropdown-item" href="/addPackage">إضافة</a></li>
                                </ul>
                            </div>
                        </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($packages))
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> النظام</th>
                <th class="font-weight-bold">الباقة بالعربية</th>
                <th class="font-weight-bold">الباقة بالإنجليزية</th>
                <th class="font-weight-bold"> السعر (شهري)</th>
                <th class="font-weight-bold"> السعر (سنوي)</th>
                <th class="font-weight-bold"> نسبه الخصم</th>
                <th class="font-weight-bold"> المحتويات</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($packages as $pk)
            @if(count($pk["packageMinor"]))
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $pk->system_name_ar }}</td>
                    <td id="PackageAr{{ $pk->id }}">{{ $pk->package_ar }}</td>
                    <td id="PackageEn{{ $pk->id }}">{{ $pk->package_en }}</td>
                    <td id="PackagePrice{{ $pk->id }}">{{ $pk->price }}</td>
                    <td id="PackagePrice{{ $pk->id }}">{{ $pk->yearly_price }}</td>
                    <td id="PackagePrice{{ $pk->id }}">{{ $pk->discount_percentage }}</td>

                    <td class="float-right">
                        @php $k=0; @endphp
                        @foreach ($pk["majors"] as $pm)
                            @if($k != 0 && $k % 3 == 0) <br><br> @endif
                            <label class="badge badge-primary text-white">
                                {{ $pm->major_ar }}
                            </label>
                            @php $k++; @endphp
                        @endforeach
                    </td>

                    <span id="system_id{{ $pk->id }}" style="display: none;">{{ $pk->systm_id }}</span>
                    <td>
                        <a href="/editPackage/{{ $pk->id }}" class="btn btn-success btn-sm btn-icon-text me-3">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyPackage', {{ $pk->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                حذف
                        </a>
                    </td>

                </tr>
                @php $i++; @endphp
            @endif
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
            {{ $packages->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
