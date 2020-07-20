<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $series = DB::table('series')
            ->select('id', 'name')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $maxSeries = 5;
        $seriesCount = 0;
        foreach ($series as $index => $obj) {
            $videos = DB::table('videos AS v')
                ->select('v.id', 'v.name', 'v.slug', 'v.thumbnail', 'v.duration', 'v.total_view', 'u.name AS created_by_name', 'v.created_by')
                ->join('users AS u', 'u.id', '=', 'v.created_by')
                ->where('v.status', 1)
                ->where('v.series_id', $obj->id)
                ->orderBy('v.created_at', 'DESC')
                ->limit(12)
                ->get();
            setListVideosInfo($videos);
            if (empty($videos)) {
                unset($series[$index]);
            } else {
                $series[$index]->videos = $videos;
            }
            $seriesCount++;
            if ($seriesCount >= $maxSeries) {
                break;
            }
        }

        $recent = [];
        $videos = DB::table('videos AS v')
            ->select('v.id', 'v.name', 'v.slug', 'v.thumbnail', 'v.duration', 'v.total_view', 'u.name AS created_by_name', 'v.created_by')
            ->join('users AS u', 'u.id', '=', 'v.created_by')
            ->where('v.status', 1)
            ->orderBy('v.created_at', 'DESC')
            ->distinct()
            ->limit(3)
            ->get();
        setListVideosInfo($videos);
        $recent = $videos;

        return view('web.home', compact('series', 'recent'));
    }
}
