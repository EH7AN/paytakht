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
        User::create([
            'name' => 'Ehsan',
            'username' => 'skyWalk',
            'email' => 'admin@paytakht.ir',
            'family' => 'Ghasemi',
            'mobile' => '09365100755',
            'media_id' => 1,
            'role_id' => Role::where('slug','admin')->first()->id,
            'password' => 123,
            'is_active' => true,
        ]);
        factory(App\User::class, 3)->create();
    }
}
