<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'user_group_id' => 1,
            'username' => 'superuser',
            'full_name' => 'Wizag',
            'email' => 'development@wizag.biz',
            'password' => bcrypt(env('SUPER_PASS')),
        ]);
    }
}
