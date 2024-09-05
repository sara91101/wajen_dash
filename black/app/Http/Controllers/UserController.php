<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data["users"] = User::select("users.*","levels.level")
        ->join("levels","levels.id","users.level_id");

        if($request->user)
        {
            $user= $request->user;
            Session(['user' => $user]);

            $data["users"] =$data["users"]->where(function($v) use ($user)
            {
                $v->where("name",'LIKE', '%'. $user .'%')
                ->orWhere("email",'LIKE', '%'. $user .'%');
            });
        }
        else
        {
            $userSession = session('user');
            if( $userSession != "")
            {
                $data["users"] =$data["users"]->where(function($v) use ($userSession)
                {
                    $v->where("name",'LIKE', '%'. $userSession .'%')
                    ->orWhere("email",'LIKE', '%'. $userSession .'%');
                });
            }
        }

        if($request->input('level') != 0)
        {
            $level = $request->input('level');

            Session(['level' => $level]);

            $data["users"] = $data["users"]->where("level_id",$level);
        }
        else
        {
            $levelSession = session('level');
            if( $levelSession != "")
            {
                $data["users"] = $data["users"]->where("level_id",$levelSession);
            }
        }
        $data["users"] =$data["users"]->paginate(15);

        $data["levels"] = Level::all();

        return view("users",$data);
    }

    public function showAll()
    {
      Session(['user' => ""]);
      Session(['level' => ""]);

      return redirect("/users");
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
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->pass = $request->password;
        $user->password = Hash::make($request->password);;
        $user->level_id = $request->level_id;
        $user->save();

        return redirect("/users")->with("Message","تم الحفظ");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user = User::find($request->User_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->pass = $request->password;
        $user->password = Hash::make($request->password);;
        $user->level_id = $request->level_id;
        $user->update();

        return redirect("/users")->with("Message","تم التعديل");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $user)
    {
        User::where('id', $user)->delete();
        return redirect("/users")->with("Message","تم الحذف");

    }


    public function changePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->pass = $request->password;
        $user->password = Hash::make($request->password);
        $user->update();

        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
