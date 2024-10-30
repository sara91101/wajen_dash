@extends('welcome')

@section('content')
    @php
        $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
        if ($page <= 0) $page = 1;

        $per_page = 15;

        $i = ($page * $per_page) - $per_page + 1;
    @endphp



    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog text-right" role="document">
            <div class="modal-content" dir="rtl">
                <div class="modal-header align-self-center">
                    <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن المدفوعات</b></h3>
                </div>
                <form method="GET" action="/paymentTransactions">
                    @csrf
                    <div class="modal-body text-right font-weight-bold" >
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">
                                رقم العضوية
                            </label>
                            <input type="text" name="membership_no" class="form-control text-right">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">الحالة</label>
                            <input type="text" name="status" class="form-control text-right">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">النوع</label>
                            <input type="text" name="operation_type" class="form-control text-right">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">في الفتره من</label>
                            <input type="date" name="start_date" class="form-control text-right">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">إلى</label>
                            <input type="date" name="end_date" class="form-control text-right">
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between" align="center">
                        <a href="/removeSearch" class="btn  my-btn btn-lg btn-primary">إلغاء البحث</a>
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
                        <span class="breadcrumb-item active" aria-current="page">/ تقرير المدفوعات </span>
                    </li>

                    <div class="float-left">
                        <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat">
                            <i class="mdi mdi-magnify"></i>
                        </label>
                        <a href="/paymentTransactionsPdf" class="badge badge-primary text-white">
                            <i class="mdi mdi-file-pdf-box"></i>
                        </a>
                        <a href="/paymentTransactionsExcel" class="badge badge-primary text-white">
                            <i class="mdi mdi-file-excel"></i>
                        </a>
                    </div>

                </ol>

            </div>
        </div>

        <div class="card-body">
            @if(count($paymentTransactions) > 0)
            <div class="table-responsive">
                <table class="table text-center" >
                <thead>
                    <th class="font-weight-bold">الرقم</th>
                    <th class="font-weight-bold">التاريخ</th>
                    <th class="font-weight-bold">رقم العضوية</th>
                    <th class="font-weight-bold">النوع</th>
                    <th class="font-weight-bold">الحالة</th>
                    <th class="font-weight-bold">سعر الخدمة</th>
                    <th class="font-weight-bold">سعر التطبيق</th>
                    <th class="font-weight-bold">سعر التاجر</th>
                </thead>

                <tbody>
                @foreach ($paymentTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction['payment_id'] }}</td>
                        <td>{{ $transaction['datetime'] }}</td>
                        <td>{{ $transaction['membership_no'] }}</td>
                        <td>{{ $transaction['operation_type'] }}</td>
                        <td>{{ $transaction['status'] }}</td>
                        <td>{{ $transaction['service_fee'] }}</td>
                        <td>{{ $transaction['app_fee'] }}</td>
                        <td>{{ $transaction['merchant_amount'] }}</td>

                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-fill-primary text-right" role="alert" >
                <i class="typcn typcn-warning"></i>لا توجد مدفوعات</div>
            @endif
        </div>

    </div>

@endsection
