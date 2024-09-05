<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["services"] = Service::whereNot("is_archived",1)->paginate(15);
        return view("services",$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $service = new Service();
        $service->ar_service = $request->input("ar_service");
        $service->en_service = $request->input("en_service");
        $service->price = $request->input("price");
        $service->save();

        return redirect("/services")->with("Message","تمت الاضافة");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request)
    {
        $service = Service::find($request->input("service_id"));
        $service->ar_service = $request->input("ar_service");
        $service->en_service = $request->input("en_service");
        $service->price = $request->input("price");
        $service->update();

        return redirect("/services")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $major_id)
    {
        Service::where("id",$major_id)->update(["is_archived"=>1]);
        return redirect("/services")->with("Message","تم الحذف");

    }
}
