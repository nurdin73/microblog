<?php

use App\Http\Controllers\ApiBlogController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\QuoteFunfactController;
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

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', [ApiBlogController::class, 'blogs']);
    Route::get('/detail/{id}', [ApiBlogController::class, 'detail']);
    Route::post('/likeUnlike', [ApiBlogController::class, 'likeUnlike']);
});

Route::get('/quote-funfacts', [QuoteFunfactController::class, 'getRandomQuotesFunfacts']);

Route::get('/collections', [CollectionController::class, 'collections']);