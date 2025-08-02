<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Governorate;
use App\Models\Info;
use App\Models\Month;
use App\Models\Package;
use App\Models\Systm;
use App\Models\Town;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $response = json_decode($client->get("$url/subscriber_statistics",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);

        //statistsics
        $data["customers"] = $response["subscribers"];
        $data["systems"] = Systm::count();
        $data["packages"] = $response["packages"];
        $data["profits"] = $response["profits"];

        //customers by months
        $data["months"] = $response["months"];

        //customers by governorates
        $data["governorates"] = $response["governorates"];

        //customers by towns
        $data["towns"] = $response["towns"];
        $data["townMap"] = $response["townMap"];

        //active & inActive customers guage
        $data["active"] = $response["active"];
        $data["inActive"] = $response["inActive"];

        //table of customers by system
        $data["customers_systems"] = Systm::with("customer")->get();



        return view('home',$data);
    }



    public function info()
    {
        $data["info"] = Info::first();
        return view("info",$data);
    }

    public function editInfo(Request $request)
    {
        $name_ar = $request->name_ar;
        $name_en = $request->name_en;
        $address_ar = $request->address_ar;
        $address_en = $request->address_en;
        $email = $request->email;
        $phone = $request->phone;

        Info::where("id",1)->update(["name_ar"=>"$name_ar","name_en"=>"$name_en",
        "address_ar"=>$address_ar,"address_en"=>"$address_en",
        "email"=>$email,"phone"=>$phone,]);

        if($request->hasFile('logo'))
        {
      	    $file = $request->file('logo');
            $filename = $file->getClientOriginalName();
            $file->move('imgs/',$filename);
      	     Info::where("id",1)->update(["logo"=>"/imgs/".$filename]);
        }
        if($request->hasFile('bill'))
        {
      	    $file = $request->file('bill');
            $filename = $file->getClientOriginalName();
            $file->move('imgs/',$filename);
      	     Info::where("id",1)->update(["bill"=>"/imgs/".$filename]);
        }

        return redirect("/info");
    }


}
