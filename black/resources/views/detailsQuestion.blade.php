@extends('welcome')

@section('content')

            <div class="card">
                <div class="card-header" dir="rtl">

                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb bg-inverse-primary justify-content-between">
                          <li class="breadcrumb-item"><a href="#">    الأسئلة والإستفسارات</a>
                            <span class="breadcrumb-item active" aria-current="page"> /   التفاصيل </span>
                           </li>

                          <a class="badge badge-primary text-white" href="/answerQuestion/{{ $question['id'] }}">
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
                                    <h6 class="timeline-title">{{ $question['name'] }}</h6>
                                    </div>
                                    <div class="timeline-body">
                                    <p>{{ $question['message'] }}</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="mdi mdi-comment-question-outline text-muted mr-1"></i>
                                        <span class="ml-md-auto font-weight-bold">{{ date('d M, Y', strtotime($question['created_at']))  }}</span>
                                    </div>
                                </div>
                            </div>
                            @foreach ($answers as $answer)
                            <div class="timeline-wrapper timeline-wrapper-danger">
                                <div class="timeline-badge"></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                    <h6 class="timeline-title">{{ $answer->name }}</h6>
                                    </div>
                                    <div class="timeline-body">
                                    <p>{{ $answer->answer }}</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="mdi mdi-message-reply-text text-muted mr-1"></i>
                                        <span class="ml-md-auto font-weight-bold">
                                            {{ date('d M, Y', strtotime($answer->created_at))  }}
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
