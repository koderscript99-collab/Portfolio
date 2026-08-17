<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaystackWebhookController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScriptCheckoutController;
use App\Http\Controllers\ScriptDownloadController;
use Illuminate\Support\Facades\Route;

// --- Homepage ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Breeze's dashboard page (shown after login) ---
Route::get('/dashboard', function () {
    return view('dashboard', [
        'projects' => auth()->user()->projects()->latest()->get(),
        'scripts' => auth()->user()->scripts()->latest()->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// --- Public product pages ---
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// --- Public course pages ---
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// --- Requires login ---
Route::middleware('auth')->group(function () {
    // Breeze's profile page (edit name/email/password, delete account)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/products/{product}/checkout', [CheckoutController::class, 'start'])->name('checkout.start');
    Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');

    Route::get('/orders/{order}', [DownloadController::class, 'show'])->name('orders.download');

    // Signed middleware: this route only works with a valid, non-expired signature
    Route::get('/orders/{order}/file', [DownloadController::class, 'file'])
        ->middleware('signed')
        ->name('orders.download.file');

    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // --- Scripts: admin-assigned, pay then admin releases the zip ---
    Route::post('/scripts/{script}/pay', [ScriptCheckoutController::class, 'start'])
        ->name('scripts.checkout.start');

    Route::get('/scripts/checkout/callback', [ScriptCheckoutController::class, 'callback'])
        ->name('scripts.checkout.callback');

    Route::get('/scripts/{script}/download', [ScriptDownloadController::class, 'download'])
        ->name('scripts.download');
});

// --- Paystack calls this directly, no auth/session (it's a server-to-server call) ---
Route::post('/webhooks/paystack', [PaystackWebhookController::class, 'handle'])
    ->withoutMiddleware(['web'])
    ->name('webhooks.paystack');

// --- Breeze's login/register/logout/password-reset/profile routes ---
require __DIR__.'/auth.php';