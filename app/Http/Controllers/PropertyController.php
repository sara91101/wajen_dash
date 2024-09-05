<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\Major;
use App\Models\Minor;
use App\Models\Operation;
use App\Models\Property;
use App\Models\Systm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data["properties"] = Property::select("minors.minor_ar","properties.*")
        ->join("minors","minors.id","properties.minor_id")
        ->with("operation");

        if($request->input('property'))
        {
          $property = $request->input('property');

          Session(['property' => $property]);

          $data["properties"] = $data["properties"]->where(function($v) use ($property)
          {
              $v->where("property_ar",'LIKE', '%'. $property .'%')
              ->orWhere("property_en",'LIKE', '%'. $property .'%');
          });
        }
        else
        {
          $propertySession = session('property');
          if( $propertySession != "")
          {
            $data["properties"] = $data["properties"]->where(function($v) use ($propertySession)
            {
                $v->where("property_ar",'LIKE', '%'. $propertySession .'%')
                ->orWhere("property_en",'LIKE', '%'. $propertySession .'%');
            });
          }
        }

        if($request->input('major_id') != 0)
        {
            $major_id = $request->input('major_id');

            Session(['prop_major_id' => $major_id]);

            $data["properties"] = $data["properties"]->where("minors.major_id", $major_id);
        }
        else
        {
          $major_id_Session = session('prop_major_id');
          if( $major_id_Session != "")
          {
            $data["properties"] = $data["properties"]->where("minors.major_id", $major_id_Session);
          }
        }

        if($request->input('minor_id') != 0)
        {
            $minor_id = $request->input('minor_id');

            Session(['prop_minor_id' => $minor_id]);

            $data["properties"] = $data["properties"]->where("minors.id", $minor_id);
        }
        else
        {
          $minor_id_Session = session('prop_minor_id');
          if( $minor_id_Session != "")
          {
            $data["properties"] = $data["properties"]->where("minors.id", $minor_id_Session);
          }
        }

        $data["properties"] = $data["properties"]->orderBy("minor_id")->orderBy("properties.id")->paginate(15);

        $data["majors"] = Major::all();
        $data["minors"] = Minor::all();
        $data["systms"] = Systm::all();
        return view("properties",$data);
    }

    public function showAll()
    {
      Session(['property' => ""]);
      Session(['prop_minor_id' => ""]);
      Session(['prop_major_id' => ""]);
      return back();
    }

    public function create(Request $request)
    {
        $system_id = $request->Input("system_id");
        $majors = Major::where("systm_id",$system_id)->pluck("id");

        $data["majors"] = Major::where("systm_id",$system_id)->get();
        $data["minors"] = Minor::whereIn("major_id",$majors)->get();

        $system = Systm::find($system_id);
        $compare = [];

        $last_operations = Operation::all();
        foreach($last_operations as $l)
        {
            $compare[] = "$l->operation_ar";
        }

        $operations = json_decode(Http::get($system->endPoint_url."v1/endPoints"),true);

        return view("createProperty",$data,compact("operations","compare"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyRequest $request)
    {
        $prop = new Property();
        $prop->minor_id = $request->input("minor_id");
        $prop->property_ar = $request->input("property_ar");
        $prop->property_en = $request->input("property_en");
        $prop->save();

        if($request->input("proc"))
        {
            $procs = $request->input("proc");
            foreach($procs as $p)
            {
                $op = new Operation();
                $op->property_id =  $prop->id;
                $op->operation_ar = $p;
                $op->save();
            }
        }

        return redirect("/properties")->with("Message","تمت الاضافة");
        // return back();
    }

    /**
     * Display the specified resource.
     */
    public function edit($property_id)
    {
        $data["property"] = Property::select("properties.*","minors.major_id","majors.systm_id")
        ->join("minors","minors.id","properties.minor_id")
        ->join("majors","majors.id","minors.major_id")
        ->join("systms","systms.id","majors.systm_id")
        ->where("properties.id",$property_id)->first();

        $data["minors"] = Minor::all();
        $data["majors"] = Major::all();

        $system = Systm::find($data["property"]->systm_id);

        $compare = [];
        $used = [];

        $last_operations = Operation::where("property_id",$data["property"]->id)->get();
        foreach($last_operations as $l)
        {
            $compare[] = "$l->operation_ar";
        }

        $used_operations = Operation::all();
        foreach($used_operations as $u)
        {
            $used[] = "$u->operation_ar";
        }


        $operations = json_decode(Http::get($system->endPoint_url."v1/endPoints"),true);

        return view("editProperty",$data,compact("operations","compare","used"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyRequest $request,$property_id)
    {
        $prop = Property::find($property_id);
        $prop->minor_id = $request->input("minor_id");
        $prop->property_ar = $request->input("property_ar");
        $prop->property_en = $request->input("property_en");
        $prop->update();

        Operation::where("property_id",$property_id)->delete();

        if($request->input("proc"))
        {
            $procs = $request->input("proc");
            foreach($procs as $p)
            {
                $op = new Operation();
                $op->property_id =  $prop->id;
                $op->operation_ar = $p;
                $op->save();
            }
        }

        return redirect("/properties")->with("Message","تم التعديل");
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $property_id)
    {
        Property::where("id",$property_id)->delete();
        return redirect("/properties")->with("Message","تم الحذف");

    }
}
