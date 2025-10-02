<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Http\Requests\RenewPackageRequest;
use App\Mail\RenewPackage;
use App\Mail\SendMail;
use App\Models\Info;
use App\Models\Major;
use App\Models\Minor;
use App\Models\Package;
use App\Models\Systm;
use App\Models\User;
use App\Services\InvoiceService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Prgayman\Zatca\Facades\Zatca;
use PDF;

class APIController extends Controller
{
    
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function updateSubscriberPackage(Request $request)
    {
        $this->skilltax_customer_package($request->membership_no, $request->package_dash_id);

        $client = new Client();

        $fileName = $request->membership_no . ".json";
        $contents = File::get(public_path('/jsons/' . $fileName));

        $token = env('SKILLTAX_TOKEN');
        $url = env('SKILLTAX_URL');

        try{
            $client->post($url."v1/updatePermissionList", [
                'headers' => ['Authorization' => 'Bearer ' . $token],
                'json' => json_decode($contents)
            ]);

            return response()->json(['message' => 'Subscriber Package Changed'],201);
        }
        catch (GuzzleException $e)
            {
                return response()->json(['message' => 'Failed to change Subscriber Package'.$e->getMessage()],400);
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

    public function subscriberBill(Request $request)
    {
        $data["sys"] = Systm::first();
        $data["info"] = Info::first();

        $date = Carbon::now()->toDateTimeString();

        $data["base64"] = Zatca::sellerName('شركة وجين لتقنية المعلومات')
                ->vatRegistrationNumber($data["info"]->tax_no)
                ->timestamp($date)
                ->totalWithVat($request->sum_after_tax)
                ->vatTotal($request->tax_value)
                ->toQrCode(
                    qrCodeOptions()
                      ->format("svg")
                      ->size(150)
                  );


        $data["invoice_date"] = $request->invoice_date;
        $data['invoiceNumber'] = $this->invoiceService->generateInvoiceNumber();

        //bill info
        $data['subscriber_name'] = $request->subscriber_name;
        $data['subscriber_phone_no'] = $request->subscriber_phone_no;
        $data['subscriber_tax_number'] = $request->subscriber_tax_number;
        $data['subscriber_address'] = $request->subscriber_address;


        $data['item'] = $request->item;
        $data['description'] = ($request->cycle == 'yearly') ? 'سنوي' : 'شهري';
        $data['quantity'] = $request->quantity;
        $data['discount'] = $request->discount;
        $data['price'] = $request->price;
        $data['sum_before_tax'] = $request->sum_before_tax;
        $data['tax_percentage'] = $request->tax_percentage;
        $data['tax_value'] = $request->tax_value;
        $data['sum_after_tax'] = $request->sum_after_tax;
        $data['subscription_start_date'] = Carbon::parse($request->subscription_start_date)->format('Y-m-d');
        $data['subscription_end_date'] = Carbon::parse($request->subscription_end_date)->format('Y-m-d');
        $data['period'] = ($request->cycle == 'yearly') ? 'سنه' : 'شهر';
        
        $pdf = PDF::loadView('bill4', $data);

        $bill_name = 'renew_subscription_'.$request->membership_no.'.pdf';
        
        $pdf->save(public_path("bills/$bill_name"));

        $this->invoiceService->storeServiceNumber($data['invoiceNumber'] ,$request->membership_no , $bill_name ,'renew');


        return ["subscriber_name" => $request->subscriber_name , 
                "membership_no" => $request->membership_no,
                "subscription_start_date" => $request->subscription_start_date,
                "subscription_end_date" => $request->subscription_end_date,
                "email" => $request->subscriber_email,
                "phone" => $request->subscriber_phone_no,
                "bill_name" => $bill_name];
    }

    public function sendSubscriptionSMS($subscriber_phone , $membership_no, $start_date, $end_date)
    {
        $msg = "عميلنا العزيز، \nنود إعلامك بأنه تم تجديد اشتراكك بنجاح للحساب برقم العضوية $membership_no تاريخ بداية الاشتراك هو $start_date وتاريخ انتهاء الاشتراك هو $end_date";
        $apiUrl = 'https://www.msegat.com/gw/sendsms.php';
        $data = [
                'userName' => 'Wajen5188',
                'apiKey' => env('OTP_MESSAGE_KEY'),
                'numbers' => $subscriber_phone,
                'userSender' => 'Skilltax',
                'msg' => $msg,
            ];
        Http::post($apiUrl, $data);
    }

    public function renewSubscriberPackage(RenewPackageRequest $request)
    {

        try
        {
            $subscriberBill = $this->subscriberBill($request);

            Mail::to($subscriberBill['email'])->send(new RenewPackage(
                $subscriberBill['subscriber_name'],
                $subscriberBill['membership_no'],
                $subscriberBill['subscription_start_date'],
                $subscriberBill['subscription_end_date'],
                $subscriberBill['bill_name']
            ));

            $this->sendSubscriptionSMS($subscriberBill['phone'],
                $subscriberBill['membership_no'],
                $subscriberBill['subscription_start_date'],
                $subscriberBill['subscription_end_date']);

            return response()->json(["message"=>"Email & SMS sent to subscriber"],200);

        }
        catch (GuzzleException $e) { return response()->json(["error"=>$e],401);}

    }
}
