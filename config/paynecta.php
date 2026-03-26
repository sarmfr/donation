<?php

return [
    'api_key' => env('PAYNECTA_API_KEY'),
    'user_email' => env('PAYNECTA_USER_EMAIL'),
    'payment_code' => env('PAYNECTA_PAYMENT_CODE'),
    'callback_url' => env('PAYNECTA_CALLBACK_URL'),
    'base_url' => 'https://paynecta.co.ke/api/v1',
];
