<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserSessionController extends Controller
{
    public function index(Request $request)
    {
        $sessions = json_decode(Http::get('https://backend.skilltax.sa/api/v1/userSessions'),true);
        $info="";
        if($request->session)
        {
            $info = $request->session;
        }
        return view("sessions",compact("sessions","info"));
    }

    public function destroy($session_id)
    {
        $client = new Client();
        $client->delete("https://backend.skilltax.sa/api/v1/userSessions/destroy/$session_id");
        return back();
    }
}
