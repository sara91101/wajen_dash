<?php

namespace App\Http\Middleware;

use App\Models\LevelSubPage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Privileges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $route = Route::currentRouteName();

        if($route != "home" && $route != "changeMode")
        {
            $privilige = LevelSubPage::join("levels","levels.id","level_sub_pages.level_id")
            ->join("sub_pages","sub_pages.id","level_sub_pages.sub_page_id")
            ->join("sub_page_operations","sub_page_operations.sub_page_id","sub_pages.id")
            ->where("level_id",$user->level_id)
            ->where("operation","$route")
            ->exists();

        // echo $route."-".$privilige;exit();

            if($privilige)
            {
                return $next($request);
            }
            else
            {
                return back()->with("NoAccess","ليس لديك صلاحية الدخول لهذه الصفحة");
            }
        }
        else
        {
            return $next($request);
        }
    }
}
