<?php

use App\Models\User;
use App\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'uuid' => Str::nanoId(),
            'name' => 'First User',
            'email' => 'admin@example.com',
            'password' => Hash::make('this-is-a-password'),
            'salt' => User::generateSalt(),
            'created_at' => DB::raw('NOW()'),
        ]);
    }
}
