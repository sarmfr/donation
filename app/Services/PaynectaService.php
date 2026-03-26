<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaynectaService
{
    protected $apiKey;
    protected $userEmail;
    protected $paymentCode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('paynecta.api_key');
        $this->userEmail = config('paynecta.user_email');
        $this->paymentCode = config('paynecta.payment_code');
        $this->baseUrl = config('paynecta.base_url');
    }

    /**
     * Initialize a payment request via Paynecta.
     *
     * @param string $phone Customer mobile number (254XXXXXXXXX)
     * @param float $amount Amount to be paid
     * @return array|bool
     */
    public function initializePayment($phone, $amount)
    {
        // Ensure phone is in format 254XXXXXXXXX
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '7') && strlen($phone) === 9) {
            $phone = '254' . $phone;
        } elseif (str_starts_with($phone, '1') && strlen($phone) === 9) {
            $phone = '254' . $phone;
        }

        try {
            $callbackUrl = config('paynecta.callback_url');
            if (blank($callbackUrl)) {
                $callbackUrl = rtrim(config('app.url'), '/') . '/paynecta/callback';
            }

            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'X-User-Email' => $this->userEmail,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/payment/initialize', [
                'code' => $this->paymentCode,
                'mobile_number' => $phone,
                'amount' => $amount,
                'callback_url' => $callbackUrl,
            ]);

            if ($response->failed()) {
                Log::error('Paynecta Payment Initialization Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Paynecta Service Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Query the status of a transaction.
     *
     * @param string $transactionRef
     * @return array|bool
     */
    public function getTransactionStatus($transactionRef)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'X-User-Email' => $this->userEmail,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . "/payment/status?reference={$transactionRef}");

            if ($response->failed()) {
                Log::error('Paynecta Transaction Status Query Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Paynecta Status Query Error: ' . $e->getMessage());
            return false;
        }
    }
}
