<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LoyaltySliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $sliders = $client->get("$url/loyalty/loyaltySlider",
        ['headers' => ['Authorization' => 'Bearer ' . $token],

        ]);
        $loyaltySliders = json_decode($sliders->getBody()->getContents(), true);

        return view("loyaltySlider",compact("loyaltySliders"));
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
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $headers = ['Authorization' => 'Bearer ' . $token,];

        $file = $request->file("image");
        $fileName = "loyalty_slider_".time(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('sliders'), $fileName);

        try
        {
            $client->post($url."/loyalty/loyaltySlider", [
            'headers' => $headers,
            'multipart' => [
                ['name'=> "ar_image_text",'contents' => $request->ar_image_text],
                    ['name'=> "en_image_text",'contents' => $request->en_image_text],
                    ['name'=> "image_order",'contents' =>$request->image_order],
                            [
                                'name'     => 'image',
                                'contents' => File::get(public_path('sliders')."/".$fileName) ,
                                'filename' => $fileName
                            ]]
                            ]);
            return redirect("/loyaltySlider")->with("Message", "تم الحفظ");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltySlider")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
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
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $slider_id = $request->slider_id;

        $headers = ['Authorization' => 'Bearer ' . $token,];

        if($request->file("image"))
        {
            $file = $request->file("image");
            $fileName = "loyalty_slider_".time(). '.' . $file->getClientOriginalExtension();
            $file->move(public_path('sliders'), $fileName);
            try
            {
                $client->post($url."/loyalty/loyaltySlider/$slider_id", [
                'headers' => $headers,
                'multipart' => [
                    ['name'=> "ar_image_text",'contents' => $request->ar_image_text],
                        ['name'=> "en_image_text",'contents' => $request->en_image_text],
                        ['name'=> "image_order",'contents' =>$request->image_order],
                                [
                                    'name'     => 'image',
                                    'contents' => File::get(public_path('sliders')."/".$fileName) ,
                                    'filename' => $fileName
                                ]]
                                ]);
                return redirect("/loyaltySlider")->with("Message", "تم التعديل");

            }
            catch (ClientException $e)
            {
                //return $e->getMessage();
                return redirect("/loyaltySlider")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }
        }
        else
        {
            // echo "no image";exit;
            try
            {
                $client->post($url."/loyalty/loyaltySlider/$slider_id", [
                'headers' => $headers,
                'json' => [ "ar_image_text" => $request->ar_image_text,
                         "en_image_text" => $request->en_image_text,
                         "image_order" =>$request->image_order]
                                ]);
                return redirect("/loyaltySlider")->with("Message", "تم التعديل");

            }
            catch (ClientException $e)
            {
                //return $e->getMessage();
                return redirect("/loyaltySlider")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->delete("$url/loyalty/loyaltySlider/$id",['headers' => ['Authorization' => 'Bearer ' . $token]]);

        return redirect("/loyaltySlider")->with("Message", "تم الحذف");
    }
}
