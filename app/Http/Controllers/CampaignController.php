<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = \App\Models\Campaign::with(['donations' => function($query) {
            $query->where('status', 'success')->orWhere('status', 'pending');
        }, 'donations.user', 'updates'])->where('status', 'active')->get();

        $grandTotalRaised = \Illuminate\Support\Facades\Cache::remember('grand_total_raised', 600, function() {
            return \App\Models\Donation::where('status', 'success')->sum('amount');
        });

        $totalDonorsCount = \Illuminate\Support\Facades\Cache::remember('total_donors_count', 600, function() {
            return \App\Models\Donation::where('status', 'success')->distinct('user_id')->count('user_id');
        });

        return view('welcome', compact('campaigns', 'grandTotalRaised', 'totalDonorsCount'));
    }

    public function show(\App\Models\Campaign $campaign)
    {
        $campaign->load(['donations' => function($query) {
            $query->where('status', 'success')->orWhere('status', 'pending')->latest();
        }, 'donations.user', 'updates' => function($query) {
            $query->latest();
        }]);

        return view('campaigns.show', compact('campaign'));
    }

    public function impact()
    {
        $closedCampaigns = \App\Models\Campaign::with(['donations' => function($query) {
            $query->where('status', 'success');
        }, 'updates' => function($query) {
            $query->latest();
        }])->where('status', 'closed')->get();

        return view('impact', compact('closedCampaigns'));
    }
}

