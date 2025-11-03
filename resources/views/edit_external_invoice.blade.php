@extends('welcome')

@section('content') 

<script>
    let counter = {{ count($invoice_details['items']) }};
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
                            <span class="breadcrumb-item active" aria-current="page"> /  تعديل ({{ $membership_no }})</span>
                        </li>
                    </ol>

                </div>
    </div>

    <form method="POST" action="{{ route('external_invoices.update',$invoice->id) }}">
        @csrf
        <div class="card-body" dir="rtl">
                <input type="hidden" name="membership_no" value="{{ $membership_no }}">
                <input type="hidden" name="customer_id" value="{{ $id }}">
                <input type="hidden" name="skilltax_invoice_id" value="{{ $invoice_details['id'] }}">
                <input type="hidden" name="invoice_number" value="{{ $invoice_details['invoice_number'] }}">
                <input type="hidden" name="invoice_date" value="{{ $invoice_details['created_at'] }}">

                    <div class="form-group col-lg-12">
                        <div class="form-group col-lg-2">
                            <label class="btn btn-success btn-sm" onclick="addService()">
                                <i class="mdi mdi-plus"></i>
                                إضافة أصناف أخرى
                            </label>
                        </div>
                    </div>

                    @foreach ($invoice_details['items'] as $item)
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label></i> الصنف</label>
                                <input name="items[]" value="{{ $item['item'] }}" class="form-control text-right" required>
                            </div>
                            <div class="form-group col-lg-1">
                                <label></i> العدد</label>
                                <input name="quantities[]" id="quantity{{ $loop->index + 1 }}" value="{{ $item['quantity'] }}" type="number" class="form-control text-right" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label> المبلغ</label>
                                <input name="prices[]" id="price{{ $loop->index + 1 }}" value="{{ $item['price'] }}" type="text" class="form-control text-right" required oninput="computePrice({{ $loop->index + 1 }})">
                            </div>
                            <div class="form-group col-lg-2">
                                <label> الخصم</label>
                                <input name="discounts[]" id="discount{{ $loop->index + 1 }}"  value="{{ $item['discounts'] }}"  type="text" class="form-control text-right" oninput="computePrice({{ $loop->index + 1 }})" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label> الإجمالي</label>
                                <input name="final_prices[]" id="final_price{{ $loop->index + 1 }}" value="{{ $item['final_price'] }}" type="text" class="form-control text-right" required>
                            </div>
                            <div class="form-group col-lg-1">
                                <span><label class="btn btn-sm btn-danger" onclick="removeDiv(this)"><i class="mdi mdi-delete"></i></label></span>
                            </div>
                        </div>
                    @endforeach

                    <div id="serve">
                    </div>      
                    
                    
                     <div class="row">
                        <div class="form-group col-lg-4">
                            <label></i> الإجمالي</label>
                            <input name="first_total" id="first_total" value="{{ $invoice_details['price'] }}" class="form-control text-right" value=0 required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label></i> الخصم على اجمالي الفاتوره</label>
                            <input name="total_discount" id="total_discount" value="{{ $invoice_details['discounts'] }}" oninput="computePrice(0)" type="number" value=0 class="form-control text-right" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>
                                 المبلغ النهائي
                                 &nbsp;&nbsp;
                                 (<input type="checkbox" name="has_tax" @if($invoice_details['taxes'] != 0) checked @endif> ضريبه ؟)
                            </label>
                            <input name="total" id="total" type="number" value="{{ $invoice_details['final_price'] +  $invoice_details['taxes'] }}" value=0 class="form-control text-right" required>
                        </div>
                     </div>
        </div>
        <div class="card-footer" align="center">
            <button type="submit" class="btn btn-bg btn-primary btn-block">حفظ</button>
        </div>
    </form>

</div>

@endsection