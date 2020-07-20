<?php

namespace App\Http\Controllers\Admin;

use App\Eloquent\Video;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Collection ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoController extends BaseController
{
    const ITEMS_PER_PAGE = 20;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->setBreadcrumb();
        $breadcrumb = $this->breadcrumb;

        $videos = DB::table('videos AS v')
            ->select('v.id', 'v.name', 'v.slug', 'v.status', 'v.thumbnail', 'v.total_view', 'v.total_comment', 'v.rating_star', 'u1.name AS created_by', 'u2.name AS updated_by')
            ->join('users AS u1', 'v.created_by', '=', 'u1.id')
            ->leftJoin('users AS u2', 'v.updated_by', '=', 'u2.id')
            ->orderBy('v.updated_at', 'DESC')
            ->orderBy('v.created_at', 'DESC')
            ->orderBy('v.id', 'DESC')
            ->paginate(self::ITEMS_PER_PAGE);

        return view('admin.videos.index', compact('breadcrumb', 'videos'));
    }

    public function create()
    {
        $this->setBreadcrumb('create');
        $breadcrumb = $this->breadcrumb;

        $video = new Video();
        $video->status = 1;
        $categories = $this->getCategories();

        return view('admin.videos.create', compact('breadcrumb', 'video', 'categories'));
    }

    public function store(Request $request)
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

        return redirect(route('admin.videos.index'))->with('success_message', 'Successfully created new video!');
    }

    public function edit(Request $request, int $id)
    {
        $this->setBreadcrumb('create');
        $breadcrumb = $this->breadcrumb;

        $video = Video::findOrFail($id);
        $categories = $this->getCategories();
        $seriesName = DB::table('series')
            ->where('id', $video->series_id)
            ->value('name');

        return view('admin.videos.edit', compact('breadcrumb', 'video', 'categories', 'seriesName'));
    }

    public function update(Request $request, int $id)
    {
        $video = Video::findOrFail($id);
        $request->validate($this->getValidationRules($video));
        $data = $this->getInputData($request);
        $data['updated_by'] = Auth::id();

        $video->fill($data);
        $video->save();
        $this->processFiles($request, $video);

        return redirect(route('admin.videos.index'))->with('success_message', 'Successfully updated a video!');
    }

    public function destroy(Request $request, int $id)
    {
        Video::destroy($id);
        return redirect(route('admin.videos.index'))->with('success_message', 'Successfully deleted a video!');
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

    private function getCategories(): Collection
    {
        return DB::table('categories')
            ->orderBy('name', 'ASC')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->pluck('name', 'id');
    }

    private function getInputData(Request $request): array
    {
        $input = $request->all();
        $name = trim(strip_tags($input['name']));
        return [
            'name' => $name,
            'slug' => (new Slugify())->slugify($name),
            'description' => $input['description'],
            'category_id' => intval($input['category_id']),
            'series_id' => intval($input['series_id']),
            'status' => intval($input['status']),
        ];
    }

    private function setBreadcrumb(string $method = 'index')
    {
        $this->breadcrumb[] = ['label' => 'Videos', 'url' => route('admin.videos.index')];
        switch ($method) {
            case 'create':
                $this->breadcrumb[] = ['label' => 'Add new video', 'url' => route('admin.videos.create')];
                break;
            default:
                break;
        }
    }
}
