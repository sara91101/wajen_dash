@extends('welcome')

@section('content')
@php $i = 1; @endphp
<script>
    function editCustomerUser(user_id)
    {
        document.getElementById("user_id").value = user_id;
        document.getElementById("user_name").value = document.getElementById("user_name"+user_id).innerHTML;
        document.getElementById("password").value = document.getElementById("password"+user_id).innerHTML;

        var type = document.getElementById("type_id"+user_id).innerHTML;
        var types = document.getElementById("type");
        for (var i = 0; i < types.options.length; i++)
        {
            if(types.options[i].value == parseInt(type))
            {
                types.options[i].selected = true;
                types.selectedIndex = i;
            }
        }
        $("#edit").modal("show");
    }
</script>

<div class="col-12" dir="rtl">
    <div class="card">
        <div class="card-header" dir="rtl">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">     المشتركين</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  التفاصيل </span>
                    </li>
                    @php $last_customer_package = $packages[sizeof($packages) - 1]; @endphp
                    <a style="text-decoration: none;" href="/CustomerBill/{{ $customer['id'] }}/{{ $last_customer_package->package_id }}/2" class="badge badge-primary text-white float-left">
                        <i class="mdi mdi-file-pdf"></i>
                        الفاتورة
                    </a>
                </ol>
            </div>
        </div>

        <div class="card-body row">
            <div class="col-lg-6">
                <div class="table-responsive pt-3">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="font-weight-bold" colspan="2">البيانات الأساسية</th>
                            </tr>
                        </thead>
                        <tbody class="text-right">
                            <tr>
                                <td>الإسم</td>
                                <td>{{$customer['first_name'] }} {{$customer['last_name'] }}</td>
                            </tr>
                            <tr>
                                <td>إسم العمل</td>
                                <td>{{$customer['business_name'] }}</td>
                            </tr>
                            <tr>
                                <td>المدينة</td>
                                <td>{{ $customer['city'] }}</td>
                            </tr>
                            <tr>
                                <td>رقم الهاتف</td>
                                <td>{{$customer['phone_no'] }}</td>
                            </tr>
                            <tr>
                                <td>البريد الإلكتروني</td>
                                <td>{{$customer['email'] }}</td>
                            </tr>
                            <tr>
                                <td>الرقم الضريبي</td>
                                <td>{{$customer['tax_number'] }}</td>
                            </tr>
                            <tr>
                                <td>نوع النشاط</td>
                                <td>@if($customer["activity_type"] == 0) مقهى @else مطعم @endif</td>
                            </tr>
                            <tr>
                                <td>باقة الإشتراك</td>
                                <td>
                                    @php $count = 1; @endphp
                                    @foreach ($packages as $cp)
                                    <a href="/CustomerBill/{{$customer['id'] }}/{{$cp->package_id }}/2" class="badge badge-primary text-white" style="text-decoration:none;">@if($cp->renew == 1)  تجديد @endif {{$cp->package_ar }}</a>
                                    @if($count % 3 == 0) <br><br> @endif
                                    @if(!($loop->last))-  @endif
                                    @php $count++; @endphp
                                    @endforeach
                                </td>
                            </tr>
                             <tr>
                                <td>عدد الرسائل </td>
                                <td>{{ $customer["available_messages"] }}</td>
                            </tr>
                        </tbody>
                  </table>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="table-responsive pt-3">
                    <table class="text-center table">
                        <thead>
                            <tr>
                                <th class="font-weight-bold" colspan="2">بيانات الإشتراك</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>النظام</td>
                                <td>{{$system->system_name_ar }}</td>
                            </tr>
                            <tr>
                                <td>رقم العضوية</td>
                                <td>{{$customer['membership_no'] }}</td>
                            </tr>
                            <tr>
                                <td>بداية الإشتراك</td>
                                <td>{{ date('Y-m-d', strtotime($customer['subscription_start_at'])) }}</td>
                            </tr>
                            <tr>
                                <td>نهاية الإشتراك</td>
                                <td>{{date('Y-m-d', strtotime($customer['subscription_end_at'])) }}</td>
                            </tr>
                            <tr>
                                <td>مبلغ الإشتراك</td>
                                <td>{{ $last_customer_package->final_amount +  $last_customer_package->discounts }} ر.س</td>
                            </tr>
                            <tr>
                                <td> الخصم</td>
                                <td>
                                    {{$last_customer_package->discounts }}
                                     ر.س
                                </td>
                            </tr>
                            <tr>
                                <td> الضريبة</td>
                                <td>
                                    {{$last_customer_package->taxes }}
                                    @if($last_customer_package->taxes_type == 2 && !is_null($last_customer_package->taxes)) % @elseif(!is_null($last_customer_package->taxes)) ر.س @endif
                                </td>
                            </tr>
                            <tr>
                                <td> الإجمالي</td>
                                <td>
                                    {{$last_customer_package->final_amount }} ر.س
                                </td>
                            </tr>
                            <tr>
                                <td> <br></td>
                                <td>
                                    <br>
                                </td>
                            </tr>
                        </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>
</div>

