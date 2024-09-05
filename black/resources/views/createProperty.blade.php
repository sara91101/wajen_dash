@extends('welcome')

@section('content')
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

<div class="card">

    <div class="card-header" dir="rtl">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-inverse-primary justify-content-between">
                <li class="breadcrumb-item"><a href="#">    الخصائص</a>
                    <span class="breadcrumb-item active" aria-current="page"> /  إضافة </span>
                </li>
            </ol>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="/newProperty">
            @csrf
            <div class="modal-body text-right font-weight-bold row" dir="rtl">
                <div class="form-group col-lg-6">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القائمة الرئيسية
                    </label>
                    <select name="major_id" id="majors" class="form-select text-right" onchange="linkMinors(this)" required>
                        <option value="">-</option>
                        @foreach ($majors as $m)
                            <option value={{ $m->id }}>{{ $m->major_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        القائمة الفرعية
                    </label>
                    <select name="minor_id" id="minors" class="form-select text-right" required>
                        <option value="">-</option>
                        @foreach ($minors as $n)
                            <option value={{ $n->id }} class="{{ $n->major_id }}">{{ $n->minor_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الخاصية بالعربية
                    </label>
                    <input type="text" name="property_ar" class="form-control text-right" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        الخاصية بالإنجليزية
                    </label>
                    <input type="text" name="property_en" class="form-control text-right">
                </div>

                <div class="alert alert-primary text-right font-weight-bold col-lg-12">
                    <i class="mdi mdi-star text-danger"></i>
                    <label class="font-weight-bold">العمليات</label>
                </div>

                <div class="row text-right" align="right" dir="rtl">
                    @php $k=1; @endphp
                    @foreach ($operations as $p)
                        @php $pos = in_array($p['name'], $compare); @endphp
                        @if(!is_null($p['name']) && str_contains($p['path'], "api/v1") && $pos == FALSE)
                            <div class="col-lg-4" dir="rtl" style="font-size: .9375rem;">
                                <input value="{{ $p['name'] }}" name="proc[]" type="checkbox" class="form-check-input" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                                &nbsp;&nbsp;&nbsp;
                                {{ $k }}. {{ $p["name"] }}
                            </div>
                            @php $k++; @endphp
                        @endif
                    @endforeach
                </div>
                <br><br>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="حفظ" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
    </div>
</div>

@endsection
