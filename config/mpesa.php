<?php

return [
    'env' => env('MPESA_ENV', 'sandbox'),
    'shortcode' => env('MPESA_SHORTCODE'),
    'passkey' => env('MPESA_PASSKEY'),
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'callback_url' => env('MPESA_CALLBACK_URL'),
    
    // B2C Specifics
    'initiator_name' => env('MPESA_INITIATOR_NAME'),
    'security_credential' => env('MPESA_SECURITY_CREDENTIAL'),
    'result_url' => env('MPESA_B2C_RESULT_URL'),
    'timeout_url' => env('MPESA_B2C_TIMEOUT_URL'),

    'base_url' => env('MPESA_ENV', 'sandbox') === 'sandbox' 
        ? 'https://sandbox.safaricom.co.ke' 
        : 'https://api.safaricom.co.ke',
];
