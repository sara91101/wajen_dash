<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
}
