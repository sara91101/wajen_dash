<?php

namespace App\Http\Controllers;

use App\Mail\InquiryMail;
use App\Models\Inquiry;
use App\Models\InquiryReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["inquires"] = Inquiry::with("reply")->paginate(15);
        return view("inquires",$data);
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
        "message" => $request->message];

        $validator = Validator::make($data, [
            'phone'      => 'required|numeric|digits:10',
            'email'     => 'required|email',
            'message'      => 'required|string',
        ]);

        if ($validator->fails())
        {
            return response()->json(["message"=>"error occured".$validator->errors()],401);
        }

        $today = date("Y-m-d");

        $ip_today = Inquiry::where("ip_address",$request->ip())->whereDate('created_at',$today)->exists();

        // if($ip_today)
        // {
        //     return response()->json(['message'=> 'The ip address already exists today',"ip"=>$request->ip()], 422);
        // }

        $inquiry = new Inquiry();
        $inquiry->phone = $request->phone;
        $inquiry->email = $request->email;
        $inquiry->message = $request->message;
        $inquiry->ip_address = $request->ip();
        $inquiry->save();

        $this->sendToEmail($data);

        return response()->json(["message"=>"Inquiry created successfully"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $inquiry_id)
    {
        $data["inquiry"] = Inquiry::with(["reply" => function($sql){
            $sql->join("users","users.id","inquiry_replies.user_id")->get();
        }])->find($inquiry_id);

        return view("inquiryReply",$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $inquiry_id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function reply(Request $request,  $inquiry)
    {
        $details = ['title' => "الرد على الإستفسار", 'body' => $request->reply];

        $inq = Inquiry::find($inquiry);

        $reply = new InquiryReply();
        $reply->user_id = Auth::user()->id;
        $reply->inquiry_id = $inquiry;
        $reply->reply = $request->reply;
        $reply->save();

        Mail::to($inq->email)->send(new \App\Mail\CustomerMail($details));

        return redirect("inquiries/$inquiry")->with("Message", "تم إرسال الرد");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $inquiry)
    {
        Inquiry::where("id",$inquiry)->delete();

        return redirect("inquiries")->with("Message", "تم حذف الإستفسار");
    }

    public function sendToEmail($details)
    {
        Mail::to("support@skilltax.sa")->send(new InquiryMail($details));
    }
}
