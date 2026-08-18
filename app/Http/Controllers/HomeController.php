<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Course;
use App\Models\Profile;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::current();

        // Show a handful of recent items on the homepage as a preview
        $products = Product::where('is_published', true)->latest()->take(3)->get();
        $courses = Course::where('is_published', true)->latest()->take(3)->get();

        // Real number, not a placeholder — distinct people who've actually paid
        $customersCount = Order::where('status', 'paid')->distinct('user_id')->count('user_id');

        return view('home', compact('profile', 'products', 'courses', 'customersCount'));
    }
}
