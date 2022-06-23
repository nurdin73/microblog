<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'content', 'status', 'posted_at'];

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, BlogTag::class, 'blog_id', 'id', 'id', 'tag_id');
    }

    public function photos()
    {
        return $this->hasMany(BlogPhoto::class, 'blog_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class, 'blog_id', 'id');
    }
}
