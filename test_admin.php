<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'kihungisamson@gmail.com';
$user = App\Models\User::where('email', $email)->first();

if ($user) {
    echo "User found: " . $user->name . "\n";
    echo "Is Admin (DB value): " . $user->is_admin . "\n";
    echo "Is Admin (method call): " . ($user->isAdmin() ? 'true' : 'false') . "\n";
} else {
    echo "User not found with email: " . $email . "\n";
}
