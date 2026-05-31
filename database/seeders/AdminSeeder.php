<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@taskflow.com'],
            [
                'name'     => 'Administrator',
                'password' => 'Admin@1234',
                'role'     => 'admin',
            ]
        );
    }
}
