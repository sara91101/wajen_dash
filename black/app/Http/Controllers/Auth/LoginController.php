<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\Systm;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    public function __construct()
    {
        $info = Info::first();
        Session(['infos' => $info]);
        Session(['mode' => "dark"]);

        $systm = Systm::first();
        Session(['url' => $systm->endPoint_url]);

        $client = new Client();

        $login = $client->post("$systm->endPoint_url/subscribers/login", [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['membership_no' => 700000, 'password' => 123456]
        ]);

        $token = json_decode($login->getBody()->getContents())->token;
        Session(['skillTax_token' => $token]);

        $this->middleware('guest')->except('logout');
    }
}
