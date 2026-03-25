<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationReceived;

class MpesaCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('M-Pesa Callback Received', ['data' => $request->all()]);

        $callbackData = $request->getContent();
        $data = json_decode($callbackData);

        if (!$data || !isset($data->Body->stkCallback)) {
            return response()->json(['status' => 'invalid_data'], 400);
        }

        $callback = $data->Body->stkCallback;
        $checkoutRequestId = $callback->CheckoutRequestID;
        $resultCode = $callback->ResultCode;

        $donation = Donation::where('transaction_reference', $checkoutRequestId)->first();

        if (!$donation) {
            Log::error('Donation not found for CheckoutRequestID', ['id' => $checkoutRequestId]);
            return response()->json(['status' => 'not_found'], 404);
        }

        if ($resultCode == 0) {
            $donation->update(['status' => 'success']);
            
            // Increment campaign amount
            $campaign = $donation->campaign;
            $campaign->increment('current_amount', $donation->amount);
            
            // Send Email Notification
            try {
                $recipient = $donation->email ?? ($donation->user->email ?? null);
                if ($recipient) {
                    Mail::to($recipient)->send(new DonationReceived($donation));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send donation receipt email', ['error' => $e->getMessage()]);
            }
            
            Log::info('Donation successful', ['donation_id' => $donation->id]);
        } else {
            $donation->update(['status' => 'failed']);
            Log::warning('Donation failed', [
                'donation_id' => $donation->id, 
                'result_desc' => $callback->ResultDesc
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
