@extends('welcome')

@section('content')

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل  بيانات نظام الولاء</b></h3>
        </div>
        <form method="POST" action="/loyaltyAbout">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group text-right">
                    <label for="exampleInputUsername1" class="text-primary-purple">عن النظام</label>
                    <textarea name="about" cols="30" rows="10" class="form-control text-right">{{ $loyaltyAbout["ar_about"] }}</textarea>
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
                      <li class="breadcrumb-item"><a href="#">    نظام الولاء</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  عن النظام </span>
                       </li>

                      <a href="/editLoyaltyAbout" class="badge badge-primary text-white" >
                        <i class="mdi mdi-pencil"></i>
                      </a>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        <div class="text-right" align="right">
            <label>النص بالعربية</label>
            <blockquote class="blockquote text-right">
               {!! $loyaltyAbout["ar_about"] !!}
            </blockquote>
        </div>
        <br><br>
        @if(!is_null($loyaltyAbout["en_about"]))
            <div class="text-left" align="left">
                <label>English Text</label>
                <blockquote class="blockquote text-left">
                    {!! $loyaltyAbout["en_about"] !!}
                </blockquote>
            </div>
        @endif
    </div>

</div>

@endsection
