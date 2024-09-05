<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use App\Models\Package;
use App\Models\Systm;
use App\Models\Town;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class ReportController extends Controller
{
    public function customers_systems_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        
        $data["systems"] = Systm::paginate(15);
        foreach($data["systems"] as $system)
        {
            if($system->id == 1)
            {
                $response = json_decode($client->get("$system->endPoint_url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
            
                $system->customer = $response["subscribers"];
            }
        }
        return view("customers_systems_report",$data);
        //echo "hi";
    }
    public function print_customers_systems_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        
        $data["systems"] = Systm::all();
        foreach($data["systems"] as $system)
        {
            if($system->id == 1)
            {
                $response = json_decode($client->get("$system->endPoint_url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
            
                $system->customer = $response["subscribers"];
            }
        }
        return view("print_customers_systems_report",$data);
    }

    public function customers_towns_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        $data["towns"] = $response["towns"];
        return view("customers_towns_report",$data);
    }
    public function print_customers_towns_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        $data["towns"] = $response["towns"];
        return view("print_customers_towns_report",$data);
    }

    public function customers_governorates_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        $data["governorates"] = $response["governorates"];
        
        return view("customers_governorates_report",$data);
    }
    public function print_customers_governorates_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        $data["governorates"] = $response["governorates"];
        return view("print_customers_governorates_report",$data);
    }

    public function customers_packages_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        
        $data["packages"] = $response["customers_by_packages"];
        return view("customers_packages_report",$data);
    }
    public function print_customers_packages_report()
    {
         $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        
        $data["packages"] = $response["customers_by_packages"];
        return view("print_customers_packages_report",$data);
    }

    public function customer_substraction_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        
        $data["systems"] = Systm::with("customer")->get();
        foreach($data["systems"] as $s)
        {
            //active & inActive customers guage
            $s->active = $response["active"];
            $s->inActive = $response["inActive"];
        }
        
        return view("customer_substraction_report",$data);
    }
    public function print_customer_substraction_report()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";
        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        
        $data["systems"] = Systm::with("customer")->get();
        foreach($data["systems"] as $s)
        {
            //active & inActive customers guage
            $s->active = $response["active"];
            $s->inActive = $response["inActive"];
        }
        return view("print_customer_substraction_report",$data);
    }
}
