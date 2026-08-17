<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700" rel="stylesheet" />

    <div class="bg-[#12141A] text-white min-h-screen">
        <div class="max-w-3xl mx-auto px-6 py-14">

            @if (!empty($course->image))
                <div class="aspect-video rounded-lg overflow-hidden bg-black/30 mb-6">
                    <img src="{{ asset('storage/' . $course->image) }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                </div>
            @endif

            <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
            <p class="text-white/70 leading-relaxed mt-4">{{ $course->description }}</p>
            <p class="font-['JetBrains_Mono'] text-2xl text-[#5EEAD4] font-bold mt-6">
                {{ $course->price > 0 ? '₦' . number_format($course->price, 2) : 'Free' }}
            </p>

            @auth
                @if ($enrolled)
                    <div class="mt-6 p-5 rounded-lg border border-[#1F6F50]/30 bg-[#1F6F50]/10">
                        <p class="font-medium text-[#5EEAD4]">You're enrolled 🎉</p>

                        @if (!empty($course->join_url))
                            <a href="{{ $course->join_url }}" target="_blank"
                               class="inline-block mt-3 px-5 py-2.5 rounded-md bg-[#A63446] text-white text-sm font-medium hover:opacity-90 transition">
                                Join the live class &rarr;
                            </a>
                        @endif
                    </div>
                @elseif ($course->price > 0)
                    <button disabled
                            class="mt-6 px-6 py-3 rounded-md bg-white/10 text-white/40 font-medium cursor-not-allowed">
                        Paid enrollment — checkout not wired up yet
                    </button>
                @else
                    <form method="POST" action="{{ route('courses.enroll', $course) }}" class="mt-6">
                        @csrf
                        <button type="submit"
                                class="px-6 py-3 rounded-md bg-[#1F6F50] text-white font-medium hover:bg-[#195A41] transition">
                            Enroll — it's free
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="inline-block mt-6 px-6 py-3 rounded-md bg-[#1F6F50] text-white font-medium hover:bg-[#195A41] transition">
                    Log in to enroll
                </a>
            @endauth
        </div>
    </div>
</x-app-layout>