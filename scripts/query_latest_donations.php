<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$donations = App\Models\Donation::orderBy('id', 'desc')
    ->take(5)
    ->get(['id', 'amount', 'payment_method', 'status', 'transaction_reference', 'created_at'])
    ->toArray();

echo json_encode($donations);
