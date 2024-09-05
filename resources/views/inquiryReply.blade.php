@extends('welcome')

@section('content')

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>الرد على الإستفسار</b></h3>
        </div>
        <form method="POST" action="/inquiryAnswer/{{ $inquiry->id }}">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        الرد
                    </label>
                    <textarea name="reply" class="form-control text-right" required></textarea>
                </div>
            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="إرسال عبر البريد الإلكتروني" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

            <div class="card">
                <div class="card-header" dir="rtl">

                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb bg-inverse-primary justify-content-between">
                          <li class="breadcrumb-item"><a href="#">    الأسئلة والإستفسارات</a>
                            <span class="breadcrumb-item active" aria-current="page"> /   التفاصيل </span>
                           </li>

                          <a class="badge badge-primary text-white" href="javascript:;" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                            <i class="mdi mdi-gmail"></i>
                          </a>
                        </ol>

                    </div>
                </div>

                <div class="card-body">
                    <div class="mt-5">
                        <div class="timeline">
                            <div class="timeline-wrapper timeline-inverted timeline-wrapper-warning">
                                <div class="timeline-badge"></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                    <h6 class="timeline-title">{{ $inquiry->phone }}</h6>
                                    </div>
                                    <div class="timeline-body">
                                    <p>{{ $inquiry->email }}</p>
                                    <p>{{ $inquiry->message }}</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="mdi mdi-comment-question-outline text-muted mr-1"></i>
                                        <span class="ml-md-auto font-weight-bold">{{ date('d M, Y', strtotime($inquiry->created_at))  }}</span>
                                    </div>
                                </div>
                            </div>
                            @foreach ($inquiry->reply as $reply)
                            <div class="timeline-wrapper timeline-wrapper-danger">
                                <div class="timeline-badge"></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                    <h6 class="timeline-title">{{ $reply->name }}</h6>
                                    </div>
                                    <div class="timeline-body">
                                    <p>{{ $reply->reply }}</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="mdi mdi-message-reply-text text-muted mr-1"></i>
                                        <span class="ml-md-auto font-weight-bold">
                                            {{ date('d M, Y', strtotime($reply->created_at))  }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
