<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // بروزرسانی یا ساخت ادمین با رمز عبور مشخص
        User::updateOrCreate(
            ['email' => 'nicedevil02@gmail.com'],
            [
                'name' => 'ادمین',
                'password' => Hash::make('Bahman+11'),
                'is_admin' => true,
                'is_super_admin' => true,
                'is_approved' => true,
            ]
        );

        // اجرای ImportOldDataSeeder
        $this->call(ImportOldDataSeeder::class);
    }
}
