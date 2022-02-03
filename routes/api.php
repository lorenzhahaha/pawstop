<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VideoPlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'api.'], function () {
    Route::apiResources(['product' => ProductController::class]);
    Route::get('/video-player/{url}', [VideoPlayerController::class, 'show'])->name('video-player.show');
});
