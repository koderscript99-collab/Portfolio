<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Templates &amp; Code</h1>

        @if ($products->isEmpty())
            <p class="text-gray-500">Nothing published yet — check back soon.</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product) }}"
                   class="block border rounded-lg overflow-hidden hover:shadow-md transition">
                    @if ($product->preview_image)
                        <img src="{{ asset('storage/' . $product->preview_image) }}"
                             class="w-full h-40 object-cover" alt="{{ $product->title }}">
                    @else
                        <div class="w-full h-40 bg-gray-100"></div>
                    @endif

                    <div class="p-4">
                        <h2 class="font-semibold">{{ $product->title }}</h2>
                        @if ($product->category)
                            <span class="text-xs text-gray-500 uppercase tracking-wide">
                                {{ $product->category }}
                            </span>
                        @endif
                        <p class="mt-2 font-medium">₦{{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>