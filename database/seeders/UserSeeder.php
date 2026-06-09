<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama'     => 'Owner',
                'username' => 'owner',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('P@55word'),
                'role'     => 'owner',
            ]
        );
    }
}
