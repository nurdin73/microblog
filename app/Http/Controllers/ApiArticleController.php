<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleShopify\ArticleShopifyRepository;
use Illuminate\Http\Request;

class ApiArticleController extends Controller
{
    protected $articleShopifyRepository;
    public function __construct(ArticleShopifyRepository $articleShopifyRepository)
    {
        $this->articleShopifyRepository = $articleShopifyRepository;
    }

    public function likeArticle(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'access_token_user' => 'required|string',
        ]);
        $data = $request->only(['title', 'article_id', 'blog_id', 'access_token_user']);
        try {
            $send = $this->articleShopifyRepository->likedArticle($data);
            $title = $send['data']->title;
            $status = $send['status'] ? "liked" : "disliked";
            return response(['message' => "Article $title has been $status"]);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function getAllLikedArticlesByUser($access_token_use)
    {
        $results = $this->articleShopifyRepository->getArticleLikedByUser($access_token_use);
        return ArticleResource::collection($results);
    }

    public function getStatusLike(Request $request)
    {
        $data = $this->validate($request, [
            'article_id' => 'required',
            'access_token_user' => 'required',
        ]);
        $result = $this->articleShopifyRepository->getLikedArticle($data['article_id'], $data['access_token_user']);
        return response([
            'liked' => $result
        ]);
    }
}
