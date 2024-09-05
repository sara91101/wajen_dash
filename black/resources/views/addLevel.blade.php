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
</script>

<div class="card">

    <div class="card-header" dir="rtl">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-inverse-primary justify-content-between">
                <li class="breadcrumb-item"><a href="#">     الصلاحيات</a>
                    <span class="breadcrumb-item active" aria-current="page"> /  إضافة </span>
                </li>
            </ol>
        </div>
    </div>

    <div class="card-body">
            <form method="POST" action="/newLevel">
                @csrf
                <div class="modal-body text-right font-weight-bold row" dir="rtl">
                    <div class="form-group col-lg-12">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                            الصلاحية
                        </label>
                        <input type="text" name="level" class="form-control text-right" required>
                    </div>

                    @foreach ($pages as $page)
                        <div class="alert alert-primary justify-content-between text-right font-weight-bold col-lg-12 pages">
                            <label class="font-weight-bold" style="float: right !important;">{{ $page->page }}</label>
                            <input  style="float: left !important;"  class="form-check-input" type="checkbox" id="success2-check" onchange="checkAll(this,'page{{ $page->id }}')">
                        </div>

                        <div class="row pages text-right  col-lg-12" align="right" dir="rtl">
                            @foreach ($page["subPage"] as $subPage)
                                <div class="col-lg-4" dir="rtl" style="font-size: .9375rem;">
                                    <input value="{{ $subPage->id }}" name="page{{ $page->id }}[]" type="checkbox" class="form-check-input page{{ $page->id }}" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                                    &nbsp;&nbsp;&nbsp;
                                    {{ $subPage->sub_page }}
                                </div>
                                <br>
                            @endforeach
                            <br>
                        </div>

                    @endforeach
                </div>
                <div class="modal-footer justify-content-center" align="center">
                    <input type="submit" value="حفظ" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>
    </div>
</div>

@endsection
