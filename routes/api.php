<?php

use App\Http\Controllers\ApiBlogController;
use App\Http\Controllers\ApiHolidayController;
use App\Http\Controllers\ApiProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\QuoteFunfactController;
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
    return response([
        'message' => 'Welcome to the API. this is base url for api',
        'status' => 'success',
        'version' => '1.0.0',
        'endpoint' => [
            [
                'title' => 'Blogs',
                'url' => url('api/blogs'),
                'method' => 'GET',
                'body' => null,
                'params' => null,
                'query' => [
                    'search' => 'string',
                    'limit' => 'integer',
                    'by' => 'string',
                    'order' => 'string',
                    'aditional' => 'string',
                    'page' => 'integer'
                ],
            ],
            [
                'title' => 'Blog Detail',
                'url' => url('api/blogs/:id'),
                'method' => 'GET',
                'body' => null,
                'params' => [
                    'id' => 'integer',
                ],
                'query' => [
                    'customer_id' => 'integer',
                ],
            ],
            [
                'title' => 'Like/Unlike Blog',
                'url' => url('api/blogs/like-dislike'),
                'method' => 'POST',
                'body' => [
                    'blog_id' => 'integer',
                    'customer_id' => 'integer',
                ],
                'params' => null,
                'query' => null,
            ],
            [
                'title' => 'Quotes/Funfacts',
                'url' => url('api/quote-funfacts'),
                'method' => 'GET',
                'body' => null,
                'params' => null,
                'query' => [
                    'limit' => 'integer',
                ],
            ],
            [
                'title' => 'Collections',
                'url' => url('api/collections'),
                'method' => 'GET',
                'body' => null,
                'params' => null,
                'query' => [
                    'search' => 'string',
                    'limit' => 'integer',
                ],
            ]
        ]
    ]);
});
Route::group(['middleware' => 'api_token'], function () {
    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [ApiBlogController::class, 'blogs']);
        Route::get('/latest-two-post', [ApiBlogController::class, 'getlatestTwoPost']);
        Route::get('/latest-five-post', [ApiBlogController::class, 'getlatestFivePost']);
        Route::get('/tag/{id}', [ApiBlogController::class, 'getByTag']);
        Route::get('/detail/{id}', [ApiBlogController::class, 'detail']);
        Route::post('/like-dislike', [ApiBlogController::class, 'likeUnlike']);
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ApiProfileController::class, 'get']);
        Route::put('/', [ApiProfileController::class, 'updateOrCreate']);
    });

    Route::get('/quote-funfacts', [QuoteFunfactController::class, 'getRandomQuotesFunfacts']);

    Route::get('/collections', [CollectionController::class, 'collections']);

    Route::get('/holidays', ApiHolidayController::class);
});

Route::get('tes', function () {
    $key = 'nakedpress';
    $payload = [
        'name' => 'nakedpress-token',
    ];

    return JWT::encode($payload, $key, 'HS256');
});
