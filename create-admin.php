<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ایجاد یا بروزرسانی کاربر
$user = User::updateOrCreate(
    ['email' => 'admin@gold.test'],
    [
        'name' => 'ادمین',
        'password' => Hash::make('admin12345'),
        'is_admin' => true,
    ]
);

echo "User ID: {$user->id}\n";
echo "Email: {$user->email}\n";
echo "Is Admin: {$user->is_admin}\n";
