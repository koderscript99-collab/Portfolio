<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700" rel="stylesheet" />
    <style>.snap-x::-webkit-scrollbar { display: none; }</style>

    @php
        $supportWhatsApp = $profile->support_whatsapp ?? null;
        $supportEmail = $profile->support_email ?? null;
        $allImages = collect([$product->preview_image])->merge($product->gallery ?? [])->filter()->values();
    @endphp

    <div class="bg-[#12141A] text-white min-h-screen">
        <div class="max-w-3xl mx-auto px-6 py-14">

            @if ($allImages->isNotEmpty())
                <div x-data="{ active: 0, count: {{ $allImages->count() }} }" class="mb-8">
                    <div
                        x-ref="track"
                        @scroll="active = Math.round($refs.track.scrollLeft / $refs.track.clientWidth)"
                        class="flex overflow-x-auto snap-x snap-mandatory rounded-lg bg-black/30 scroll-smooth"
                        style="scrollbar-width: none;"
                    >
                        @foreach ($allImages as $image)
                            <div class="h-[50vh] max-h-[480px] w-full flex-none snap-center">
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="w-full h-full object-cover" alt="{{ $product->title }}">
                            </div>
                        @endforeach
                    </div>

                    @if ($allImages->count() > 1)
                        <div class="flex justify-center gap-1.5 mt-3">
                            @foreach ($allImages as $index => $image)
                                <button
                                    @click="$refs.track.scrollTo({ left: {{ $index }} * $refs.track.clientWidth, behavior: 'smooth' })"
                                    :class="active === {{ $index }} ? 'bg-[#5EEAD4] w-5' : 'bg-white/20 w-1.5'"
                                    class="h-1.5 rounded-full transition-all"
                                ></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            @if ($product->category)
                <span class="font-['JetBrains_Mono'] text-xs uppercase tracking-wide text-white/40">
                    {{ $product->category }}
                </span>
            @endif

            <h1 class="text-3xl font-bold mt-1">{{ $product->title }}</h1>
            <p class="text-white/70 leading-relaxed mt-4">{{ $product->description }}</p>
            <p class="font-['JetBrains_Mono'] text-2xl text-[#5EEAD4] font-bold mt-6">
                ₦{{ number_format($product->price, 2) }}
            </p>

            @auth
                @if ($purchased)
                    <div class="mt-6 p-5 rounded-lg border border-[#1F6F50]/30 bg-[#1F6F50]/10">
                        <p class="font-medium text-[#5EEAD4]">You own this product.</p>

                        @php
                            $order = $product->orders()
                                ->where('user_id', auth()->id())
                                ->where('status', 'paid')
                                ->latest()
                                ->first();
                        @endphp

                        @if ($order)
                            <a href="{{ route('orders.download', $order) }}"
                               class="inline-block mt-3 px-5 py-2.5 rounded-md bg-[#1F6F50] text-white text-sm font-medium hover:bg-[#195A41] transition">
                                Get your download
                            </a>
                        @endif

                        @if ($product->instructions)
                            <div class="mt-6">
                                <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-2">// how to use this</p>
                                <div class="prose prose-invert max-w-none text-sm">{!! $product->instructions !!}</div>
                            </div>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('checkout.start', $product) }}" class="mt-6">
                        @csrf
                        <button type="submit"
                                class="px-6 py-3 rounded-md bg-[#1F6F50] text-white font-medium hover:bg-[#195A41] transition">
                            Buy now
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="inline-block mt-6 px-6 py-3 rounded-md bg-[#1F6F50] text-white font-medium hover:bg-[#195A41] transition">
                    Log in to purchase
                </a>
            @endauth

            @if ($supportWhatsApp || $supportEmail)
                <div class="mt-14 pt-8 border-t border-white/10">
                    <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-3">// need help?</p>
                    <div class="flex gap-3">
                        @if ($supportWhatsApp)
                            <a href="https://wa.me/{{ $supportWhatsApp }}?text={{ urlencode('Hi, I need help with: ' . $product->title) }}"
                               target="_blank"
                               class="px-4 py-2 rounded-md bg-[#1F6F50] text-white text-sm font-medium hover:bg-[#195A41] transition">
                                Chat on WhatsApp
                            </a>
                        @endif
                        @if ($supportEmail)
                            <a href="mailto:{{ $supportEmail }}?subject={{ urlencode('Help with ' . $product->title) }}"
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