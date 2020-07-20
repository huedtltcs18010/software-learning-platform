<?php

return [
    'ffmpeg' => [
        'binaries' => env('FFMPEG_BINARIES', '/usr/bin/ffmpeg'),// sudo apt install ffmpeg
        'threads'  => 12,
    ],

    'ffprobe' => [
        'binaries' => env('FFPROBE_BINARIES', '/usr/bin/ffprobe'),
    ],

    'timeout' => 3600,

    'enable_logging' => true,
];
