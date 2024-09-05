@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editfaq(faq_id)
    {
        document.getElementById("faq_id").value = faq_id;
        document.getElementById("ar_question").value = document.getElementById("faqAr"+faq_id).innerHTML;
        document.getElementById("en_question").value = document.getElementById("faqEn"+faq_id).innerHTML;
        document.getElementById("ar_answer").value = document.getElementById("answerAr"+faq_id).innerHTML;
        document.getElementById("en_answer").value = document.getElementById("answerEn"+faq_id).innerHTML;
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة الأسئلة المتكرره - نظام الولاء </b></h3>
        </div>
        <form method="POST" action="/loyaltyFAQ">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        السؤال بالعربية
                    </label>
                    <input type="text" name="ar_question" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الإجابة بالعربية
                    </label>
                    <textarea name="ar_answer" class="form-control text-right" required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">السؤال بالإنجليزية</label>
                    <input type="text" name="en_question" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">

                        الإجابة بالإنجليزية
                    </label>
                    <textarea name="en_answer" class="form-control text-right" ></textarea>
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
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل  الأسئلة المتكررة</b></h3>
        </div>
        <form method="POST" action="/editLoyaltyFAQ">
            @csrf
            <input type="hidden" name="faq_id" id="faq_id">

            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        السؤال بالعربية
                    </label>
                    <input type="text" name="ar_question" id="ar_question" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الإجابة بالعربية
                    </label>
                    <textarea name="ar_answer" id="ar_answer" class="form-control text-right" required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">السؤال بالإنجليزية</label>
                    <input type="text" name="en_question" id="en_question" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        الإجابة بالإنجليزية
                    </label>
                    <textarea name="en_answer" id="en_answer" class="form-control text-right"></textarea>
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
                      <li class="breadcrumb-item"><a href="#">    الإعدادات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  الأسئلة المتكررة </span>
                       </li>

                      <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                        <i class="mdi mdi-plus"></i>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($faqs) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">السؤال بالعربية</th>
                <th class="font-weight-bold">الإجابة بالعربية</th>
                <th class="font-weight-bold">السؤال بالإنجليزية</th>
                <th class="font-weight-bold">الإجابة بالإنجليزية</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($faqs as $faq)
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="faqAr{{ $faq['id'] }}">{{ $faq['question_ar'] }}</td>
                    <td id="answerAr{{ $faq['id'] }}">{{ $faq['answer_ar'] }}</td>
                    <td id="faqEn{{ $faq['id'] }}">{{ $faq['question_en'] }}</td>
                    <td id="answerEn{{ $faq['id'] }}">{{ $faq['answer_en'] }}</td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editfaq({{ $faq['id'] }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'loyaltyFAQ', {{ $faq['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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


        @else
        <div class="alert alert-fill-primary text-right" role="alert" dir="rtl">
            <i class="typcn typcn-warning"></i>
            لا توجد بيانات
        </div>
        @endif
    </div>



</div>

@endsection
