<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["activities"] = Activity::paginate(15);

        return view("activities",$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request)
    {
        $activity = new Activity();
        $activity->activity_ar = $request->input("activity_ar");
        $activity->activity_en = $request->input("activity_en");
        $activity->save();

        return redirect("/activities")->with("Message","تمت الاضافة");
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request)
    {
        $activity = Activity::find($request->input("activity_id"));
        $activity->activity_ar = $request->input("activity_ar");
        $activity->activity_en = $request->input("activity_en");
        $activity->update();

        return redirect("/activities")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $activity_id)
    {
        Activity::where("id",$activity_id)->delete();
        return redirect("/activities")->with("Message","تم الحذف");

    }
}
