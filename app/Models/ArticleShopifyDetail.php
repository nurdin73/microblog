<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleShopifyDetail extends Model
{
    use HasFactory;
    protected $fillable = ['article_liked_id', 'title', 'image', 'content', 'published_at'];

    public function articleLike()
    {
        return $this->belongsTo(ArticleLikeShopify::class, 'article_liked_id', 'id');
    }
}
