<?php

namespace App\Http\Controllers;

use App\Http\Requests\MinorRequest;
use App\Models\Major;
use App\Models\Minor;
use Illuminate\Http\Request;

class MinorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data["minors"] = Minor::select("minors.*","majors.major_ar")
        ->join("majors","majors.id","minors.major_id")
        ->with("property");

        if($request->input('minor'))
        {
          $minor = $request->input('minor');

          Session(['minor' => $minor]);

          $data["minors"] = $data["minors"]->where(function($v) use ($minor)
          {
              $v->where("minor_ar",'LIKE', '%'. $minor .'%')
              ->orWhere("minor_en",'LIKE', '%'. $minor .'%');
          });
        }
        else
        {
          $minorSession = session('minor');
          if( $minorSession != "")
          {
            $data["minors"] = $data["minors"]->where(function($v) use ($minorSession)
            {
                $v->where("minor_ar",'LIKE', '%'. $minorSession .'%')
                ->orWhere("minor_en",'LIKE', '%'. $minorSession .'%');
            });
          }
        }

        if($request->input('major_id') != 0)
        {
            $major_id = $request->input('major_id');

            Session(['major_id' => $major_id]);

            $data["minors"] = $data["minors"]->where("minors.major_id", $major_id);
        }
        else
        {
          $major_id_Session = session('major_id');
          if( $major_id_Session != "")
          {
            $data["minors"] = $data["minors"]->where("minors.major_id", $major_id_Session);
          }
        }

        $data["minors"] = $data["minors"]->orderBy("major_id")->orderBy("minor_ar")->paginate(15);

        $data["majors"] = Major::all();
        return view("minors",$data);
    }

    public function showAll()
    {
      Session(['minor' => ""]);
      Session(['major_id' => ""]);
      return back();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MinorRequest $request)
    {
        $minor = new Minor();
        $minor->minor_ar = $request->input("minor_ar");
        $minor->minor_en = $request->input("minor_en");
        $minor->major_id = $request->input("major_id");
        $minor->save();

        return redirect("/minors")->with("Message","تمت الاضافة");
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
    public function update(MinorRequest $request)
    {
        $minor = Minor::find($request->input("minor_id"));
        $minor->minor_ar = $request->input("minor_ar");
        $minor->minor_en = $request->input("minor_en");
        $minor->major_id = $request->input("major_id");
        $minor->update();

        return redirect("/minors")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $minor_id)
    {
        Minor::where("id",$minor_id)->delete();
        return redirect("/minors")->with("Message","تم الحذف");

    }
}

