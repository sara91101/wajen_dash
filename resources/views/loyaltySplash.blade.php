@extends('welcome')

@section('content')

    <script>
        function editSplash(Splash_id)
        {
            document.getElementById("Splash_id").value = Splash_id;
            document.getElementById("ar_image_text").value = document.getElementById("ar_image"+Splash_id).innerHTML;
            document.getElementById("en_image_text").value = document.getElementById("en_image"+Splash_id).innerHTML;

            $("#edit").modal("show");
        }
    </script>

    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header align-self-center">
                <h3 align="center" class="modal-title text-primary-purple"><b>إضافة الصور البدائية - نظام الولاء</b></h3>
            </div>
            <form method="POST" action="/loyaltySplash" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">النص بالعربية </label>
                        <input type="text" name="ar_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">النص بالإنجليزية </label>
                        <input type="text" name="en_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">  الصورة</label>
                        <input type="file" name="image" class="form-control text-right" accept="image/png, image/jpg, image/jpeg" required>
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
                <h3 align="center" class="modal-title text-primary-purple"><b>تعديل الصور البدائية - نظام الولاء</b></h3>
            </div>
            <form method="POST" action="/editLoyaltySplash" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="Splash_id" name="splash_id" class="form-control text-right">

                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">النص بالعربية </label>
                        <input type="text" id="ar_image_text" name="ar_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">النص بالإنجليزية </label>
                        <input type="text" id="en_image_text" name="en_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">  الصورة</label>
                        <input type="file" name="image" class="form-control text-right" accept="image/png, image/jpg, image/jpeg">
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
                            <span class="breadcrumb-item active" aria-current="page"> /   الصور البدائية </span>
                        </li>

                        <a href="/editLoyaltyAbout" class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                            <i class="mdi mdi-plus"></i>
                        </a>
                        </ol>

                    </div>
        </div>

        @php $i=1; @endphp
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" dir="rtl">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>النص بالعربية</th>
                            <th>النص بالإنجليزية</th>
                            <th>العمليات</th>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($loyaltySplashes as $Splash)
                            <tr>
                                <td>{{ $i }}</td>
                                <td class="py-1">
                                    <img src="https://back.skilltax.sa/public{{ $Splash['image'] }}" alt="image"/></td>
                                <td id="ar_image{{ $Splash['id'] }}">{{ $Splash['ar_text'] }}</td>
                                <td id="en_image{{ $Splash['id'] }}">{{ $Splash['en_text'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editSplash({{ $Splash['id'] }})">
                                        <i class="typcn typcn-edit btn-icon-append"></i>
                                            تعديل
                                    </a>
                                    &nbsp;&nbsp;
                                    <a onclick="destroyItem( 'loyaltySplash', {{ $Splash['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
        </div>
    </div>


@endsection
