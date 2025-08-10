@extends('welcome')
@section('content')
<link rel="stylesheet" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

<style>
    * {
        margin: 0;
        padding: 0;
    }

    html {
        height: 100%;
    }

    /*Background color*/
    {{--  #grad1 {
        background-color: : #9C27B0;
        background-image: linear-gradient(120deg, #FF4081, #81D4FA);
    }  --}}

    /*form styles*/
    #msform
    {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset .form-card
    {
        background: white;
        border: 0 none;
        border-radius: 0px;
        //box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    #msform fieldset
    {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type)
    {
        display: none;
    }

    #msform fieldset .form-card
    {
        text-align: right;
        color: #9E9E9E;
    }

    #msform input, #msform textarea
    {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        //font-family: montserrat;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px;
    }

    #msform input:focus, #msform textarea:focus
    {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid #844fc1;
        outline-width: 0;
    }

    /*Blue Buttons*/
    #msform .action-button
    {
        width: 100px;
        background: #844fc1;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus
    {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #844fc1;
    }

    /*Previous Buttons*/
    #msform .action-button-previous
    {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover, #msform .action-button-previous:focus
    {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
    }

    /*Dropdown List Exp Date*/
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px;
    }

    select.list-dt:focus {
        border-bottom: 2px solid #844fc1;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative;
    }

    /*FieldSet headings*/
    .fs-title
    {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    /*progressbar*/
    #progressbar
    {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
        direction: rtl;
    }

    #progressbar .active
    {
        color: lightgrey;
    }

    #progressbar li
    {
        list-style-type: none;
        font-size: 12px;
        width: 33.3%;
        float: right;
        position: relative;
        direction: rtl;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account::before
    {
        font-family: "Material Design Icons";
        content: "1";
    }

    #progressbar #personal:before
    {
        font-family: "Material Design Icons";
        content: "2";
    }

    #progressbar #services:before
    {
        font-family: "Material Design Icons";
        content: "3";
    }

    /*ProgressBar before any progress*/
    #progressbar li:before
    {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after
    {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before, #progressbar li.active:after
    {
        background: #844fc1;
    }

    /*Imaged Radio Buttons*/
    .radio-group {
        position: relative;
        margin-bottom: 25px;
    }

    .radio {
        display:inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor:pointer;
        margin: 8px 2px;
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
    }

    /*Fit image in bootstrap div*/
    .fit-image{
        width: 100%;
        object-fit: cover;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    {{--  let amount = 0;  --}}
    let counter = {{ count($services) }};
    $(document).ready(function()
    {
        $('#package_time').on('change', function() {
            package_time(this);
        });
        //let city_id = {!! $towns[0]['id'] !!};
        //showGovernate(city_id);

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $("#next").click(function()
        {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //check values
            var first_name = document.getElementById("first_name").value;
            var second_name = document.getElementById("second_name").value;
            var phone = document.getElementById("phone").value;
            //let email = validateEmail();
            let tax_no = document.getElementById("tax_no").value;
            //let governate = document.getElementById("governate").value;

            if(first_name != "" && second_name != ""
            && bussiness_name != "" && phone != ""
            && email )
            //Add Class Active
            {
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            }
            else
            {
                toastr.options={positionClass: "toast-center-center"}
                toastr.error("الرجاء ملأ جميع الحقول بالطريقة الصحيحة","عٌذراً");
            }
        });

        $("#next1").click(function()
        {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

             //check values
             var package_id = document.getElementById("package_id").value;
             var start_date = document.getElementById("start_date").value;
             var end_date = document.getElementById("end_date").value;

             if(package_id != ""&& start_date != "" && end_date != "")
             //Add Class Active
             {

                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
                //hide the current fieldset with style
             current_fs.animate({opacity: 0}, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            }
            else
            {
                toastr.options={positionClass: "toast-center-center"}
                toastr.error("الرجاء ملأ جميع الحقول بالطريقة الصحيحة","عٌذراً");
            }
        });


        $(".previous").click(function()
        {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function(){
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $(".submit").click(function()
        {

            return true;
        })

    });

    

    // This is now in the global scope
function package_time(select) {
    let startDateInput = document.getElementById('start_date');
    let endDateInput   = document.getElementById('end_date');

    let startDateValue = startDateInput.value;
    let packageValue   = select.value;

    if (!startDateValue || !packageValue) {
        endDateInput.value = '';
        return;
    }

    let date = new Date(startDateValue);

    switch (packageValue) {
        case 'day': date.setDate(date.getDate() + 1); break;
        case '14day': date.setDate(date.getDate() + 14); break;
        case 'month': date.setMonth(date.getMonth() + 1); break;
        case '3month': date.setMonth(date.getMonth() + 3); break;
        case '6month': date.setMonth(date.getMonth() + 6); break;
        case 'year': date.setFullYear(date.getFullYear() + 1); break;
        default:
            endDateInput.value = '';
            return;
    }

    let yyyy = date.getFullYear();
    let mm   = String(date.getMonth() + 1).padStart(2, '0');
    let dd   = String(date.getDate()).padStart(2, '0');

    endDateInput.value = `${yyyy}-${mm}-${dd}`;
}


    function addPackagePrice(checkbox,price)
    {
        if(checkbox.checked)
        {
            amount += price;
        }
        else
        {
            amount -= price;
        }

        document.getElementById("final_amount").value = amount;
        taxes_discounts();
    }

    function taxes_discounts()
    {
        var package=document.getElementById("package_id");
        var packagePrice = package.options[package.selectedIndex].getAttribute('data-price');
        let amount = parseInt(packagePrice);

        //taxes computations
        let tax = 0;
        let discount = 0;

        //let taxes_value = document.getElementById("taxes").value;
        let discounts_value = document.getElementById("discounts").value;

        /*if(!(taxes_value == ""))
        {
            if(document.getElementById("tax_percent").checked)
            {
                tax = amount * taxes_value / 100;
            }
            else
            {
                tax = taxes_value;
            }
        }*/

        if(!(discounts_value == ""))
        {
            if(document.getElementById("discount_percent").checked)
            {
                discount = document.getElementById("final_amount").value * discounts_value / 100;
            }
            else
            {
                discount  = discounts_value;
            }
            document.getElementById("discounts_value").value =  parseFloat(discount);
        }
        document.getElementById("total_amount").value =document.getElementById("final_amount").value -  parseFloat(discount);
    }

    function services_price(counter_value)
    {
        var prices_sum = parseFloat(0);

        for(var i=1;i<=counter;i++)
        {
            var discount = parseFloat(0);
            var quantity = document.getElementById('quantity'+i).value;
            var unit_price = document.getElementById('unit_price'+i).value;

            document.getElementById('prices'+i).value = parseFloat(unit_price * quantity);

            if(document.getElementById('discounts'+i).value != "")
            {
                if(document.getElementById("discount_type"+i).checked)
                {
                    document.getElementById('discount_type_value'+i).value = 1;
                    discount = document.getElementById('prices'+i).value * document.getElementById('discounts'+i).value / 100;
                }
                else
                {
                    discount  = document.getElementById('discounts'+i).value;
                }
            }
            document.getElementById('full_prices'+i).value = parseFloat((unit_price * quantity) - discount);


            prices_sum += parseFloat(document.getElementById('full_prices'+i).value);
        }
        document.getElementById('final_amount').value = parseFloat(prices_sum);
    }

    function showPackages(sel)
    {
        let systm_id = sel.value;

        var packages = document.getElementById("package_id");
        for (var i = 0; i < packages.length; i++)
        {
            if(packages[i].className != parseInt(systm_id))
            {
                packages[i].style.display = "none";
            }
            else
            {
                packages[i].style.display = "block";
            }
        }
    }

    function price(sel)
    {
        var package=document.getElementById("package_id");
        var packagePrice = package.options[package.selectedIndex].getAttribute('data-price');
        //document.getElementById("final_amount").value = parseInt(packagePrice);
        document.getElementById("dash_id").value = package.options[package.selectedIndex].getAttribute('data-dash');

    }

    function checkPhoneLength()
    {
        let check_phone_length = true;
        if(document.getElementById("phone").value.length != document.getElementById("phone").minLength)
        {
            document.getElementById("phone_error").innerHTML = "الرجاء إدخال 10 أرقام";
            check_phone_length = false;
        }
        else
        {
            document.getElementById("phone_error").innerHTML = "";

        }
        return check_phone_length;
    }
    function checkPasswordLength()
    {
        let check_password_length = true;
        if(document.getElementById("password").value.length != document.getElementById("password").minLength)
        {
            document.getElementById("password_error").innerHTML = "الرجاء إدخال 6 أرقام";
            check_password_length = false;
        }
        else
        {
            document.getElementById("password_error").innerHTML = "";

        }
        return check_password_length;
    }

    function validateFrom(event)
    {
        let check_phone_length = checkPhoneLength();
        let check_password_length = checkPasswordLength();
        if(check_phone_length)
        {
            document.forms['myform'].submit();
        }
		if(!check_phone_length)
		{
            toastr.options={positionClass: "toast-center-center"}
            toastr.error("رقم الهاتف يجب أن تحتوي على 10 أرقام","عٌذراً");
        }

        event.preventDefault();
    }

    function validateEmail()
    {
        var email = document.getElementById("email").value;
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    function addService()
    {
        counter++;
            var myDiv = document.createElement("div");
            myDiv.classList.add("row");
            myDiv.innerHTML += '<div class="form-group col-lg-4"><span>'+
                '<label onclick="removeDiv(this)"><i class="mdi mdi-delete text-danger"></i></label>'+
                ' المنتج<br><br></span>'+
                '<input name="service[]" class="form-control text-right"></div>'+
                '<div class="form-group col-lg-1"><label> العدد<br><br></label>'+
                '<input name="quantity[]" id="quantity'+counter+'" type="number" class="form-control text-right" onblur="services_price('+counter+')">'+
                '</div><div class="form-group col-lg-1"><label> سعر الوحدة<br><br></label>'+
                '<input id="unit_price'+counter+'"  type="number" step=".0001" class="form-control text-right" onblur="services_price('+counter+')">'+
                '</div><div class="form-group col-lg-2"><label> المبلغ الكلي<br><br></label>'+
                '<input name="price[]" id="prices'+counter+'"  type="number" step=".0001" class="form-control text-right">'+
                '</div><div class="form-group col-lg-3"><label>الخصم على المنتج'+
                ' (  <input value="1" id="discount_type'+counter+'" name="discount_types[]" type="checkbox" class="form-check-input" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">'+
                ' نسبة  )</label><input name="discount_type_value[]" value="0" id="discount_type_value'+counter+'"  type="hidden">'+
                '<input value=0 name="item_discounts[]" id="discounts'+counter+'" onblur="services_price('+counter+')"  type="number" step=".0001" class="form-control text-right">'+
                '</div><div class="form-group col-lg-1"><label>الإجمالي<br><br></label>'+
                '<input name="full_prices[]" id="full_prices'+counter+'"  type="number" step=".0001" class="form-control text-right">'+
                '</div></div>';

            var div = document.getElementById("serve");

            div.append(myDiv);
    }

    function removeDiv(row)
    {
        var d = row.parentNode.parentNode.parentNode.remove();
        counter--;
        services_price(counter);
    }

</script>

<div class="card">

    <div class="card-header" dir="rtl">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-inverse-primary justify-content-between">
                <li class="breadcrumb-item"><a href="#">     المشتركين</a>
                    <span class="breadcrumb-item active" aria-current="page"> /  تعديل </span>
                </li>
            </ol>
        </div>
    </div>

    <div class="card-body">
        @if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif
        <form id="msform" name="myform" action="/updateCustomer/{{ $customer['id'] }}" method="POST" onsubmit="validateFrom(event);">
            @csrf
            <ul id="progressbar">
                <li class="active" id="account"><strong>البيانات الأساسية</strong></li>
                <li id="personal"><strong>بيانات الإشتراك </strong></li>
                <li id="services"><strong> الخدمات </strong></li>
            </ul>

            <fieldset>
                <div class="form-card row text-right" dir="rtl">
                    <div class="form-group col-lg-4">
                        <input type="hidden" name="previous_customer_package" value="{{ $customer['package_id'] }}">
                        <input type="hidden" name="membership_no" value="{{ $customer['membership_no'] }}">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>الإسم الأول</label>
                        <input type="text" value="{{ $customer['first_name'] }}" name="first_name" id="first_name" class="form-control text-right" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>الإسم الثاني</label>
                        <input type="text" value="{{ $customer['last_name'] }}"  id="second_name" name="second_name" class="form-control text-right" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1">إسم العمل</label>
                        <input type="text"  value="{{ $customer['business_name'] }}" id="bussiness_name" name="bussiness_name" class="form-control text-right">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>
                            رقم الهاتف (10 أرقام)
                        </label>
                        <input value="{{ $customer['phone_no'] }}" type="number" id="phone" minlength="10" maxlength="10" name="phone" class="form-control text-right" required onblur="checkPhoneLength()">
                        <label id="phone_error" class="badge badge-danger text-white"></label>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"> البريد الإلكتروني</label>
                        <input value="{{ $customer['email'] }}" type="email" id="email" name="email" class="form-control text-right">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1">الرقم الضريبي</label>
                        <input value="{{ $customer['tax_number'] }}" type="number" id="tax_no" name="tax_no" class="form-control text-right">
                    </div>

                    <div class="form-group col-lg-4">
                        <label><i class="mdi mdi-star text-danger"></i>الغرض من الحساب</label>
                        <select name="is_testing_account" class="form-select text-right" required onchange="showGovernate(this.value)">
                            <option value="0" @if($customer['is_testing_account'] == 0) selected @endif>فعلي</option>
                            <option value="1" @if($customer['is_testing_account'] == 1) selected @endif>تجريبي</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>المدينة</label>
                        <select name="town_id" id="city" class="form-select text-right" required onchange="showGovernate(this.value)">

                            @foreach ($towns as $t)
                                <option value={{ $t["id"] }} @if($t['id'] == $customer['city_id']) selected @endif>{{ $t["ar_name"] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i> نوع النشاط</label>
                        <select name="activity_id" id="activity" class="form-select text-right" required>
                            @foreach ($activities as $a)
                                <option value={{ $a['id'] }} @if(($a['id']) == $customer['activity_type']) selected @endif>{{ $a['ar_activity'] }}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
                    <label data-toggle="tooltip" title=" Please fill the mandatory fields..!"  id="next" class="next action-button">التالي</label>
            </fieldset>

            <fieldset>
                <div class="form-card row text-right" dir="rtl">

                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>الباقة</label>
                        <select name="package_id" id="package_id" class="form-select text-right" required onchange="price(this)">
                            <option value="">-</option>
                            @foreach ($packages as $package)
                                <option value={{ $package["id"] }} class="1" data-dash="{{ $package['dash_id'] }}" data-price = "{{ $package['price'] }}"
                                @if($package['id'] == $customer['package_id']) selected @endif>
                                {{ $package['package_ar'] }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="dash_id" id="dash_id">
                    </div>

                    <div class="form-group col-lg-4">
                        <label><i class="mdi mdi-star text-danger"></i>رسوم تطبيق تود (%)</label>
                        <input type="nmber" step="any" name="application_fees" value={{ $customer['application_fees'] }}>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1">
                             كلمة المرور (6 أرقام)
                            </label>
                        <input type="number" id="password" name="password" minlength="6" maxlength="6" class="form-control text-right"  onblur="checkPasswordLength()">
                        <label id="password_error" class="badge badge-danger text-white"></label>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>تاريخ بداية الإشتراك </label>
                        <input type="date" id="start_date" value="{{ date('Y-m-d',strtotime($customer['subscription_start_at'])) }}" name="start_date" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label>الفتره الزمنيه </label>
                        <select name="package_time" id="package_time" class="form-select text-right" >
                            <option value="">-</option>
                            <option value="day">يوم</option>
                            <option value="14day">14 يوم</option>
                            <option value="month">شهر</option>
                            <option value="3month">3 أشهر</option>
                            <option value="6month">6 أشهر</option>
                            <option value="year">عام</option>
                        </select>                    
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i> تاريخ نهاية الإشتراك </label>
                        <input type="date" id="end_date" value="{{ date('Y-m-d',strtotime($customer['subscription_end_at'])) }}" name="end_date" class="form-control text-right" required>
                    </div>

                    {{--  <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1">الضريبة
                            (  <input value="2" @if($customerPackage->taxes_type == 2) checked @endif id="tax_percent" name="tax_percent" type="checkbox" class="form-check-input" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                              نسبة  )
                        </label>
                        <input type="text" id="taxes" value="{{ $customerPackage->taxes }}" name="taxes" class="form-control text-right" onblur="taxes_discounts()">
                    </div>  --}}
                    {{--  <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>المبلغ<br><br></label>
                        <input type="text" id="final_amount" value="{{ $customerPackage->discounts + $customerPackage->final_amount }}" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1">الخصومات
                            (  <input value="2" @if($customerPackage->discounts_type == 2) checked @endif id="discount_percent" name="discount_percent" type="checkbox" class="form-check-input" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                              نسبة  )
                        </label>
                        @php
                            if($customerPackage->discounts_type == 2)
                            {
                                $discount_percent = (100 * $customerPackage->discounts) / ($customerPackage->discounts + $customerPackage->final_amount);
                            }
                            else
                            {
                                $discount_percent = $customerPackage->discounts;
                            }
                        @endphp
                        <input type="text" onblur="taxes_discounts()" value="{{ $discount_percent }}" id="discounts"  class="form-control text-right">
                        <input type="hidden" value="{{ $customerPackage->discounts }}" id="discounts_value" name="discounts" class="form-control text-right">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-primary"></i>الإجمالي<br><br></label>
                        <input type="text" id="total_amount" value="{{ $customerPackage->final_amount }}" name="amount" class="form-control text-right" readonly>
                    </div>  --}}
                </div>

                <label data-toggle="tooltip" title=" Please fill the mandatory fields..!"  id="next1" class="next action-button">التالي</label>
                <input type="button" name="previous" class="previous action-button-previous" value="السابق"/>



            </fieldset>

            <fieldset>
                <div class="form-card text-right" dir="rtl">
                    <div class="form-group col-lg-2">
                        <label class="btn btn-success btn-sm" onclick="addService()">
                            <i class="mdi mdi-plus"></i>
                        </label>
                    </div>
                    <div id="serve">
                        @foreach($services as $ser)
                            @if($ser['package_id'] == $customer['package_id'])
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>
                                        @if(!$loop->first) <label onclick="removeDiv(this)"><i class="mdi mdi-delete text-danger"></i></label> @endif
                                        المنتج<br><br></label>
                                    <input name="service[]" value="{{ $ser['service'] }}" class="form-control text-right">
                                </div>
                                <div class="form-group col-lg-1">
                                    <label> العدد<br><br></label>
                                    <input name="quantity[]" value="{{ $ser['quantity'] }}" id="quantity{{ $loop->iteration }}" type="number" class="form-control text-right">
                                </div>
                                <div class="form-group col-lg-1">
                                    <label> سعر الوحدة<br><br></label>
                                    <input id="unit_price{{ $loop->iteration }}" value="{{ $ser['price'] / $ser['quantity'] }}"  type="number" step=".0001" class="form-control text-right" onblur="services_price(1)">
                                </div>
                                <div class="form-group col-lg-1">
                                    <label> المبلغ الكلي<br><br></label>
                                    <input name="price[]" value="{{ $ser['price'] }}" id="prices{{ $loop->iteration }}" type="text" class="form-control text-right">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>
                                        الخصم على المنتج
                                            (  <input value="1" @if($ser['discount_type'] == 1) checked @endif id="discount_type{{ $loop->iteration }}" name="discount_types[]" type="checkbox" class="form-check-input" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                                            نسبة  )
                                    </label>
                                    <input name="discount_type_value[]" value="{{ $ser['discount_type'] }}" id="discount_type_value{{ $loop->iteration }}"  type="hidden">
                                    <input name="item_discounts[]" value="{{ $ser['discount'] }}" onblur="services_price({{ $loop->iteration }})" id="discounts{{ $loop->iteration }}"  type="number" step=".0001" class="form-control text-right">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>الإجمالي<br><br></label>
                                    <input name="full_prices[]" value="{{ $ser['full_price'] }}" id="full_prices{{ $loop->iteration }}"  type="number" step=".0001" class="form-control text-right">
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <br>
                    <div class="row text-white" style="background-color: #9E9E9E; border=1;border-radius:.90rem;">
                        <div class="form-group col-lg-4">
                            <label><i class="mdi mdi-star text-danger"></i>المبلغ<br><br></label>
                            <input value="{{ $customerPackage->discounts + $customerPackage->final_amount }}" type="number" step=".0001" id="final_amount" class="form-control text-right" required>
                        </div>

                        <div class="form-group col-lg-4">
                            <label>
                            الخصم على إجمالي الفاتوره
                                (  <input value="2" @if($customerPackage->discounts_type == 2) checked @endif id="discount_percent" name="discount_percent" type="checkbox" class="form-check-input" style="width: 18px; height: 18px; border-radius: 2px;  border: solid #844fc1; border-width: 2px;">
                                نسبة  )
                            </label>
                            @php
                                if($customerPackage->discounts_type == 2)
                                {
                                    $discount_percent = (100 * $customerPackage->discounts) / ($customerPackage->discounts + $customerPackage->final_amount);
                                }
                                else
                                {
                                    $discount_percent = $customerPackage->discounts;
                                }
                            @endphp
                            <input type="text" onblur="taxes_discounts()" value="{{ $discount_percent }}" id="discounts" class="form-control text-right">
                            <input type="hidden" id="discounts_value" value="{{ $customerPackage->discounts }}" name="discounts" class="form-control text-right">
                        </div>


                        <div class="form-group col-lg-4">
                            <label><i class="mdi mdi-star text-primary"></i>إجمالي  <br><br></label>
                            <input type="number" step=".0001" value="{{ $customerPackage->final_amount }}" @if(isset($customer)) value=0 @endif  id="total_amount" name="amount" class="form-control text-right" readonly>
                        </div>
                    </div>

                </div>

                <input type="submit" name="make_payment" class="action-button" value="تعديل"/>
                <input type="button" name="previous" class="previous action-button-previous" value="السابق"/>
            </fieldset>
        </form>
    </div>
    </div>
</div>

@endsection
