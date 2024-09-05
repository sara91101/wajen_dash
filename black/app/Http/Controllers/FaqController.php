<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["faqs"] = Faq::paginate(15);
        return view("faqs",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $faq = new Faq();
        $faq->systm_id = 1;
        $faq->ar_question = $request->ar_question;
        $faq->systm_id = 1;
        $faq->ar_answer = $request->ar_answer;
        $faq->en_question = $request->en_question;
        $faq->en_answer = $request->en_answer;
        $faq->save();

        return redirect("faqs")->with("Message","تم الحفظ");
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request)
    {
        $faq =  Faq::find($request->faq_id);
        $faq->ar_question = $request->ar_question;
        $faq->systm_id = 1;
        $faq->ar_answer = $request->ar_answer;
        $faq->en_question = $request->en_question;
        $faq->en_answer = $request->en_answer;
        $faq->update();

        return redirect("faqs")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $faq)
    {
        Faq::where("id",$faq)->delete();
        return redirect("faqs")->with("Message","تم الحذف");

    }
}
