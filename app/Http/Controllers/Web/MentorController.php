<?php

namespace App\Http\Controllers\Web;

use App\Eloquent\Series;
use App\Eloquent\Video;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Collection ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class MentorController extends BaseController
{
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
                ->where('p.name', 'upload_video')
                ->count();

            if ($count == 0) {
                Auth::logout();
                Session::flush();
                return Redirect::to('login');
            }

            return $next($request);
        });
    }

    public function createVideo(Request $request)
    {
        $video = new Video();
        $video->status = 1;
        $video->series_id = 0;
        $categories = $this->getCategories();

        $series = DB::table('series')
            ->where('created_by', Auth::id())
            ->where('status', 1)
            ->orderBy('name')
            ->pluck('name', 'id');
        $series[0] = 'Please choose series';

        return view('web.mentor.video.create', compact('video', 'categories', 'series'));
    }

    public function storeVideo(Request $request)
    {
        $request->validate($this->getValidationRules(new Video()));
        $data = $this->getInputData($request);
        $data['created_by'] = Auth::id();
        $data['total_view'] = 0;
        $data['total_comment'] = 0;
        $data['rating_star'] = 0;
        $data['duration'] = 0;
        $data['thumbnail'] = '';
        $data['filename'] = '';

        $video = Video::create($data);
        $this->processFiles($request, $video);
        return redirect(route('videos.show', [$video->slug . '-' . $video->id]));
    }

    private function getCategories(): Collection
    {
        return DB::table('categories')
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->pluck('name', 'id');
    }

    private function getValidationRules(Video $video): array
    {
        $res = [
            'name' => 'required|min:3|max:100',
            'category_id' => 'required|integer',
            'series_id' => 'required|integer',
            'description' => 'required',
            'status' => 'required|integer',
        ];
        if (!$video->id) {
            $res['thumbnail'] = 'required|mimetypes:image/jpeg|max:' . Video::FILE_SIZE_LIMITATION;
            $res['filename'] = 'required|mimetypes:video/mp4|max:' . Video::FILE_SIZE_LIMITATION;
        }
        return $res;
    }

    private function getInputData(Request $request): array
    {
        $input = $request->all();
        $name = trim(strip_tags($input['name']));

        $seriesId = intval($input['series_id']);
        if (isset($input['series']) && !empty($input['series'])) {
            $series = trim(strip_tags($input['series']));
            $seriesId = Series::insert([
                'name' => $series,
                'slug' => (new Slugify())->slugify($series),
                'created_by' => Auth::id(),
                'status' => 1,
            ]);
        }
        $createdBy = DB::table('series')
            ->where('id', $seriesId)
            ->value('created_by');
        if ($createdBy != Auth::id()) {
            $seriesId = null;
        }

        return [
            'name' => $name,
            'slug' => (new Slugify())->slugify($name),
            'description' => $input['description'],
            'category_id' => intval($input['category_id']),
            'series_id' => $seriesId,
            'status' => intval($input['status']),
        ];
    }

    private function processFiles(Request $request, Video $video)
    {
        $dir = $video->id;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            if ($video->thumbnail && Storage::disk('videos')->exists($video->thumbnail)) {
                Storage::disk('videos')->delete($video->thumbnail);
            }
            $filename = time() . '.jpg';
            $video->thumbnail = $dir . '/' . $filename;
            $request->thumbnail->storeAs($dir, $filename, 'videos');

            $thumbnailDir = public_path(Video::THUMBNAIL_DIR . $dir);
            File::isDirectory($thumbnailDir) or File::makeDirectory($thumbnailDir, 0777, true, true);

            Image::make($request->thumbnail)
                ->resize(Video::THUMBNAIL_WIDTH, Video::THUMBNAIL_HEIGHT)
                ->save($thumbnailDir . '/' . Video::THUMBNAIL_PREFIX . '_' . $filename);
        }
        if ($request->hasFile('filename') && $request->file('filename')->isValid()) {
            if ($video->filename && Storage::disk('videos')->exists($video->filename)) {
                Storage::disk('videos')->delete($video->filename);
            }
            $filename = time() . '.mp4';
            $video->filename = $dir . '/' . $filename;
            $request->filename->storeAs($dir, $filename, 'videos');

            $video->duration = FFMpeg::fromDisk('videos')
                ->open($video->filename)
                ->getDurationInSeconds();
        }
        $video->save();
    }
}
