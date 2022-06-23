<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();
        // \App\Models\Blog::factory(100)->create();
        // \App\Models\Tag::factory(10)->create();
        // \App\Models\BlogPhoto::factory(10)->create();
        // \App\Models\BlogLike::factory(10)->create();
        // \App\Models\BlogTag::factory(100)->create();
        // \App\Models\QuoteFunfact::factory(100)->create();
        // \App\Models\QuoteFunfactTag::factory(10)->create();
        // \App\Models\Collection::factory(100)->create();
        \App\Models\Holiday::factory(10)->create();
    }
}
