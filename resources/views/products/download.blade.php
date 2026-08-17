<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700" rel="stylesheet" />

    @php
        $supportWhatsApp = $profile->support_whatsapp ?? null;
        $supportEmail = $profile->support_email ?? null;
    @endphp

    <div class="bg-[#12141A] text-white min-h-screen">
        <div class="max-w-2xl mx-auto px-6 py-14">

            <div class="rounded-lg border border-[#1F6F50]/30 bg-[#1F6F50]/10 p-6">
                <p class="font-['JetBrains_Mono'] text-xs text-[#5EEAD4] tracking-widest uppercase mb-2">// order confirmed</p>
                <h1 class="text-2xl font-bold">You're all set</h1>
                <p class="mt-1 text-white/70">
                    Your purchase of <strong>{{ $product->title }}</strong> is confirmed.
                </p>

                @if ($downloadUrl)
                    <a href="{{ $downloadUrl }}"
                       class="inline-block mt-4 px-6 py-3 rounded-md bg-[#1F6F50] text-white font-medium hover:bg-[#195A41] transition">
                        Download your files
                    </a>
                    <p class="text-xs text-white/40 mt-2 font-['JetBrains_Mono']">
                        Link expires in 15 minutes. Revisit this page any time for a fresh one.
                    </p>
                @else
                    <p class="mt-4 text-sm text-[#F0A0AC]">
                        No file has been attached to this product yet — contact support below.
                    </p>
                @endif
            </div>

            @if ($product->instructions)
                <div class="mt-10">
                    <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-2">// how to use this</p>
                    <div class="prose prose-invert max-w-none text-sm">{!! $product->instructions !!}</div>
                </div>
            @endif

            @if ($supportWhatsApp || $supportEmail)
                <div class="mt-14 pt-8 border-t border-white/10">
                    <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-3">// need help?</p>
                    <div class="flex gap-3">
                        @if ($supportWhatsApp)
                            <a href="https://wa.me/{{ $supportWhatsApp }}?text={{ urlencode('Hi, I need help with my order: ' . $product->title) }}"
                               target="_blank"
                               class="px-4 py-2 rounded-md bg-[#1F6F50] text-white text-sm font-medium hover:bg-[#195A41] transition">
                                Chat on WhatsApp
                            </a>
                        @endif
                        @if ($supportEmail)
                            <a href="mailto:{{ $supportEmail }}?subject={{ urlencode('Order help: ' . $product->title) }}"
                               class="px-4 py-2 rounded-md border border-white/10 text-white text-sm font-medium hover:border-[#1F6F50] transition">
                                Email support
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>