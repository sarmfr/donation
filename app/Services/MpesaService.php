<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortcode;
    protected $passkey;
    protected $callbackUrl;

    public function __construct()
    {
        $this->baseUrl = config('mpesa.base_url');
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->shortcode = config('mpesa.shortcode');
        $this->passkey = config('mpesa.passkey');
        $this->callbackUrl = config('mpesa.callback_url');
    }

    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

        if ($response->failed()) {
            Log::error('M-Pesa auth failed', ['response' => $response->json()]);
            return null;
        }

        return $response->json()['access_token'];
    }

    public function stkPush($phone, $amount, $reference, $description)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return false;

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        // Ensure phone is in format 254XXXXXXXXX
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }

        $response = Http::withToken($accessToken)->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => $reference,
            'TransactionDesc' => $description,
        ]);

        if ($response->failed()) {
            Log::error('M-Pesa STK Push failed', ['response' => $response->json()]);
            return false;
        }

        return $response->json();
    }

    public function b2cRequest($phone, $amount, $remarks)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return false;

        // Ensure phone is in format 254XXXXXXXXX
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }

        $response = Http::withToken($accessToken)->post($this->baseUrl . '/mpesa/b2c/v1/paymentrequest', [
            'InitiatorName' => config('mpesa.initiator_name'),
            'SecurityCredential' => config('mpesa.security_credential'),
            'CommandID' => 'BusinessPayment',
            'Amount' => $amount,
            'PartyA' => $this->shortcode,
            'PartyB' => $phone,
            'Remarks' => $remarks,
            'QueueTimeOutURL' => config('mpesa.timeout_url'),
            'ResultURL' => config('mpesa.result_url'),
            'Occasion' => 'Campaign Withdrawal',
        ]);

        if ($response->failed()) {
            Log::error('M-Pesa B2C Request failed', ['response' => $response->json()]);
            return false;
        }

        return $response->json();
    }
}
