<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // اگر ادمین وجود نداشت، بسازش
        if (!User::where('email', 'admin@gold.test')->exists()) {
            User::create([
                'name' => 'ادمین',
                'email' => 'admin@gold.test',
                'password' => Hash::make('admin12345'),
                'is_admin' => true,
            ]);
        }

        // اجرای ImportOldDataSeeder
        $this->call(ImportOldDataSeeder::class);
    }
}
