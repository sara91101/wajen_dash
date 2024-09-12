<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["keywords"] = Keyword::paginate(15);

        return view("keywords",$data);
    }

    public function keywordList()
    {
        $keywords = Keyword::all();

        return response()->json($keywords,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("createKeyword");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Keyword = new Keyword();
        $Keyword->ar_keyword = $request->ar_keyword;
        $Keyword->en_keyword = $request->en_keyword;
        $Keyword->save();

        return redirect("/keywords")->with("Message","تمت الاضافة");

    }

    /**
     * Display the specified resource.
     */
    public function show( $Keyword_id)
    {
        $Keyword = Keyword::find($Keyword_id);

        return response()->json($Keyword,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $Keyword)
    {
        $data["Keyword"] = Keyword::find($Keyword);

        return view("editKeyword",$data);
    }

    public function Keyword($Keyword_id)
    {
        $data["Keyword"] = Keyword::find($Keyword_id);

        return view("Keyword",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $Keyword = Keyword::find($request->keyword_id);
        $Keyword->ar_keyword = $request->ar_keyword;
        $Keyword->en_keyword = $request->en_keyword;
        $Keyword->update();

        return redirect("/keywords")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $Keyword_id)
    {
        $Keyword = Keyword::find($Keyword_id);

        $Keyword->delete();

        return redirect("/keywords")->with("Message","تم الحذف");

    }
}
