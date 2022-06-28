<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = ['account_id', 'weight', 'height', 'result'];

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id', 'id');
    }
}
