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

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");
        try
        {
            $subscribers = $client->get("$url/subscribers",['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $customers = json_decode($subscribers->getBody()->getContents(), true);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();
        $data["towns"] = json_decode(Http::get("$url/cities"), true);
        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);
        $systm = Systm::first();

        return view("customers", compact("customers","systm"),$data);
    }

    public function showAll()
    {
        Session(['customer' => ""]);
        Session(['sys' => ""]);
        Session(['start' => ""]);
        Session(['end' => ""]);
        Session(['act_id' => ""]);
        Session(['town_id' => ""]);
        Session(['governorate_id' => ""]);

        return redirect("/customers");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = "https://backend.skilltax.sa/api/v1";

        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);

        $data["towns"] = json_decode(Http::get("$url/cities"), true);

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();

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
        //dd($data);exit;
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1/subscribers/register";
        $headers = [
            'Content-Type' => 'application/json',
        ];
        // print_r($data)."<br>";exit;
        try {
            $postResponse = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        return json_decode($postResponse->getBody()->getContents());
    }
        catch (\Exception $exception) { }

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
        $url = "https://backend.skilltax.sa/api/v1";
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
            "user_id" => Auth::user()->id,
        ];

        $subscriber = $this->skilltax_customer_register($data);

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

        $attach = $membership_no . "_" . $subscriber->package_id;

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
        catch (\Exception $e) {}

        return redirect("/customers")->with("Message", "تمت الاضافة");
    }

    /**
     * Display the specified resource.
     */
    public function show($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $data["casheirs"] = json_decode($client->get("$url/allCasheirs", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $employees = $client->get("$url/employees", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ]);

        $data["system"] = Systm::first();

        $data["employees"] = json_decode($employees->getBody()->getContents());

        $membership_no = $data['customer']['membership_no'];
        $data["packages"] = json_decode($client->get("$url/subscribers/packages/$membership_no", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents());

        $data["packages"] = Package::all();



        return view("customer", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $membership_no = $data["customer"]["membership_no"];
        $customer_package_id = $data["customer"]["package_id"];

        $data["systems"] = Systm::with("package")->get();

        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);

        $data["towns"] = json_decode(Http::get("$url/cities"), true);

        $data["activities"] = Activity::all();

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
        $url = "https://backend.skilltax.sa/api/v1";
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

            "package_id" => $request->package_id,
            "final_amount" => $request->amount,
            "taxes" => $request->taxes,
            "discounts" => $request->discounts,
            "taxes_type" => $request->taxes_type,
            "discounts_type" => $request->discounts_type,
            "user_id" => Auth::user()->id,
        ];
        $membership_no = $request->membership_no;

        $client->post("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => $data
        ]);

        if($request->package_id != $request->previous_customer_package)
        {
            $this->skilltax_customer_package($membership_no, $request->dash_id);

            $fileName = $membership_no . ".json";
            $contents = File::get(public_path('/jsons/' . $fileName));


            $client->post("$url/updatePermissionList", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                'json' => json_decode($contents)
            ]);
        }
        return redirect("/customers")->with("Message", "تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/archive/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);

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

    public function CustomerBill($customer_id, $package_id, $status)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
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

        $pdf = PDF::loadView('bill', $data);

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
        $data["customers"] = Customer::select("customers.*", "systms.system_name_ar", "towns.ar_town", "governorates.ar_governorate", "activities.activity_ar")
            ->join("systms", "systms.id", "customers.systm_id")
            ->join("governorates", "governorates.id", "customers.governorate_id")
            ->join("towns", "towns.id", "governorates.town_id")
            ->join("activities", "activities.id", "customers.activity_id");

        $customer = Session('customer');
        $sys = Session('sys');
        $act_id = Session('act_id');
        $town_id = Session('town_id');
        $governorate_id = Session('governorate_id');
        $customer = Session('customer');
        $customer = Session('customer');
        $customer = Session('customer');

        if ($customer != "") {
            $data["customers"] = $data["customers"]->where(function ($v) use ($customer) {
                $v->where("first_name", 'LIKE', '%' . $customer . '%')
                    ->orWhere("second_name", 'LIKE', '%' . $customer . '%')
                    ->orWhere("phone", 'LIKE', '%' . $customer . '%')
                    ->orWhere("membership_no", 'LIKE', '%' . $customer . '%')
                    ->orWhere("tax_no", 'LIKE', '%' . $customer . '%')
                    ->orWhere("email", 'LIKE', '%' . $customer . '%');
            });
        }

        if ($sys != "") {
            $data["customers"] = $data["customers"]->where("systm_id", $sys);
        }

        if ($act_id != "") {
            $data["customers"] = $data["customers"]->where("activity_id", $act_id);
        }

        if ($town_id != "") {
            $data["customers"] = $data["customers"]->where("town_id", $town_id);
        }

        if ($governorate_id != "") {
            $data["customers"] = $data["customers"]->where("governorate_id", $governorate_id);
        }

        $data["customers"] = $data["customers"]->get();

        return view("printCustomers", $data);
    }

    public function emailCustomer($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
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
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $data["customer"] = json_decode($client->get("$url/subscribers/$customer_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);

        $data["messages"] = Message::where("membership_no", $membership_no)->get();

        return view("messages", $data);
    }

    public function casheirs(Request $request)
    {
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");
        $client = new Client();
        $casheirs = json_decode($client->get("$url/allCasheirs", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            ])->getBody()->getContents(), true);
        $info = "";
        if ($request->casheir) {
            $info = $request->casheir;
        }
        return view("casheirs", compact("casheirs", "info"));
    }

    public function casheirActivate($customer_id,$first_name,$last_name,$staff_no,$email,$casheir_id, $status)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");
        $msg = "";

        if($status == 1)
        {
            $client->post("$url/staff/activate/$casheir_id", [
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
        $url = "https://backend.skilltax.sa/api/v1";
        $client = new Client();
        $token = session("skillTax_token");
        try
        {
            $subscribers = $client->get("$url/subscribers",['headers' => ['Authorization' => 'Bearer ' . $token]]);
            $customers = json_decode($subscribers->getBody()->getContents(), true);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

        $data["systems"] = Systm::all();
        $data["activities"] = Activity::all();
        $data["towns"] = json_decode(Http::get("$url/cities"), true);
        $data["governorates"] = json_decode(Http::get("$url/governorates"), true);
        $systm = Systm::first();

        return view("archiveCustomers", compact("customers","systm"),$data);
    }

    public function unArchiveCustomer($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/unarchive/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/archiveCustomers")->with("Message", "تم إلغاء أرشفة المشترك");
    }

    public function inActivateCustomer($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/inactivate/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/customers")->with("Message", "تم إلغاء تفعيل المشترك");
    }

    public function customerActivate($customer_id)
    {
        $client = new Client();
        $url = "https://backend.skilltax.sa/api/v1";
        $token = session("skillTax_token");

        $client->post("$url/subscribers/activate/$customer_id", ['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/customers")->with("Message", "تم تفعيل المشترك");
    }

}
