<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = 'nicedevil02@gmail.com';
        $user = User::where('email', $adminEmail)->first();

        if (!$user) {
            User::create([
                'email'          => $adminEmail,
                'name'           => 'ادمین',
                'username'       => 'admin',
                'display_token'  => \Illuminate\Support\Str::random(40),
                'password'       => Hash::make(env('ADMIN_INITIAL_PASSWORD', 'Bahman+11')),
                'is_admin'       => true,
                'is_super_admin' => true,
                'is_approved'    => true,
            ]);
        } else {
            // حفظ رمز عبور جاری کاربر و تنها اطمینان از دسترسی‌های ادمین
            $user->update([
                'is_admin'       => true,
                'is_super_admin' => true,
                'is_approved'    => true,
            ]);
        }

        // اجرای ImportOldDataSeeder
        $this->call(ImportOldDataSeeder::class);
    }
}
