<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $breadcrumb = [];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return Redirect::to('login');
            }

            $count = DB::table('users AS u')
                ->join('user_role_pivot AS urp', 'urp.user_id', '=', 'u.id')
                ->join('role_permission_pivot AS rpp', 'rpp.role_id', '=', 'urp.role_id')
                ->join('permissions AS p', 'rpp.permission_id', '=', 'p.id')
                ->where('u.id', '=', Auth::id())
                ->where('p.name', 'access_admin_area')
                ->count();

            if ($count == 0) {
                Auth::logout();
                Session::flush();
                return Redirect::to('login');
            }

            return $next($request);
        });
        $this->breadcrumb[] = ['label' => 'Admin CP', 'url' => route('admin.dashboard')];
    }
}
