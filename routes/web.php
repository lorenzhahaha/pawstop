<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Google2FAController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect()->route('login');
    } else {
        return redirect()->route('home');
    }
});

// OTP
Route::get('/security/validate', [LoginController::class, 'getValidateToken'])->name('otp-validate');
Route::post('/security/validate', [LoginController::class, 'postValidateToken'])->name('post-otp-validate')->middleware('throttle: 5');

// Google Authentication
Route::get('/google/redirect/login', [LoginController::class, 'redirectToProviderLogin'])->name('google-redirect-login');
Route::get('/google/redirect/register', [LoginController::class, 'redirectToProviderRegister'])->name('google-redirect-register');
Route::get('/callback', [LoginController::class, 'handleProviderCallback']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // Auth Overrides
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::patch('/profile', [HomeController::class, 'updateProfile'])->name('update-profile');
    Route::post('/chart/update-product-categories', [HomeController::class, 'chartUpdateProductCategories'])->name('chart.update-product-categories');

    // OTP
    Route::get('/security', [Google2FAController::class, 'security'])->name('security');
    Route::get('/security/setup', [Google2FAController::class, 'securitySetup'])->name('security-setup');
    Route::patch('/security/setup/complete', [Google2FAController::class, 'securitySetupComplete'])->name('security-setup-complete');
    Route::get('/security/deactivate', [Google2FAController::class, 'securityDeactivate'])->name('security-deactivate');

    // Admin
    Route::resource('admin', AdminController::class);
    Route::get('/admin/list/removed', [AdminController::class, 'showDeletedUsers'])->name('deleted-users');

    // Product
    Route::resource('product', ProductController::class);
    Route::post('/product/list', [ProductController::class, 'list'])->name('product.list');
});
