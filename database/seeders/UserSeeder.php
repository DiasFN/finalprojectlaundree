<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@laundree.com',
            'no_hp' => '089876543212',
            'password' => Hash::make('karyawan'),
            'role' => 'admin'
        ]);
    }
}
