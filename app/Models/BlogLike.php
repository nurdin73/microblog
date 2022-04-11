<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model
{
    use HasFactory;
    protected $fillable = ['blog_id', 'shopify_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
