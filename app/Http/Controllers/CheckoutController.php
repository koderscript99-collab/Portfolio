<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Step 1: user clicks "Buy" -> we create a pending order and redirect to Paystack
    public function start(Product $product)
    {
        $user = auth()->user();

        // Don't let someone buy the same product twice
        if ($product->isPurchasedBy($user)) {
            return redirect()
                ->route('products.show', $product)
                ->with('info', 'You already own this product.');
        }

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $product->price,
            'status' => 'pending',
            // unique reference Paystack will echo back to us
            'payment_reference' => 'ord_' . Str::random(20),
        ]);

        // Talk to Paystack's API directly — no third-party package needed,
        // this is a single plain HTTP call.
        $response = Http::withToken(config('services.paystack.secret'))
            ->post('https://api.paystack.co/transaction/initialize', [
                // Paystack expects the amount in kobo (smallest currency unit)
                'amount' => (int) ($order->amount * 100),
                'email' => $user->email,
                'reference' => $order->payment_reference,
                'callback_url' => route('checkout.callback'),
                'metadata' => ['order_id' => $order->id],
            ]);

        if (! $response->successful() || ! $response->json('status')) {
            $order->update(['status' => 'failed']);

            return redirect()
                ->route('products.show', $product)
                ->with('error', 'Could not start payment. Please try again.');
        }

        // Send the browser to Paystack's hosted checkout page
        return redirect()->away($response->json('data.authorization_url'));
    }

    // Step 2: Paystack redirects the BROWSER back here after payment attempt.
    // In production, the webhook (PaystackWebhookController) is the real
    // source of truth for "did this actually get paid". But webhooks are a
    // server-to-server call FROM Paystack TO your app — and while you're
    // developing on 127.0.0.1, Paystack's servers can't reach your machine
    // at all, so the webhook never arrives. To make local testing (and the
    // user's experience generally) work reliably, we also verify directly
    // here, since this callback runs in the user's own browser hitting your
    // own server, which always works regardless of webhook reachability.
    public function callback()
    {
        $reference = request('reference') ?? request('trxref');
        $order = Order::where('payment_reference', $reference)->firstOrFail();

        if ($order->status !== 'paid') {
            $verify = Http::withToken(config('services.paystack.secret'))
                ->get("https://api.paystack.co/transaction/verify/{$reference}")
                ->json();

            $verifiedStatus = $verify['data']['status'] ?? null;
            // Use requested_amount, not amount — 'amount' can include Paystack's
            // transaction fee on top when the customer bears the fee, so it
            // won't exactly match what we originally charged for.
            $verifiedAmountKobo = $verify['data']['requested_amount'] ?? $verify['data']['amount'] ?? 0;
            $expectedAmountKobo = (int) ($order->amount * 100);

            if ($verifiedStatus === 'success' && $verifiedAmountKobo === $expectedAmountKobo) {
                $order->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            }
        }

        if ($order->fresh()->status === 'paid') {
            return redirect()
                ->route('orders.download', $order)
                ->with('success', 'Payment confirmed! Your download is ready.');
        }

        return redirect()
            ->route('products.show', $order->product)
            ->with('info', 'Payment is processing — you\'ll get access as soon as it\'s confirmed.');
    }
}