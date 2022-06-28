<?php

namespace App\Repositories\ArticleShopify;

use App\Models\ArticleLikeShopify;
use App\Models\ArticleShopifyDetail;
use App\Traits\Shopify;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class ArticleShopifyRepository implements ArticleShopifyInterface
{
    use Shopify;
    protected $articleLikeShopify;
    public function __construct(ArticleLikeShopify $articleLikeShopify)
    {
        $this->articleLikeShopify = $articleLikeShopify;
    }

    public function likedArticle($data)
    {
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($data['account_id']);
        if (!$checkCustomer) return false;
        $customer_id = $type == 'storefront_api' ? $checkCustomer : $data['account_id'];
        $checkArticle = $this->getArticles($data['title']);
        if (isset($checkArticle['errors'])) {
            throw new Exception($checkArticle['errors'][0]['message']);
        }
        $article = $checkArticle['data']['articles']['nodes'][0];
        $articleId = $type == 'storefront_api' ? $article['id'] : $data['article_id'];
        $data = [
            'article_id' => $articleId,
            'account_id' => $customer_id
        ];
        $sync = ArticleLikeShopify::where($data)->first();
        if ($sync) {
            $status = $sync->status ? false : true;
            $update = $sync->update(['status' => $status]);
        } else {
            $status = true;
            $sync = ArticleLikeShopify::create($data);
        }
        $detail = ArticleShopifyDetail::updateOrCreate([
            'article_liked_id' => $sync->id,
        ], [
            'title' => $article['title'],
            'image' => $article['image']['url'],
            'content' => $article['content'],
            'publihed_at' => $article['publishedAt']
        ]);
        return [
            'data' => $detail,
            'status' => $status
        ];
    }

    public function getArticleLikedByUser($user_id)
    {
        $search = request()->search ?? '';
        $limit = request()->limit ?? 10;
        $orderBy = request()->orderBy ?? 'published_at';
        $sortBy = request()->sortBy ?? 'desc';
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($user_id);
        if (!$checkCustomer) return false;
        $customerId = $type == 'storefront_api' ? $checkCustomer : $user_id;
        $results = ArticleShopifyDetail::whereHas('articleLike', function (Builder $q) use ($customerId) {
            return $q->where('account_id', $customerId)->where('status', true);
        });
        if ($search != '') {
            $results = $results->where('title', 'like', "%$search%");
        }
        $results = $results->orderBy($orderBy, $sortBy)->paginate($limit);
        return $results;
    }
}
