<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends BaseController
{
    const ITEMS_PER_PAGE = 40;

    public function categoryShow(Request $request, string $slugAndId)
    {
        $slugAndId = getSlugAndId($slugAndId);
        $id = $slugAndId['id'];
        $slug = $slugAndId['slug'];
        $category = DB::table('categories')
            ->select('id', 'name', 'slug')
            ->where('status', 1)
            ->where('id', $id)
            ->first();
        if (!$category) {
            abort(404);
        }
        if ($category->slug != $slug) {
            return redirect(route('videos.categories.show', [$category->slug . '-' . $category->id]));
        }

        $videos = DB::table('videos AS v')
            ->select('v.id', 'v.name', 'v.slug', 'v.thumbnail', 'v.duration', 'v.total_view', 'u.name AS created_by_name', 'v.created_by')
            ->join('users AS u', 'u.id', '=', 'v.created_by')
            ->where('v.status', 1)
            ->where('v.category_id', $category->id)
            ->orderBy('v.created_at', 'DESC')
            ->paginate(self::ITEMS_PER_PAGE);
        setListVideosInfo($videos);

        return view('web.videos.categories.show', compact('category', 'videos'));
    }

    public function show(Request $request, string $slugAndId)
    {
        $slugAndId = getSlugAndId($slugAndId);
        $id = $slugAndId['id'];
        $slug = $slugAndId['slug'];
        $video = DB::table('videos')
            ->select('slug', 'status', 'id', 'name', 'created_at', 'description', 'total_view', 'total_comment')
            ->where('id', $id)
            ->first();
        if (!$video) {
            abort(404);
        }

        if ($video->status != 1) {
            abort(404);
        }

        if ($video->slug != $slug) {
            return redirect(route('videos.show', [$video->slug . '-' . $video->id]));
        }

        $video->total_view++;
        $this->updateTotalView($video);
        $this->updateUserHistory($video);

        $createdAt = Carbon::parse($video->created_at);
        $video->publishedText = 'Published on ' . $createdAt->format('F') . ' ' . $createdAt->format('Y');

        return view('web.videos.show', compact('video'));
    }

    private function updateTotalView($video)
    {
        DB::table('videos')
            ->where('id', $video->id)
            ->update(['total_view' => $video->total_view]);
    }

    private function updateUserHistory($video)
    {
        if (Auth::check()) {
            $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
            $history = DB::table('user_videos')
                ->select('id')
                ->where('user_id', Auth::id())
                ->where('video_id', $video->id)
                ->where('created_at', '>=', $startOfDay)
                ->where('created_at', '<=', $endOfDay)
                ->first();
            $now = Carbon::now()->format('Y-m-d H:i:s');
            if ($history) {
                DB::table('user_videos')
                    ->where('id', $history->id)
                    ->update(['updated_at' => $now]);
            } else {
                DB::table('user_videos')
                    ->insert([
                        'user_id' => Auth::id(),
                        'video_id' => $video->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
            }
        }
    }
}
