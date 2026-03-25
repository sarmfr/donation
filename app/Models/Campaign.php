<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'title',
        'description',
        'goal_amount',
        'current_amount',
        'image_path',
        'status',
        'is_verified',
        'end_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updates()
    {
        return $this->hasMany(CampaignUpdate::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    protected $appends = ['total_raised', 'payout_balance'];

    public function getTotalRaisedAttribute(): float
    {
        return (float) $this->donations()->where('status', 'success')->sum('amount');
    }

    public function getPayoutBalanceAttribute(): float
    {
        $raised = $this->total_raised;
        $withdrawn = $this->withdrawals()->where('status', '!=', 'failed')->sum('amount');
        return $raised - $withdrawn;
    }

    public function payoutBalance(): float
    {
        return $this->payout_balance;
    }

    public function totalRaised(): float
    {
        return $this->total_raised;
    }

    /**
     * Calculate progress percentage.
     */
    public function progressPercentage(): float
    {
        if (!$this->goal_amount) return 0;
        return min(100, ($this->totalRaised() / $this->goal_amount) * 100);
    }

    /**
     * Get remaining goal amount.
     */
    public function remainingAmount(): float
    {
        if (!$this->goal_amount) return 0;
        return max(0, $this->goal_amount - $this->totalRaised());
    }
}
