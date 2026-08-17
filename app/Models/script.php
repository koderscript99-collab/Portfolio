<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'amount',
        'status', 'payment_reference', 'paid_at',
        'file_path', 'released_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'released']);
    }

    public function isReleased(): bool
    {
        return $this->status === 'released' && $this->file_path !== null;
    }
}