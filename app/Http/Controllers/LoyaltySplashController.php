<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LoyaltySplashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $splashes = $client->get("$url/loyalty/loyaltySplash",
        ['headers' => ['Authorization' => 'Bearer ' . $token],

        ]);
        $loyaltySplashes = json_decode($splashes->getBody()->getContents(), true);

        return view("loyaltySplash",compact("loyaltySplashes"));
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
        $fileName = "loyalty_splash_".time(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('splashes'), $fileName);

        try
        {
            $client->post($url."/loyalty/loyaltySplash", [
            'headers' => $headers,
            'multipart' => [
                    ['name'=> "ar_text",'contents' => $request->ar_text],
                    ['name'=> "en_text",'contents' => $request->en_text],
                            [
                                'name'     => 'image',
                                'contents' => File::get(public_path('splashes')."/".$fileName) ,
                                'filename' => $fileName
                            ]]
                            ]);
            return redirect("/loyaltySplash")->with("Message", "تم الحفظ");

        }
        catch (ClientException $e)
        {
            //return $e->getMessage();
            return redirect("/loyaltySplash")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
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

        $splash_id = $request->splash_id;

        $headers = ['Authorization' => 'Bearer ' . $token,];

        if($request->file("image"))
        {
            $file = $request->file("image");
            $fileName = "loyalty_splash_".time(). '.' . $file->getClientOriginalExtension();
            $file->move(public_path('splashes'), $fileName);
            try
            {
                $client->post($url."/loyalty/loyaltySplash/$splash_id", [
                'headers' => $headers,
                'multipart' => [
                        ['name'=> "ar_text",'contents' => $request->ar_text],
                        ['name'=> "en_text",'contents' => $request->en_text],
                                [
                                    'name'     => 'image',
                                    'contents' => File::get(public_path('splashes')."/".$fileName) ,
                                    'filename' => $fileName
                                ]]
                                ]);
                return redirect("/loyaltySplash")->with("Message", "تم التعديل");

            }
            catch (ClientException $e)
            {
                //return $e->getMessage();
                return redirect("/loyaltySplash")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }
        }
        else
        {
            // echo "no image";exit;
            try
            {
                $client->post($url."/loyalty/loyaltySplash/$splash_id", [
                'headers' => $headers,
                'json' => [ "ar_text" => $request->ar_text,
                         "en_text" => $request->en_text]
                                ]);
                return redirect("/loyaltySplash")->with("Message", "تم التعديل");

            }
            catch (ClientException $e)
            {
                //return $e->getMessage();
                return redirect("/loyaltySplash")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
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

        $client->delete("$url/loyalty/loyaltySplash/$id",['headers' => ['Authorization' => 'Bearer ' . $token]]);

        return redirect("/loyaltySplash")->with("Message", "تم الحذف");
    }
}
