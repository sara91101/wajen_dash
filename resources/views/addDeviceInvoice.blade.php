@extends('welcome')

@section('content') 

<script>
    let counter = 1;
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
                '<input name="prices[]" id="price'+counter+'" type="text" class="form-control text-right" required oninput="computePrice('+counter+')"></div>'+
                '<div class="form-group col-lg-2"><label> الخصم</label>'+
                '<input name="discounts[]" id="discount'+counter+'" value="0"  type="text" class="form-control text-right" oninput="computePrice('+counter+')" required></div>'+
                '<div class="form-group col-lg-2"><label> الإجمالي</label>'+
                '<input name="final_prices[]" id="final_price'+counter+'" type="text" class="form-control text-right" required></div>'+
                '<div class="form-group col-lg-1"><span><label class="btn btn-sm btn-danger" onclick="removeDiv(this)"><i class="mdi mdi-delete"></i></label></span></div></div>';

            var div = document.getElementById("serve");

            div.append(myDiv);
    }

    function removeDiv(row)
    {
        var d = row.parentNode.parentNode.parentNode.parentNode.remove();
    }

   function computePrice(number) {
    let rows = document.querySelectorAll("[id^='quantity']"); 
    let first_total = 0;
    let total = 0;

    rows.forEach((row, index) => {
        let i = index + 1; 

        let quantity = parseFloat(document.getElementById("quantity" + i).value) || 0;
        let price = parseFloat(document.getElementById("price" + i).value) || 0;
        let discount = parseFloat(document.getElementById("discount" + i).value) || 0;

        // Calculate row total with row-level discount
        let row_total = (quantity * price) - discount;
        document.getElementById("final_price" + i).value = row_total.toFixed(2);

        //first_total += (quantity * price);  // before discount
        first_total += row_total;  // before discount
        total += row_total;                 // after row-level discounts
    });

    // Read global discount once (outside loop)
    let full_discount = parseFloat(document.getElementById("total_discount").value) || 0;

    // Show totals
    document.getElementById("first_total").value = first_total.toFixed(2); 
    document.getElementById("total").value = (total - full_discount).toFixed(2);
}



</script>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">  الفواتير </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  إضافة ({{ $membership_no }})</span>
                        </li>
                    </ol>

                </div>
    </div>

    <form method="POST" action="{{ route('createDeviceInvoice') }}">
        @csrf
        <div class="card-body" dir="rtl">
                <input type="hidden" name="membership_no" value="{{ $membership_no }}">
                <input type="hidden" name="customer_id" value="{{ $id }}">

                    <div class="form-group col-lg-12">
                        <div class="form-group col-lg-2">
                            <label class="btn btn-success btn-sm" onclick="addService()">
                                <i class="mdi mdi-plus"></i>
                                إضافة أصناف أخرى
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label></i> الصنف</label>
                            <input name="items[]" class="form-control text-right" required>
                        </div>
                        <div class="form-group col-lg-1">
                            <label></i> العدد</label>
                            <input name="quantities[]" id="quantity1" type="number" class="form-control text-right" required>
                        </div>
                        <div class="form-group col-lg-2">
                            <label> المبلغ</label>
                            <input name="prices[]" id="price1" type="text" class="form-control text-right" required oninput="computePrice(1)">
                        </div>
                        <div class="form-group col-lg-2">
                            <label> الخصم</label>
                            <input name="discounts[]" id="discount1" value="0"  type="text" class="form-control text-right" oninput="computePrice(1)" required>
                        </div>
                        <div class="form-group col-lg-2">
                            <label> الإجمالي</label>
                            <input name="final_prices[]" id="final_price1" type="text" class="form-control text-right" required>
                        </div>
                        <div class="form-group col-lg-1">
                            <span><label class="btn btn-sm btn-danger" onclick="removeDiv(this)"><i class="mdi mdi-delete"></i></label></span>
                        </div>
                    </div>

                    <div id="serve">
                    </div>      
                    
                    
                     <div class="row">
                        <div class="form-group col-lg-4">
                            <label></i> الإجمالي</label>
                            <input name="first_total" id="first_total" class="form-control text-right" value=0 required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label></i> الخصم على اجمالي الفاتوره</label>
                            <input name="total_discount" id="total_discount" oninput="computePrice(0)" type="number" value=0 class="form-control text-right" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>
                                 المبلغ النهائي
                                 &nbsp;&nbsp;
                                 (<input type="checkbox" name="has_tax"> ضريبه ؟)
                            </label>
                            <input name="total" id="total" type="number" value=0 class="form-control text-right" required>
                        </div>
                     </div>
        </div>
        <div class="card-footer" align="center">
            <button type="submit" class="btn btn-bg btn-primary btn-block">حفظ</button>
        </div>
    </form>

</div>

@endsection