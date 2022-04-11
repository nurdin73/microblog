<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tags', 'tag_id', 'blog_id');
    }

    public function quoteFunfacts()
    {
        return $this->belongsToMany(QuoteFunfact::class, 'quote_funfact_tags', 'tag_id', 'quote_funfact_id');
    }
}
