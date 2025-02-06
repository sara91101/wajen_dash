<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\Systm;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function home_after_otp()
    {
        $info = Info::first();
        Session(['infos' => $info]);
        Session(['mode' => "light"]);

        $client = new Client();

        $login = $client->post("https://back.skilltax.sa/api/v1/subscribers/login", [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['membership_no' => 701292, 'password' => "888888"]
        ]);

        $token = json_decode($login->getBody()->getContents())->token;
        Session(['skillTax_token' => $token]);

        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/sendOtpMessage');
        }  else {
            return back();
        }
    }



    public function logout(Request $request)
    {
        User::where('id',Auth::user()->id)->update([
                    'verification_code' => null,
                    'valid_until' => null, // make otp expire after 5 minutes
                    'code_used'=> 0,
                    'verified'=> 0,
                    ]);
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }


    public function postman( $phone)
    {
        $text = "رمز التحقق هو";

        // Check if otp to loyalty app
        $code = rand(1234, 9999);

        $message = $text . ':' . ' ' . $code;

        try {
                $apiUrl = 'https://www.msegat.com/gw/sendsms.php';
                $data = [
                    'userName' => 'Wajen5188',
                    'apiKey' => env('OTP_MESSAGE_KEY'),
                    'numbers' => $phone,
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
                        return $responseData;
                } else {
                    // Data creation failed
                    return response()->json(['message' => 'Failed to create verification code'], 500);
                }
            } catch (\Exception $e) {
                Log::error('Error in sending OTP '. $e->getMessage());
                return response()->json(['message' => $e->getMessage()], 500);
            }
        
    }

    // Function to send OTP message to a phone number
    public function sendOtpMessage(Request $request)
    {
        $user = Auth::user();
        $current_time = Carbon::now();
        if(is_null($user->verification_code) || $request->resend == 1)
        { 
            $text = "رمز التحقق هو";

            // Check if otp to loyalty app
            $code = rand(1234, 9999);

            $message = $text . ':' . ' ' . $code;

            try {
                $apiUrl = 'https://www.msegat.com/gw/sendsms.php';
                $data = [
                    'userName' => 'Wajen5188',
                    'apiKey' => env('OTP_MESSAGE_KEY'),
                    'numbers' => $user->phone_number,
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
                        User::where('id',$user->id)->update([
                        'verification_code' => $code,
                        'valid_until' => Carbon::now()->addMinutes(5), // make otp expire after 5 minutes
                        'code_used'=> 0,
                        'verified'=> 0,
                        ]);
                    

                    return view('verification_code');
                } else {
                    // Data creation failed
                    return response()->json(['message' => 'Failed to create verification code'], 500);
                }
            } catch (\Exception $e) {
                Log::error('Error in sending OTP '. $e->getMessage());
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        else{return view('verification_code');}
    }

    public function checkVerificationCode(Request $request)
    {
        $user = Auth::user();
        $user_exist = User::where('id',$user->id)->where('verification_code',$request->code)->where('code_used',0)->where('valid_until','>',Carbon::now())->exists();
        if($user_exist)
        {
            User::where('id',$user->id)->update(['code_used'=> 1,'verified' => 1]);
            $this->home_after_otp();
           return redirect('/home');
        }
        else
        {
            return back()->with('verification_message','رمز التحقق غير صحيح');
        }
    }
}
