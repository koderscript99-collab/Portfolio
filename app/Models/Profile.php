<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['name', 'tagline', 'bio', 'avatar', 'social_links', 'support_whatsapp', 'support_email'];

    protected $casts = [
        'social_links' => 'array',
    ];

    // There's only ever meant to be one row — this returns whichever one
    // actually exists, creating a blank one only if the table is genuinely empty.
    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }
}