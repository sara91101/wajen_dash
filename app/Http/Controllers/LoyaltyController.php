<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoyaltyController extends Controller
{
    public function about()
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $subscribers = $client->get("$url/loyalty/loyaltyAbout",
        ['headers' => ['Authorization' => 'Bearer ' . $token],

        ]);
        $loyaltyAbout = json_decode($subscribers->getBody()->getContents(), true);

        return view("loyaltyAbout",compact("loyaltyAbout"));
    }

    public function updateAbout(Request $request)
    {

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        try
        {
            $client->post($url."/loyalty/loyaltyAbout", [
            'headers' => $headers,
            'json' => ["ar_about" => $request->ar_about,"en_about" => $request->en_about]
            ]);

            return redirect("/loyaltyAbout")->with("Message", "تم التعديل");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyAbout")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }

    }

    public function edit()
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $subscribers = $client->get("$url/loyalty/loyaltyAbout",
        ['headers' => ['Authorization' => 'Bearer ' . $token]]);
        $loyaltyAbout = json_decode($subscribers->getBody()->getContents(), true);

        return view("editLoyaltyAbout",compact("loyaltyAbout"));
    }
}
