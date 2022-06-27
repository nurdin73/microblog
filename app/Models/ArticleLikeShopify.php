<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLikeShopify extends Model
{
    use HasFactory;
    protected $fillable = ['article_id', 'account_id', 'status'];

    public function detail()
    {
        return $this->belongsTo(ArticleShopifyDetail::class, 'id', 'article_liked_id');
    }
}
