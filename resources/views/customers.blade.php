@extends('welcome')

@section('content')
@php

  $i = ($page * $perPage) - $perPage + 1;

@endphp

<script>
    function inActivateCustomer(customer_id)
    {
        swal({
                title: 'تحذير',
                text: "هل أنت متأكد من إلغاء التفعيل؟",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
            actions: 'vertical-buttons',
            cancelButton: 'top-margin'
            },
                buttons: {
                cancel: {
                    text: "لا",
                    value: null,
                    visible: true,
                    className: "btn btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "نعم",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
                }
            }).then(okay => {
            if (okay) {
                window.location = "/inActivateCustomer/"+customer_id;}
                });
    }

    function notifyCustomer(customer_id)
    {
        document.getElementById("notify_customer_id").value = customer_id;

        if(customer_id != "all")
        {
            document.getElementById("notify_customer_name").value = document.getElementById("name"+customer_id).innerHTML;
        }
        else
        {
            document.getElementById("notify_customer_name").value = "جميع المشتركين";
        }
        $("#notifyCustomer").modal("show");
    }

    function visit(membershipNo)
    {
        document.getElementById("visit_membership_no").value = membershipNo;
        $("#visitDashboard").modal("show");
    }

</script>

    @if (session()->has('visit_url'))
        <script>
            window.open("{!! session()->get('visit_url') !!}", "_blank");
            {!! Session::forget('visit_url') !!}
        </script>
    @endif

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن مشترك</b></h3>
        </div>
        <form method="POST" action="/customers">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        الإسم - رقم الهاتف - البريد الإلكتروني - رقم العضوية
                    </label>
                    <input type="text" name="customer" class="form-control text-right">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> الباقة</label>
                    <select name="package_id" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($packages as $package)
                            <option value="{{ $package['id'] }}">{{ $package['package_ar'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> المدينة</label>
                    <select name="town" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($towns as $t)
                            <option value="{{ $t['id'] }}">{{ $t['ar_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple"> النشاط</label>
                    <select name="activity" class="form-select text-right">
                        <option value="">-</option>
                        @foreach ($activities as $a)
                            <option value="{{ $a->id }}">{{ $a->activity_ar }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-between" align="center">
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary foat-left">
                <a href="/allCustomers" class="btn  my-btn btn-lg btn-primary foat-right">إلغاء البحث</a>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="notifyCustomer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إرسال إشعار للمشترك</b></h3>
        </div>
        <form method="POST" action="/sendNotification">
            @csrf
            <input type="hidden" name="subscribers[]" class="form-control text-right" id="notify_customer_id" >
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



<div class="modal fade" id="visitDashboard" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>زيارة حساب سكيل تاكس</b></h3>
        </div>
        <form method="POST" action="/visit">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        رقم العضوية
                    </label>
                    <input type="text" name="membership_no" id="visit_membership_no" class="form-control text-right" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        كلمة المرور
                    </label>
                    <input type="password" name="password" class="form-control text-right">
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="إرسال" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  المشتركين </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>

                        <label class="badge badge-primary text-white">
                            <div class="dropdown dropstart">
                                <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical  text-white"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat" href="javascript:;">بحث</a></li>
                                    <li><a class="dropdown-item" href="/addCustomer">إضافة</a></li>
                                    <li><a class="dropdown-item" href="/notifyMultiple">إشعار مجموعة المشتركين</a></li>
                                    <li><a class="dropdown-item" href="/printCustomers">طباعة</a></li>
                                </ul>
                            </div>
                        </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($customers) > 0)
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
                <th class="font-weight-bold"> تفعيل الولاء </th>
                <th class="font-weight-bold">الحالة</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($results as $c)
            @if($c["is_archived"] == 0)
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="name{{ $c['id'] }}">
                    {{ $c["first_name"] }} {{ $c["last_name"] }}
                    </td>

                     <td>{{ $c["business_name"] }}</td>

                    <td>{{ $c["membership_no"] }}</td>
                    <td>{{ $c["city"]}}</td>
                    <td>{{ $c["ar_activity"] }}</td>

                    <td>{{ $c["package_ar"] }}</td>
                    <td>@if(!is_null($c['subscription_end_at'])){{date('Y-m-d', strtotime($c['subscription_end_at'])) }} @endif</td>
                    <td>{{ $c["available_messages"] }}</td>

                    <td>
                        @if( $c['loyalty_status'] == 'active')
                        <span href="javascript:;" class="badge badge-success text-white">
                            مفعل
                        </span>
                        @elseif( $c['loyalty_status'] == 'pending')
                        <a href="javascript:;" class="badge badge-warning text-white" onclick="changeLoyaltyStatus({{ $c['membership_no'] }},'active')" style="cursor:hand;text-decoration:none">
                            طلب تفعيل
                        </a>
                        @elseif( $c['loyalty_status'] == 'inactivate pending')
                        <a href="javascript:;" class="badge badge-primary text-white" onclick="changeLoyaltyStatus({{ $c['membership_no'] }},'inactive')"  style="cursor:hand;text-decoration:none">
                            طلب إلغاء تفعيل
                        </a>
                        @elseif( $c['loyalty_status'] == 'inactive')
                        <span href="/customerActivate/{{ $c['id'] }}" class="badge badge-danger text-white">
                            غير مفعل
                        </span>
                        @endif
                    </td>

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
                        {{--  @if($c["id"] != 1)  --}}
                            <div class="input-group text-right" style="text-align: right;">
                              <div class="input-group-prepend">
                                <button class="badge badge-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal  text-white"></i>
                                </button>
                                <div class="dropdown-menu" style="text-align: right;">
                                    <a class="dropdown-item text-right" href="/showCustomer/{{ $c['id'] }}" style="text-decoration: none">
                                        التفاصيل
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-right" onclick="notifyCustomer({{ $c['id'] }})"  href="javascript:;" style="text-decoration: none">
                                        إرسال إشعار
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-right" href="/emailCustomer/{{ $c['id'] }}" style="text-decoration: none">
                                        البريد الإلكتروني
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-right" href="/editCustomer/{{ $c['id'] }}" style="text-decoration: none">
                                        تعديل
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-right" onclick="destroyItem( 'destroyCustomer', {{ $c['id'] }})"  href="javascript:;" style="text-decoration: none">
                                        أرشفة
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>

                                    <a class="dropdown-item text-right"  href="/visit/{{ $c['membership_no'] }}" style="text-decoration: none">
                                        زيارة الحساب في سكيل تاكس
                                    </a>
                                </div>
                              </div>
                            </div>
                        {{--  @endif  --}}
                        {{--  <label class="badge badge-primary text-white text-right">
                            <div class="dropdown dropstart">
                                <a href="javascript:;" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal  text-white"></i>
                                </a>
                                <ul class="dropdown-menu text-right" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item text-right" href="/showCustomer/{{ $c['id'] }}" style="text-decoration: none">
                                            التفاصيل
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-right" href="/CustomerMessages/{{ $c['id'] }}/{{ $c['membership_no'] }}" style="text-decoration: none">
                                            البريد الإلكتروني
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-right" href="/editCustomer/{{ $c['id'] }}" style="text-decoration: none">
                                            تعديل
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-right" onclick="destroyItem( 'destroyCustomer', {{ $c['id'] }})"  href="javascript:;" style="text-decoration: none">
                                            أرشفة
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </label>  --}}
                    </td>
                </tr>
                @php $i++; @endphp
            @endif
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
    <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination pagination-primary flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $results->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
