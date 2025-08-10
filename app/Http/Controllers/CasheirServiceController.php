<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CasheirServiceController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = json_decode(Http::get("https://back.skilltax.sa/api/v1/casheirServices"), true);
            
        return view('casheirServices',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $storeCity = $client->post("https://back.skilltax.sa/api/v1/casheirServices",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => ["ar_service" => $request->ar_service,"en_service" => $request->en_service]]);
        // return json_decode($storeCity->getStatusCode());

        return redirect("/casheirServices")->with("Message","تمت الاضافة");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $client = new Client();

        $token = session("skillTax_token");

        $client->post("https://back.skilltax.sa/api/v1/casheirServices/$request->Service_id",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => ["ar_service" => $request->ar_service,"en_service" => $request->en_service]]);

        return redirect("/casheirServices")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $service)
    {
        $client = new Client();

        $token = session("skillTax_token");

        $client->delete("https://back.skilltax.sa/api/v1/casheirServices/$service",['headers' => ['Authorization' => 'Bearer ' . $token]]);
        return redirect("/casheirServices")->with("Message","تم أرشفة الخدمه");
    }
}
