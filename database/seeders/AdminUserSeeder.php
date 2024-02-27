<?php
declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        UserFactory::new([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ])->create();

        DB::table('roles')->insert([
            'name' => 'admin',
            'permissions' => '{"platform.index": true, "platform.systems.roles": true, "platform.systems.users": true, "platform.systems.attachment": true}',
            'slug' => 'admin',
        ]);
        DB::table('role_users')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
