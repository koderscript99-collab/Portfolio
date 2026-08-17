<x-app-layout>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-['JetBrains_Mono'] font-bold text-xl text-[#16181D]">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-[#12141A] min-h-screen py-12">
        <div class="max-w-5xl mx-auto px-6">

            @if (session('error'))
                <div class="bg-[#A63446]/15 border border-[#A63446]/30 text-[#F0A0AC] text-sm p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-[#1F6F50]/15 border border-[#1F6F50]/30 text-[#5EEAD4] text-sm p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('info'))
                <div class="bg-white/5 border border-white/10 text-white/80 text-sm p-4 rounded-lg mb-6">
                    {{ session('info') }}
                </div>
            @endif

            {{-- Quick links --}}
            <div class="grid grid-cols-2 gap-4 mb-10">
                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-4 p-5 rounded-lg border border-white/10 bg-[#1B1E26] hover:border-[#1F6F50] hover:bg-[#1F252E] transition">
                    <span class="shrink-0 w-11 h-11 rounded-lg bg-[#1F6F50]/15 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#5EEAD4]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12h-9m9-3.75h-9m3.75-9h-6.75a2.25 2.25 0 00-2.25 2.25v13.5a2.25 2.25 0 002.25 2.25h11.25a2.25 2.25 0 002.25-2.25V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-white">Templates</p>
                        <p class="text-xs text-white/50">Browse and buy code</p>
                    </div>
                </a>

                <a href="{{ route('courses.index') }}"
                   class="flex items-center gap-4 p-5 rounded-lg border border-white/10 bg-[#1B1E26] hover:border-[#A63446] hover:bg-[#1F252E] transition">
                    <span class="shrink-0 w-11 h-11 rounded-lg bg-[#A63446]/15 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#F0A0AC]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-white">Classes</p>
                        <p class="text-xs text-white/50">Join a live session</p>
                    </div>
                </a>
            </div>

            {{-- Projects --}}
            <div class="mb-10">
                <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-4">// your projects</p>

                @forelse ($projects as $project)
                    <div class="p-5 rounded-lg border border-white/10 bg-[#1B1E26] mb-3">
                        <div class="flex items-baseline justify-between">
                            <p class="font-semibold text-white">{{ $project->name }}</p>
                            <span class="font-['JetBrains_Mono'] text-xs text-white/40">{{ $project->language }}</span>
                        </div>

                        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-white/50">
                            <span>{{ $project->host_type }} — {{ $project->host_provider }}</span>
                            @if ($project->hosting_expiry_date)
                                <span>Hosting expires {{ $project->hosting_expiry_date->format('M d, Y') }}</span>
                            @endif
                            @if ($project->database_expiry_date)
                                <span>DB expires {{ $project->database_expiry_date->format('M d, Y') }}</span>
                            @endif
                        </div>

                        @if ($project->url)
                            <a href="{{ $project->url }}" target="_blank" class="text-sm text-[#5EEAD4] hover:underline mt-1 inline-block">
                                {{ $project->url }}
                            </a>
                        @endif

                        <div class="w-full bg-white/10 rounded-full h-2 mt-3">
                            <div
                                class="h-2 rounded-full {{ $project->progress >= 100 ? 'bg-[#1F6F50]' : ($project->progress >= 50 ? 'bg-[#C99A3B]' : 'bg-[#A63446]') }}"
                                style="width: {{ $project->progress }}%"
                            ></div>
                        </div>
                        <p class="font-['JetBrains_Mono'] text-xs text-white/40 mt-1">{{ $project->progress }}% complete</p>
                    </div>
                @empty
                    <p class="text-sm text-white/50">No projects assigned yet.</p>
                @endforelse
            </div>

            {{-- Scripts --}}
            <div>
                <p class="font-['JetBrains_Mono'] text-xs text-[#F0A0AC] tracking-widest uppercase mb-4">// your scripts</p>

                @forelse ($scripts as $script)
                    <div class="p-5 rounded-lg border border-white/10 bg-[#1B1E26] mb-3">
                        <p class="font-semibold text-white">{{ $script->title }}</p>
                        @if ($script->description)
                            <p class="text-sm text-white/50 mt-1">{{ $script->description }}</p>
                        @endif

                        <div class="flex items-center justify-between mt-3">
                            <span class="font-['JetBrains_Mono'] text-[#5EEAD4] font-bold">
                                ₦{{ number_format($script->amount, 2) }}
                            </span>
                            <span class="text-xs font-['JetBrains_Mono'] uppercase tracking-wide text-white/40">
                                {{ ucfirst($script->status) }}
                            </span>
                        </div>

                        @if ($script->status === 'pending')
                            <form action="{{ route('scripts.checkout.start', $script) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2 rounded-md bg-[#1F6F50] text-white text-sm font-medium hover:bg-[#195A41] transition">
                                    Pay Now
                                </button>
                            </form>
                        @elseif ($script->status === 'paid')
                            <p class="text-sm text-white/50 mt-3">Payment confirmed — waiting on admin to release your file.</p>
                        @elseif ($script->isReleased())
                            <a href="{{ route('scripts.download', $script) }}"
                               class="inline-block mt-3 px-4 py-2 rounded-md border border-white/10 bg-transparent text-white text-sm font-medium hover:border-[#1F6F50] transition">
                                Download
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-white/50">No scripts assigned yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>