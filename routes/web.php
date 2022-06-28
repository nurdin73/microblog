<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HolidayControlller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteFunfactController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TagController;
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


Auth::routes([
    'register' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::group(['middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::get('/', HomeController::class)->name('home');
    Route::resource('blogs', BlogController::class);
    Route::post('/image-upload', [BlogController::class, 'imageUpload'])->name('image-upload');
    Route::put('/change-image-position', [BlogController::class, 'changeImagePosition'])->name('change-image-position');
    Route::delete('/image-delete/{id}', [BlogController::class, 'imageDelete'])->name('image-delete');
    Route::resource('quote-funfacts', QuoteFunfactController::class);
    Route::resource('collections', CollectionController::class)->except(['create']);
    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::resource('tags', TagController::class)->except(['create', 'edit']);
    });
    Route::resource('holiday', HolidayControlller::class)->except(['edit', 'create', 'show']);
    Route::get('surveys', SurveyController::class)->name('surveys');
    Route::get('/get-collection-shopify', [CollectionController::class, 'getCollectionShopify'])->name('get-collection-shopify');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('change-password.update');
});
