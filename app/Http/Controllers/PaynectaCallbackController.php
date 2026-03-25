<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaynectaCallbackController extends Controller
{
    /**
     * Handle the callback from Paynecta.
     */
    public function handle(Request $request)
    {
        Log::info('Paynecta Webhook Received', $request->all());

        $payload = $request->all();

        // Extract the reference and status
        // Based on typical webhook structures, we expect a 'reference' or 'transactionRef'
        // and a 'status' or 'success' flag.
        $reference = $payload['reference'] ?? ($payload['data']['reference'] ?? null);
        $status = $payload['status'] ?? ($payload['data']['status'] ?? null);
        
        Log::info("Processing Paynecta Webhook: Ref={$reference}, Status={$status}");
        
        $isSuccess = ($status === 'success' || $status === 'completed' || ($payload['success'] ?? false) === true);

        if (!$reference) {
            Log::error('Paynecta Webhook Error: Missing transaction reference.', $payload);
            return response()->json(['message' => 'Missing reference'], 400);
        }

        $donation = Donation::where('transaction_reference', $reference)->first();

        if (!$donation) {
            Log::error("Paynecta Webhook Error: Donation not found for reference: {$reference}");
            return response()->json(['message' => 'Donation not found'], 404);
        }

        if ($isSuccess) {
            $donation->update(['status' => 'success']);
            
            // Increment the campaign collected amount
            $donation->campaign->increment('current_amount', $donation->amount);
            
            Log::info("Paynecta Webhook: Donation #{$donation->id} marked as successful.");
        } else {
            $donation->update(['status' => 'failed']);
            Log::warning("Paynecta Webhook: Donation #{$donation->id} marked as failed. Status: {$status}");
        }

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
