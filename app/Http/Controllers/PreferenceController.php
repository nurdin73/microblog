<?php

namespace App\Http\Controllers;

use App\Models\Preferences;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function preferences()
    {
        return Preferences::all();
    }
}
