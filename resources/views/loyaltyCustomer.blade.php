@extends('welcome')

@section('content')

    @php

        if ($page <= 0) $page = 1;

        $per_page = 100;

        $i = (int)(!isset($_GET["i"]) ? ($page * $per_page) - $per_page + 1 : $_GET["i"]);

        $lastpage = ceil($total/$per_page);
    @endphp

    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header align-self-center">
                <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن عميل</b></h3>
            </div>
            <form method="POST" action="/loyaltyCustomers/{{ $page }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group text-right">
                        <label for="exampleInputUsername1" class="text-primary-purple">رقم العضوية - رقم الهاتف </label>
                        <input type="text" name="membership_no" class="form-control text-right">
                    </div>
                </div>
                <div class="modal-footer justify-content-center" align="center">
                    <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header" dir="rtl">

                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">    نظام الولاء</a>
                            <span class="breadcrumb-item active" aria-current="page"> /    العملاء </span>
                        </li>

                        <a href="javascript:;" class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                            <i class="mdi mdi-magnify"></i>
                        </a>
                        </ol>

                    </div>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class="table" dir="rtl">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الإسم</th>
                            <th>رقم العضوية</th>
                            <th>رقم الهاتف</th>
                            <th>إسم العمل</th>
                            <th>العنوان</th>
                            <th>عدد النقاط</th>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($loyaltyCustomers as $customer)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $customer['membership_no'] }}</td>
                                <td>{{ $customer['full_name'] }}</td>
                                <td>{{ $customer['phone_no'] }}</td>
                                <td>{{ $customer['business_name'] }}</td>
                                <td>{{ $customer['address'] }}</td>
                                <td>{{ $customer['points_balance'] }}</td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($total > $per_page)
        <div class="card-footer">
            <div  dir="rtl" align="center" class="pagination pagination-primary flat rounded rounded-flat" style="display: flex;justify-content: center;">
                @for($p = 1; $p <= $lastpage; $p++)
                    <a href="/loyaltyCustomers/{{ $p }}" class="btn btn-sm @if($p == $page) btn-primary @else btn-dark @endif text-white">{{ $p }}</a> &nbsp;
                @endfor
            </div>
        </div>
        @endif
    </div>


@endsection
