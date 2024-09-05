<?php

namespace App\Http\Controllers;

use App\Mail\QuestionMail;

use App\Models\Answer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use GuzzleHttpClientException\ClientException;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionController extends Controller
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
        $url = "https://back.skilltax.sa/api/v1";

        try
        {
            $data["questions"] = json_decode($client->get("$url/questions")->getBody()->getContents());

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

        foreach($data["questions"] as $question)
        {
            $question->answers = Answer::where("question_id",$question->id)->count();
        }
        return view("questions",$data);
    }

    public function destroy($question_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $client->delete("$url/questions/$question_id");

        Answer::where("question_id",$question_id)->delete();

        return redirect("/questions")->with("Message", "تم الحذف");

    }

    public function answer($question_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $data["person"] =json_decode($client->get("$url/questions/$question_id")->getBody()->getContents(), true);


        return view("/sendMail",$data);

    }

    public function reply(Request $request)
    {
        $details = ['title' => $request->title, 'body' => $request->body];

        $message = new Answer();
        $message->user_id = Auth::user()->id;
        $message->question_id = $request->question_id;
        $message->answer = $request->body;
        $message->save();

        Mail::to($request->email)->send(new \App\Mail\CustomerMail($details));

        return redirect("/questions")->with("Message","تم الرد");
    }

    public function show($question_id)
    {
        $client = new Client();
        $url = "https://back.skilltax.sa/api/v1";
        $data["question"] =json_decode($client->get("$url/questions/$question_id")->getBody()->getContents(), true);

        $data["answers"] = Answer::select("answers.*","users.name")
        ->join("users","users.id","answers.user_id")
        ->where("question_id",$question_id)->get();
        return view("/detailsQuestion",$data);

    }

    public function sendToEmail(Request $request)
    {
        $details = ['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone,
        'activity_name' => $request->activity_name, 'activity_type' => $request->activity_type, 'town' => $request->town];
        Mail::to("support@skilltax.sa")->send(new QuestionMail($details));
    }
}
