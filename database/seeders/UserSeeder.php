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
            'name' => 'Nguyễn Văn A',
            'email' => 'admin@example.com',
            'phone_number' => '0909123456',
            'department_id' => null, // không thuộc phòng ban
            'password' => Hash::make('password'), // nên hash password
        ]);

        // Bạn có thể thêm nhiều user khác tại đây nếu muốn
    }
}
