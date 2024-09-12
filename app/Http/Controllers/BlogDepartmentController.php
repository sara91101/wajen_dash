<?php

namespace App\Http\Controllers;

use App\Models\BlogDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["blog_departments"] = BlogDepartment::paginate(15);

        return view("blog_departments",$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $department = new BlogDepartment();
        $department->en_department = $request->input("en_department");
        $department->ar_department = $request->input("ar_department");
        if($request->file("photo"))
        {
            $path = public_path('/blogs');

            $file = $request->file("photo");
            $fileName = "blog_department".time(). '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $department->photo = $fileName;
        }
        $department->save();

        return redirect("/blogDepartments")->with("Message","تمت الاضافة");
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $department = BlogDepartment::find($request->input("department_id"));
        $department->en_department = $request->input("en_department");
        $department->ar_department = $request->input("ar_department");

        if($request->file("photo"))
        {
            File::delete(public_path("blogs/$department->photo"));

            $path = public_path('/blogs');

            $file = $request->file("photo");
            $fileName = "blog_department".time(). '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $department->photo = $fileName;
        }

        $department->update();

        return redirect("/blogDepartments")->with("Message","تم التعديل");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $department_id)
    {
        BlogDepartment::where("id",$department_id)->delete();
        return redirect("/blogDepartments")->with("Message","تم الحذف");

    }

    public function blogDepartmentList()
    {
        $departments = BlogDepartment::all();

        return response()->json($departments);
    }

     public function blogs($department_id)
    {
        $blogs = BlogDepartment::where("id",$department_id)->with(["blog"=>function($sql){
            $sql->with("keyword")->get();
        }])->first();

        return response()->json($blogs);
    }
}
