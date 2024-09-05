@extends('welcome')

@section('content')

<div class="modal fade text-primary-purple" id="infoo" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title"><b>تعديل بيانات الشركة</b></h3>
        </div>
        <div class="modal-body text-right font-weight-bold" dir="rtl">
          <form method="post" action="/editInfo" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label class="col-form-label">إسم الشركة بالعربية</label>
              <input type="text" name="name_ar" class="form-control" value="{{$info->name_ar }}" required>
            </div>
            
            <div class="form-group">
                <label class="col-form-label">  الرقم الضريبي</label>
                <input type="text" name="tax_no" class="form-control" value="{{$info->tax_no }}" required>
              </div>
            <div class="form-group">
              <label class="col-form-label">إسم الشركة بالإنجليزية</label>
              <input type="text" name="name_en" class="form-control" value="{{$info->name_en }}" required>
            </div>
            <div class="form-group">
              <label class="col-form-label"> العنوان بالعربية</label>
              <input type="text" name="address_ar" class="form-control" value="{{$info->address_ar }}" required>
            </div>
            <div class="form-group">
              <label class="col-form-label"> العنوان بالإنجليزية</label>
              <input type="text" name="address_en" class="form-control" value="{{$info->address_en }}" required>
            </div>

            <div class="form-group">
              <label class="col-form-label"> رقم الهاتف</label>
              <input type="text" name="phone" class="form-control" value="{{$info->phone }}" required>
            </div>
            <div class="form-group">
              <label class="col-form-label"> البريد الإلكتروني</label>
              <input type="text" name="email" class="form-control" value="{{$info->email }}" required>
            </div>
            <div class="form-group">
                <label> شعار الشركة</label>
                <input type="file" name="logo" class="form-control">

            </div>
            <div class="form-group">
                <label> شعار الشركة الخاص بالفواتير</label>
                <input type="file" name="bill" class="form-control">

            </div>

        </div>
        <div class="modal-footer justify-content-center" align="center">
          <input type="submit" value="تعديل" class="btn btn-primary">
        </div>

    </form>
      </div>
    </div>
</div>

{{--  <div class="card">
    <div class="card-body">
        <div class="row">
                    <div class="col-lg-12">
                      <div class="border-bottom text-center pb-4">

                      <!-- div class="row portfolio-grid">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                          <figure class="effect-text-in">
                            <img src="{{$info->logo}}" alt="image"/>
                            <figcaption>
                              <p class="file-upload-browse">edit</p>
                            </figcaption>
                          </figure>
                        </div></div-->

                        <img src="/public/{{$info->logo}}" alt="profile" class="img-lg rounded-circle mb-3"/> xx
                        &nbsp; &nbsp;
                        <img src="/public/{{$info->bill}}" alt="profile" class="img-lg rounded-circle mb-3"/>

                        <div class="mb-3">
                          <h3>{{$info->name_en}} - {{$info->name_ar}}</h3>

                        </div>
                        <p class="w-75 mx-auto mb-3">{{$info->address}}. </p>
                        <div class="d-flex justify-content-center">
                          <button class="btn btn-primary btn-lg"  data-bs-toggle="modal" data-bs-target="#infoo" data-whatever="@fat">تعديل البيانات</button>
                        </div>
                      </div>

                      <div class="py-4" dir="rtl">
                        <p class="clearfix">
                          <span class="float-right font-weight-bold">
                            العنوان بالعربية
                          </span>
                          <span class="float-right">
                           : &nbsp; &nbsp; {{$info->address_ar}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-right font-weight-bold">
                            العنوان بالإنجليزية
                          </span>
                          <span class="float-right">
                              : &nbsp; &nbsp; {{$info->address_en}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-right font-weight-bold">
                            رقم الهاتف
                          </span>
                          <span class="float-right">
                            : &nbsp; &nbsp;  {{$info->phone}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-right font-weight-bold">
                            البريد الإلكتروني
                          </span>
                          <span class="float-right">
                             : &nbsp; &nbsp; {{$info->email}}
                          </span>
                        </p>
                      </div>

                    </div>
                    </div>

    </div>  --}}


                    <div class="card">
                        <div class="card-header justify-content-between" style="display: flex !important;">
                            <img class="img-lg rounded-circle mb-3" src="{{$info->logo}}" alt="logo"/>
                            <h4 class="card-title">
                                {{$info->name_en}} - {{$info->name_ar}} <br><br><br>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary btn-lg"  data-bs-toggle="modal" data-bs-target="#infoo" data-whatever="@fat">تعديل البيانات</button>
                                </div>
                            </h4>
                            <img class="img-lg rounded-circle mb-3" src="{{$info->bill}}" alt="bill"/>
                        </div>

                        <div class="card-body" dir="rtl">

                            <div class="list-wrapper">
                                <ul class="d-flex flex-column-reverse todo-list">
                                    <li class="rtl">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="radio" checked>
                                                البريد الإلكتروني: {{ $info->email }}
                                            </label>
                                        </div>
                                    </li>
                                    <li class="rtl">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="radio" checked>
                                                رقم الهاتف : {{ $info->phone }}
                                            </label>
                                        </div>
                                    </li>
                                    <li class="rtl">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="radio" checked>
                                                الرقم الضريبي  : {{ $info->tax_no }}
                                            </label>
                                        </div>
                                    </li>
                                    <li class="rtl">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="radio" checked>
                                                العنوان بالإنجليزية : {{ $info->address_en }}
                                            </label>
                                        </div>
                                    </li>
                                    <li class="rtl">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="radio" checked>
                                                العنوان بالعربية : {{ $info->address_ar }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
</div>


@endsection
