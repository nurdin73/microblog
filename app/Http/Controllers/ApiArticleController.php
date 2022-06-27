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
        $data = $this->validate($request, [
            'title' => 'required|string',
            'account_id' => 'required|string',
        ]);
        $data['article_id'] = $request->article_id;
        $data['blog_id'] = $request->blog_id;
        try {
            $send = $this->articleShopifyRepository->likedArticle($data);
            $title = $send['data']->title;
            $status = $send['status'] ? "liked" : "disliked";
            return response(['message' => "Article $title has been $status"]);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function getAllLikedArticlesByUser($user_id)
    {
        $results = $this->articleShopifyRepository->getArticleLikedByUser($user_id);
        return ArticleResource::collection($results);
    }
}
