<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::firstOrCreate(
            ['email' => 'admin@iremetech.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@iremetech.com',
                'password' => Hash::make('Ireme@2021'),
                'role' => 'super_admin',
            ]
        );

        // Create Website Admin
        User::firstOrCreate(
            ['email' => 'admin@buffalovillage.com'],
            [
                'name' => 'Website Admin',
                'email' => 'admin@buffalovillage.com',
                'password' => Hash::make('password'),
                'role' => 'website_admin',
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Super Admin: admin@iremetech.com / Ireme@2021');
        $this->command->info('Website Admin: admin@buffalovillage.com / password');
    }
}
