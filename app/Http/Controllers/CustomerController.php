<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\CustomerUser;
use App\Models\Info;
use App\Models\Major;
use App\Models\Message;
use App\Models\Minor;
use App\Models\Package;
use App\Models\Systm;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Prgayman\Zatca\Facades\Zatca;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set default page
        $data["page"] = request()->has('page') ? request('page') : 1;

        // Set default per page
        $data["perPage"] =  10;

        // Offset required to take the results
        $offset = ($data["page"] * $data["perPage"]) - $data["perPage"];

        //search

        if($request->input('customer') != 0)
        {
            Session(['customer' => $request->customer]);
        }
        if($request->input('activity') != 0)
        {
            Session(['activity' => $request->activity]);
        }
        if($request->input('town') != 0)
        {
            Session(['town_id' => $request->town]);
        }
        if($request->input('package_id') != 0)
        {
            Session(['package_id' => $request->package_id]);
        }
        //endsearch

        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");
        try
        {
            $counter = 0;
            $subscribers = $client->get("$url/subscribers",['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $customers = json_decode($subscribers->getBody()->getContents(), true);

            //paginate result
            $newCollection = collect($customers)->filter(function ($item,$counter)
                {

                    if($item["is_archived"] == 1) {$counter++;}
                    return ($item["is_archived"] != 1) &&  (session('activity') != "" ? $item["activity_type"] == session('activity') : $item["is_archived"] != 1)
                    &&  (session('town_id') != "" ? $item["city_id"] == session('town_id') : $item["is_archived"] != 1)
                    &&  (session('package_id') != "" ? $item["package_id"] == session('package_id') : $item["is_archived"] != 1)
                    && ((session('customer') != "" ? str_contains($item["first_name"], session('customer'))  :  $item["is_archived"] != 1)
                    || (session('customer') != "" ? str_contains($item["last_name"], session('customer'))  :  $item["is_archived"] != 1)
                    || (session('customer') != "" ? str_contains($item["membership_no"], session('customer'))  :  $item["is_archived"] != 1)
                    || (session('customer') != "" ? str_contains($item["phone_no"], session('customer'))  :  $item["is_archived"] != 1)
                    || (session('customer') != "" ? str_contains($item["email"], session('customer'))  :  $item["is_archived"] != 1));

                });

            $data["results"] =  new LengthAwarePaginator(
                $newCollection->slice($offset, $data["perPage"]),
                $newCollection->count() - $counter,
                $data["perPage"],
                $data["page"],
                ['path' => request()->url(), 'query' => request()->query()]
           );

           $data["packages"] = json_decode(Http::get("$url/packages"), true);

            $data["towns"] = json_decode(Http::get("$url/cities"), true);
            $data["governorates"] = json_decode(Http::get("$url/governorates"), true);

        }
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/home")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();

        $systm = Systm::first();

        return view("customers", compact("customers","systm"),$data);
    }

    public function showAll()
    {
        Session(['customer' => ""]);
        Session(['activity' => ""]);
        Session(['town_id' => ""]);
        Session(['package_id' => ""]);

        return redirect("/customers");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1";

        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);

        $data["towns"] = json_decode(Http::get("$url/cities"), true);

        $data["systems"] = Systm::all();
        $data["activities"] = json_decode(Http::get("$url/loyalty/activityTypes"),true);

        $data["packages"] = json_decode($client->get("$url/packages", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        return view("createCustomer", $data);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function skilltax_customer_register($data)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/subscribers/register";
        $headers = [
            'Content-Type' => 'application/json',
        ];
        try
        {
            $postResponse = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
            'http_errors' => false
            ]);

         return json_decode($postResponse->getBody()->getContents());
        }
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }

    }

    public function skilltax_customer_package($membership_no, $package_id)
    {
        // to put file data
        $fileName = $membership_no.".json";
        $fileStorePath = public_path('jsons/' . $fileName);
        $dataMajors = [];
        $package = Package::with(['packageMinor' => function ($query) {
            $query->join("minors", "minors.id", "package_minors.minor_id");
        }])->where("id", $package_id)->first();

        $majorsArray = [];
        $minorsArray = [];

        foreach ($package->packageMinor as $pn) {
            $majorsArray[] = $pn->major_id;
            $minorsArray[] = $pn->minor_id;
        }

        $majorsArrays = Major::whereIn("id", $majorsArray)->get();
        foreach ($majorsArrays as $ma) {
            //subscriber property insertion
            $major = Major::find($ma->id);

            //permission list insertion
            $minors = Minor::where("major_id", $ma->id)->whereIn("id", $minorsArray)->with(["property" => function ($query) {
                $query->with("operation");
            }])->get();

            $minorData = [];

            foreach ($minors as $minor) {
                $properties = [];
                if (sizeof($minor->property) > 0) {
                    foreach ($minor->property as $mp) {
                        $operations = [];
                        if (sizeof($mp->operation) > 0) {
                            foreach ($mp->operation as $mpo) {
                                $operations[] = ["operation_ar" => "$mpo->operation_ar"];
                            }
                        }
                        $properties[] = ["property_ar" => "$mp->property_ar", "operations" => $operations];
                    }
                }
                $minorData[] = ["permission" => "$minor->minor_ar", "properties" => $properties];
            }
            $dataMajors[] = ["dash_id" => $major->id, "property" => "$major->major_ar", "membership_no" => "$membership_no", "permissionLists" => $minorData];
        }


        $data = [
            "membership_no" => $membership_no,
            "package" => $dataMajors,
        ];

        File::put($fileStorePath, json_encode($data));
    }

    public function store(CustomerRequest $request)
    {
        $url = "https://back.skilltax.sa/api/v1";
        $data = [
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('second_name'),
            "email" => $request->input('email'),
            "phone_no" => $request->input('phone'),
            "business_name" => $request->input('bussiness_name'),
            "tax_number" => $request->input('tax_no'),
            "activity_type" => $request->input('activity_id'),
            "city_id" => $request->input('town_id'),
            "governorate_id" => $request->input('governorate_id'),
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "password" => $request->input('password'),
            "paid" => 1,
            "password_confirmation" => $request->input('password'),

            "package_id" => $request->package_id,
            "final_amount" => $request->amount,
            "taxes" => 15,
            "discounts" => $request->discounts,
            "tax_percent" => 2,
            "discount_percent" => $request->discount_percent,

            "services"=>$request->service,
            "quantities"=>$request->quantity,
            "prices"=>$request->price,

            "user_id" => Auth::user()->id,
            "is_testing_account"=>$request->is_testing_account,

            "item_discounts"=>$request->item_discounts,
            "discount_types"=>$request->discount_type_value,
            "full_prices"=>$request->full_prices,

        ];

        $subscriber = $this->skilltax_customer_register($data);

        if (!$subscriber)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
        $membership_no = $subscriber->membership_no;

        $this->skilltax_customer_package($membership_no, $request->dash_id);

        $fileName = $membership_no . ".json";
        $contents = File::get(public_path('/jsons/' . $fileName));

        // echo $contents;exit;
        $client = new Client();

        $token = session("skillTax_token");

        $client->post("$url/permissionList", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => json_decode($contents)
        ]);

        $this->CustomerBill($subscriber->id, $subscriber->package_id, 1);

        return redirect("/customers")->with("Message", "تمت الاضافة");
    }

    public function sendSubscriptionDetails($subscriber_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $subscriber = json_decode($client->get("$url/subscribers/$subscriber_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $this->CustomerBill($subscriber_id, $subscriber['package_id'], 1);

        $attach = $subscriber['membership_no'] . "_" . $subscriber['package_id'];

        $fullname = $subscriber['first_name'] . " " . $subscriber['last_name'];

        try
        {
            Mail::to($subscriber['email'])->send(new \App\Mail\SendMail(
                $fullname,
                'Welcome to SkillTax POS system',
                $subscriber['membership_no'],
                $subscriber['subscription_start_at'],
                $subscriber['subscription_end_at'],
                $attach
            ));

            $message = new Message();
            $message->membership_no = $subscriber['membership_no'];
            $message->title = "رسالة إكتمال التسجيل";
            $message->body = "Subscriber Name: $fullname <br>
            Membership ID:  ".$subscriber['membership_no']." <br>
            Subscription Start Date / Time :  ".$subscriber['subscription_start_at']." <br>
            Subscription End Date / Time :".  $subscriber['subscription_end_at'] ;
            $message->save();
        }
        catch (GuzzleException $e) { return response()->json(["error"=>$e],401);}

        return redirect("customers")->with('Message','تم إرسال بيانات الإشتراك');
    }

    public function sendInvoice(Request $request)
    {
        $path = "";
        if ($request->hasFile('attachment')) {
            if ($request->attachment && $request->attachment->isValid()) {
                $file_name = time() . '.' . $request->attachment->extension();
                $request->attachment->move(public_path('attachments'), $file_name);

                $path = "attachments/$file_name";
            }
        }
        $details = ['title' => $request->title, 'body' => $request->body, 'path' => $path];

        Mail::to($request->email)->send(new \App\Mail\CustomerMail($details));

        return redirect("customers")->with("Message","تم إرسال البريد الإلكتروني");
    }


    /**
     * Display the specified resource.
     */
    public function show($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $data["casheirs"] = json_decode($client->get("$url/allCasheirs", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $employees = $client->get("$url/all_employees", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ]);

        $data["system"] = Systm::first();

        $data["employees"] = json_decode($employees->getBody()->getContents());

        $membership_no = $data['customer']['membership_no'];
        $data["packages"] = json_decode($client->get("$url/subscribers/packages/$membership_no", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents());

        $data["branches"] = json_decode($client->get("$url/subscriberBranches/".$membership_no, [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                ])->getBody()->getContents());


        $data["services"] = json_decode($client->get("$url/subscriber_service/$membership_no", [
        'headers' => ['Authorization' => 'Bearer ' . $token],
        ])->getBody()->getContents(), true);




        return view("customer", $data);
    }

     public function archieveBranch($branch_id,$customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->delete("$url/branches/$branch_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ]);

        return redirect("/showCustomer/$customer_id")->with("Message", "تم حذف الفرع");

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $membership_no = $data["customer"]["membership_no"];
        $customer_package_id = $data["customer"]["package_id"];

        $data["systems"] = Systm::with("package")->get();

        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);

        $data["towns"] = json_decode(Http::get("$url/cities"), true);

        $data["activities"] = json_decode(Http::get("$url/loyalty/activityTypes"),true);

        $data["packages"] = json_decode($client->get("$url/packages", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $customer_packages = json_decode($client->get("$url/subscribers/packages/$membership_no", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                ])->getBody()->getContents());
        foreach($customer_packages as $customer_package)
        {
            if($customer_package->package_id == $customer_package_id)
            {
                $data["customerPackage"] = $customer_package;
            }
        }

         $data["services"] = json_decode($client->get("$url/subscriber_service/$membership_no", [
        'headers' => ['Authorization' => 'Bearer ' . $token],
        ])->getBody()->getContents(), true);


        return view("editCustomer", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request,  $customer_id)
    {

        $client = new Client();

        $token = session("skillTax_token");
        // echo $request->membership_no;
        // echo $request->package_id;
        // exit;
        $url = "https://back.skilltax.sa/api/v1";
        $data = [
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('second_name'),
            "email" => $request->input('email'),
            "phone_no" => $request->input('phone'),
            "business_name" => $request->input('bussiness_name'),
            "tax_number" => $request->input('tax_no'),
            "activity_type" => $request->input('activity_id'),
            "city_id" => $request->input('town_id'),
            "governorate_id" => $request->input('governorate_id'),
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "password" => $request->input('password'),

            "package_id" => $request->package_id,
            "final_amount" => $request->amount,
            "taxes" => 15,
            "discounts" => $request->discounts,
            "taxes_type" => 2,
            "discount_percent" => $request->discount_percent,

            "services"=>$request->service,
            "quantities"=>$request->quantity,
            "prices"=>$request->price,

            "user_id" => Auth::user()->id,
            "renew"=> $request->renew,
            "is_testing_account"=>$request->is_testing_account,

            "item_discounts"=>$request->item_discounts,
            "discount_types"=>$request->discount_type_value,
            "full_prices"=>$request->full_prices,

        ];
        $membership_no = $request->membership_no;

        try {
            $client->post("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => $data
        ]);}
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }

        if($request->package_id != $request->previous_customer_package)
        {
            $this->skilltax_customer_package($membership_no, $request->dash_id);

            $fileName = $membership_no . ".json";
            $contents = File::get(public_path('/jsons/' . $fileName));

            try{
            $client->post("$url/updatePermissionList", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                'json' => json_decode($contents)
            ]);
            }
            catch (GuzzleException $e)
            {
                //return $e->getMessage();
                return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }
        }
        return redirect("/customers")->with("Message", "تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        try{$client->post("$url/subscribers/archive/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);}
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }

        return redirect("/customers")->with("Message", "تم أرشفة المشترك");
    }

    public function newCustomerUser(Request $request, $customer_id)
    {
        $custmerUser = new CustomerUser();
        $custmerUser->customer_id = $customer_id;
        $custmerUser->user_type_id  = $request->input("type");
        $custmerUser->user_name = $request->input("user_name");
        $custmerUser->password = $request->input("password");
        $custmerUser->save();

        return redirect("/showCustomer/$customer_id")->with("Message", "تم إضافة المستخدم");
    }

    public function updateCustomerUser(Request $request)
    {
        $custmerUser = CustomerUser::find($request->input("user_id"));
        $custmerUser->user_type_id  = $request->input("type");
        $custmerUser->user_name = $request->input("user_name");
        $custmerUser->password = $request->input("password");
        $custmerUser->update();

        return redirect("/showCustomer/$custmerUser->customer_id")->with("Message", "تم تعديل المستخدم");
    }

    public function destroyCustomerUser($user_id)
    {
        $custmerUser = CustomerUser::find($user_id);
        $customer_id = $custmerUser->customer_id;
        $custmerUser->delete();
        return redirect("/showCustomer/$customer_id")->with("Message", "تم حذف المستخدم");
    }

    /*public function CustomerBill($customer_id, $package_id, $status)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $membership_no = $data["customer"]["membership_no"];

        $subscriber_packages = json_decode($client->get("$url/subscribers/packages/$membership_no", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                ])->getBody()->getContents());

        foreach($subscriber_packages as $subscriber_package)
        {
            if($subscriber_package->package_id == $package_id)
            {
                $data["package"] = $subscriber_package;
                $data["user"] = User::find($subscriber_package->user_id);
            }
        }

        $data["sys"] = Systm::first();
        $data["info"] = Info::first();

        if(!is_null($data["package"]->taxes)){$taxes = $data["package"]->taxes;}
        else {$taxes = 0;}

        if($data["package"]->taxes_type == 2){$taxes = $data["package"]->price * $data["package"]->taxes / 100;}

        $date = Carbon::now()->toDateTimeString();
        $data["base64"] = Zatca::sellerName($data["info"]->name_ar)
                ->vatRegistrationNumber($data["info"]->tax_no)
                ->timestamp($date)
                ->totalWithVat($data["package"]->final_amount)
                ->vatTotal($taxes)
                ->toQrCode(
                    qrCodeOptions()
                      ->format("svg")
                      ->size(150)
                  );

         $data["services"] = json_decode($client->get("$url/subscriber_service/$membership_no", [
        'headers' => ['Authorization' => 'Bearer ' . $token],
        ])->getBody()->getContents(), true);


        $pdf = PDF::loadView('bill3', $data);
        //return view("bill",$data);


        $fileName = $membership_no."_".$package_id.".pdf";
        //
        if ($status == 1) {
            return $pdf->save(public_path("bills/$fileName"));
        } else {
            $pdf->stream($membership_no."_invoice.pdf");
        }
    }*/




    public function CustomerBill($customer_id, $package_id, $status)
    {
        $sum = 0;

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $membership_no = $data["customer"]["membership_no"];

        $subscriber_packages = json_decode($client->get("$url/subscribers/packages/$membership_no", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                ])->getBody()->getContents());

        foreach($subscriber_packages as $subscriber_package)
        {
            if($subscriber_package->package_id == $package_id)
            {
                $data["package"] = $subscriber_package;
                $data["user"] = User::find($subscriber_package->user_id);
            }
        }

        $subscriber_services = json_decode($client->get("$url/subscriber_service/$membership_no", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
            // print_r($subscriber_services); exit();
        $data["services"] = [];
        foreach($subscriber_services as $subscriber_service)
        {
            if($subscriber_service["package_id"] == $package_id)
            {
                $data["services"][] = $subscriber_service;
                $sum += $subscriber_service["full_price"];
            }
        }

        // print_r($data["services"]); exit();

        $data["sys"] = Systm::first();
        $data["info"] = Info::first();

        // if(!is_null($data["package"]->taxes)){$taxes = $data["package"]->taxes;}
        // else {$taxes = 0;}

        if($data["package"]->taxes_type == 2){$taxes = $data["package"]->price * $data["package"]->taxes / 100;}

        $date = Carbon::now()->toDateTimeString();

        if(!is_null($data["package"]->old_invoice)){$sum += $data["package"]->final_amount;}


        $total = ($sum - $data["package"]->discounts) * 100 /115;

        if($data["package"]->taxes != 0) {$vat = ($sum - $data["package"]->discounts) - $total;}
        else{$vat = 0;}
        //$sum_with_vat = $sum + $vat -  $data["package"]->discounts;

        $data["base64"] = Zatca::sellerName('شركة وجين لتقنية المعلومات')
                ->vatRegistrationNumber($data["info"]->tax_no)
                ->timestamp($date)
                ->totalWithVat($sum)
                ->vatTotal($vat)
                ->toQrCode(
                    qrCodeOptions()
                      ->format("svg")
                      ->size(150)
                  );



        $pdf = PDF::loadView('bill3', $data);
        //return view("bill",$data);


        $fileName = $membership_no."_".$package_id.".pdf";
        //
        if ($status == 1) {
            return $pdf->save(public_path("bills/$fileName"));
        } else {
            $pdf->stream($membership_no."_invoice.pdf");
        }
    }

    public function printCustomers()
    {

        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");
        try
        {
            $counter = 0;
            $subscribers = $client->get("$url/subscribers",['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $customers = json_decode($subscribers->getBody()->getContents(), true);

            //paginate result
            $data["newCollection"] = collect($customers)->map(function ($item) {
                    $activity_type = Activity::find($item["activity_type"] + 1);
                    $item["activity_ar"] = $activity_type->activity_ar;
                    return $item;
                })->filter(function ($item,$counter)
            {
                if($item["is_archived"] == 1) {$counter++;}
                return ($item["is_archived"] != 1) &&  (session('activity') != "" ? $item["activity_type"] == session('activity') - 1 : $item["is_archived"] != 1)
                &&  (session('town_id') != "" ? $item["city_id"] == session('town_id') : $item["is_archived"] != 1)
                &&  (session('package_id') != "" ? $item["package_id"] == session('package_id') : $item["is_archived"] != 1)
                && ((session('customer') != "" ? str_contains($item["first_name"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["last_name"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["membership_no"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["phone_no"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["email"], session('customer'))  :  $item["is_archived"] != 1));
            });




        }
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/home")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();

        $systm = Systm::first();

        return view("printCustomers", compact("customers","systm"),$data);
    }

    public function emailCustomer($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        return view("sendMail", $data);
    }

    public function customerSendMail(Request $request)
    {
        $details = ['title' => $request->title, 'body' => $request->body];

        $message = new Message();
        $message->membership_no = $request->customer_id;
        $message->title = $request->title;
        $message->body = $request->body;
        $message->save();

        Mail::to($request->email)->send(new \App\Mail\CustomerMail($details));

        return redirect("/CustomerMessages/$request->subscriber_id/$request->customer_id")->with("Message","تمت المراسلة");
    }

    public function CustomerMessages($customer_id,$membership_no)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $data["messages"] = Message::where("membership_no", $membership_no)->get();

        return view("messages", $data);
    }

    public function casheirs(Request $request)
    {
        Session(["info"=> ""]);
         // Set default page
        $data["page"] = request()->has('page') ? request('page') : 1;

        // Set default per page
        $data["perPage"] =  10;

        // Offset required to take the results
        $offset = ($data["page"] * $data["perPage"]) - $data["perPage"];

        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");
        $client = new Client();
        $casheirs = json_decode($client->get("$url/allCasheirs", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $info = "";
        if ($request->casheir) {
            Session(["info"=> $request->casheir]);
            $info = $request->casheir;
        }
        //echo "info".$info;
        //paginate result
            $newCollection = collect($casheirs)->filter(function ($item)
                {
                    $info = session('info');
                    return ($item["status"] == 0)
                    && (session('info') != "" ? $item["staff_no"] == session('info') : $item["status"] == 0)
                    && (session('info') ? $item["membership_no"] == session('info') : $item["status"] == 0)
                    && (session('info') ? str_contains($item["first_name"],session('info')) : $item["status"] == 0)
                    && (session('info') ? str_contains($item["last_name"],session('info')) : $item["status"] == 0)
                    ;
                });

            $data["results"] =  new LengthAwarePaginator(
                $newCollection->slice($offset, $data["perPage"]),
                $newCollection->count(),
                $data["perPage"],
                $data["page"],
                ['path' => request()->url(), 'query' => request()->query()]
           );

        return view("casheirs", compact("casheirs", "info"),$data);
    }

    public function casheirActivate($customer_id,$first_name,$last_name,$staff_no,$email,$casheir_id, $status)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");
        $msg = "";

        if($status == 1)
        {
            $client->get("$url/staff/activate/$casheir_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ]);
            $msg = "تم التفعيل";

        Mail::to($email)->send(new \App\Mail\CasheirMail(
                    $first_name." ".$last_name,
                    'Welcome to SkilTax POS system',
                    $staff_no
                ));
        }
        elseif($status == 2)
        {
            $client->post("$url/staff/inactivate/$casheir_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ]);
            $msg = "تم إلغاء التفعيل";
        }

        // $customerService = new CustomerService();
        // $customerService->membership_no = $membership_no;
        // $customerService->staff_no = $staff_no;
        // $customerService->service_id = $customerService_id;
        // $customerService->price = $price;
        // $customerService->user_id = Auth::user()->id;
        // $customerService->save();

        return redirect("/showCustomer/$customer_id")->with("Message",$msg);

    }

    public function archiveCustomers(Request $request)
    {
        $counter=0;
        // Set default page
        $data["page"] = request()->has('page') ? request('page') : 1;

        // Set default per page
        $data["perPage"] =  10;

        // Offset required to take the results
        $offset = ($data["page"] * $data["perPage"]) - $data["perPage"];

        $url = "https://back.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");
        try
        {
            $subscribers = $client->get("$url/subscribers",['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $customers = json_decode($subscribers->getBody()->getContents(), true);

             //paginate result
            $newCollection = collect($customers)->filter(function ($item,$counter)
            {
                if($item["is_archived"] == 0) {$counter++;}
                return $item["is_archived"] != 0;
            });

            $data["results"] =  new LengthAwarePaginator(
                $newCollection->slice($offset, $data["perPage"]),
                $newCollection->count() - $counter,
                $data["perPage"],
                $data["page"],
                ['path' => request()->url(), 'query' => request()->query()]
           );

           $data["towns"] = json_decode(Http::get("$url/cities"), true);
        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);
        }
        catch (GuzzleException $e)
        {
            return $e->getMessage();
        }

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();

        $systm = Systm::first();

        return view("archiveCustomers", compact("customers","systm"),$data);
    }

    public function unArchiveCustomer($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/unarchive/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/archiveCustomers")->with("Message", "تم إلغاء أرشفة المشترك");
    }

    public function inActivateCustomer($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/inactivate/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/customers")->with("Message", "تم إلغاء تفعيل المشترك");
    }

    public function customerActivate($customer_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/activate/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/customers")->with("Message", "تم تفعيل المشترك");
    }

    public function subscribersRegister(CustomerRequest $request)
     {
        $url = "https://back.skilltax.sa/api/v1";
        $data = [
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('second_name'),
            "email" => $request->input('email'),
            "phone_no" => $request->input('phone'),
            "business_name" => $request->input('bussiness_name'),
            "tax_number" => $request->input('tax_no'),
            "activity_type" => $request->input('activity_id') - 1,
            "city_id" => $request->input('town_id'),
            "governorate_id" => $request->input('governorate_id'),
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "password" => $request->input('password'),
            "paid" => 1,
            "password_confirmation" => $request->input('password'),

            "package_id" => $request->package_id,
            "final_amount" => $request->amount,
            "taxes" => $request->taxes,
            "discounts" => $request->discounts,
            "taxes_type" => $request->taxes_type,
            "discounts_type" => $request->discounts_type,
            "user_id" => $request->user_id,
        ];

        $subscriber = $this->skilltax_customer_register($data);

        $membership_no = $subscriber->membership_no;

        $this->skilltax_customer_package($membership_no, $request->dash_id);

        $fileName = $membership_no . ".json";
        $contents = File::get(public_path('/jsons/' . $fileName));

        // echo $contents;exit;
        $client = new Client();

        $login = $client->post("$url/subscribers/login", [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['membership_no' => 700000, 'password' => 123456]
        ]);

        $token = json_decode($login->getBody()->getContents())->token;
        Session(['skillTax_token' => $token]);

        $client->post("$url/permissionList", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => json_decode($contents)
        ]);

        $this->CustomerBill($subscriber->id, $subscriber->package_id, 1);

        $attach = $membership_no . "_" . $subscriber->package_id;
        $attach = "";

        $fullname = $request->first_name . " " . $request->second_name;

        try
        {
            Mail::to($request->email)->send(new \App\Mail\SendMail(
                $fullname,
                'Welcome to SkilTax POS system',
                $membership_no,
                $request->start_date,
                $request->end_date,
                $attach
            ));

            $message = new Message();
            $message->membership_no = $membership_no;
            $message->title = "رسالة إكتمال التسجيل";
            $message->body = "Subscriber Name: $fullname <br>
            Membership ID:  $membership_no <br>
            Subscription Start Date / Time :  $request->start_date <br>
            Subscription End Date / Time :  $request->end_date ";
            $message->save();
        }
        catch (GuzzleException $e) {}

        return response()->json($subscriber,201);
    }

    public function createBranch(Request $request)
    {

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/branches";
        $token = session("skillTax_token");
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ];
        try
        {

        $data = [
            "ar_name" => $request->input('ar_name'),
            "en_name" => $request->input('en_name'),
            "phone_number" => $request->input('phone_number'),

            "city_id" => $request->input('city_id'),
            "membership_no" => $request->input('membership_no'),

            "price" => $request->input('price'),
            "discount" => $request->input('discount'),
            "taxes" => $request->input('taxes'),
            "final_price" => $request->input('final_price')
            ];

            $client->post($url, [
            'headers' => $headers,
            'json' => $data,
            'http_errors' => false
            ]);

         return redirect("/customers")->with("Message", "تم إضافة الفرع");
        }
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }


    //branchBill
    public function branchBill($customer_id,$branch_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $data["branch"] = json_decode($client->get("$url/showBranch/$branch_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $data["user"] = Auth::user();
        $data["info"] = Info::first();

        $date = Carbon::now()->toDateTimeString();

        $taxes = 0;
        if(!is_null($data["branch"]["taxes"])) {$taxes = $data["branch"]["taxes"];}

        $data["base64"] = Zatca::sellerName($data["info"]->name_ar)
            ->vatRegistrationNumber($data["info"]->tax_no)
            ->timestamp($date)
            ->totalWithVat($data["branch"]["final_price"])
            ->vatTotal($taxes)
            ->toQrCode(
                qrCodeOptions()
                  ->format("svg")
                  ->size(300)
              );

    $pdf = PDF::loadView('branchBill', $data);
    return $pdf->stream();
        //return view("branchBill",$data);
    }


    public function visit($membership_no)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v2/subscriberDashboardLogin";

        $token = session("skillTax_token");
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        try
        {
            $postResponse = $client->post($url, [
            'headers' => $headers,
            'json' => ["membership_no"=> $membership_no,"password"=> "Bhq3GQei9oH_d_hs5"],
            'http_errors' => false
            ]);

            $returned_code = $postResponse->getStatusCode();
            if($returned_code == 200)
            {
                $response = json_decode($postResponse->getBody()->getContents());

                $first_name = $response->subscriber->first_name;
                $last_name = $response->subscriber->last_name;
                $email = $response->subscriber->email;
                // echo $response;exit;

                $visit_url = 'https://v1.skilltax.sa/admin-access?membership_no='.$membership_no.'&token='.$response->token.'&first_name='.$first_name.'&last_name='.$last_name.'&email='.$email;

                session(['visit_url'=> $visit_url]);


                return redirect()->back();
            }
            else
            {
                return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }

        //  return json_decode($postResponse->getBody()->getCode());
        }
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }

    public function sendNotification(Request $request)
    {
        $subscribers_ids = $request->subscribers;
        $title = $request->title;
        $message = $request->message;

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v2/subscriberDashboardNotification";

        $token = session("skillTax_token");
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        try
        {
            $postResponse = $client->post($url, [
            'headers' => $headers,
            'json' => ["title"=> $title,"message"=> $message,"subscribers"=>$subscribers_ids]
            ]);

            $returned_code = $postResponse->getStatusCode();
            if($returned_code == 201)
            {
                return redirect("/customers")->with("Message", " تم إرسال الإشعار");
            }
            else
            {
                return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
            }

        //  return json_decode($postResponse->getBody()->getCode());
        }
        catch (GuzzleException $e)
        {
            //return $e->getMessage();
            return redirect("/customers")->with("errorMessage", " حذث خطأ الرجاء المحاولة مرو أخرى");
        }
    }

    public function notifyMultiple()
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1";

        $subscribers = $client->get("$url/subscribers",['headers' => ['Authorization' => 'Bearer ' . $token]]);
        $customers = json_decode($subscribers->getBody()->getContents(), true);

        //paginate result
        $results = collect($customers)->map(function ($item) {
                $activity_type = Activity::find($item["activity_type"]);
                if($activity_type)
                {
                    $item["activity_ar"] = $activity_type->activity_ar;
                }
                else
                {
                    $item["activity_ar"] = "";
                }
                return $item;
            })
            ->filter(function ($item,$counter)
            {

                if($item["is_archived"] == 1) {$counter++;}
                return ($item["is_archived"] != 1) &&  (session('activity') != "" ? $item["activity_type"] == session('activity') - 1 : $item["is_archived"] != 1)
                &&  (session('town_id') != "" ? $item["city_id"] == session('town_id') : $item["is_archived"] != 1)
                &&  (session('package_id') != "" ? $item["package_id"] == session('package_id') : $item["is_archived"] != 1)
                && ((session('customer') != "" ? str_contains($item["first_name"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["last_name"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["membership_no"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["phone_no"], session('customer'))  :  $item["is_archived"] != 1)
                || (session('customer') != "" ? str_contains($item["email"], session('customer'))  :  $item["is_archived"] != 1));

            });
        return view("notifyMultiple",compact("results"));
    }


    public function loyaltyStatus($membership_no,$status)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v2";
        $token = session("skillTax_token");

        if($status == 'active')
        {
            $msg = "تم تفعيل نقاط الولاء للمشترك $membership_no";
            $client->post("$url/activateLoyaltyApp", ['headers' => ['Authorization' => 'Bearer ' . $token],'json'=> ['membership_no' => $membership_no]]);
        }
        else
        {
            $msg = "تم إلغاء تفعيل نقاط الولاء للمشترك $membership_no";
            $client->post("$url/inactivateLoyaltyApp", ['headers' => ['Authorization' => 'Bearer ' . $token],'json'=> ['membership_no' => $membership_no]]);
        }

        return back()->with("Message", $msg);
    }

}
