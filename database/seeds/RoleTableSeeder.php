<?php

use Illuminate\Database\Seeder;
use App\Role;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('roles')->delete();

        Role::create([
            'slug' => 'admin',
        ]);
        Role::create([
            'slug' => 'user',
        ]);
    }
}
