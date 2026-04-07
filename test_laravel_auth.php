<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::where('username', 'admin')->first();
if (!$user) { echo "User tidak ditemukan!"; exit; }

echo "Username: " . $user->username . "\n";
echo "Hash: " . $user->password . "\n";
echo "Verify admin123: " . (password_verify('admin123', $user->password) ? 'BERHASIL' : 'GAGAL') . "\n";
echo "Hash::check: " . (\Illuminate\Support\Facades\Hash::check('admin123', $user->password) ? 'BERHASIL' : 'GAGAL') . "\n";
