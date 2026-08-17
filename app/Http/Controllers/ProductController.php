<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_published, 404);

        $purchased = $product->isPurchasedBy(auth()->user());

        return view('products.show', compact('product', 'purchased'));
    }
}