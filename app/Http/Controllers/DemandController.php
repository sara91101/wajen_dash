<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Demand;
use App\Models\Systm;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");
        $types = [];
        try {
            $subscribers = $client->get("$url/freeTrials", ['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $demands = json_decode($subscribers->getBody()->getContents(), true);
            
            foreach($demands as $demand)
            {
                $type = $demand["activity_type"];
                $act = Activity::find($type);
                array_push($types, "$act->activity_ar");
            }
        } catch (ClientException $e) {
            return $e->getMessage();
        }
        return view("demands", compact("demands","types"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Demand $demand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demand $demand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Demand $demand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $demand)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1/freeTrials";
        $token = session("skillTax_token");

        $client->delete("$url/$demand", ['headers' => ['Authorization' => 'Bearer ' . $token]]);

        return redirect("/demands")->with("Message", "تم حذف الطلب");
    }

    public function registerDemand($demand)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/freeTrials/$demand", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ])->getBody()->getContents(), true);

        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);

        $data["towns"] = json_decode(Http::get("$url/cities"), true);

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();

        $data["packages"] = json_decode($client->get("$url/packages", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ])->getBody()->getContents(), true);

        $data["today"] = date("Y-m-d");
        $data["afterMonth"] = now()->addDays(30)->toDateString();


        return view("createCustomer",$data);
    }

}
