<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    protected $fillable = ['product_id', 'path', 'version'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}