<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'campaign_id',
        'amount',
        'status',
        'recipient_phone',
        'mpesa_reference',
        'remarks',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
