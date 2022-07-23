<?php

namespace App\Repositories\ArticleShopify;

interface ArticleShopifyInterface
{
    public function likedArticle(array $data);

    public function getArticleLikedByUser(String $user_id);
}
