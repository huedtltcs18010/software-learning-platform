<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends BaseController
{
    public function index(Request $request)
    {
        $objs = DB::table('user_videos AS uv')
            ->select('v.id', 'v.name', 'v.slug', 'v.thumbnail', 'v.duration', 'v.total_view', 'u.name AS created_by_name', 'v.created_by', 'uv.updated_at AS last_seen')
            ->join('videos AS v', 'v.id', '=', 'uv.video_id')
            ->join('users AS u', 'u.id', '=', 'v.created_by')
            ->where('uv.user_id', Auth::id())
            ->where('v.status', 1)
            ->orderBy('uv.updated_at', 'DESC')
            ->limit(3)
            ->get();
        setListVideosInfo($objs);
        $videos = [];
        foreach ($objs as $obj) {
            $date = Carbon::parse($obj->last_seen)->format('Y-m-d');
            if (!isset($videos[$date])) {
                $videos[$date] = [];
            }
            $videos[$date][] = $obj;
        }
        return view('web.histories.index', compact('videos'));
    }
}
