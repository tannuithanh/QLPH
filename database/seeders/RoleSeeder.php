<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'display_name' => 'Quản trị hệ thống',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'staff',
                'display_name' => 'Nhân viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
