<?php

namespace App\Http\Controllers;

use App\Http\Requests\TownRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class TownController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://backend.skilltax.sa/api/v1";
        try{$towns = json_decode(Http::get("$url/cities"), true);}catch (\Exception $e) {

            return $e->getMessage();
        }
        return view("towns",compact("towns"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TownRequest $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $storeCity = $client->post("$url/cities",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => ["ar_name" => $request->ar_town,"en_name" => $request->en_town]]);
        // return json_decode($storeCity->getStatusCode());

        return redirect("/towns")->with("Message","تمت الاضافة");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TownRequest $request)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $client->post("$url/cities/$request->town_id",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => ["ar_name" => $request->ar_town,"en_name" => $request->en_town]]);

        return redirect("/towns")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $town)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $client->post("$url/cities/archive/$town",['headers' => ['Authorization' => 'Bearer ' . $token]]);
        return redirect("/towns")->with("Message","تم أرشفة المدينة");
    }
}
