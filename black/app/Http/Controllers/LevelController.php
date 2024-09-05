<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use App\Models\Level;
use App\Models\LevelSubPage;
use App\Models\Page;
use App\Models\SubPage;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["levels"] = Level::with(["levelSubPage"=>function($query)
        {
            $query->join("sub_pages","sub_pages.id","level_sub_pages.sub_page_id")
            ->join("pages","pages.id","sub_pages.page_id");
        }])->get();
        $data["subPages"] = SubPage::count();
        return view("levels",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["pages"] = Page::with("subPage")->get();
        return view("addLevel",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $level = new Level();
        $level->level = $request->level;
        $level->save();

        $pages = Page::all();
        foreach($pages as $page)
        {
            $pageName = "page".$page->id;
            if($request->input("$pageName"))
            {
                foreach($request->input("$pageName") as $subPage)
                {
                    $levelSubPage = new LevelSubPage();
                    $levelSubPage->level_id = $level->id;
                    $levelSubPage->sub_page_id = $subPage;
                    $levelSubPage->save();
                }
            }
        }

        return redirect("/levels")->with("Message","تمت الاضافة");

    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $level_id)
    {
        $data["level"] = Level::with("levelSubPage")->where("id",$level_id)->first();
        $previousPermissions = [];
        foreach($data["level"]["levelSubPage"] as $levelSubPage)
        {
            $previousPermissions[] = $levelSubPage->sub_page_id;
        }
        $data["pages"] = Page::with("subPage")->get();
        return view("editLevel",$data,compact("previousPermissions"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $level_id)
    {
        $level = Level::find($level_id);
        $level->level = $request->level;
        $level->update();

        LevelSubPage::where("level_id",$level_id)->delete();

        $pages = Page::all();
        foreach($pages as $page)
        {
            $pageName = "page".$page->id;
            if($request->input("$pageName"))
            {
                foreach($request->input("$pageName") as $subPage)
                {
                    $levelSubPage = new LevelSubPage();
                    $levelSubPage->level_id = $level->id;
                    $levelSubPage->sub_page_id = $subPage;
                    $levelSubPage->save();
                }
            }
        }
        return redirect("/levels")->with("Message","تم التعديل");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $level_id)
    {
        Level::where("id",$level_id)->delete();
        return redirect("/levels")->with("Message","تم الحذف");
    }
}
