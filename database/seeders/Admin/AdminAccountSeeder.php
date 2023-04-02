<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, Admin};
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'admin';
        $user->password = Hash::make('password');
        $user->save();
        // $user = User::create([
        //     'username' => 'admin',
        //     'password' => Hash::make('password')
        // ]);
        // Admin::create([
        //     'user_id' => $user->id,
        //     'email_address' => 'admin@example.com',
        //     'first_name' => 'Admin',
        //     'middle_name' => 'Admin',
        //     'last_name' => 'Admin'
        // ]);
    }
}
