<x-app-layout>
    @php
        $supportWhatsApp = $profile->support_whatsapp ?? null;
        $supportEmail = $profile->support_email ?? null;
    @endphp

    <div class="max-w-3xl mx-auto px-6 py-16">

        {{-- File-tab header, matches the card style from the listing page --}}
        <div class="code-window mb-8">
            <div class="code-window-bar">
                <span class="code-window-dot"></span>
                <span class="code-window-dot"></span>
                <span class="code-window-dot"></span>
                <span class="code-window-filename">{{ $product->slug }}.zip</span>
            </div>

            <div class="p-6">
                @if ($product->preview_image)
                    <img src="{{ asset('storage/' . $product->preview_image) }}"
                         class="w-full h-64 object-cover rounded mb-6" alt="{{ $product->title }}">
                @endif

                {{-- Gallery: extra screenshots beyond the main preview --}}
                @if (!empty($product->gallery))
                    <div class="grid grid-cols-3 gap-2 mb-6">
                        @foreach ($product->gallery as $image)
                            <img src="{{ asset('storage/' . $image) }}"
                                 class="w-full h-20 object-cover rounded border border-[var(--border-subtle)]" alt="">
                        @endforeach
                    </div>
                @endif

                <h1 class="font-display text-2xl font-semibold">{{ $product->title }}</h1>
                @if ($product->category)
                    <span class="font-mono text-[11px] text-[var(--text-muted)] uppercase tracking-wide">
                        {{ $product->category }}
                    </span>
                @endif

                <p class="text-[var(--text-muted)] mt-4 leading-relaxed">{{ $product->description }}</p>

                <p class="font-mono text-lg text-[var(--accent-amber)] mt-6">
                    // ₦{{ number_format($product->price, 2) }}
                </p>

                @auth
                    @if ($purchased)
                        @php
                            $order = $product->orders()
                                ->where('user_id', auth()->id())
                                ->where('status', 'paid')
                                ->latest()
                                ->first();
                        @endphp

                        <div class="mt-6 p-4 rounded-md bg-[var(--surface-hover)] border border-[var(--accent-amber)]">
                            <p class="font-mono text-sm text-[var(--accent-amber)]">✓ you own this</p>

                            @if ($order)
                                <a href="{{ route('orders.download', $order) }}"
                                   class="inline-block mt-3 px-5 py-2.5 rounded-md bg-[var(--accent-amber)] text-[#12141a] font-medium text-sm hover:opacity-90 transition">
                                    Download .zip
                                </a>
                            @endif
                        </div>

                        @if ($product->instructions)
                            <div class="mt-8 pt-6 border-t border-[var(--border-subtle)]">
                                <p class="font-mono text-xs text-[var(--text-muted)] mb-3">/* how to use this */</p>
                                <div class="text-[var(--text-primary)] leading-relaxed">
                                    {!! $product->instructions !!}
                                </div>
                            </div>
                        @endif
                    @else
                        <form method="POST" action="{{ route('checkout.start', $product) }}" class="mt-6">
                            @csrf
                            <button type="submit"
                                    class="px-6 py-3 rounded-md bg-[var(--accent-amber)] text-[#12141a] font-medium hover:opacity-90 transition">
                                Buy now
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block mt-6 px-6 py-3 rounded-md bg-[var(--accent-amber)] text-[#12141a] font-medium hover:opacity-90 transition">
                        Log in to purchase
                    </a>
                @endauth
            </div>
        </div>

        {{-- Contact / support --}}
        @if ($supportWhatsApp || $supportEmail)
            <div class="pt-6 border-t border-[var(--border-subtle)]">
                <p class="font-mono text-xs text-[var(--text-muted)] mb-3">// need help with this?</p>
                <div class="flex gap-3">
                    @if ($supportWhatsApp)
                        <a href="https://wa.me/{{ $supportWhatsApp }}?text={{ urlencode('Hi, I need help with: ' . $product->title) }}"
                           target="_blank"
                           class="px-4 py-2 rounded-md bg-[var(--surface)] border border-[var(--border-subtle)] text-sm hover:border-[var(--accent-teal)] transition">
                            WhatsApp
                        </a>
                    @endif
                    @if ($supportEmail)
                        <a href="mailto:{{ $supportEmail }}?subject={{ urlencode('Help with ' . $product->title) }}"
                           class="px-4 py-2 rounded-md bg-[var(--surface)] border border-[var(--border-subtle)] text-sm hover:border-[var(--accent-teal)] transition">
                            Email
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>