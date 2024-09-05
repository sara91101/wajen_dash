<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerUserTypeRequest;
use App\Models\CustomerUserType;

class CustomerUserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["userTypes"] = CustomerUserType::paginate(15);

        return view("userTypes",$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerUserTypeRequest $request)
    {
        $userType = new CustomerUserType();
        $userType->user_type_ar = $request->input("user_type_ar");
        $userType->user_type_en = $request->input("user_type_en");
        $userType->save();

        return redirect("/userTypes")->with("Message","تمت الاضافة");
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUserTypeRequest $request)
    {
        $userType = CustomerUserType::find($request->input("user_type_id"));
        $userType->user_type_ar = $request->input("user_type_ar");
        $userType->user_type_en = $request->input("user_type_en");
        $userType->update();

        return redirect("/userTypes")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $user_type_id)
    {
        CustomerUserType::where("id",$user_type_id)->delete();
        return redirect("/userTypes")->with("Message","تم الحذف");

    }
}
