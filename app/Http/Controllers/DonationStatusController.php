<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationStatusController extends Controller
{
    public function show(Request $request)
    {
        $donation = Donation::where('transaction_reference', $request->query('reference'))->first();

        if (! $donation) {
            return response()->json(['status' => 'pending'], 200);
        }

        return response()->json([
            'status' => $donation->status,
            'reference' => $donation->transaction_reference,
        ]);
    }
}
