<?php

use App\Contentcat;
use App\Productcat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentcatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contentcats')->delete();

        Contentcat::create([
            'title' => 'News',
        ]);
        Contentcat::create([
            'title' => 'Articles',
        ]);
        Contentcat::create([
            'title' => 'Posts',
        ]);
    }
}
