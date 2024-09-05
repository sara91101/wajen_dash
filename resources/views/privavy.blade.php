@extends("welcome")

@section("content")
<div class="row" dir="rtl">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">
                            سياسة الخصوصية</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>

                    <a class="badge badge-primary text-white" href="/addPrivacy">
                        <i class="mdi mdi-plus"></i>
                    </a>
                </ol>

                </div>
            </div>
            <div class="card-body">
            <div class="mt-4">
                <div class="accordion" id="accordion" role="tablist">
                @php $f=1; @endphp
                @foreach ($privacy as $pr)
                @php $s=1; @endphp
                <div class="card">
                    <div class="card-header" role="tab" id="heading-1">
                        <h6 class="mb-0">
                            <a data-bs-toggle="collapse" href="#collapse-{{ $pr->id }}" aria-expanded="true" aria-controls="collapse-1">
                            {{ $pr->ar_first }}
                            </a>
                        </h6>
                    </div>
                    <div id="collapse-{{ $pr->id }}" class="collapse show" role="tabpanel" aria-labelledby="heading-1" data-bs-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-9">
                                <p class="mb-0">
                                    @foreach ($pr["second"] as $second)
                                    <p>{{ $s }}. {!! $second->ar_second !!}</p>
                                    @php $s++; @endphp
                                    @if(!is_null($second["third"]))
                                        <ul>
                                        @foreach ($second["third"] as $third)
                                            <li>{!! $third->ar_third !!}</li>
                                        @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                                </p>
                            </div>
                            </div>
                        </div>
                        <div class="card-footer justify-content-between" style="display: flex ;justify-content:space-between">
                                <a align="right" href="/editPrivacy/{{ $pr->id }}" class="badge badge-pill badge-primary text-white">
                                        <i class="mdi mdi-pencil"></i>
                                </a>
                                <label align="left" onclick="destroyItem('destroyPrivacy',{{ $pr->id }})"  class="badge badge-pill badge-danger text-white">
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
