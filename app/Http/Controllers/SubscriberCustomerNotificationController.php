<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriberCustomerNotificationController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = Config('app.skilltax_v2')."SubscriberCustomerAllNotification";

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ],
            'query' => [ 
                'membership_no' => $request->membership_no,
                'status' => $request->status,
                'paginate' => 25,
                'page' => $request->get('page', 1)
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        $items = collect($result['data']);

        $data = new LengthAwarePaginator(
            $items,
            $result['total'],
            $result['per_page'],
            $result['current_page'],
            ['path' => url()->current() , 'query' => $request->query()]
        );

        return view('SubscriberCustomerNotification',['notifications' => $data]);
    }

    public function changeStatus($id , $status)
    {
        $client = new Client();
        $url = Config('app.skilltax_v2')."SubscriberCustomerNotification/changeStatus/$id";
        $token = session("skillTax_token");

        if($status == 'accept')
        {
            $msg = "تم قبول الاشعار وارساله للزبائن";
        }
        else
        {
            $msg = "تم رفض الاشعار";
        }

        $client->post("$url", ['headers' => ['Authorization' => 'Bearer ' . $token],'json'=> ['status' => $status]]);


        return back()->with("Message", $msg);
    }
}
