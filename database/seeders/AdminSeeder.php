<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@taskflow.com';
        $hashed = Hash::make('Admin@1234');

        $exists = DB::table('users')->where('email', $email)->exists();

        if ($exists) {
            DB::table('users')->where('email', $email)->update([
                'name'       => 'Administrator',
                'password'   => $hashed,
                'role'       => 'admin',
                'updated_at' => now(),
            ]);
        } else {
            DB::table('users')->insert([
                'name'       => 'Administrator',
                'email'      => $email,
                'password'   => $hashed,
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
