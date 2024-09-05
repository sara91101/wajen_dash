@extends("welcome")

@section("content")
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">
                             نظام الولاء</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  الشروط والأحكام </span>
                        </li>

                    <a class="badge badge-primary text-white" href="/addLoyaltyCondition">
                        <i class="mdi mdi-plus"></i>
                    </a>
                </ol>

                </div>
            </div>
            <div class="card-body">
            <div class="mt-4">
                <div class="accordion row" id="accordion" role="tablist">
                    @php $f=1; @endphp
                    @foreach ($conditions as $condition)
                        <div class="card col-6">
                            <div class="card-header" role="tab" id="heading-1">
                                <h6 class="mb-0">
                                    <a data-bs-toggle="collapse" href="#collapse-{{ $condition['id'] }}" aria-expanded="true" aria-controls="collapse-1">
                                        {{ $condition['en_title'] }}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-{{ $condition['id'] }}" class="collapse show" role="tabpanel" aria-labelledby="heading-1" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-9">
                                        <p class="mb-0">
                                            <p>{!! $condition['en_details'] !!}</p>
                                        </p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer justify-content-between" style="display: flex ;justify-content:space-between">
                                        <a align="right" href="/editLoyaltyCondition/{{ $condition['id'] }}" class="badge badge-pill badge-primary text-white">
                                                <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <label align="left" onclick="destroyItem('destroyLoyaltyCondition',{{ $condition['id'] }})"  class="badge badge-pill badge-danger text-white">
                                                <i class="mdi mdi-delete"></i>
                                        </label>
                                </div>
                            </div>
                        </div>

                        <div class="card col-6" dir="rtl">
                            <div class="card-header" role="tab" id="heading-1">
                                <h6 class="mb-0">
                                    <a data-bs-toggle="collapse" href="#collapse-{{ $condition['id'] }}" aria-expanded="true" aria-controls="collapse-1">
                                        {{ $condition['ar_title'] }}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-{{ $condition['id'] }}" class="collapse show" role="tabpanel" aria-labelledby="heading-1" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-9">
                                        <p class="mb-0">
                                            <p>{!! $condition['ar_details'] !!}</p>
                                        </p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer justify-content-between" style="display: flex ;justify-content:space-between">
                                        <a align="right" href="/editLoyaltyCondition/{{ $condition['id'] }}" class="badge badge-pill badge-primary text-white">
                                                <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <label align="left" onclick="destroyItem('destroyLoyaltyCondition',{{ $condition['id'] }})"  class="badge badge-pill badge-danger text-white">
                                                <i class="mdi mdi-delete"></i>
                                        </label>
                                </div>
                            </div>
                        </div>
                        @php $f++; @endphp
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection
