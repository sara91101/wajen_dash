<?php

namespace App\Http\Controllers;

use App\Models\FreeTrialOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FreeTrialOtpController extends Controller
{
    public function sendOTP(Request $request)
    {
        $check_ip = FreeTrialOtp::where('ip_address',$request->ip())->whereDate('created_at', today())->count();
        if($check_ip >= 10){
            return response()->json([
                'ar_message' => 'عذرا، أكملت عدد المحاولات المسموح بها اليوم، الرجاء المحاولة غدا',
                'en_message' => "Sorry, you can't apply again today. Please try again tomorrow."
            ], 400);
        }
        $data = [
            'phone' => $request->phone
        ];

        $validator = Validator::make($data, [
            'phone'      => ['required', 'regex:/^05\d{8}$/'],
        ]);

        $text = "رمز التحقق هو";

        // Check if otp to loyalty app
        $code = rand(1234, 9999);

        $message = $text . ':' . ' ' . $code;

        if ($validator->fails()) {
            Log::info('Request validation problem :' . $validator->errors());
            return $validator->errors();
        } else {
            try {
                    $otp = new FreeTrialOtp();
                    $otp->phone = $request->phone;
                    $otp->otp = $code;
                    $otp->ip_address = $request->ip();
                    $otp->valid_until = Carbon::now()->addMinutes(5);
                    $otp->save();

                    $apiUrl = 'https://www.msegat.com/gw/sendsms.php';
                    $data = [
                        'userName' => 'Wajen5188',
                        'apiKey' => env('OTP_MESSAGE_KEY'),
                        'numbers' => $request->phone,
                        'userSender' => 'WAJEN',
                        'msg' => $message,
                    ];

                    // Make request to msegat api
                    $response = Http::post($apiUrl, $data);
                    $responseData = $response->json();
                    // return $responseData;
                    $responseStatusCode = $response->status(); // Get the status code of the response

                    // $responseStatusCode = 200;

                    if ($responseStatusCode === 200) {
                            return response()->json(['en_message' => 'OTP Sent' , 'ar_message' => 'تم إرسال رمز التحقق'], 200);
                    } else {
                        // Data creation failed
                        return response()->json(['en_message' => 'Error in sending OTP' ,  'ar_message' => 'عذرا حدث خطأ ، لم يتم إرسال رمز التحقق'], 400);

                    }
            } catch (\Exception $e) {
                Log::error('Error in sending OTP '. $e->getMessage());
                return response()->json(['en_message' => 'Error in sending OTP' ,  'ar_message' => 'عذرا حدث خطأ ، لم يتم إرسال رمز التحقق'], 400);
            }
        }
        
    }

    

    public function checkVerificationCode(Request $request)
    {
        $data = [
            'otp' => $request->otp,
            'phone' => $request->phone
        ];

        $validator = Validator::make($data, [
            'otp' => ['required', 'digits:4'],
            'phone' => ['required', 'regex:/^05\d{8}$/'],
        ]);

        if ($validator->fails()) {
            Log::info('Request validation problem :' . $validator->errors());
            return $validator->errors();
        } 
        else {
            $opt_phone = FreeTrialOtp::where('phone',$request->phone)->where('otp',$request->otp)
                            ->where('used',0)->where('valid_until','>',Carbon::now())->orderBy('id','DESC')->first();
            if($opt_phone)
            {
                $opt_phone->update(['used'=> 1]);
                return response()->json(['en_message'=> 'success','ar_message'=> 'نجاح'],200);
            }
            else
            {
                return response()->json(['en_message'=> 'error: OTP Wrong','ar_message'=> 'عذرا ، رقم التحقق خطأ'],400);
            }
        }
    }


    public function free_trial_repot(Request $request)
    {
        $subscribers = FreeTrialOtp::select('*');

        if($request->info){
            $info = $request->info;
            $subscribers = $subscribers->where(function($sql) use ($info) {
                $sql->where('phone',$info)->orWhere('membership_no',$info);
            });
        }

        if($request->status){
            $subscribers = $subscribers->where('status',$request->status);
        }
        
        $subscribers = $subscribers->paginate(30);

        return view('free_trial_repot',compact('subscribers'));
    }
}
