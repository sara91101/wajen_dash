<?php

namespace App\Http\Controllers;

use App\Mail\FriendMail;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["friends"] = Friend::paginate(15);

        return view("friends",$data);
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
        $data = ["friend_phone" => $request->friend_phone,
        "friend_email" => $request->friend_email,
        "friend_first_name" => $request->friend_first_name,
        "friend_last_name" => $request->friend_last_name,

        "subscriber_fullname" => $request->subscriber_fullname,
        "subscriber_business_name" => $request->subscriber_business_name,
        "subscriber_activity" => $request->subscriber_activity,
        "subscriber_phone" => $request->subscriber_phone,
        "subscriber_email" => $request->subscriber_email,
        ];

        $validator = Validator::make($data, [
            'friend_phone'      => 'required|numeric|digits:10',
            'friend_email'     => 'nullable|email',
            'friend_first_name'      => 'required|string',
            'friend_last_name'      => 'required|string',

            'subscriber_fullname'      => 'required|string',
            'subscriber_business_name'      => 'required|string',
            'subscriber_activity'      => 'required|string',
            'subscriber_phone'      => 'required|numeric|digits:9',
            'subscriber_email'     => 'nullable|email',
        ]);

        if ($validator->fails())
        {
            return response()->json(["message"=>"error occured".$validator->errors()],401);
        }

        $today = date("Y-m-d");

        $ip_today = Friend::where("ip_address",$request->ip())->whereDate('created_at',$today)->exists();

        if($ip_today)
        {
            return response()->json(['message'=> 'The ip address already exists today',"ip"=>$request->ip()], 422);
        }

        $Friend = new Friend();
        $Friend->friend_phone = $request->friend_phone;
        $Friend->friend_email = $request->friend_email;
        $Friend->friend_first_name = $request->friend_first_name;
        $Friend->friend_last_name = $request->friend_last_name;

        $Friend->subscriber_business_name = $request->subscriber_business_name;
        $Friend->subscriber_fullname = $request->subscriber_fullname;
        $Friend->subscriber_activity = $request->subscriber_activity;
        $Friend->subscriber_phone = $request->subscriber_phone;
        $Friend->subscriber_email = $request->subscriber_email;

        $Friend->ip_address = $request->ip();
        $Friend->save();

        $this->sendToEmail($data);

        return response()->json(["message"=>"Friend created successfully"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $friend)
    {
        Friend::where("id",$friend)->delete();

        return redirect("friends")->with("Message", "تم الحذف ");
    }



    public function sendToEmail($details)
    {
        Mail::to("support@skilltax.sa")->send(new FriendMail($details));
    }
}
