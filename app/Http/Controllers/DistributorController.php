<?php

namespace App\Http\Controllers;

use App\Mail\DistributorMail;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["distributors"] = Distributor::paginate(15);

        return view("distributors",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = ["phone" => $request->phone,
        "email" => $request->email,
        "first_name" => $request->first_name,
        "last_name" => $request->last_name,
        "business_name" => $request->business_name,
        "city" => $request->city,
        "branches_no" => $request->branches_no,
        ];

        $validator = Validator::make($data, [
            'phone'      => 'required|numeric|digits:10',
            'email'     => 'required|email',
            'first_name'      => 'required|string',
            'last_name'      => 'required|string',
            'business_name'      => 'required|string',
            'city'      => 'required|string',
            'branches_no'      => 'required|numeric',
        ]);

        if ($validator->fails())
        {
            return response()->json(["message"=>"error occured".$validator->errors()],401);
        }

        $today = date("Y-m-d");

        $ip_today = Distributor::where("ip_address",$request->ip())->whereDate('created_at',$today)->exists();

        if($ip_today)
        {
            return response()->json(['message'=> 'The ip address already exists today',"ip"=>$request->ip()], 422);
        }

        $Distributor = new Distributor();
        $Distributor->phone = $request->phone;
        $Distributor->email = $request->email;
        $Distributor->first_name = $request->first_name;
        $Distributor->last_name = $request->last_name;
        $Distributor->business_name = $request->business_name;
        $Distributor->city = $request->city;
        $Distributor->branches_no = $request->branches_no;
        $Distributor->ip_address = $request->ip();
        $Distributor->save();

        $this->sendToEmail($data);

        return response()->json(["message"=>"Distributor created successfully"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $distributor)
    {
        Distributor::where("id",$distributor)->delete();

        return redirect("distributors")->with("Message", "تم حذف الموزع");
    }

    public function sendToEmail($details)
    {
        Mail::to("support@skilltax.sa")->send(new DistributorMail($details));
    }
}
