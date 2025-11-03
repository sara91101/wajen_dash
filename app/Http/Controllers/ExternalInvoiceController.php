<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\Invoice;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Prgayman\Zatca\Facades\Zatca;
use PDF;

class ExternalInvoiceController extends Controller
{
    
    public function edit($invoice , $membership_no , $id)
    {
        $data['invoice'] = Invoice::findOrFail($invoice);

        $data['membership_no'] = $membership_no;

        $data['id'] = $id;

        $client = new Client();
        $url = env('SKILLTAX_URL');
        $token = env("SKILLTAX_TOKEN");

       $data['invoice_details'] = json_decode($client->get($url."v2/external_invoices/".$data['invoice']->invoice_number, ['headers' => ['Authorization' => 'Bearer ' . $token]])
       ->getBody()->getContents(), true);

        return view('edit_external_invoice',$data);
    }

    public function destroy($invoice)
    {
        Invoice::where('id',$invoice)->delete();

        return back()->with("Message","تم الحذف");
    }

    

    public function update(Request $request)
    {
        $data['invoiceNumber'] = $request->invoice_number;

        $data["info"] = Info::first();

        $data['membership_no'] = $request->membership_no;
        $data['id'] = $request->customer_id;

        $data['items'] = $request->items;
        $data['quantities'] = $request->quantities;
        $data['prices'] = $request->prices;
        $data['discounts'] = $request->discounts;
        $data['final_prices'] = $request->final_prices;
        $data['sum_before_tax'] = $request->first_total;
        $data['discount'] = $request->total_discount;
        $data['tax_value'] = $request->has_tax ? ($request->total * 15 / 100) : 0;
        $data['sum_after_tax'] = $request->total - $data['tax_value'];

        $items_array = [];
        foreach($data['items'] as $x => $item){
            $items_array[] =  [
                    "item"=> $item,
                    "quantity"=> $data['quantities'][$x],
                    "price"=> $data['prices'][$x],
                    "discounts"=> $data['discounts'][$x] ?? 0,
                    "taxes"=> 0,
                    "final_price"=> $data['final_prices'][$x] ?? 0
            ];
        }

        //send data to skilltax
        $payload = [
                "invoice_number"=> $data['invoiceNumber'],
                "membership_no"=> $data['membership_no'],
                "price"=> $data['sum_before_tax'],
                "discounts"=> $data['discount'],
                "taxes"=> $data['tax_value'],
                "final_price"=> $data['sum_after_tax'],
                "items"=> $items_array
            ];

        $client = new Client();
        $url = env('SKILLTAX_URL');
        $token = env("SKILLTAX_TOKEN");

       $client->put($url."v2/external_invoices/$request->skilltax_invoice_id", ['headers' => ['Authorization' => 'Bearer ' . $token],'json'=> $payload]);
        
        //subscriber info 
        $subscriber = json_decode($client->get($url."v1/subscribers/$request->customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $data['subscriber_name'] = $subscriber["first_name"]." ".$subscriber["last_name"];
        $data['subscriber_phone_no'] = $subscriber["phone_no"];
        $data['subscriber_tax_number'] = $subscriber["tax_number"];
        $data['subscriber_address'] = $subscriber["city"];

        $data["info"] = Info::first();

        $date = Carbon::parse($request->invoice_date)->format('Y-m-d');

        $data["base64"] = Zatca::sellerName('شركة وجين لتقنية المعلومات')
                ->vatRegistrationNumber($data["info"]->tax_no)
                ->timestamp($date)
                ->totalWithVat($data['sum_after_tax'])
                ->vatTotal($data['tax_value'])
                ->toQrCode(
                    qrCodeOptions()
                      ->format("svg")
                      ->size(150)
                  );

        $pdf = PDF::loadView('deviceBill', $data);

        $fileName = "external_invoice".$data['invoiceNumber'].".pdf";

        $pdf->save(public_path("bills/$fileName"));
        
        return redirect(route('customerInvoices',['membership_no' => $request->membership_no , 'customer_id' => $request->customer_id]));
    }
}
