<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ensure admin group/role exists and get its id
        $adminGroup = Group::firstOrCreate(
            ['nama' => env('ADMIN_GROUP_NAME', 'Super Admin')],
            [
                'deskripsi' => 'Default admin group',
                'akses_penuh' => (bool) env('ADMIN_GROUP_AKSES_PENUH', true),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@arpusjateng.go.id'],
            [
                'name' => 'Admin',
                'password' => 'secret123',
            ]
        );
    }
}
