@extends('welcome')

@section('content')

<script>
    function checkAll(source,name)
    {
        checkboxes = document.getElementsByClassName(name);
        for(var i=0, n=checkboxes.length;i<n;i++)
        {
            checkboxes[i].checked = source.checked;
        }
    }
</script>

    <div class="modal fade" id="notifyCustomer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header align-self-center">
                <h3 align="center" class="modal-title text-primary-purple"><b>إرسال إشعار للمشترك</b></h3>
            </div>
            <form method="POST" action="/sendNotification">
                @csrf
                <input type="hidden" name="notify_customer_id" class="form-control text-right" id="customer_id" >
                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group" id="customerName">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            المشترك
                        </label>
                        <input type="text" class="form-control text-right"  id="notify_customer_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            العنوان
                        </label>
                        <input type="text" name="title" class="form-control text-right" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            الرسالة
                        </label>
                        <textarea name="message" class="form-control text-right" required></textarea>
                    </div>

                </div>
                <div class="modal-footer" align="center">
                    <input type="submit" value="إرسال" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>
        </div>
        </div>
    </div>





    <form method="POST" action="/sendNotification">
        @csrf
        <div class="card">

            <div class="card-header" dir="rtl">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  المشتركين </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  إرسال الإشعار لمتعدد </span>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card-body">
                @php $i=1; @endphp
                @if(count($results) > 0)
                <div  class="row" dir="rtl">
                    <div class="form-group col-lg-6 col-md-12">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            العنوان
                        </label>
                        <input type="text" name="title" class="form-control text-right" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            الرسالة
                        </label>
                        <textarea name="message" class="form-control text-right" required></textarea>
                    </div>
                </div>


                    <div class="table-responsive-xl">
                        <table class="table text-center" dir="rtl">
                        <thead>
                            <th class="font-weight-bold">#</th>
                            <th class="font-weight-bold"> الإسم</th>
                                            <th class="font-weight-bold"> إسم النشاط</th>

                            <th class="font-weight-bold"> رقم العضوية</th>
                            <th class="font-weight-bold"> المدينة</th>
                            <!--th class="font-weight-bold"> المحافظة</th-->
                            <th class="font-weight-bold"> النشاط</th>
                            <th class="font-weight-bold"> الباقة</th>
                            <th class="font-weight-bold"> إنتهاء الإشتراك</th>
                            <th class="font-weight-bold"> عدد الرسائل</th>
                            <th class="font-weight-bold">الحالة</th>
                            <th class="font-weight-bold"><input type="checkbox" onchange="checkAll(this,'subs')"></th>
                        </thead>

                        <tbody>
                        @foreach ($results as $c)
                            <tr>
                                <td >{!! $i !!}</td>
                                <td id="name{{ $c['id'] }}">
                                    {{ $c["first_name"] }} {{ $c["last_name"] }}
                                </td>

                                <td>{{ $c["business_name"] }}</td>

                                <td>{{ $c["membership_no"] }}</td>
                                <td>{{ $c["city"]}}</td>
                                <td>{{ $c["activity_ar"] }}</td>

                                <td>{{ $c["package_ar"] }}</td>
                                <td>@if(!is_null($c['subscription_end_at'])){{date('Y-m-d', strtotime($c['subscription_end_at'])) }} @endif</td>
                                <td>{{ $c["available_messages"] }}</td>
                                <td>
                                    @if( $c['status'])
                                    <a href="javascript:;" class="badge badge-success text-white" onclick="inActivateCustomer({{ $c['id'] }})">
                                        <i class="mdi mdi-check-circle"></i>
                                    </a>
                                    @else
                                    <a href="/customerActivate/{{ $c['id'] }}" class="badge badge-danger text-white">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                    @endif
                                </td>

                                <td>
                                    <input type="checkbox" name="subscribers[]" value="{{ $c['id'] }}" class="subs">
                                </td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                @else
                <div class="alert alert-fill-primary text-right" role="alert" dir="rtl">
                    <i class="typcn typcn-warning"></i>
                    لا توجد بيانات
                </div>
                @endif
            </div>


            <div class="card-footer justify-content-center" align="center">
                <input type="submit" value="إرسال" class="btn  my-btn btn-lg btn-primary">
            </div>

        </div>

    </form>
@endsection
