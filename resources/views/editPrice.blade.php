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
        width: 50%;
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
    let counter = {{ count($price["service"]) }};
    function taxes_discounts()
    {
        let final_amount = parseInt(document.getElementById("final_amount").value);
        let discount = parseInt(document.getElementById("discount").value);
        document.getElementById("final_amount").value = final_amount - discount;
    }

    function price(sel)
    {
        var package=document.getElementById("package_id");
        var packagePrice = package.options[package.selectedIndex].getAttribute('data-price');
        document.getElementById("final_amount").value = parseInt(packagePrice);
        document.getElementById("dash_id").value = package.options[package.selectedIndex].getAttribute('data-dash');
        document.getElementById("discount").value = "";
    }


    function computePrice(number)
    {
        let quantity = document.getElementById("quantity"+number).value;
        let price = parseFloat(document.getElementById("price"+number).value);
        let discount = parseFloat(document.getElementById("discount"+number).value);

        document.getElementById("final_price"+number).value = (quantity * price) - discount;
    }

    function addService()
    {
        counter++;
            var myDiv = document.createElement("div");
            myDiv.classList.add("row");
            myDiv.innerHTML += '<div class="row"><div class="form-group col-lg-4">'+
                '<label></i> الصنف</label><input name="items[]" class="form-control text-right" required></div>'+
                '<div class="form-group col-lg-1"><label></i> العدد</label>'+
                '<input name="quantities[]" id="quantity'+counter+'" type="number" class="form-control text-right" required></div>'+
                '<div class="form-group col-lg-2"><label> المبلغ</label>'+
                '<input name="prices[]" id="price'+counter+'" type="text" class="form-control text-right" required onblur="computePrice('+counter+')"></div>'+
                '<div class="form-group col-lg-2"><label> الخصم</label>'+
                '<input name="discounts[]" id="discount'+counter+'" value="0"  type="text" class="form-control text-right" onblur="computePrice('+counter+')" required></div>'+
                '<div class="form-group col-lg-2"><label> الإجمالي</label>'+
                '<input name="final_prices[]" id="final_price'+counter+'" type="text" class="form-control text-right" required></div>'+
                '<div class="form-group col-lg-1"><span><label class="btn btn-sm btn-danger" onclick="removeDiv(this)"><i class="mdi mdi-delete"></i></label></span></div></div>';

            var div = document.getElementById("serve");

            div.append(myDiv);
    }

    function removeDiv(row)
    {
        var d = row.parentNode.parentNode.parentNode.remove();
    }

</script>

<div class="card">

    <div class="card-header" dir="rtl">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-inverse-primary justify-content-between">
                <li class="breadcrumb-item"><a href="#">     عرض السعر</a>
                    <span class="breadcrumb-item active" aria-current="page"> /  تعديل </span>
                </li>
            </ol>
        </div>
    </div>

    <div class="card-body">
        @if($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        <form id="msform" name="myform" action="/priceShow/{{ $price['id'] }}" method="POST" onsubmit="validateFrom(event);">
            @csrf

            <fieldset>
                <div class="form-card row text-right" dir="rtl">
                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>الإسم الأول</label>
                        <input type="text" name="name" value="{{ $price['name'] }}" id="name" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="exampleInputUsername1">
                            <i class="mdi mdi-star text-danger"></i>
                            إسم النشاط
                        </label>
                        <input type="text" id="activity_name" value="{{ $price['activity_name'] }}" name="activity_name" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>الباقة</label>
                        <select name="package_id" id="package_id" class="form-select text-right" required onchange="price(this)">
                            <option value="">-</option>
                            @foreach ($packages as $package)
                                <option value = "{{ $package['id'] }}"
                                @if($package['id'] == $price['package_id']) selected @endif
                                data-dash="{{ $package['dash_id'] }}"  data-price="{{ $package['price'] }}" >
                                    {{ $package['package_ar'] }}
                                </option>
                            @endforeach
                        </select>

                        <input type="hidden" name="dash_id" id="dash_id">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1">الخصم
                        </label>
                        <input type="text"  value="{{ $price['discount'] }}" onblur="taxes_discounts()" id="discount" name="discount" class="form-control text-right">
                    </div>


                    <div class="form-group col-lg-4">
                        <label for="exampleInputUsername1"><i class="mdi mdi-star text-danger"></i>المبلغ</label>
                        <input type="text" id="final_amount"  value="{{ $price['final_price'] }}" name="final_price" class="form-control text-right" required>
                    </div>

                    <div class="form-group col-lg-12">
                        <div class="form-group col-lg-2">
                            <label class="btn btn-success btn-sm" onclick="addService()">
                                <i class="mdi mdi-plus"></i>
                                إضافة أصناف أخرى
                            </label>
                        </div>
                    </div>

                    @php $t=1; @endphp
                    @foreach ($price['service'] as $service)
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label></i> الصنف</label>
                                <input name="items[]" value="{{ $service['item'] }}" class="form-control text-right" required>
                            </div>
                            <div class="form-group col-lg-1">
                                <label></i> العدد</label>
                                <input name="quantities[]" value="{{ $service['quantity'] }}" id="quantity{{ $t }}" type="number" class="form-control text-right" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label> المبلغ</label>
                                <input name="prices[]" value="{{ $service['price'] }}" id="price{{ $t }}" type="text" class="form-control text-right" required onblur="computePrice({{ $t }})">
                            </div>
                            <div class="form-group col-lg-2">
                                <label> الخصم</label>
                                <input name="discounts[]" value="{{ $service['discount'] }}" id="discount{{ $t }}" value="0"  type="text" class="form-control text-right" onblur="computePrice({{ $t }})" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label> الإجمالي</label>
                                <input name="final_prices[]" value="{{ $service['final_price'] }}" id="final_price{{ $t }}" type="text" class="form-control text-right" required>
                            </div>
                            <div class="form-group col-lg-1">
                                <span>
                                    <label class="btn btn-sm btn-danger" onclick="removeDiv(this)"><i class="mdi mdi-delete"></i></label>
                                </span>
                            </div>
                        </div>
                        @php $t++; @endphp
                    @endforeach
                    <div id="serve">
                    </div>
                </div>
                <input type="submit" name="make_payment" class="action-button" value="تعديل"/>
            </fieldset>
        </form>
    </div>
    </div>
</div>

@endsection
