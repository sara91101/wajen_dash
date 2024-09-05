<?php

namespace App\Http\Controllers;

use App\Http\Requests\GovernorateRequest;
use App\Models\Town;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use GuzzleHttpClientException\ClientException;
use Illuminate\Pagination\LengthAwarePaginator;
class GovernorateController extends Controller
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
        
        try
        {
            
            $client = new Client();

            $token = session("skillTax_token");
            $url = "https://backend.skilltax.sa/api/v1";

            $governorates = json_decode(Http::get("$url/governorates"), true);

            $towns = json_decode(Http::get("$url/cities"), true);
            
            //paginate result
            $newCollection = collect($governorates);

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

        return view("governorates",compact("governorates","towns"),$data);
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
