@extends('welcome')

@section('content')

    <script>
        function editSlider(slider_id,slider_order)
        {
            document.getElementById("slider_id").value = slider_id;
            document.getElementById("ar_image_text").value = document.getElementById("ar_image"+slider_id).innerHTML;
            document.getElementById("en_image_text").value = document.getElementById("en_image"+slider_id).innerHTML;
            document.getElementById("image_order").value = slider_order;

            $("#edit").modal("show");
        }
    </script>

    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header align-self-center">
                <h3 align="center" class="modal-title text-primary-purple"><b>إضافة محرك الصور - نظام الولاء</b></h3>
            </div>
            <form method="POST" action="/loyaltySlider" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">العنوان بالعربية </label>
                        <input type="text" name="ar_image_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">العنوان بالإنجليزية </label>
                        <input type="text" name="en_image_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">  الصورة</label>
                        <input type="file" name="image" class="form-control text-right" accept="image/png, image/jpg, image/jpeg" required>
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple"> الترتيب </label>
                        <input type="number" name="image_order" min="1" class="form-control text-right">
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
                <h3 align="center" class="modal-title text-primary-purple"><b>تعديل محرك الصور - نظام الولاء</b></h3>
            </div>
            <form method="POST" action="/editLoyaltySlider" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="slider_id" name="slider_id" class="form-control text-right">

                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">العنوان بالعربية </label>
                        <input type="text" id="ar_image_text" name="ar_image_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">العنوان بالإنجليزية </label>
                        <input type="text" id="en_image_text" name="en_image_text" class="form-control text-right">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">  الصورة</label>
                        <input type="file" name="image" class="form-control text-right" accept="image/png, image/jpg, image/jpeg">
                    </div>
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple"> الترتيب </label>
                        <input type="number" id="image_order" name="image_order" min="1" class="form-control text-right">
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
                            <span class="breadcrumb-item active" aria-current="page"> /   الصور المتحركة </span>
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
                            <th>العنوان بالعربية</th>
                            <th>العنوان بالإنجليزية</th>
                            <th>العمليات</th>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($loyaltySliders as $slider)
                            <tr>
                                <td>{{ $i }}</td>
                                <td class="py-1">
                                    <img src="https://back.skilltax.sa/public{{ $slider['image_path'] }}" alt="image"/></td>
                                <td id="ar_image{{ $slider['id'] }}">{{ $slider['ar_image_text'] }}</td>
                                <td id="en_image{{ $slider['id'] }}">{{ $slider['en_image_text'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editSlider({{ $slider['id'] }},{{ $slider['image_order'] }})">
                                        <i class="typcn typcn-edit btn-icon-append"></i>
                                            تعديل
                                    </a>
                                    &nbsp;&nbsp;
                                    <a onclick="destroyItem( 'loyaltySlider', {{ $slider['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
