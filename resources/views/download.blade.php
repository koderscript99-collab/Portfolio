<x-app-layout>
    @php
        $supportWhatsApp = $profile->support_whatsapp ?? null;
        $supportEmail = $profile->support_email ?? null;
    @endphp

    <div class="max-w-2xl mx-auto px-6 py-16">
        <div class="code-window mb-8">
            <div class="code-window-bar">
                <span class="code-window-dot" style="background-color:var(--accent-amber)"></span>
                <span class="code-window-filename">order confirmed</span>
            </div>
            <div class="p-6">
                <h1 class="font-display text-2xl font-semibold">You're all set</h1>
                <p class="mt-2 text-[var(--text-muted)]">
                    Your purchase of <span class="text-[var(--text-primary)]">{{ $product->title }}</span> is confirmed.
                </p>

                @if ($downloadUrl)
                    <a href="{{ $downloadUrl }}"
                       class="inline-block mt-6 px-6 py-3 rounded-md bg-[var(--accent-amber)] text-[#12141a] font-medium hover:opacity-90 transition">
                        Download .zip
                    </a>
                    <p class="font-mono text-xs text-[var(--text-muted)] mt-3">
                        // link expires in 15 minutes — revisit this page for a fresh one
                    </p>
                @else
                    <p class="mt-4 text-sm text-red-400 font-mono">
                        // no file attached to this product yet — contact support below
                    </p>
                @endif
            </div>
        </div>

        @if ($product->instructions)
            <div class="mb-8">
                <p class="font-mono text-xs text-[var(--text-muted)] mb-3">/* how to use this */</p>
                <div class="text-[var(--text-primary)] leading-relaxed">
                    {!! $product->instructions !!}
                </div>
            </div>
        @endif

        @if ($supportWhatsApp || $supportEmail)
            <div class="pt-6 border-t border-[var(--border-subtle)]">
                <p class="font-mono text-xs text-[var(--text-muted)] mb-3">// need help?</p>
                <div class="flex gap-3">
                    @if ($supportWhatsApp)
                        <a href="https://wa.me/{{ $supportWhatsApp }}?text={{ urlencode('Hi, I need help with my order: ' . $product->title) }}"
                           target="_blank"
                           class="px-4 py-2 rounded-md bg-[var(--surface)] border border-[var(--border-subtle)] text-sm hover:border-[var(--accent-teal)] transition">
                            WhatsApp
                        </a>
                    @endif
                    @if ($supportEmail)
                        <a href="mailto:{{ $supportEmail }}?subject={{ urlencode('Order help: ' . $product->title) }}"
                           class="px-4 py-2 rounded-md bg-[var(--surface)] border border-[var(--border-subtle)] text-sm hover:border-[var(--accent-teal)] transition">
                            Email
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>