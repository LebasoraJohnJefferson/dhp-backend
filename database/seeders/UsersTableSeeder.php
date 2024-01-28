<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'admin',
            'middle_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'roles' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'first_name' => 'Christian',
            'middle_name' => 'Rosaroso',
            'last_name' => 'Paranas',
            'email' => 'christianparans1@gmail.com',
            'password' => Hash::make('admin123'),
            'roles' => 'admin',
            'is_active' => true,
        ]);
    }
}
