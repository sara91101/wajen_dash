@extends('welcome')

@section('content')
<script>
    function validateFrom(formName,event)
	{
        document.getElementById("en_details").value = document.getElementById("quillExample1").children[0].innerHTML;

        document.getElementById("ar_details").value = document.getElementById("quillExample2").children[0].innerHTML;

        document.forms[formName].submit();
	}




    function addKeyword()
    {
        var myDiv = document.createElement("div");
        myDiv.classList.add("col-lg-12");
        myDiv.classList.add("row");
        myDiv.innerHTML += '<div class="form-group col-lg-5" dir="rtl">'+
            '<input type="text" name="ar_keyword[]" class="form-control text-right" placeholder="بالعربية">'+
            '</div><div class="form-group col-lg-5" dir="rtl">'+
            '<input type="text" name="en_keyword[]" class="form-control text-left" placeholder="بالإنجليزية">'+
            '</div>'+
            '<div class="col-lg-2"><div class="form-group"><span><label class="btn btn-sm btn-danger" onclick="removeDiv(this)"><i class="mdi mdi-delete"></i></label></span></div></div></div>';

        var div = document.getElementById("keywords");

        div.append(myDiv);
    }

    function removeDiv(row)
    {
        var d = row.parentNode.parentNode.parentNode.parentNode.remove();
    }
</script>
    <div class="card">

        <div class="card-header" dir="rtl">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">    المٌدونة</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  تعديل مقال </span>
                    </li>
                </ol>
            </div>
        </div>


            <form method="POST" action="/updateBlog/{{ $blog->id }}" enctype="multipart/form-data" name="my-form" onsubmit="validateFrom('my-form',event)">
                @csrf
                <div class="card-body row" >

                    <div class="form-group col-lg-6" dir="rtl">
                        <label class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                            العنوان بالعربية
                        </label>
                        <input type="text" value="{{ $blog->ar_title }}" name="ar_title" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-6" dir="rtl">
                        <label class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                            القسم
                        </label>
                        <select class="form-select" name="department_id">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if($blog->department_id == $department->id) selected @endif>
                                    {{ $department->ar_department }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6" dir="rtl">
                        <div  class="text-primary-purple text-right">صورة توضيحية </div>
                        <input type="file" name="image" accept="image/png, image/jpeg, image/jpg" />
                    </div>

                    <div class="form-group col-lg-6" dir="rtl">
                        <label class="text-primary-purple">العنوان بالإنجليزية</label>
                        <input type="text" value="{{ $blog->en_title }}" name="en_title" class="form-control text-left">
                    </div>

                    <div class="form-group col-lg-12">
                        <div class="text-primary-purple text-right" dir="rtl">
                            <i class="mdi mdi-star text-danger"></i>
                            التفاصيل بالعربية
                        </div>
                        <div id="quillExample2" class="quill-container text-right" style="text-align: right !important;">
                            {!! $blog->ar_details !!}
                        </div>
                        <textarea name="ar_details" id="ar_details" class="form-control" style="display: none;"></textarea>
                    </div>

                    <div><br><br><br><br></div>

                    <div class="form-group col-lg-12">
                        <div class="text-primary-purple text-right" dir="rtl">
                            التفاصيل بالإنجليزية
                        </div>
                        <div id="quillExample1" class="quill-container">
                            {!! $blog->en_details !!}
                        </div>
                        <textarea name="en_details" id="en_details" class="form-control" style="display: none;"></textarea>
                    </div>

                    <div><br><br><br><br></div>

                <div id="keywords" class="col-lg-12 row" dir="rtl">
                    <div class="col-lg-12" dir="rtl">
                        <h4 class="text-primary-purple">
                            <span class="btn btn-sm btn-success" onclick="addKeyword()">
                                <i class="mdi mdi-plus"></i>
                            </span>
                            الكلمات الدًالة
                        </h4>
                    </div>

                    @foreach($blog['keyword'] as $keyword)
                        <div class="col-lg-12 row">
                            <div class="form-group col-lg-5" dir="rtl">
                                <input type="text" value="{{ $keyword->ar_keyword }}" name="ar_keyword[]" class="form-control text-right" placeholder="بالعربية">
                            </div>
                            <div class="form-group col-lg-5" dir="rtl">
                                <input type="text" value="{{ $keyword->en_keyword }}" name="en_keyword[]" class="form-control text-left" placeholder="بالإنجليزية">
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <span><label class="btn btn-sm btn-danger" onclick="removeDiv(this)">
                                        <i class="mdi mdi-delete"></i></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                </div>

                <br><br>
                <div class="modal-footer justify-content-center" align="center">
                    <input type="submit" value="تعديل" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>
    </div>
@endsection
