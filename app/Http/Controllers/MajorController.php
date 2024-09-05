<?php

namespace App\Http\Controllers;

use App\Http\Requests\MajorRequest;
use App\Models\Major;
use App\Models\Systm;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["majors"] = Major::select("majors.*","systms.system_name_ar")
        ->join("systms","systms.id","majors.systm_id")
        ->with("minor")
        ->paginate(15);

        $data["systems"] = Systm::all();
        return view("majors",$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MajorRequest $request)
    {
        $major = new Major();
        $major->major_ar = $request->input("major_ar");
        $major->major_en = $request->input("major_en");
        $major->systm_id = $request->input("systm_id");
        $major->save();

        return redirect("/majors")->with("Message","تمت الاضافة");
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MajorRequest $request)
    {
        $major = Major::find($request->input("major_id"));
        $major->major_ar = $request->input("major_ar");
        $major->major_en = $request->input("major_en");
        $major->systm_id = $request->input("systm_id");
        $major->update();

        return redirect("/majors")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $major_id)
    {
        Major::where("id",$major_id)->delete();
        return redirect("/majors")->with("Message","تم الحذف");

    }
}
