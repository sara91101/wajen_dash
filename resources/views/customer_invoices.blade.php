@extends('welcome')

@section('content') 



<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  الفواتير </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>

                </div>
    </div>

    <div class="card-body">
        @if(count($invoices) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> رقم العضويه</th>
                <th class="font-weight-bold"> رقم الفاتوره</th>
                <th class="font-weight-bold"> النوع</th>
                <th class="font-weight-bold">التاريخ</th>
            </thead>

            <tbody>
            @foreach ($invoices as $invoice )
                <tr>
                    <td >{!! $loop->index + 1 !!}</td>
                    <td>
                        {{ $invoice->membership_no }}
                    </td>
                    
                     <td><a href="/public/bills/{{ $invoice->path }}" class="btn btn-primary btn-sm" target="blank">{{ $invoice->invoice_number }}</a></td>
                     
                    <td >{{ $invoice->type }}</td>
                    <td>{{ $invoice->created_at }}</td>
                    
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-fill-primary text-right" role="alert" dir="rtl">
            <i class="typcn typcn-warning"></i>
            لا توجد فواتير
        </div>
        @endif
    </div>
    <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination pagination-primary flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $invoices->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection