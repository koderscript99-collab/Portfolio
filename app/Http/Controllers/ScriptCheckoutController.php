<?php

namespace App\Http\Controllers;

use App\Models\Script;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ScriptCheckoutController extends Controller
{
    // User pays for a script that admin already assigned to them.
    // Unlike products, there's no "browse and buy" step — the record
    // already exists with status = pending before the user ever sees this.
    public function start(Script $script)
    {
        $user = auth()->user();

        abort_unless($script->user_id === $user->id, 403);

        if ($script->isPaid()) {
            return redirect()
                ->route('dashboard')
                ->with('info', 'This script has already been paid for.');
        }

        // Reuse the same reference on retry instead of generating a new one
        // each time the user clicks "Pay" again after a failed attempt.
        if (! $script->payment_reference) {
            $script->update(['payment_reference' => 'scr_'.Str::random(20)]);
        }

        $response = Http::withToken(config('services.paystack.secret'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'amount' => (int) ($script->amount * 100),
                'email' => $user->email,
                'reference' => $script->payment_reference,
                'callback_url' => route('scripts.checkout.callback'),
                'metadata' => ['script_id' => $script->id],
            ]);

        if (! $response->successful() || ! $response->json('status')) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Could not start payment. Please try again.');
        }

        return redirect()->away($response->json('data.authorization_url'));
    }

    // Browser lands here after Paystack checkout — cosmetic redirect only.
    // The webhook is still the only source of truth for "paid" status.
    public function callback()
    {
        $reference = request('reference') ?? request('trxref');
        $script = Script::where('payment_reference', $reference)->firstOrFail();

        if ($script->isPaid()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Payment confirmed! The admin will release your file shortly.');
        }

        return redirect()
            ->route('dashboard')
            ->with('info', 'Payment is processing — you\'ll be notified once confirmed.');
    }
}