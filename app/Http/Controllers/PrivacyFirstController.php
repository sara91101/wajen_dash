<?php

namespace App\Http\Controllers;

use App\Models\PrivacyFirst;
use App\Models\PrivacySecond;
use App\Models\PrivacyThird;
use Illuminate\Http\Request;

class PrivacyFirstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacies = PrivacyFirst::with(["second"=> function($query){$query->with("third");}])->get();
        return response()->json($privacies,201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("createPrivacy");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $first = new PrivacyFirst();
        $first->ar_first = $request->first;
        $first->save();

        $seconds = $request->second;
        if(sizeof($seconds) != 0)
        {
            for($i = 0; $i < sizeof($seconds); $i++)
            {
                if($seconds[$i] != "")
                {
                    $second = new PrivacySecond();
                    $second->first_id = $first->id;
                    $second->ar_second = $seconds[$i];
                    $second->save();

                    $secondThirds = "third".$i+1;
                    $thirds = $request[$secondThirds];
                    if(sizeof($thirds) != 0)
                    {
                        for($j = 0; $j < sizeof($thirds); $j++)
                        {
                            if($thirds[$j] != "")
                            {
                                $third = new PrivacyThird();
                                $third->second_id = $second->id;
                                $third->ar_third = $thirds[$j];
                                $third->save();
                            }
                        }
                    }
                }
            }
        }
        return redirect("/privacy")->with("Message","تمت الاضافة");

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data["privacy"] = PrivacyFirst::with(["second"=> function($query){$query->with("third");}])->get();
        return view("privavy",$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $privacyFirst)
    {
        $data["privacy"] = PrivacyFirst::with(["second"=> function($query){$query->with("third");}])
        ->where("id",$privacyFirst)->first();
        $data["counter"] = PrivacySecond::where("first_id",$privacyFirst)->count();
        return view("editPrivacy",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $privacyFirst)
    {
        $first = PrivacyFirst::find($privacyFirst);
        $first->ar_first = $request->first;
        $first->save();

        PrivacySecond::where("first_id",$privacyFirst)->delete();

        $seconds = $request->second;
        if(!is_null($seconds))
        {
            for($i = 0; $i < sizeof($seconds); $i++)
            {
                if($seconds[$i] != "")
                {
                    $second = new PrivacySecond();
                    $second->first_id = $first->id;
                    $second->ar_second = $seconds[$i];
                    $second->save();

                    $secondThirds = "third".$i+1;
                    $thirds = $request[$secondThirds];
                    if(!is_null($thirds))
                    {
                        for($j = 0; $j < sizeof($thirds); $j++)
                        {
                            if($thirds[$j] != "")
                            {
                                $third = new PrivacyThird();
                                $third->second_id = $second->id;
                                $third->ar_third = $thirds[$j];
                                $third->save();
                            }
                        }
                    }
                }
            }
        }
        return redirect("/privacy")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $privacyFirst)
    {
        PrivacyFirst::where("id",$privacyFirst)->delete();
        return redirect("/privacy")->with("Message","تم الحذف");
    }
}
