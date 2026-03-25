<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    protected $paynectaService;

    public function __construct(\App\Services\PaynectaService $paynectaService)
    {
        $this->paynectaService = $paynectaService;
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:10',
            'phone' => 'required|string',
            'email' => Auth::check() ? 'nullable|email' : 'required|email',
            'is_anonymous' => 'sometimes|accepted',
        ]);

        $donation = \App\Models\Donation::create([
            'campaign_id'    => $validated['campaign_id'],
            'user_id'        => Auth::id(),
            'email'          => $validated['email'] ?? (Auth::user()?->email),
            'amount'         => $validated['amount'],
            'is_anonymous'   => $request->has('is_anonymous'),
            'payment_method' => 'paynecta',
            'status'         => 'pending',
        ]);

        // Trigger Paynecta Payment Initialization
        $response = $this->paynectaService->initializePayment(
            $validated['phone'],
            $validated['amount']
        );

        if ($response && isset($response['success']) && $response['success'] === true) {
            $donation->update([
                'transaction_reference' => $response['data']['reference'] ?? null,
            ]);
            return redirect()->route('donation.success', ['campaign' => $validated['campaign_id']]);
        }

        return redirect()->back()->with('error', 'Failed to initiate payment. Please try again.');
    }

    public function success(Request $request)
    {
        $campaign = \App\Models\Campaign::find($request->campaign);
        return view('donations.success', compact('campaign'));
    }
}
