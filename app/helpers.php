<?php

use App\Eloquent\Video;
use Illuminate\Support\Facades\DB;

function getVideoThumbnail($video): string
{
    $vid = str_replace(
        $video->id . '/',
        $video->id . '/' . Video::THUMBNAIL_PREFIX . '_',
        $video->thumbnail
    );
    return asset(Video::THUMBNAIL_DIR . $vid);
}

function getSlugAndId(string $slugAndId): array
{
    $arr = explode('-', $slugAndId);
    $lastIndex = count($arr) - 1;
    $id = intval($arr[$lastIndex]);
    unset($arr[$lastIndex]);
    return [
        'slug' => implode('-', $arr),
        'id' => $id,
    ];
}

function getVideoCategories(): array
{
    $objs = DB::table('categories')
        ->select('id', 'name', 'slug')
        ->where('status', 1)
        ->orderBy('name', 'ASC')
        ->orderBy('id', 'ASC')
        ->get();
    $res = [];
    foreach ($objs as $obj) {
        $res[] = [
            'name' => $obj->name,
            'url' => route('videos.categories.show', [$obj->slug . '-' . $obj->id]),
        ];
    }
    return $res;
}

function setListVideosInfo(&$videos)
{
    foreach ($videos as $index => $video) {
        $videos[$index]->url = route('videos.show', [$video->slug . '-' . $video->id]);
        $videos[$index]->thumbnail = getVideoThumbnail($video);
        $videos[$index]->duration = gmdate('H:i:s', $video->duration);
        $videos[$index]->created_by_url = route('fo.users.show', [$video->created_by]);
    }
}
