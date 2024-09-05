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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    public function index(Request $request)
    {
        // Session::flush();
        // Auth::logout();

        // return redirect('/');
        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");

        $visits_dates = [];
        $sales_dates = [];
        $orders_dates = [];

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

        //customers_by_packages
        $data["customers_by_packages"] = $response["customers_by_packages"];

        //customers by towns
        $data["towns"] = $response["towns"];
        $data["townMap"] = $response["townMap"];

        //active & inActive customers guage
        $data["active"] = $response["active"];
        $data["inActive"] = $response["inActive"];

        //table of customers by system
        $data["customers_systems"] = Systm::with("customer")->get();


        //new statistics
        if($request->filter_type  == "orders")
        {
            $orders_dates = ["start_date" => $request->start_date,"end_date" => $request->end_date];
        }
        $orders_counts = json_decode($client->get("$url/ordersCount",
        ['headers' => ['Authorization' => 'Bearer '.$token],
        'json' => $orders_dates])->getBody()->getContents(), true);
        $data['completedOrders'] = $orders_counts['completedOrders'];
        $data['canceledOrders'] = $orders_counts['canceledOrders'];
        $data['totalOrders'] = $orders_counts['totalOrders'];

        if($request->filter_type  == "visits")
        {
            $visits_dates = ["start_date" => $request->start_date,"end_date" => $request->end_date];
        }
        $menu_visits = json_decode($client->get("$url/menuVisits",
        ['headers' => ['Authorization' => 'Bearer '.$token],
        "json" => $visits_dates])->getBody()->getContents(), true);
        $data['menu_visits'] = $menu_visits['visits'];

        if($request->filter_type  == "sales")
        {
            $sales_dates = ["start_date" => $request->start_date,"end_date" => $request->end_date];
        }
        $sales_amount = json_decode($client->get("$url/salesAmount",
        ['headers' => ['Authorization' => 'Bearer '.$token],
        "json"=>$sales_dates])->getBody()->getContents(), true);
        $data['sales_amount'] = $sales_amount['salesAmount'];


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
        $tax_no = $request->tax_no;

        Info::where("id",1)->update(["name_ar"=>"$name_ar","name_en"=>"$name_en",
        "address_ar"=>$address_ar,"address_en"=>"$address_en","tax_no"=>"$tax_no",
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

    public function changeMode()
    {
        $mode = Session("mode");
        if($mode == "dark")
        {
            Session(['mode' => "light"]);
        }
        else
        {
            Session(['mode' => "dark"]);
        }

        return back();
    }

}
