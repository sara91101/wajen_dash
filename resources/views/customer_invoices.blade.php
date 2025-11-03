@extends('welcome')

@section('content') 



<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  الفواتير </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>
                        
                            <label class="badge badge-primary text-white">
                                <div class="dropdown dropstart">
                                    <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical  text-white"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="/addDeviceInvoice/{{ $membership_no }}/{{ $id }}">إضافة</a></li>
                                    </ul>
                                </div>
                            </label>
                            
                    </ol>

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
                <th class="font-weight-bold">العمليات</th>
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
                    <td>
                        @if($invoice->type == 'External')
                            <a href="{{ route('external_invoices.edit',['id' => $invoice->id, 'membership_no' => $membership_no,'customer_id' =>$id]) }}" class="btn btn-sm btn-warning">تعديل</a>
                            <a href="javascript:;" class="btn btn-sm btn-danger" onclick="destroyItem( 'external_invoices_destroy', {{ $invoice->id }})">حذف</a>
                        @endif
                    </td>
                    
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