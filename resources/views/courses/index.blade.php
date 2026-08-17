<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700" rel="stylesheet" />

    <div class="bg-[#12141A] text-white min-h-screen">
        <div class="max-w-5xl mx-auto px-6 py-14">
            <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-2">// classes</p>
            <h1 class="text-3xl font-bold mb-10">Classes</h1>

            @if ($courses->isEmpty())
                <p class="text-white/50">No classes published yet — check back soon.</p>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($courses as $course)
                    <a href="{{ route('courses.show', $course) }}"
                       class="group block rounded-lg border border-white/10 bg-[#1B1E26] overflow-hidden hover:border-[#A63446] hover:-translate-y-0.5 transition">
                        <div class="aspect-video bg-black/30 overflow-hidden relative">
                            @if (!empty($course->image))
                                <img src="{{ asset('storage/' . $course->image) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     alt="{{ $course->title }}">
                            @endif
                            @if (!empty($course->join_url))
                                <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full bg-[#A63446] text-white text-[10px] font-['JetBrains_Mono'] uppercase tracking-wide">
                                    Live
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h2 class="font-semibold text-white">{{ $course->title }}</h2>
                            <p class="text-sm text-white/50 mt-1 line-clamp-2">{{ $course->description }}</p>
                            <p class="font-['JetBrains_Mono'] text-[#5EEAD4] font-bold mt-2">
                                {{ $course->price > 0 ? '₦' . number_format($course->price, 2) : 'Free' }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>