<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'Maryam',
            'email' => 'admin@cassetteshop.ir',
            'family' => 'Rajabi',
            'mobile' => '09372770491',
            'role_id' => Role::where('slug','admin')->first()->id,
            'password' => 123,
            'is_active' => true,
        ]);
        factory(App\User::class, 3)->create();
    }
}
