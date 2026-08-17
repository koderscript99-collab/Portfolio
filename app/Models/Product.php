<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price',
        'preview_image', 'gallery', 'category', 'instructions', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
        'gallery' => 'array',
    ];

    public function files()
    {
        return $this->hasMany(ProductFile::class);
    }

    public function latestFile()
    {
        return $this->hasOne(ProductFile::class)->latestOfMany();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Has the given user actually paid for this product?
    public function isPurchasedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->orders()
            ->where('user_id', $user->id)
            ->where('status', 'paid')
            ->exists();
    }
}