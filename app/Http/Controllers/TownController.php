<?php

namespace App\Http\Controllers;

use App\Http\Requests\TownRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use GuzzleHttpClientException\ClientException;
use Illuminate\Pagination\LengthAwarePaginator;
class TownController extends Controller
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

        $url = session("url")."v1";
        try
        {
            $towns = json_decode(Http::get("$url/cities"), true);
            //paginate result
            $newCollection = collect($towns);

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
        return view("towns",compact("towns"),$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TownRequest $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = session("url")."v1";
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
        $url = session("url")."v1";

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
        $url = session("url")."v1";

        $client->post("$url/cities/archive/$town",['headers' => ['Authorization' => 'Bearer ' . $token]]);
        return redirect("/towns")->with("Message","تم أرشفة المدينة");
    }
}
