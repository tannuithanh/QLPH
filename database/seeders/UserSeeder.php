<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'meeting@vinhgiapottery.com',
            'phone_number' => '0378644279',
            'department_id' => null,
            'password' => Hash::make('123456'),
            'admin' => true, // ✅ Đánh dấu là admin
        ]);

        // Bạn có thể thêm nhiều user khác tại đây nếu muốn
    }
}
