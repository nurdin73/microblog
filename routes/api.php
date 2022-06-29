<?php

use App\Http\Controllers\ApiArticleController;
use App\Http\Controllers\ApiBlogController;
use App\Http\Controllers\ApiHolidayController;
use App\Http\Controllers\ApiProfileController;
use App\Http\Controllers\ApiSurveyController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\QuoteFunfactController;
use App\Http\Controllers\TagController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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

Route::get('/', function () {
    return response(['message' => "Welcome to nakedpress api"]);
});
Route::group(['middleware' => 'api_token'], function () {
    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [ApiBlogController::class, 'blogs']);
        Route::get('/latest-two-post', [ApiBlogController::class, 'getlatestTwoPost']);
        Route::get('/latest-five-post', [ApiBlogController::class, 'getlatestFivePost']);
        Route::get('/tag/{id}', [ApiBlogController::class, 'getByTag']);
        Route::get('/detail/{id}', [ApiBlogController::class, 'detail']);
        Route::post('/like-dislike', [ApiBlogController::class, 'likeUnlike']);
        Route::get('/{user_id}/liked', [ApiBlogController::class, 'getBlogLikedByUser']);
    });

    Route::group(['prefix' => 'articles'], function () {
        Route::post('/liked', [ApiArticleController::class, 'likeArticle']);
        Route::get('/{user_id}/liked', [ApiArticleController::class, 'getAllLikedArticlesByUser']);
        Route::get('/has-liked', [ApiArticleController::class, 'getStatusLike']);
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ApiProfileController::class, 'get']);
        Route::put('/', [ApiProfileController::class, 'updateOrCreate']);
    });

    Route::group(['prefix' => 'survey'], function () {
        Route::post('/store', [ApiSurveyController::class, 'store']);
        Route::get('/me', [ApiSurveyController::class, 'show']);
        Route::get('/latest', [ApiSurveyController::class, 'latest']);
        Route::get('/has-grant', [ApiSurveyController::class, 'grant']);
    });

    Route::get('/quote-funfacts', [QuoteFunfactController::class, 'getRandomQuotesFunfacts']);

    Route::get('/collections', [CollectionController::class, 'collections']);

    Route::get('/preferences', [PreferenceController::class, 'preferences']);

    Route::get('/tags', [TagController::class, 'tags']);

    Route::get('/holidays', ApiHolidayController::class);
});
