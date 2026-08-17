<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700" rel="stylesheet" />

    <div class="bg-[#12141A] text-white min-h-screen">
        <div class="max-w-5xl mx-auto px-6 py-14">
            <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-2">// templates</p>
            <h1 class="text-3xl font-bold mb-10">Templates &amp; Code</h1>

            @if ($products->isEmpty())
                <p class="text-white/50">Nothing published yet — check back soon.</p>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product) }}"
                       class="group block rounded-lg border border-white/10 bg-[#1B1E26] overflow-hidden hover:border-[#1F6F50] hover:-translate-y-0.5 transition">
                        <div class="aspect-video bg-black/30 overflow-hidden">
                            @if ($product->preview_image)
                                <img src="{{ asset('storage/' . $product->preview_image) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     alt="{{ $product->title }}">
                            @endif
                        </div>
                        <div class="p-4">
                            <h2 class="font-semibold text-white">{{ $product->title }}</h2>
                            @if ($product->category)
                                <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wide text-white/40">
                                    {{ $product->category }}
                                </span>
                            @endif
                            <p class="font-['JetBrains_Mono'] text-[#5EEAD4] font-bold mt-1">
                                ₦{{ number_format($product->price, 2) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>