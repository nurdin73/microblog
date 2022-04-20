<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteFunfact extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'type', 'content', 'status', 'published_at', 'link'];

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, QuoteFunfactTag::class, 'quote_funfact_id', 'id', 'id', 'tag_id');
    }
}
