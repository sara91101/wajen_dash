<?php

namespace App\Http\Controllers;

use App\Http\Requests\GovernorateRequest;
use App\Models\Town;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $governorates = json_decode(Http::get("$url/governorates"), true);

        $towns = json_decode(Http::get("$url/cities"), true);

        return view("governorates",compact("governorates","towns"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GovernorateRequest $request)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $client->post("$url/governorates",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => ["city_id"=> $request->town_id ,"ar_name" => $request->ar_governorate,"en_name" => $request->en_governorate]]);

        return redirect("/governorates")->with("Message","تمت الاضافة");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(GovernorateRequest $request)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $client->post("$url/governorates/$request->governorate_id",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
         "json" => ["city_id"=> $request->town_id ,"ar_name" => $request->ar_governorate,"en_name" => $request->en_governorate]]);

        return redirect("/governorates")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $governorate)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $client->delete("$url/governorates/$governorate",['headers' => ['Authorization' => 'Bearer ' . $token]]);

        return redirect("/governorates")->with("Message","تم أرشفة المحافظة");
    }
}
