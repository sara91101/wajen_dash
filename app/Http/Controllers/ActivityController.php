<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data["activities"] = Activity::paginate(15);

        $url = "https://back.skilltax.sa/api/v1/loyalty/activityTypes";
        $token = session("skillTax_token");
        // echo $token;exit;
        $client = new Client();
        try{
            $activities = $client->get($url,['headers' => ['Authorization' => 'Bearer ' . $token]]);

            $data["activities"] = json_decode($activities->getBody()->getContents(), true);

            return view("activities",$data);
        }
         catch (\Exception $e) {

            return back()->with("errorMessage",$e);
        }

    }

    public function activityList()
    {
        $activities = Activity::select(DB::raw('(id - 1) as id'),"activity_ar","activity_en")->get();

        return response()->json($activities,200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request)
    {
        // $activity = new Activity();
        // $activity->activity_ar = $request->input("activity_ar");
        // $activity->activity_en = $request->input("activity_en");
        // $activity->save();

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/loyalty/activityTypes";

        $token = session("skillTax_token");
        // echo $token;exit;
        $data = [
            "ar_activity" => $request->activity_ar,
            "en_activity" => $request->activity_en
        ];


        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);


        return redirect("/activities")->with("Message","تمت الاضافة");
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request)
    {
        // $activity = Activity::find($request->input("activity_id"));
        // $activity->activity_ar = $request->input("activity_ar");
        // $activity->activity_en = $request->input("activity_en");
        // $activity->update();

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/loyalty/activityTypes/$request->activity_id";

        $token = session("skillTax_token");
        // echo $token;exit;
        $data = [
            "ar_activity" => $request->activity_ar,
            "en_activity" => $request->activity_en
        ];


        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);


        return redirect("/activities")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $activity_id)
    {
        // Activity::where("id",$activity_id)->delete();

        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1/loyalty/activityTypes/$activity_id";
        $token = session("skillTax_token");

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $client->delete($url, ['headers' => $headers]);

        return redirect("/activities")->with("Message","تم الحذف");

    }

     public function apiActivities()
    {
        $activities = Activity::all();

        return response()->json($activities);
    }
}
