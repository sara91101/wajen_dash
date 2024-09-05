<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Pagination\LengthAwarePaginator;

class LoyaltyContactController extends Controller
{
    public function index()
    {
        // Set default page
        $data["page"] = request()->has('page') ? request('page') : 1;

        // Set default per page
        $data["perPage"] =  10;

        // Offset required to take the results
        $offset = ($data["page"] * $data["perPage"]) - $data["perPage"];

        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1/loyalty";

        try
        {
            $data["questions"] = json_decode($client->get("$url/loyaltyContactUs",['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(),
            );

            //paginate result
            $newCollection = collect($data["questions"]);

            $data["results"] =  new LengthAwarePaginator(
                $newCollection->slice($offset, $data["perPage"]),
                $newCollection->count(),
                $data["perPage"],
                $data["page"],
                ['path' => request()->url(), 'query' => request()->query()]
           );
        }
        catch (ClientException $e) {

            return $e->getMessage();
        }

        return view("loyaltyContact",$data);
    }

    public function destroy($question_id)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v1/loyalty";
        $client->delete("$url/loyaltyContactUs/$question_id",['headers' => ['Authorization' => 'Bearer ' . $token]]);


        return redirect("/loyaltyContacts")->with("Message", "تم الحذف");

    }

}
