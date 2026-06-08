<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'invoice_number',
        'payment_method',
        'amount',
        'status',
        'started_at',
        'expired_at',
        'paid_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive()
    {
        return $this->status === 'paid'
            && $this->expired_at
            && $this->expired_at->isFuture();
    }

    public function isExpired()
    {
        return $this->status === 'expired'
            || ($this->expired_at && $this->expired_at->isPast());
    }
}