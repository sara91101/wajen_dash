<?php

namespace App\Http\Controllers;

use App\Models\BlogDepartment;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Spatie\Backtrace\File;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["blogs"] = Blogs::select("blogs.*","blog_departments.ar_department")
        ->join("blog_departments","blog_departments.id","blogs.department_id")
        ->paginate(15);

        $data["departments"] = BlogDepartment::all();

        return view("blogs",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["departments"] = BlogDepartment::all();
        return view("createBlog",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = new Blogs();
        $blog->department_id = $request->department_id;
        $blog->ar_title = $request->ar_title;
        $blog->en_title = $request->en_title;
        $blog->ar_details = $request->ar_details;
        $blog->en_details = $request->en_details;

        if($request->file("image"))
        {
            $path = public_path('/blogs');

            $file = $request->file("image");
            $fileName = "blog".time(). '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $blog->image = $fileName;
        }
        $blog->save();

        return redirect("/blogs")->with("Message","تمت الاضافة");

    }

    /**
     * Display the specified resource.
     */
    public function show( $blog_id)
    {
        $blog = Blogs::find($blog_id);

        return response()->json($blog,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $blog)
    {
        $data["blog"] = Blogs::find($blog);

        $data["departments"] = BlogDepartment::all();

        return view("editBlog",$data);
    }

    public function blog($blog_id)
    {
        $data["blog"] = Blogs::find($blog_id);

        return view("blog",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$blog_id)
    {
        $blog = Blogs::find($blog_id);
        $blog->department_id = $request->department_id;
        $blog->ar_title = $request->ar_title;
        $blog->en_title = $request->en_title;
        $blog->ar_details = $request->ar_details;
        $blog->en_details = $request->en_details;

        if($request->file("image"))
        {
            FacadesFile::delete(public_path("blogs/$blog->image"));

            $path = public_path('blogs');

            $file = $request->file("image");
            $fileName = "blog".time(). '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $blog->image = $fileName;
        }
        $blog->update();

        return redirect("/blogs")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $blog_id)
    {
        $blog = Blogs::find($blog_id);

        FacadesFile::delete(public_path("blogs/$blog->image"));

        $blog->delete();

        return redirect("/blogs")->with("Message","تم الحذف");

    }
}
