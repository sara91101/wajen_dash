<?php

namespace App\Http\Controllers;

use App\Models\Info;
// use Barryvdh\DomPDF ;
use PDF;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class PriceShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Set default page
        $data["page"] = request()->has('page') ? request('page') : 1;

        // Set default per page
        $data["perPage"] =  10;

        // Offset required to take the results
        $offset = ($data["page"] * $data["perPage"]) - $data["perPage"];

        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        try
        {
            $priceShow = $client->get("$url/priceShow",['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $priceShowResult = json_decode($priceShow->getBody()->getContents(), true);


            //paginate result
            $newCollection = collect($priceShowResult);

            $data["results"] =  new LengthAwarePaginator(
                $newCollection->slice($offset, $data["perPage"]),
                $newCollection->count(),
                $data["perPage"],
                $data["page"],
                ['path' => request()->url(), 'query' => request()->query()]
           );
        }
        catch (ClientException $e) {

            return $e->getMessage();
        }
        return view("priceShow",$data);
    }

    public function create()
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1";

        $data["packages"] = json_decode($client->get("$url/packages", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        return view("createPrintShow", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1";

        $data = ["name" => $request->name,"activity_name" => $request->activity_name,
        "package_id" => $request->package_id,"final_price" => $request->final_price,
        "discount" => $request->discount,
        "items" => $request->items,
        "quantities" => $request->quantities,
        "prices" => $request->prices,
        "discounts" => $request->discounts,
        "final_prices" => $request->final_prices];
        // dd($data);exit;
        $client->post("$url/priceShow",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => $data]);

        return redirect("/priceShow")->with("Message","تمت الاضافة");
    }

    public function show($priceShowId)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["price"] = json_decode($client->get("$url/priceShow/$priceShowId", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

            // to put file data
        $fileName = "price".$data["price"]["id"].".pdf";
        $fileStorePath = public_path('prices/' . $fileName);


        $data["info"] = Info::first();

        // return view("price",$data);

        $pdf = PDF::loadView('price3', $data);

        $pdf->save(public_path("prices/$fileName"));
        return $pdf->stream($fileStorePath);
    }

    /**
     * Update the specified resource in storage.
     */

    public function edit($priceShowId)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["price"] = json_decode($client->get("$url/priceShow/$priceShowId", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

            $data["packages"] = json_decode($client->get("$url/packages", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                ])->getBody()->getContents(), true);

        return view("editPrice",$data);
    }
    public function update(Request $request,$priceShowId)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1";

        $data = ["name" => $request->name,"activity_name" => $request->activity_name,
        "package_id" => $request->package_id,"final_price" => $request->final_price,
        "discount" => $request->discount,"items" => $request->items,
        "quantities" => $request->quantities,
        "prices" => $request->prices,
        "discounts" => $request->discounts,
        "final_prices" => $request->final_prices];
    //dd($data);exit;
        $client->post("$url/priceShow/$priceShowId",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => $data]);

        return redirect("/priceShow")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($town)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1";

        $client->delete("$url/priceShow/$town",['headers' => ['Authorization' => 'Bearer ' . $token]]);
        return redirect("/priceShow")->with("Message","تم الحذف");
    }
}
