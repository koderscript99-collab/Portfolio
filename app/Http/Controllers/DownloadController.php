<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class DownloadController extends Controller
{
    // The "your purchase is ready" page — shown after payment, or any time
    // the buyer logs back in and wants to re-download / re-read instructions.
    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'paid', 403, 'Payment not yet confirmed.');

        $product = $order->product;
        $file = $product->latestFile;
        $profile = Profile::current();

        // Generate a temporary signed link, e.g. valid for 15 minutes.
        // Even if this URL leaks, it stops working after it expires.
        $downloadUrl = $file
            ? URL::temporarySignedRoute(
                'orders.download.file',
                now()->addMinutes(15),
                ['order' => $order->id]
              )
            : null;

        return view('products.download', compact('order', 'product', 'downloadUrl', 'profile'));
    }

    // The actual file stream. Only reachable via the signed URL above.
    public function file(Order $order)
    {
        // Laravel automatically 403s here if the signature is invalid or expired
        // because this route is wrapped with the 'signed' middleware (see routes/web.php)
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'paid', 403);

        $file = $order->product->latestFile;
        abort_unless($file, 404);

        // 'private' disk should point at storage/app/private (not web-accessible)
        return Storage::disk('local')->download(
            $file->path,
            $order->product->slug . '.zip'
        );
    }
}