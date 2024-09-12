@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editblog(blog_id)
    {
        document.getElementById("blog_id").value = blog_id;

        let dept = document.getElementById("dept"+blog_id).innerHTML;

        document.getElementById("ar_title").value = document.getElementById("blogAr"+blog_id).innerHTML;
        document.getElementById("en_title").value = document.getElementById("blogEn"+blog_id).innerHTML;
        document.getElementById("ar_details").value = document.getElementById("detailsAr"+blog_id).innerHTML;
        document.getElementById("en_details").value = document.getElementById("detailsEn"+blog_id).innerHTML;

        var drop = document.getElementById("department_id");
        for(let k =0; k < drop.length; k++)
        {
            if(drop[k].value == dept) {drop[k].selected = true;}
            else {drop[k].selected = false;}
        }

        $("#edit").modal("show");
    }

    function showDetails(details)
    {
        document.getElementById("blog_det").innerHTML = document.getElementById(details).innerHTML;

        $("#details").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة </b></h3>
        </div>
        <form method="POST" action="/blogs" enctype="multipart/form-data">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         القسم
                    </label>
                    <select class="form-select" name="department_id">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->ar_department }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        العنوان بالعربية
                    </label>
                    <input type="text" name="ar_title" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        التفاصيل بالعربية
                    </label>
                    <textarea name="ar_details" class="form-control text-right" required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">العنوان بالإنجليزية</label>
                    <input type="text" name="en_title" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        التفاصيل بالإنجليزية
                    </label>
                    <textarea name="en_details" class="form-control text-right"></textarea>
                </div>

                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">صورة توضيحية </label>
                    <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" />
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل مقال</b></h3>
        </div>
        <form method="POST" action="/updateBlog" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="blog_id" id="blog_id">

            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         القسم
                    </label>
                    <select class="form-select" name="department_id" id="department_id">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->ar_department }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        العنوان بالعربية
                    </label>
                    <input type="text" name="ar_title" id="ar_title" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        التفاصيل بالعربية
                    </label>
                    <textarea name="ar_details" id="ar_details" class="form-control text-right" required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">العنوان بالإنجليزية</label>
                    <input type="text" name="en_title" id="en_title" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        التفاصيل بالإنجليزية
                    </label>
                    <textarea name="en_details" id="en_details" class="form-control text-right" required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">صورة توضيحية </label>
                    <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" />
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="تعديل" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>تفاصيل المقال</b></h3>
        </div>

        <div class="modal-body text-center">
            <blockquote class="blockquote" id="blog_det"></blockquote>
        </div>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                      <li class="breadcrumb-item"><a href="#">    الإعدادات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /   المدونة </span>
                       </li>

                      <a href="/createBlog" class="badge badge-primary text-white">
                        <i class="mdi mdi-plus"></i>
                      </a>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($blogs) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"></th>
                <th class="font-weight-bold">القسم</th>
                <th class="font-weight-bold">العنوان بالعربية</th>
                <th class="font-weight-bold">العنوان بالإنجليزية</th>
                <th class="font-weight-bold"></th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($blogs as $blog)
            <p id="detailsAr{{ $blog->id }}" style="display: none;">{{  $blog->ar_details  }}</p>
            <p id="detailsEn{{ $blog->id }}" style="display: none;">{{  $blog->en_details  }}</p>
                <tr>
                    <td >{!! $i !!}</td>
                    <td>
                        @if(!is_null($blog->image))
                        <img src="{{ $blog->image }}" class="img-lg rounded" alt="blog image"/>
                        @endif
                    </td>
                    <spane id="dept{{ $blog->id }}" style="display: none;">{{ $blog->department_id }}</spane>
                    <td>{{ $blog->ar_department }}</td>
                    <td id="blogAr{{ $blog->id }}">{{ $blog->ar_title }}</td>
                    <td id="blogEn{{ $blog->id }}">{{ $blog->en_title }}</td>
                    <td>
                        @if($blog->starred == 0)
                        <a href="/starBlog/{{ $blog->id }}/1">
                            <i class="mdi mdi-star-outline text-warning"></i>
                        </a>
                        @else
                        <a href="/starBlog/{{ $blog->id }}/0">
                            <i class="mdi mdi-star text-success"></i>
                        </a>
                        @endif
                    </td>
                    <td>
                        <a href="/blog/{{ $blog->id }}" class="btn btn-sm btn-info btn-icon-text me-3">
                            <i class="mdi mdi-eye"></i>
                        </a>

                        <a href="/editBlog/{{ $blog->id }}" class="btn btn-success btn-sm btn-icon-text me-3">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyBlog', {{ $blog->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                        </a>
                    </td>

                </tr>
                @php $i++; @endphp
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
            {{ $blogs->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
