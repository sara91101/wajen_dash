<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoyaltyCustomerController extends Controller
{
    public function index($page = 1,Request $request)
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $data["page"] = $page;

        $json_data = ["pages" => 100];

        if($request->membership_no)
        {
            $json_data["membership_no"] = $request->membership_no;
        }
        // print_r($json_data);exit;
        $Customers = $client->get("$url/loyalty/allCustomers?page=$page",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
            'json'=> $json_data
        ]);

        // print_r(json_decode($Customers->getBody()->getContents(), true)["data"]);exit;
        $loyaltyCustomersAll = json_decode($Customers->getBody()->getContents(), true);

        $data["loyaltyCustomers"] = $loyaltyCustomersAll["data"];
        $data["total"] = $loyaltyCustomersAll["total"];

        return view("loyaltyCustomer",$data);
    }

    public function notifyMultipleLoyalty(Request $request)
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $data["page"] = $request->page;

        $json_data = ["pages" => 100];

        if($request->membership_no)
        {
            $json_data["membership_no"] = $request->membership_no;
        }
        // print_r($json_data);exit;
        $Customers = $client->get("$url/loyalty/allCustomers?page=$request->page",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
            'json'=> $json_data
        ]);

        // print_r(json_decode($Customers->getBody()->getContents(), true)["data"]);exit;
        $loyaltyCustomersAll = json_decode($Customers->getBody()->getContents(), true);

        $data["loyaltyCustomers"] = $loyaltyCustomersAll["data"];
        $data["total"] = $loyaltyCustomersAll["total"];

        return view("notifyLoyaltyCustomers",$data);
    }

    public function sendLoyaltyNotification(Request $request)
    {
        $loyalties_ids = $request->loyalties;
        $title = $request->title;
        $message = $request->message;

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v2/usersDashboardNotification";

        $token = session("skillTax_token");
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        try
        {
            $postResponse = $client->post($url, [
            'headers' => $headers,
            'json' => ["title"=> $title,"message"=> $message,"users"=>$loyalties_ids]
            ]);

            $returned_code = $postResponse->getStatusCode();
            if($returned_code == 201)
            {
                return redirect("/loyaltyCustomers/1")->with("Message", " تم إرسال الإشعار");
            }
            else
            {
                return redirect("/loyaltyCustomers/1")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }

        }
        catch (ExceptionClientException $e)
        {
            return redirect("/loyaltyCustomers/1")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }

    

    public function messageMultipleLoyalty(Request $request)
    {
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $data["page"] = $request->page;

        $json_data = ["pages" => 100];

        if($request->membership_no)
        {
            $json_data["membership_no"] = $request->membership_no;
        }
        // print_r($json_data);exit;
        $Customers = $client->get("$url/loyalty/allCustomers?page=$request->page",
        ['headers' => ['Authorization' => 'Bearer ' . $token],
            'json'=> $json_data
        ]);

        // print_r(json_decode($Customers->getBody()->getContents(), true)["data"]);exit;
        $loyaltyCustomersAll = json_decode($Customers->getBody()->getContents(), true);

        $data["loyaltyCustomers"] = $loyaltyCustomersAll["data"];
        $data["total"] = $loyaltyCustomersAll["total"];

        return view("messageMultipleLoyalty",$data);
    }

    public function sendLoyaltyMessage(Request $request)
    {
        $message = $request->message;

        $phones = $request->phones;

        //dd($phones);

        $responseStatusCode = 200;
        
        try {
                $apiUrl = 'https://www.msegat.com/gw/sendsms.php';

                foreach($phones as $phone){
                    $data = [
                        'userName' => 'Wajen5188',
                        'apiKey' => env('OTP_MESSAGE_KEY'),
                        'numbers' => $phone,
                        'userSender' => 'WAJEN',
                        'msg' => $message,
                    ];

                    // Make request to msegat api
                    $response = Http::post($apiUrl, $data);

                    
                    $responseData = $response->json();
                    // return $responseData;
                    $responseStatusCode = $response->status(); // Get the status code of the response
                }

                // $responseStatusCode = 200;

                if ($responseStatusCode === 200) {
                    return redirect("/loyaltyCustomers/1")->with("Message", " تم إرسال الرسائل");
                } else {
                    // Data creation failed
                    return redirect("/loyaltyCustomers/1")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
                }
            } catch (\Exception $e) {
                Log::error('Error in sending OTP '. $e->getMessage());
                return redirect("/loyaltyCustomers/1")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");

            }
    }
}
