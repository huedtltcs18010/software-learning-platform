<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Raju\Streamer\Helpers\VideoStream;

class StreamController extends BaseController
{
    public function show(Request $request, int $id)
    {
        $video = DB::table('videos')
            ->select('filename')
            ->where('id', $id)
            ->first();
        if (!$video) {
            return response('File doesn\'t exists', 404);
        }

        //@todo get from database base on video id
        $videosDir = config('larastreamer.basepath');
        $filePath = $videosDir . '/' . $video->filename;
        if (file_exists($filePath)) {
            $stream = new VideoStream($filePath);
            return response()->stream(function () use ($stream) {
                $stream->start();
            });
        }
        return response('File doesn\'t exists', 404);
    }
}
