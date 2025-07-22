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


    <form method="POST" action="/sendLoyaltyMessage">
        @csrf
        <div class="card">

            <div class="card-header" dir="rtl">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  عٌملاء الولاء </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  إرسال رساله نصيه لمتعدد </span>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card-body">
                @php $i=1; @endphp
       
                <div  class="row" dir="rtl">
                    <div class="form-group col-12">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            الرسالة
                        </label>
                        <textarea name="message" class="form-control text-right" required></textarea>
                    </div>
                </div>


          
                        
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
                            <th class="font-weight-bold"><input type="checkbox" onchange="checkAll(this,'subs')"></th>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($loyaltyCustomers as $customer)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $customer['full_name'] }}</td>
                                <td>{{ $customer['membership_no'] }}</td>
                                <td>{{ $customer['phone_no'] }}</td>
                                <td>{{ $customer['business_name'] }}</td>
                                <td>{{ $customer['address'] }}</td>
                                <td>{{ $customer['points_balance'] }}</td>

                                <td>
                                    <input type="checkbox" name="phones[]" value="{{ $customer['phone_no'] }}" class="subs">
                                </td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
              
            
            </div>


            <div class="card-footer justify-content-center" align="center">
                <input type="submit" value="إرسال" class="btn  my-btn btn-lg btn-primary">
            </div>

        </div>

    </form>
@endsection
