@extends('welcome')

@section('content')


    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog text-right" role="document">
            <div class="modal-content" dir="rtl">
                <div class="modal-header align-self-center">
                    <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن تسجيل الدخول</b></h3>
                </div>
                <form method="GET" action="/skilltaxLoginReport">
                    @csrf
                    <div class="modal-body text-right font-weight-bold" >
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">
                                رقم العضوية
                            </label>
                            <input type="text" name="membership_no" class="form-control text-right"><br>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">الحاله</label>
                            <select class="form-select" name="status" dir="rtl">
                                <option value="">-</option>
                                <option value="success">Success</option>
                                <option value="failed">Failed</option>
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
                    <li class="breadcrumb-item"><a href="#"> تقاير سكيل تاكس</a>
                        <span class="breadcrumb-item active" aria-current="page">/ تقرير تسجيل الدخول </span>
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
            @if(count($logins) > 0)
            @php $i=1; @endphp
            <div class="table-responsive">
                <table class="table text-center" >
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">الزمن</th>
                    <th class="font-weight-bold">رقم العضوية</th>
                    <th class="font-weight-bold">رقم الجهاز</th>
                    <th class="font-weight-bold">الموقع</th>
                    <th class="font-weight-bold">الحاله</th>
                    <th class="font-weight-bold">الرساله</th>
                    {{-- <th class="font-weight-bold">حذف</th> --}}
                </thead>

                <tbody>
                @foreach ($logins as $index => $record)
                    <tr>
                        <td>{{ ($logins->currentPage() - 1) * $logins->perPage() + $index + 1 }}</td>
                        <td>{{ $record['login_time'] }}</td>
                        <td>{{ $record['membership_no'] }}</td>

                        <td>{{ $record['ip_address'] }}</td>

                        <td>{{ $record['country'] }} -  {{ $record['city'] }}</td>
                        <td>{{ $record['status'] }}</td>
                        <td>{{ $record['response_message'] }}</td>
                        {{-- <td><i class="bx bx-delete"></i></td> --}}

                    </tr>
                @endforeach
                </tbody>
                </table>
            </div><br><br><br>

            
            <div class="d-flex justify-content-center">
                {{ $logins->links('pagination::bootstrap-4') }}
            </div>

            @else
            <div class="alert alert-fill-primary text-right" role="alert" >
                <i class="typcn typcn-warning"></i>لا توجد بيانات</div>
            @endif
        </div>

    </div>

@endsection
