@extends('welcome')

@section('content')
<script>
    function validateFrom(formName,event)
	{
        document.getElementById("en_details").value = document.getElementById("quillExample1").children[0].innerHTML;

        document.getElementById("ar_details").value = document.getElementById("quillExample2").children[0].innerHTML;

        document.forms[formName].submit();
	}
</script>
    <div class="card">

        <div class="card-header" dir="rtl">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">    نظام الولاء</a>
                        <li class="breadcrumb-item"><a href="#">  /  عن النظام</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  تعديل </span>
                    </li>
                </ol>
            </div>
        </div>


            <form method="POST" action="/loyaltyAbout" enctype="multipart/form-data" name="my-form" onsubmit="validateFrom('my-form',event)">
                @csrf
                <div class="card-body row" >
                    <div class="form-group col-lg-12">
                        <div class="text-primary-purple text-right" dir="rtl">
                            <i class="mdi mdi-star text-danger"></i>
                            النص بالعربية
                        </div>
                        <div id="quillExample2" class="quill-container text-right" style="text-align: right !important;">
                            {!! $loyaltyAbout["ar_about"] !!}
                        </div>
                        <textarea name="ar_about" id="ar_details" class="form-control" style="display: none;"></textarea>
                    </div>

                    <div><br><br><br><br></div>

                    <div class="form-group col-lg-12">
                        <div class="text-primary-purple text-right" dir="rtl">
                            النص بالإنجليزية
                        </div>
                        <div id="quillExample1" class="quill-container">
                            {!! $loyaltyAbout["en_about"] !!}
                        </div>
                        <textarea name="en_about" id="en_details" class="form-control" style="display: none;"></textarea>
                    </div>

                </div>

                <br><br>
                <div class="modal-footer justify-content-center" align="center">
                    <input type="submit" value="تعديل" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>
    </div>
@endsection
