<?php

use Illuminate\Database\Seeder;
use App\Productcat;
use Illuminate\Support\Facades\DB;

class ProductcatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productcats')->delete();

        Productcat::create([
            'title' => 'Album',
            'nameFa' => 'آلبوم',
        ]);
        Productcat::create([
            'title' => 'MetalPin',
            'nameFa' => 'پین فلزی',
        ]);
        Productcat::create([
            'title' => 'Sticker',
            'nameFa' => 'استیکر',
        ]);
    }
}
