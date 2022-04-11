<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteFunfactTag extends Model
{
    use HasFactory;
    protected $fillable = ['quote_funfact_id', 'tag_id'];
    public function quoteFunfact()
    {
        return $this->belongsTo(QuoteFunfact::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
