<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class LoyaltyConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $subscribers = $client->get("$url/loyalty/loyaltyConditions",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
        ]);
        $conditions = json_decode($subscribers->getBody()->getContents(), true);

        return view("loyaltyCondition",compact("conditions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("createLoyaltyCondition");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        try
        {
            $client->post($url."/loyalty/loyaltyConditions", [
            'headers' => $headers,
            'json' => ["ar_title" => $request->ar_title,"en_title" => $request->en_title,
                        "ar_details" => $request->ar_details,"en_details" => $request->en_details]
            ]);

            return redirect("/loyaltyConditions")->with("Message", "تم الحفظ");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyConditions")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $subscribers = $client->get("$url/loyalty/loyaltyConditions/$id",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
        ]);
        $condition = json_decode($subscribers->getBody()->getContents(), true);

        return view("editLoyaltyCondition",compact("condition"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        try
        {
            $client->post($url."/loyalty/loyaltyConditions/$id", [
            'headers' => $headers,
            'json' => ["ar_title" => $request->ar_title,"en_title" => $request->en_title,
                        "ar_details" => $request->ar_details,"en_details" => $request->en_details]
            ]);

            return redirect("/loyaltyConditions")->with("Message", "تم التعديل");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyConditions")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        try
        {
            $client->delete($url."/loyalty/loyaltyConditions/$id", [
            'headers' => $headers]);

            return redirect("/loyaltyConditions")->with("Message", "تم الحذف");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyConditions")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }
}
