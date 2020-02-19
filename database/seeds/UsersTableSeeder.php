<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name'      => 'Paulo Sanda',
            'email'     => 'paulosanda@gmail.com',
            'password'  => bcrypt('!!0860ps@20'),
            'is_admin'  => 1
        ]);
    }
}