<br>
@if(count($services) > 0)
        <div class="row" dir="rtl">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" dir="rtl">
                        <div aria-label="breadcrumb">
                            <ol class="breadcrumb bg-inverse-primary justify-content-between">
                                <li class="breadcrumb-item">
                                    <a href="#">     الخدمات</a>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive pt-3">
                            <table class="text-center table ">
                                <thead>
                                <tr>
                                    <th class="ms-5 font-weight-bold">#</th>
                                    <th class="font-weight-bold">البند </th>
                                    <th class="font-weight-bold">العدد </th>
                                    <th class="font-weight-bold"> المبلغ</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $serve)
                                            <tr>
                                                <td >{!! $i !!}</td>
                                                <td>{{ $serve["service"] }}</td>
                                                <td>{{ $serve["quantity"] }}</td>
                                                <td>{{ $serve["price"] }}</td>
                                            </tr>
                                            @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


<br>
<div class="row" dir="rtl">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" dir="rtl">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item">
                            <a href="#">     المستخدمين</a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive pt-3">
                    <table class="text-center table ">
                        <thead>
                        <tr>
                            <th class="ms-5 font-weight-bold">#</th>
                            <th class="font-weight-bold">اسم الموظف</th>
                            <th class="font-weight-bold">رقم الموظف</th>
                            <th class="font-weight-bold"> الصلاحية</th>
                            <th class="font-weight-bold"> الحالة</th>
                            <th class="font-weight-bold"> الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($casheirs as $casheir)
                                @if($casheir["membership_no"] == $customer['membership_no'])
                                    <tr>
                                        <td >{!! $i !!}</td>
                                        <td>{{ $casheir["first_name"] }} {{ $casheir["last_name"] }}</td>
                                        <td>{{ $casheir["staff_no"] }}</td>
                                        <td>كاشير</td>
                                        @if($casheir["status"] == 0)
                                        <td><span class="badge badge-danger">غير مفعل</span></td>
                                        <td>
                                            <a href="/casheirActivate/{{ $customer['id'] }}/{{ $casheir['first_name'] }}/{{ $casheir['last_name'] }}/{{ $casheir['staff_no'] }}/{{ $casheir['email'] }}/{{ $casheir['id'] }}/1" class="btn btn-success btn-sm btn-icon-text">
                                                تفعيل
                                            </a>
                                        </td>
                                        @else
                                        <td><span class="badge badge-success"> مفعل</span></td>
                                        <td>
                                            <a href="/casheirActivate/{{ $customer['id'] }}/{{ $casheir['first_name'] }}/{{ $casheir['last_name'] }}/{{ $casheir['staff_no'] }}/{{ $casheir['email'] }}/{{ $casheir['id'] }}/2" class="btn btn-danger btn-sm btn-icon-text">
                                                إلغاء التفعيل
                                            </a>
                                            &nbsp;&nbsp;
                                            <!--a href="/casheirActivate/{{ $customer['id'] }}/{{ $casheir['first_name'] }}/{{ $casheir['last_name'] }}/{{ $casheir['staff_no'] }}/{{ $casheir['email'] }}/{{ $casheir['id'] }}/2" class="btn btn-primary btn-sm btn-icon-text">
                                                الفاتورة
                                            </a-->
                                        </td>
                                        @endif
                                    </tr>
                                    @php $i++; @endphp
                                @endif
                            @endforeach


                            @foreach ($employees as $employee)
                                @if($employee->membership_no == $customer['membership_no'])
                                    <tr>
                                        <td >{!! $i !!}</td>
                                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td>{{ $employee->staff_no }}</td>
                                        <td>{{ $employee->ar_role }}</td>
                                        @if($employee->status == 0)
                                        <td><span class="badge badge-danger">غير مفعل</span></td>
                                        <td>-</td>
                                        @else
                                        <td><span class="badge badge-success"> مفعل</span></td>
                                        <td> - </td>
                                        @endif
                                    </tr>
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<br>
<div class="row" dir="rtl">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" dir="rtl">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item">
                            <a href="#">     الفروع</a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive pt-3">
                    <table class="text-center table ">
                        <thead>
                        <tr>
                            <th class="ms-5 font-weight-bold">#</th>
                            <th class="font-weight-bold">الفرع بالعربية</th>
                            <th class="font-weight-bold">الفرع بالإنجليزية</th>
                            <th class="font-weight-bold"> المدينة</th>
                            <th class="font-weight-bold"> رقم الهاتف</th>
                            <th class="font-weight-bold"> الفاتورة</th>
                            <th class="font-weight-bold"> حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $b = 1; @endphp
                            @foreach ($branches as $branch)
                                    <tr>
                                        <td >{!! $b !!}</td>
                                        <td>{{ $branch->ar_name }}</td>
                                        <td>{{ $branch->en_name }}</td>
                                        <td>{{ $branch->city }}</td>
                                        <td>{{ $branch->phone_number }}</td>
                                        <td>
                                            @if(!is_null($branch->price))
                                            <a href="/branchBill/{{$customer['id'] }}/{{ $branch->id }}" class="btn btn-primary btn-sm btn-icon-text">
                                                <i class="mdi mdi-newspaper"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/destroyBranch/{{ $branch->id }}/{{$customer['id'] }}" class="btn btn-danger btn-sm btn-icon-text">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php $b++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
