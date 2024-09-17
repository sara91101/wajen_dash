<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://back.skilltax.sa/api/v1/loyalty/keys";
        $token = session("skillTax_token");
        // echo $token;exit;
        $client = new Client();
        try{
            $keys = $client->get($url,['headers' => ['Authorization' => 'Bearer ' . $token]]);

            $data["keys"] = json_decode($keys->getBody()->getContents(), true);

            return view("keys",$data);
        }
         catch (\Exception $e) {

            return back()->with("errorMessage",$e);
        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/loyalty/keys";

        $token = session("skillTax_token");

        $data = [
            "key_name" => $request->key_name,
            "key_value" => $request->key_value
        ];


        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);


        return redirect("/keys")->with("Message","Key Saved");
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/loyalty/keys/$request->key_id";

        $token = session("skillTax_token");
        // echo $token;exit;
        $data = [
            "key_name" => $request->key_name,
            "key_value" => $request->key_value
        ];


        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);


        return redirect("/keys")->with("Message","Key Updated");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $key_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/loyalty/keys/$key_id";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->delete($url, ['headers' => $headers]);

        return redirect("/keys")->with("Message","Key Deleted");

    }

}
