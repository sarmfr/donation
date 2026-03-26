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

        $reference = data_get($payload, 'reference')
            ?? data_get($payload, 'transaction_reference')
            ?? data_get($payload, 'transactionRef')
            ?? data_get($payload, 'data.reference')
            ?? data_get($payload, 'data.transaction_reference')
            ?? data_get($payload, 'data.transactionRef')
            ?? data_get($payload, 'data.payment.reference');

        $status = data_get($payload, 'status')
            ?? data_get($payload, 'data.status')
            ?? data_get($payload, 'data.payment.status');

        $status = is_string($status) ? strtolower(trim($status)) : null;

        Log::info("Processing Paynecta Webhook: Ref={$reference}, Status={$status}");

        $isSuccess = in_array($status, ['success', 'completed', 'complete', 'paid', 'approved'], true)
            || (($payload['success'] ?? false) === true)
            || ((int) data_get($payload, 'result_code', -1) === 0)
            || ((int) data_get($payload, 'data.result_code', -1) === 0);

        if (!$reference) {
            Log::error('Paynecta Webhook Error: Missing transaction reference.', $payload);
            return response()->json(['message' => 'Missing reference'], 400);
        }

        $donation = Donation::where('transaction_reference', $reference)->first();

        if (!$donation) {
            Log::error("Paynecta Webhook Error: Donation not found for reference: {$reference}");
            return response()->json(['message' => 'Donation not found'], 404);
        }

        if ($donation->status === 'success') {
            return response()->json(['message' => 'Webhook already processed'], 200);
        }

        if ($isSuccess) {
            $donation->update(['status' => 'success']);
            
            // Increment the campaign collected amount
            if ($donation->wasChanged('status')) {
                $donation->campaign->increment('current_amount', $donation->amount);
            }
            
            Log::info("Paynecta Webhook: Donation #{$donation->id} marked as successful.");
        } else {
            $pendingStatuses = ['pending', 'processing', 'initiated', 'queued'];
            $nextStatus = in_array((string) $status, $pendingStatuses, true) ? 'pending' : 'failed';
            $donation->update(['status' => $nextStatus]);
            Log::warning("Paynecta Webhook: Donation #{$donation->id} marked as {$nextStatus}. Status: {$status}");
        }

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
