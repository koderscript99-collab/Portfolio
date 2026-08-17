<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'name', 'language', 'hosting_expiry_date', 'database_expiry_date',
        'host_type', 'host_provider', 'url', 'progress',
    ];

    protected $casts = [
        'hosting_expiry_date' => 'date',
        'database_expiry_date' => 'date',
        'progress'=> 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpiringSoon(int $days = 7): bool
    {
        return $this->expiry_date
            && $this->expiry_date->isFuture()
            && now()->diffInDays($this->expiry_date) <= $days;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }
}