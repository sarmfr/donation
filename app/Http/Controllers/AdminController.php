<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_donations' => \App\Models\Donation::where('status', 'success')->sum('amount'),
            'active_campaigns' => \App\Models\Campaign::where('status', 'active')->count(),
            'total_users' => \App\Models\User::count(),
            'pending_withdrawals' => \App\Models\Withdrawal::where('status', 'pending')->count(),
            'unread_messages' => \App\Models\ContactMessage::where('status', 'unread')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function campaigns()
    {
        $campaigns = \App\Models\Campaign::latest()->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function createCampaign()
    {
        $users = \App\Models\User::select('id', 'name', 'email')->orderBy('name')->get();
        return view('admin.campaigns.create', compact('users'));
    }

    public function storeCampaign(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'nullable|numeric|min:1',
            'status' => 'required|in:active,closed',
            'is_verified' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $validated['is_verified'] = $request->has('is_verified');

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('campaigns'), $imageName);
            $validated['image_path'] = 'campaigns/'.$imageName;
        }

        \App\Models\Campaign::create($validated);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully!');
    }

    public function editCampaign(\App\Models\Campaign $campaign)
    {
        $users = \App\Models\User::select('id', 'name', 'email')->orderBy('name')->get();
        return view('admin.campaigns.edit', compact('campaign', 'users'));
    }

    public function updateCampaign(Request $request, \App\Models\Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'nullable|numeric|min:1',
            'status' => 'required|in:active,closed',
            'is_verified' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $validated['is_verified'] = $request->has('is_verified');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($campaign->image_path && file_exists(public_path($campaign->image_path))) {
                @unlink(public_path($campaign->image_path));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('campaigns'), $imageName);
            $validated['image_path'] = 'campaigns/'.$imageName;
        }

        $campaign->update($validated);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully!');
    }

    public function destroyCampaign(\App\Models\Campaign $campaign)
    {
        if ($campaign->image_path && file_exists(public_path($campaign->image_path))) {
            @unlink(public_path($campaign->image_path));
        }
        $campaign->delete();
        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign deleted successfully!');
    }

    public function addUpdate(Request $request, \App\Models\Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'update_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('update_image')) {
            $imageName = 'update_'.time().'.'.$request->update_image->extension();
            $request->update_image->move(public_path('campaigns/updates'), $imageName);
            $validated['image_path'] = 'campaigns/updates/'.$imageName;
        }

        $campaign->updates()->create($validated);

        return redirect()->back()->with('success', 'Campaign update posted successfully!');
    }

    public function donations()
    {
        $donations = \App\Models\Donation::with(['user', 'campaign'])->latest()->paginate(20);
        
        $globalStats = [
            'total_volume' => \App\Models\Donation::where('status', 'success')->sum('amount'),
            'pending_count' => \App\Models\Donation::where('status', 'pending')->count(),
            'total_count' => \App\Models\Donation::count(),
        ];

        return view('admin.donations.index', compact('donations', 'globalStats'));
    }

    public function withdrawals()
    {
        $withdrawals = \App\Models\Withdrawal::with('campaign')->latest()->paginate(20);
        $campaigns   = \App\Models\Campaign::select('id', 'title')->where('status', 'active')->orderBy('title')->get();
        return view('admin.withdrawals.index', compact('withdrawals', 'campaigns'));
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'campaign_id'     => 'required|exists:campaigns,id',
            'amount'          => 'required|numeric|min:10',
            'recipient_phone' => 'required|string|regex:/^254[0-9]{9}$/',
            'remarks'         => 'nullable|string|max:255',
        ]);

        $campaign = \App\Models\Campaign::findOrFail($request->campaign_id);

        if ($campaign->payoutBalance() < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient campaign balance. Available: KES ' . number_format($campaign->payoutBalance()));
        }

        \App\Models\Withdrawal::create([
            'campaign_id'     => $request->campaign_id,
            'amount'          => $request->amount,
            'recipient_phone' => $request->recipient_phone,
            'remarks'         => $request->remarks,
            'status'          => 'pending',
        ]);

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal request created successfully.');
    }

    public function approveWithdrawal(\App\Models\Withdrawal $withdrawal, \App\Services\MpesaService $mpesaService)
    {
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This withdrawal has already been processed.');
        }

        $response = $mpesaService->b2cRequest(
            $withdrawal->recipient_phone,
            (int) $withdrawal->amount,
            "Payout for campaign: " . $withdrawal->campaign->title
        );

        if ($response && isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
            $withdrawal->update([
                'status' => 'completed',
                'mpesa_reference' => $response['ConversationID'] ?? null,
            ]);

            // Notify User
            try {
                if ($withdrawal->campaign->user) {
                    \Illuminate\Support\Facades\Mail::to($withdrawal->campaign->user->email)
                        ->send(new \App\Mail\WithdrawalNotification($withdrawal));
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send withdrawal approval email: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Payout initiated successfully via M-Pesa B2C!');
        }

        return redirect()->back()->with('error', 'M-Pesa B2C request failed. Please check logs.');
    }

    public function exportDonations()
    {
        $donations = \App\Models\Donation::with(['user', 'campaign'])->latest()->get();
        $filename = "donations_" . date('Y-m-d_H-i') . ".csv";
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Donor', 'Campaign', 'Amount', 'M-Pesa Ref', 'Status', 'Date');

        $callback = function() use($donations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($donations as $donation) {
                fputcsv($file, array(
                    $donation->id,
                    $donation->is_anonymous ? 'Anonymous' : ($donation->user->name ?? 'Guest'),
                    $donation->campaign->title,
                    $donation->amount,
                    $donation->transaction_reference,
                    $donation->status,
                    $donation->created_at->format('Y-m-d H:i')
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function messages()
    {
        $messages = \App\Models\ContactMessage::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function markMessageRead(\App\Models\ContactMessage $message)
    {
        $message->update(['status' => 'read']);
        return redirect()->back()->with('success', 'Message marked as read.');
    }
}
