<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoPlayerController extends Controller
{
    public function index($url)
    {
        return view('video-player', compact('url'));
    }
}
