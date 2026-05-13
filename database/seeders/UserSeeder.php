<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'john@email.com'],
            [
                'document' => '75000001',
                'fullname' => 'John Wick',
                'gender' => 'Male',
                'birthdate' => '1964-09-02',
                'phone' => '3100000001',
                'password' => Hash::make('admin'),
                'role' => 'Admin',
                'active' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'larac@email.com'],
            [
                'document' => '75000002',
                'fullname' => 'Lara Croft',
                'gender' => 'Female',
                'birthdate' => '1968-02-14',
                'phone' => '3100000002',
                'password' => Hash::make('12345'),
                'role' => 'Customer',
                'active' => 1,
            ]
        );
    }
}
