<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UnitController extends Controller
{
    public function index()
    {
        $url = "https://back.skilltax.sa/api/v1";
        $token = session("skillTax_token");
        // echo $token;exit;
        $client = new Client();
        try{
            $units = $client->get("$url/inventory-units",['headers' => ['Authorization' => 'Bearer ' . $token]]);

            $units = json_decode($units->getBody()->getContents(), true);
        }
         catch (\Exception $e) {

            return $e->getMessage();
        }

        return view("units",compact("units"));
    }

    public function unitList()
    {
        $Unites = Unit::whereNot('is_archived',1)
        ->get();

        return response()->json($Unites, 200);
    }

    public function store(UnitRequest $request)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/inventory-units";

        $token = session("skillTax_token");
        // echo $token;exit;
        $data = [
            "ar_name" => $request->ar_name,
            "en_name" => $request->en_name
        ];


        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);


        return redirect("/units")->with("Message","تمت الاضافة");
    }
    public function show($id)
    {
        $Unit = Unit::where('id',$id)->whereNot('is_archived',1)->first();

        if(!$Unit){

            return response()->json(['message'=>'Unit not found'], 404);
        }

        return response()->json($Unit, 200);
    }

    public function update(Request $request)
    {
        $client = new Client();
        $url="https://back.skilltax.sa/api/v1/inventory-units/$request->Unit_id";

        $token = session("skillTax_token");
        // echo $token;exit;
        $data = [
            "ar_name" => $request->ar_name,
            "en_name" => $request->en_name,
            "status" => 1
        ];

        //echo $token;exit;
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);


        return redirect("/units")->with("Message","تم التعديل");
    }

    public function activateUnit($Unit_id)
    {
        $client = new Client();
        $url="https://back.skilltax.sa/api/v1/inventory-units/activate/$Unit_id";

        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->get($url, [
            'headers' => $headers
        ]);

        return redirect("/units")->with("Message","تم التفعيل");
    }

    public function inActivateUnit($Unit_id)
    {
        $client = new Client();
        $url="https://back.skilltax.sa/api/v1/inventory-units/inActivate/$Unit_id";

        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->get($url, [
            'headers' => $headers
        ]);

        return redirect("/units")->with("Message","تم إلغاء التفعيل");
    }

    public function destroy($Unit_id)
    {
        $client = new Client();
        $url="https://back.skilltax.sa/api/v1/inventory-units/archive/$Unit_id";

        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $Unit_id
        ]);


        return redirect("/units")->with("Message","تم الحذف");
    }



    public function sync_qoyod_categories()
    {
        $user = Auth::user();

        try {
            DB::transaction(function () use ($user) {
                $un_sync_categories = Category::whereNull('qoyod_id')->get();

                foreach($un_sync_categories as $category)
                {
                    $this->qoyodService->store($user->qoyod_key,$category->id,$category->ar_name,$category->en_name);
                }
            });

            return response()->json(['message'=>'categories synchronization succeed'],201);
        }
        catch(\Exception $e)
        {
            return response()->json(['message'=>'categories synchronization failed'],400);
        }
    }
}
