<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public const SUPER_ADMIN_EMAIL = 'admin@iremetech.com';

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => self::SUPER_ADMIN_EMAIL],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Ireme@2021'),
                'role' => 'super_admin',
                'session_version' => 0,
            ]
        );

        // Demote any other accounts incorrectly marked as super_admin.
        User::query()
            ->where('role', 'super_admin')
            ->where('email', '!=', self::SUPER_ADMIN_EMAIL)
            ->update(['role' => 'website_admin']);

        User::firstOrCreate(
            ['email' => 'admin@knlca.ac.rw'],
            [
                'name' => 'Website Admin',
                'password' => Hash::make('password'),
                'role' => 'website_admin',
                'session_version' => 0,
            ]
        );

        $this->command?->info('Admin users ready.');
        $this->command?->info('Super Admin: '.self::SUPER_ADMIN_EMAIL.' / Ireme@2021');
        $this->command?->info('Website Admin: admin@knlca.ac.rw / password');
    }
}
