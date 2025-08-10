@extends('welcome')

@section('content')


    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog text-right" role="document">
            <div class="modal-content" dir="rtl">
                <div class="modal-header align-self-center">
                    <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن مشترك الباقه المجانيه</b></h3>
                </div>
                <form method="GET" action="/free_trial_repot">
                    @csrf
                    <div class="modal-body text-right font-weight-bold" >
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">
                                رقم العضوية / رقم الهاتف
                            </label>
                            <input type="text" name="info" class="form-control text-right"><br>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">الحاله</label>
                            <select class="form-select" name="status" dir="rtl">
                                <option value="">-</option>
                                <option value="Completed">Completed</option>
                                <option value="Not-compleated">Not-compleated</option>
                            </select><br>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between" align="center">
                        <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card" dir="rtl">

        <div class="card-header" >
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">التقارير العامه</a>
                        <span class="breadcrumb-item active" aria-current="page">/ تقرير الإشتراك في الباقه المجانيه </span>
                    </li>

                    <div class="float-left">
                        <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat">
                            <i class="mdi mdi-magnify"></i>
                        </label>
                    </div>
                </ol>

            </div>
        </div>

        <div class="card-body">
            @if(count($subscribers) > 0)
            @php $i=1; @endphp
            <div class="table-responsive">
                <table class="table text-center" >
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">التاريخ</th>
                    <th class="font-weight-bold">رقم الهاتف</th>
                    <th class="font-weight-bold">رقم العضوية</th>
                    <th class="font-weight-bold">رقم الجهاز</th>
                    <th class="font-weight-bold">الحاله</th>
                </thead>

                <tbody>
                @foreach ($subscribers as $index => $subscriber)
                    <tr>
                        <td>{{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $index + 1 }}</td>
                        <td>{{ $subscriber->created_at }}</td>
                        <td>{{ $subscriber->phone }}</td>
                        <td>{{ $subscriber->membership_no }}</td>
                        <td>{{ $subscriber->ip_address }}</td>
                        <td>{!! ($subscriber->status == 'Completed') ? "<span class='btn btn-sm btn-success'>$subscriber->status</span>" : "<span class='btn btn-sm btn-danger'>$subscriber->status</span>" !!}</td>

                    </tr>
                @endforeach
                </tbody>
                </table>
            </div><br><br><br>

            
            <div class="d-flex justify-content-center">
                {{ $subscribers->links('pagination::bootstrap-4') }}
            </div>

            @else
            <div class="alert alert-fill-primary text-right" role="alert" >
                <i class="typcn typcn-warning"></i>لا توجد بيانات</div>
            @endif
        </div>

    </div>

@endsection
