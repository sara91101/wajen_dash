@extends('welcome')

@section('content')
<script>
    function checkAll(source,name)
    {
        checkboxes = document.getElementsByClassName(name);
        for(var i=0, n=checkboxes.length;i<n;i++)
        {
            checkboxes[i].checked = source.checked;
        }
    }
    function showMajors(sel)
    {
        var lastMajors = document.getElementsByClassName("majors");
        for (var j = 0; j < lastMajors.length; j++)
        {
            lastMajors[j].style.display = "none";
        }

        var sys = sel.value;
        var majors = document.getElementsByClassName("sys"+sys);
        for (var i = 0; i < majors.length; i++)
        {
            majors[i].classList.remove("row");
            majors[i].classList.add("row");
            majors[i].style.display = "block";
        }
    }
</script>

<div class="card">

    <div class="card-header" dir="rtl">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-inverse-primary justify-content-between">
                <li class="breadcrumb-item"><a href="#">    باقات الإشتراك</a>
                    <span class="breadcrumb-item active" aria-current="page"> /  إضافة </span>
                </li>
            </ol>
        </div>
    </div>

    <div class="card-body">
            <form method="POST" action="/storePackage">
                @csrf
                <div class="modal-body text-right font-weight-bold row" dir="rtl">
                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                            الباقة بالعربية
                        </label>
                        <input type="text" name="package_ar" class="form-control text-right" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1" class="text-primary-purple">الباقة بالإنجليزية</label>
                        <input type="text" name="package_en" class="form-control text-right">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                            النظام
                        </label>
                        <select name="systm_id" class="form-select text-right" required onchange="showMajors(this)">
                            {{--  <option value="">-</option>  --}}
                            @foreach ($systems as $s)
                                <option value={{ $s->id }}>{{ $s->system_name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i> السعر (شهري)</label>
                        <input type="number" step="any" name="price" id="monthly_price" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i> السعر (سنوي)</label>
                        <input type="number" step="any" id="yeraly_price" name="yeraly_price" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i> نسبة الخصم</label>
                        <input type="number" step="any" name="discount_percentage" class="form-control text-right">
                    </div>

                    @foreach ($majors as $m)
                        @if(count($m["minor"]) > 0)
                            <div class="alert alert-primary justify-content-between text-right font-weight-bold col-lg-12 majors sys{{ $m->systm_id }}">
                                <label class="font-weight-bold" style="float: right !important;">{{ $m->major_ar }}</label>
                                <input  style="float: left !important;"  class="form-check-input" type="checkbox" id="success2-check" onchange="checkAll(this,'major{{ $m->id }}')">
                            </div>

                            <div class="row majors text-right sys{{ $m->systm_id }}  col-lg-12" align="right" dir="rtl">
                                @foreach ($m["minor"] as $n)
                                    <div class="col-lg-4" dir="rtl" style="font-size: .9375rem;">
                                        <input value="{{ $n->id }}" name="major{{ $m->id }}[]" type="checkbox" class="form-check-input major{{ $m->id }}" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                                        &nbsp;&nbsp;&nbsp;
                                        {{ $n->minor_ar }}
                                    </div>
                                @endforeach
                            </div>
                            <br><br>
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer justify-content-center" align="center">
                    <input type="submit" value="حفظ" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>

    </div>
</div>

@endsection
