<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Models\Customer;
use App\Models\Major;
use App\Models\Minor;
use App\Models\Package;
use App\Models\PackageMinor;
use App\Models\Systm;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->input('minor') != 0)
        {
            $minor = $request->input('minor');
            Session(['pk_minor' => $minor]);
        }
        else
        {
            $minor = session('pk_minor');
        }


        if($request->input('major') != 0)
        {
            $major = $request->input('major');
            Session(['pk_major' => $major]);
        }
        else
        {
            $major = session('pk_major');
        }

        $data["packages"] = Package::select("packages.*","systms.system_name_ar")
        ->join("systms","systms.id","packages.systm_id")
        ->with(['packageMinor' => function($query) use($minor,$major)
        {
            $query->join('minors', "minors.id","package_minors.minor_id");

            if($minor != "")
            {
                $query->where("minors.id", $minor);
            }
            if($major != "")
            {
                $query->where("minors.major_id", $major);
            }
        }]);

        if($request->input('package'))
        {
          $package = $request->input('package');

          Session(['package' => $package]);

          $data["packages"] = $data["packages"]->where(function($v) use ($package)
          {
              $v->where("package_ar",'LIKE', '%'. $package .'%')
              ->orWhere("package_en",'LIKE', '%'. $package .'%');
          });
        }
        else
        {
          $packageSession = session('package');
          if( $packageSession != "")
          {
            $data["packages"] = $data["packages"]->where(function($v) use ($packageSession)
            {
                $v->where("package_ar",'LIKE', '%'. $packageSession .'%')
                ->orWhere("package_en",'LIKE', '%'. $packageSession .'%');
            });
          }
        }

        if($request->input('systm') != 0)
        {
            $systm = $request->input('systm');

            Session(['pk_systm' => $systm]);

            $data["packages"] = $data["packages"]->where("packages.systm_id", $systm);
        }
        else
        {
          $systm_id_Session = session('pk_systm');
          if( $systm_id_Session != "")
          {
            $data["packages"] = $data["packages"]->where("packages.systm_id", $systm_id_Session);
          }
        }


        $data["packages"] = $data["packages"]->whereNot("is_archived",1)->paginate(15);

        foreach($data["packages"] as $p)
        {
            $majors = [];
            foreach($p["packageMinor"] as $pn)
            {
                $majors[] = $pn->major_id;
            }
            $p->majors = Major::whereIN("id",$majors)->get();
        }
        $data["systems"] = Systm::all();
        $data["majors"] = Major::all();
        $data["minors"] = Minor::all();

        return view("packages",$data);
    }

    public function showAll()
    {
      Session(['package' => ""]);
      Session(['pk_systm' => ""]);
      Session(['pk_major' => ""]);
      Session(['pk_minor' => ""]);
      return back();
    }

    public function create()
    {
        $data["systems"] = Systm::all();
        $data["majors"] = Major::with("minor" )->get();


        return view("createPackage",$data);
    }

    public function edit($package_id)
    {
        $data["package"] = Package::with(['packageMinor' => function($query)
        {
            $query->join('minors', "minors.id","package_minors.minor_id");
        }])->where("packages.id",$package_id)->first();

        $data["systems"] = Systm::all();

        $data["majors"] = Major::with("minor")->get();

        return view("editPackage",$data);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageRequest $request)
    {
        $package = new Package();
        $package->package_ar = $request->input("package_ar");
        $package->package_en = $request->input("package_en");
        $package->systm_id = $request->input("systm_id");
        $package->price = $request->input("price");
        $package->save();

        $majors = Major::all();
        foreach($majors as $m)
        {
            if($request->input("major".$m->id))
            {
                $minors = $request->input("major".$m->id);
                foreach($minors as $n)
                {
                    $packageMinor = new PackageMinor();
                    $packageMinor->package_id = $package->id;
                    $packageMinor->minor_id = $n;
                    $packageMinor->save();
                }
            }
        }
        $client = new Client();

        $token = session("skillTax_token");
        $url = session("url")."v1";

    $data =[
        "dash_id"=>$package->id,
        "package_ar" => $request->input("package_ar"),
        "package_en" => $request->input("package_en"),
        "price" => $request->input("price")
        ];
        $client->post("$url/packages", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => $data
        ]);
        return redirect("/packages")->with("Message","تمت الاضافة");
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $Package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $request,$package_id)
    {
        $package = Package::find($package_id);
        $package->package_ar = $request->input("package_ar");
        $package->package_en = $request->input("package_en");
        $package->price = $request->input("price");
        $package->update();

        PackageMinor::where("package_id",$package_id)->delete();

        $majors = Major::all();
        foreach($majors as $m)
        {
            if($request->input("major".$m->id))
            {
                $minors = $request->input("major".$m->id);
                foreach($minors as $n)
                {
                    $packageMinor = new PackageMinor();
                    $packageMinor->package_id = $package->id;
                    $packageMinor->minor_id = $n;
                    $packageMinor->save();
                }
            }
        }

        $this->skilltax_customers_package($package_id);

        $fileName = "package_".$package_id.".json";
        $contents = File::get( public_path('/jsons/'.$fileName));

        $client = new Client();

        $token = session("skillTax_token");
        $url = session("url")."v1";
        $client->post("$url/updateCustomersPackage", [
        'headers'=> ['Authorization' => 'Bearer ' . $token ],
        'json' => json_decode($contents)]);


        $data =[
        "package_ar" => $request->input("package_ar"),
        "package_en" => $request->input("package_en"),
        "price" => $request->input("price")
        ];
        $client->post("$url/packages/$package_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => $data
        ]);

        return redirect("/packages")->with("Message","تم التعديل");
    }

    public function skilltax_customers_package($package_id)
    {
        $client = new Client();

        $token = session("skillTax_token");
        $url = session("url")."v1";

        $allPackageSubscribers = json_decode($client->get("$url/subscribers/searchByPackage/$package_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(),true);

        // to put file data
        $fileName = "package_".$package_id.".json";
        $fileStorePath = public_path('/jsons/'.$fileName);

        $memberships = [];

        foreach($allPackageSubscribers as $customer)
        {
            $memberships[] = $customer['membership_no'];
        }
        $dataMajors = [];
        $package = Package::with(['packageMinor'=> function($query)
            {
                $query->join("minors","minors.id","package_minors.minor_id");
            }])->where("id",$package_id)->first();

            $majorsArray = [];
            $minorsArray = [];

            foreach($package->packageMinor as $pn)
            {
                $majorsArray[] = $pn->major_id;
                $minorsArray[] = $pn->minor_id;
            }

            $majorsArrays = Major::whereIn("id",$majorsArray)->get();
            foreach($majorsArrays as $ma)
            {
                //subscriber property insertion
                $major = Major::find($ma->id);

                //permission list insertion
                $minors = Minor::where("major_id",$ma->id)->whereIn("id",$minorsArray)->with(["property" => function($query)
                {
                    $query->with("operation");
                }])->get();

                $minorData = [];

                foreach($minors as $minor)
                {
                    $properties = [];
                    if(sizeof($minor->property) > 0)
                    {
                        foreach($minor->property as $mp)
                        {
                            $operations = [];
                            if(sizeof($mp->operation) > 0)
                            {
                                foreach($mp->operation as $mpo)
                                {
                                    $operations[] = ["operation_ar" =>"$mpo->operation_ar"];
                                }
                            }
                            $properties[] =["property_ar" =>"$mp->property_ar","operations"=>$operations];
                        }
                    }
                    $minorData[] = ["permission" => "$minor->minor_ar","properties"=>$properties];
                }
                $dataMajors[]= ["dash_id" => $major->id,"property" => "$major->major_ar","permissionLists"=>$minorData];
            }


        $data = [
            "memberships" => $memberships,
            "package" => $dataMajors,
        ];

        File::put($fileStorePath, json_encode($data));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $package_id)
    {
        Package::where("id",$package_id)->update(["is_archived"=>1]);

        $client = new Client();

        $token = session("skillTax_token");
        $url = session("url")."v1";

        $client->delete("$url/packages/$package_id", [
            'headers' => ['Authorization' => 'Bearer ' . $token]
        ]);

        return redirect("/packages")->with("Message","تمت الأرشفة");

    }
}
