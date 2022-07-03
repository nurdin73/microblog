<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['account_id', 'birthDate', 'gender', 'latestSurveyDate'];

    public function preferences()
    {
        return $this->hasManyThrough(Preferences::class, ProfilePreference::class, 'profile_id', 'id', 'id', 'preference_id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'account_id', 'account_id');
    }

    public function latestSurvey()
    {
        return $this->hasOne(Survey::class, 'account_id', 'account_id')->latestOfMany('created_at');
    }
}
