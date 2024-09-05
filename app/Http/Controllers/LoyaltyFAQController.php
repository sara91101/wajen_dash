<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class LoyaltyFAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $subscribers = $client->get("$url/loyalty/loyaltyFAQ",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
        ]);
        $faqs = json_decode($subscribers->getBody()->getContents(), true);

        return view("loyaltyFAQ",compact("faqs"));
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
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        try
        {
            $client->post($url."/loyalty/loyaltyFAQ", [
            'headers' => $headers,
            'json' => ["question_ar" => $request->ar_question,"question_en" => $request->en_question,
                        "answer_ar" => $request->ar_answer,"answer_en" => $request->en_answer]
            ]);

            return redirect("/loyaltyFAQ")->with("Message", "تم الحفظ");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyFAQ")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $faq_id = $request->faq_id;

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        try
        {
            $client->post($url."/loyalty/loyaltyFAQ/$faq_id", [
            'headers' => $headers,
            'json' => ["question_ar" => $request->ar_question,"question_en" => $request->en_question,
                        "answer_ar" => $request->ar_answer,"answer_en" => $request->en_answer]
            ]);

            return redirect("/loyaltyFAQ")->with("Message", "تم التعديل");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyFAQ")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
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
            $client->delete($url."/loyalty/loyaltyFAQ/$id", [
            'headers' => $headers]);

            return redirect("/loyaltyFAQ")->with("Message", "تم الحذف");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltyFAQ")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }
}
