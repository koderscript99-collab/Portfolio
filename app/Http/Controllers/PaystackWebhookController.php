<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackWebhookController extends Controller
{
    // Paystack calls this URL directly from their servers, not via the
    // user's browser. Configure it in your Paystack dashboard as:
    // https://yourdomain.com/webhooks/paystack
    public function handle(Request $request)
    {
        // 1. Verify the request really came from Paystack (signature check)
        $signature = $request->header('x-paystack-signature');
        $expected = hash_hmac('sha512', $request->getContent(), config('services.paystack.secret'));

        if (! hash_equals($expected, (string) $signature)) {
            Log::warning('Paystack webhook: invalid signature');
            abort(400);
        }

        $payload = $request->all();

        if (($payload['event'] ?? null) !== 'charge.success') {
            return response()->json(['status' => 'ignored']);
        }

        $reference = $payload['data']['reference'] ?? null;
        $order = Order::where('payment_reference', $reference)->first();

        if (! $order || $order->status === 'paid') {
            return response()->json(['status' => 'ok']); // already handled or unknown
        }

        // 2. Double-check with Paystack's API directly (belt and braces —
        // never trust the webhook body alone for the amount/status)
        $verify = Http::withToken(config('services.paystack.secret'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();

        $verifiedStatus = $verify['data']['status'] ?? null;
        // Use requested_amount, not amount — see CheckoutController for why.
        $verifiedAmountKobo = $verify['data']['requested_amount'] ?? $verify['data']['amount'] ?? 0;
        $expectedAmountKobo = (int) ($order->amount * 100);

        if ($verifiedStatus === 'success' && $verifiedAmountKobo === $expectedAmountKobo) {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Optional: notify the buyer by email here
            // Mail::to($order->user)->send(new PurchaseConfirmed($order));
        } else {
            $order->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }
}