<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class VideoPlayerController extends Controller
{
    public function show($url)
    {
        $path = public_path('video-player') . DIRECTORY_SEPARATOR . $url;
        dd($path);

        if (!File::exists($path)) {
            abort(404);
        } else {
            return response()->file($path);
        }
    }
}
