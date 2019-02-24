<?php

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
         $this->call(RoleTableSeeder::class);
        $this->call(MediaTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(ProductcatTableSeeder::class);
         $this->call(ProductTableSeeder::class);
         $this->call(ContentcatTableSeeder::class);
         $this->call(ContentTableSeeder::class);
         $this->call(SliderTableSeeder::class);
         $this->call(DiscountTableSeeder::class);
    }
}
