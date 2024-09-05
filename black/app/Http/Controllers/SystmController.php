<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystmRequest;
use App\Models\Systm;
use GuzzleHttp\Client;


class SystmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $client = new Client();
        $token = session("skillTax_token");
        
        $data["systems"] = Systm::paginate(15);
        foreach($data["systems"] as $system)
        {
            $system->casheirs = 0;
            $url = "https://backend.skilltax.sa/api/v1";
            if($system->id == 1)
            {
                $response = json_decode($client->get("$system->endPoint_url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
            
                $system->customers = $response["subscribers"];
            
                $casheirs = json_decode($client->get("$url/allCasheirs", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                ])->getBody()->getContents(), true);
            
                foreach($casheirs as $casheir)
                {
                    if($casheir["status"] == 1)
                    {
                        $system->casheirs ++;
                    }
                }
            }
        }
        return view("systems",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SystmRequest $request)
    {
        $system = new Systm();
        $system->system_name_ar = $request->input("system_name_ar");
        $system->system_name_en = $request->input("system_name_en");
        $system->url = $request->input("url");
        $system->endPoint_url = "https://backend.skilltax.sa/api/v1";

        $arNameExist = Systm::where('system_name_ar', $request->input("system_name_ar"))->exists();

        $enNameExist = Systm::where('system_name_en', $request->input("system_name_en"))->whereNotNull("system_name_en")->exists();

        if($arNameExist || $enNameExist)
        {
            return redirect("/systems")->with("Notify","النظام مٌدخل مٌسبقاً ");
        }

        $system->save();

        return redirect("/systems")->with("Message","تمت الاضافة");
    }

    /**
     * Display the specified resource.
     */
    public function show(Systm $systm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SystmRequest $request)
    {
        $system = Systm::find($request->input("system_id"));
        $system->system_name_ar = $request->input("system_name_ar");
        $system->system_name_en = $request->input("system_name_en");
        $system->url = $request->input("url");
        $system->endPoint_url = "https://backend.skilltax.sa/api/v1";
        $system->update();

        return redirect("/systems")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($systm_id)
    {
        Systm::where("id",$systm_id)->delete();
        return redirect("/systems")->with("Message","تم الحذف");

    }
}
