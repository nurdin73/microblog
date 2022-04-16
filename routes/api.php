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
Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', [ApiBlogController::class, 'blogs']);
    Route::get('/detail/{id}', [ApiBlogController::class, 'detail']);
    Route::post('/like-dislike', [ApiBlogController::class, 'likeUnlike']);
});

Route::get('/quote-funfacts', [QuoteFunfactController::class, 'getRandomQuotesFunfacts']);

Route::get('/collections', [CollectionController::class, 'collections']);