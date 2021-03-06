<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPhoto extends Model
{
    use HasFactory;
    protected $fillable = ['blog_id', 'src', 'position'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
