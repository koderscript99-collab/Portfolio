<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <style>
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp .7s ease-out both; }
        @keyframes floatSlow { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-14px) rotate(3deg); } }
        .float-slow { animation: floatSlow 6s ease-in-out infinite; }
        @keyframes floatSlower { 0%,100% { transform: translateY(0); } 50% { transform: translateY(12px); } }
        .float-slower { animation: floatSlower 8s ease-in-out infinite; }
    </style>

    <div class="bg-[#0A0918] font-['Inter'] text-white min-h-screen overflow-x-hidden">

        {{-- NAV --}}
        <nav class="sticky top-4 z-50 mx-4">
            <div class="max-w-6xl mx-auto px-6 h-[64px] flex items-center justify-between bg-white text-[#14131F] rounded-2xl shadow-xl shadow-black/20">
                <a href="#" class="flex items-center gap-2 font-bold text-[15px] whitespace-nowrap">
                    <svg class="w-4 h-4 text-[#8B5CF6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    {{ $profile->name ?? 'Your Name' }}
                </a>

                <div class="hidden md:flex items-center gap-7 text-sm font-medium text-[#4B4A57]">
                    <a href="#templates" class="flex items-center gap-1.5 hover:text-[#14131F] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        Source Code
                    </a>
                    <a href="#classes" class="flex items-center gap-1.5 hover:text-[#14131F] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/></svg>
                        Classes
                    </a>
                    <a href="#templates" class="flex items-center gap-1.5 hover:text-[#14131F] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>
                        Projects
                    </a>
                    <a href="#about" class="flex items-center gap-1.5 hover:text-[#14131F] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        About
                    </a>
                    <a href="#contact" class="flex items-center gap-1.5 hover:text-[#14131F] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg>
                        Contact
                    </a>
                </div>

                <a href="#contact"
                   class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-[#14131F] text-white text-sm font-semibold hover:bg-black transition whitespace-nowrap">
                    <span>&#8599;</span> Hire Me
                </a>
            </div>
        </nav>

        {{-- HERO --}}
        <section class="relative max-w-6xl mx-auto px-6 pt-20 pb-28">
            <div class="absolute -top-10 -left-24 w-96 h-96 bg-[#8B5CF6]/25 rounded-full blur-[100px] float-slow"></div>
            <div class="absolute top-32 -right-16 w-96 h-96 bg-[#6366F1]/20 rounded-full blur-[100px] float-slower"></div>

            <div class="relative grid sm:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="fade-up inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#A78BFA]">
                        {{ $profile->tagline ?? 'Full-Stack Web Developer' }}
                    </span>

                    <h1 class="fade-up mt-5 text-5xl sm:text-6xl font-extrabold leading-[1.1]" style="animation-delay:.1s">
                        Hi, I'm
                        <span class="text-[#8B5CF6]">{{ \Illuminate\Support\Str::of($profile->name ?? 'there')->before(' ') }}.</span><br>
                        I build what works.
                    </h1>

                    <p class="fade-up mt-6 text-gray-400 text-lg max-w-md" style="animation-delay:.2s">
                        {{ $profile->bio ?? 'Add your bio from the admin panel — Portfolio Info section.' }}
                    </p>

                    <div class="fade-up mt-9 flex items-center gap-4 flex-wrap" style="animation-delay:.3s">
                        <a href="#templates"
                           class="px-7 py-3.5 rounded-full bg-gradient-to-r from-[#8B5CF6] to-[#6366F1] text-white font-semibold shadow-lg shadow-[#6366F1]/30 hover:-translate-y-0.5 hover:shadow-xl transition">
                            View templates &rarr;
                        </a>
                        <a href="#contact"
                           class="px-7 py-3.5 rounded-full border border-white/25 text-white font-semibold hover:bg-white/10 hover:-translate-y-0.5 transition">
                            Get in touch
                        </a>
                    </div>
                </div>

                <div class="fade-up relative flex justify-center" style="animation-delay:.15s">
                    <div class="relative w-72 h-72">
                        {{-- rotating gradient ring --}}
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-[#8B5CF6] to-[#38BDF8] p-[3px] animate-[spin_10s_linear_infinite]">
                            <div class="w-full h-full rounded-full bg-[#0A0918]"></div>
                        </div>

                        @if ($profile->avatar)
                            <img src="{{ asset('storage/' . $profile->avatar) }}"
                                 class="absolute inset-3 w-[calc(100%-1.5rem)] h-[calc(100%-1.5rem)] rounded-full object-cover"
                                 alt="{{ $profile->name }}">
                        @endif

                        {{-- Floating skill badges. Swap the fallback array below for a real
                             $profile->skills field once you add one in the admin panel. --}}
                        @php
                            $skills = $profile->skills ?? [
                                ['label' => 'Laravel / PHP', 'sub' => 'Backend systems'],
                                ['label' => 'Django / Python', 'sub' => 'Full-stack builds'],
                            ];
                        @endphp

                        @if (!empty($skills[0]))
                            <div class="float-slow absolute -top-2 -left-10 bg-[#12112B]/95 backdrop-blur border border-white/10 rounded-2xl px-4 py-3 shadow-xl">
                                <p class="text-sm font-bold text-white">{{ $skills[0]['label'] }}</p>
                                <p class="text-xs text-gray-400">{{ $skills[0]['sub'] }}</p>
                            </div>
                        @endif

                        @if (!empty($skills[1]))
                            <div class="float-slower absolute bottom-2 -right-14 bg-[#12112B]/95 backdrop-blur border border-white/10 rounded-2xl px-4 py-3 shadow-xl">
                                <p class="text-sm font-bold text-white">{{ $skills[1]['label'] }}</p>
                                <p class="text-xs text-gray-400">{{ $skills[1]['sub'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="relative flex justify-center mt-16">
                <a href="#about"
                   class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center animate-bounce">
                    <span class="text-white">&darr;</span>
                </a>
            </div>
        </section>

        {{-- SOCIAL --}}
        @if (!empty($profile->social_links))
            <section class="max-w-4xl mx-auto px-6 py-14 text-center">
                <span class="inline-block px-3 py-1 rounded-full bg-[#6FA287]/15 text-[#6FA287] text-xs font-bold uppercase tracking-wide mb-3">
                    Let's connect
                </span>
                <h2 class="text-3xl font-extrabold">Find me on social media</h2>
                <p class="text-gray-400 mt-3 max-w-md mx-auto">
                    Follow along for what I'm building, quick tips, and behind-the-scenes.
                </p>

                <div class="flex justify-center gap-3 mt-8 flex-wrap">
                    @foreach ($profile->social_links as $link)
                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#12112B] border border-white/10 shadow-sm hover:-translate-y-0.5 hover:border-white/25 transition">
                            @if (!empty($link['icon']))
                                <img src="{{ asset('storage/' . $link['icon']) }}" alt="" class="w-5 h-5 rounded-full object-cover">
                            @endif
                            <span class="text-sm font-semibold text-white">{{ $link['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ABOUT + STATS --}}
        <section id="about" class="max-w-4xl mx-auto px-6 py-16">
            <div class="bg-[#12112B] rounded-3xl border border-white/8 shadow-sm p-10 sm:p-12 relative overflow-hidden">
                <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-[#8B5CF6]/15 rounded-full blur-2xl"></div>

                <span class="inline-block px-3 py-1 rounded-full bg-[#8B5CF6]/15 text-[#A78BFA] text-xs font-bold uppercase tracking-wide">
                    About me
                </span>
                <p class="relative text-2xl sm:text-3xl font-semibold leading-snug mt-4 mb-10 text-white">
                    {{ $profile->bio ?? 'Add your bio from the admin panel — Portfolio Info section.' }}
                </p>

                <div class="relative grid grid-cols-3 gap-4 pt-8 border-t border-white/8">
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-[#8B5CF6]">{{ $products->count() }}+</p>
                        <p class="text-xs text-gray-400 mt-1 font-medium">Templates</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-[#8B5CF6]">{{ $courses->count() }}+</p>
                        <p class="text-xs text-gray-400 mt-1 font-medium">Classes</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-[#8B5CF6]">{{ $customersCount }}+</p>
                        <p class="text-xs text-gray-400 mt-1 font-medium">Happy customers</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- TEMPLATES --}}
        <section id="templates" class="max-w-5xl mx-auto px-6 py-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-[#8B5CF6]/10 text-[#A78BFA] text-xs font-bold uppercase tracking-wide mb-2">
                        Source code
                    </span>
                    <h2 class="text-3xl font-extrabold text-white">Templates</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#A78BFA] hover:underline">See all &rarr;</a>
            </div>

            @if ($products->isEmpty())
                <p class="text-gray-400">No templates published yet — check back soon.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product) }}"
                           class="group block rounded-2xl border border-white/8 bg-gradient-to-br from-[#161530] to-[#0D0C22] overflow-hidden shadow-sm hover:shadow-lg hover:shadow-[#8B5CF6]/10 hover:-translate-y-1 transition">
                            <div class="aspect-video bg-[#1B1A38] overflow-hidden">
                                @if ($product->preview_image)
                                    <img src="{{ asset('storage/' . $product->preview_image) }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $product->title }}">
                                @endif
                            </div>
                            <div class="p-5">
                                @if ($product->category)
                                    <span class="text-[11px] font-medium text-gray-400">
                                        {{ $product->category }}
                                    </span>
                                @endif
                                <h3 class="font-bold text-white mt-2">{{ $product->title }}</h3>
                                @if (!empty($product->description))
                                    <p class="text-sm text-gray-400 mt-1">{{ $product->description }}</p>
                                @endif
                                <p class="font-extrabold text-white mt-3">&#8358;{{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- CLASSES --}}
        <section id="classes" class="max-w-5xl mx-auto px-6 py-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-[#6FA287]/15 text-[#6FA287] text-xs font-bold uppercase tracking-wide mb-2">
                        Learn with me
                    </span>
                    <h2 class="text-3xl font-extrabold text-white">Live classes</h2>
                </div>
                <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-[#A78BFA] hover:underline">See all &rarr;</a>
            </div>

            @if ($courses->isEmpty())
                <p class="text-gray-400">No classes published yet — check back soon.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <a href="{{ route('courses.show', $course) }}"
                           class="group block rounded-2xl border border-white/8 bg-gradient-to-br from-[#161530] to-[#0D0C22] overflow-hidden shadow-sm hover:shadow-lg hover:shadow-[#8B5CF6]/10 hover:-translate-y-1 transition">
                            <div class="aspect-video bg-[#1B1A38] overflow-hidden relative">
                                @if (!empty($course->image))
                                    <img src="{{ asset('storage/' . $course->image) }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $course->title }}">
                                @endif
                                @if (!empty($course->join_url))
                                    <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-[#8B5CF6] text-white text-[10px] font-bold uppercase tracking-wide">
                                        Live
                                    </span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-white">{{ $course->title }}</h3>
                                <p class="font-extrabold text-white mt-1">
                                    {{ $course->price > 0 ? '₦' . number_format($course->price, 2) : 'Free' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- CONTACT --}}
        <section id="contact" class="max-w-5xl mx-auto px-6 py-16">
            @php
                $supportWhatsApp = $profile->support_whatsapp ?? null;
                $supportEmail = $profile->support_email ?? null;
            @endphp

            <div class="relative rounded-3xl bg-gradient-to-br from-[#7C3AED] to-[#4C1D95] px-8 py-16 sm:px-16 text-center overflow-hidden">
                <div class="absolute -top-10 -left-10 w-56 h-56 bg-white/10 rounded-full blur-3xl float-slow"></div>
                <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-[#38BDF8]/20 rounded-full blur-3xl float-slower"></div>

                <span class="relative inline-block px-3 py-1 rounded-full bg-white/10 text-white text-xs font-bold uppercase tracking-wide mb-3">
                    Have an idea?
                </span>
                <h2 class="relative text-3xl sm:text-4xl font-extrabold text-white">Let's work together.</h2>
                <p class="relative text-white/80 mt-3 max-w-md mx-auto">
                    Projects, classes, and thoughtful collaborations are always welcome.
                </p>

                <div class="relative flex flex-wrap justify-center gap-4 mt-8">
                    @if ($supportWhatsApp)
                        <a href="https://wa.me/{{ $supportWhatsApp }}" target="_blank"
                           class="px-7 py-3.5 rounded-full bg-white text-[#1E1B4B] font-semibold shadow-lg hover:-translate-y-0.5 transition">
                            Chat on WhatsApp &#8599;
                        </a>
                    @endif
                    @if ($supportEmail)
                        <a href="mailto:{{ $supportEmail }}"
                           class="px-7 py-3.5 rounded-full border border-white/30 text-white font-semibold hover:bg-white/10 hover:-translate-y-0.5 transition">
                            Email me
                        </a>
                    @endif
                    @if (!$supportWhatsApp && !$supportEmail)
                        <p class="relative text-white/70 text-sm">Add your WhatsApp number or email in Admin → Portfolio Info.</p>
                    @endif
                </div>

                <div class="relative flex justify-center mt-10">
                    <span class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center animate-bounce">
                        <span class="text-white">&darr;</span>
                    </span>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>