<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@trackify.test',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@trackify.test',
            ],
            [
                'name' => 'Citra Lestari',
                'email' => 'citra@trackify.test',
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi@trackify.test',
            ],
            [
                'name' => 'Eko Saputra',
                'email' => 'eko@trackify.test',
            ],
            [
                'name' => 'Fajar Hidayat',
                'email' => 'fajar@trackify.test',
            ],
            [
                'name' => 'Gita Permata',
                'email' => 'gita@trackify.test',
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra@trackify.test',
            ],
            [
                'name' => 'Intan Maharani',
                'email' => 'intan@trackify.test',
            ],
            [
                'name' => 'Joko Susilo',
                'email' => 'joko@trackify.test',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
