@extends("welcome")

@section("content")
<div class="row" dir="rtl">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">
                             المدُونة</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض لمقال </span>
                        </li>

                </ol>

                </div>
            </div>
            <div class="card-body">
            <div class="mt-4">
                <div class="accordion" id="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" role="tab" id="heading-1">
                            <h6 class="mb-0">
                                <a data-bs-toggle="collapse" href="#collapse-ar" aria-expanded="true" aria-controls="collapse-1">
                                {{ $blog->ar_title }}
                                </a>
                            </h6>
                        </div>
                        <div id="collapse-ar" class="collapse show" role="tabpanel" aria-labelledby="heading-1" data-bs-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-9">
                                    <p class="mb-0">
                                        {!! $blog->ar_details !!}
                                    </p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="heading-1">
                            <h6 class="mb-0">
                                <a data-bs-toggle="collapse" href="#collapse-en" aria-expanded="true" aria-controls="collapse-1">
                                {{ $blog->en_title }}
                                </a>
                            </h6>
                        </div>
                        <div id="collapse-en" class="collapse show" role="tabpanel" aria-labelledby="heading-1" data-bs-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-9">
                                    <p class="mb-0">
                                        {!! $blog->en_details !!}
                                    </p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection
