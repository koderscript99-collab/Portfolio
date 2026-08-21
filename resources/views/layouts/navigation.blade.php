<nav x-data="{ open: false }" class="sticky top-4 z-50 mx-4">
    <div class="max-w-6xl mx-auto px-6 h-[64px] flex items-center justify-between bg-white text-[#14131F] rounded-2xl shadow-xl shadow-black/20">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-[15px] whitespace-nowrap">
            <svg class="w-4 h-4 text-[#8B5CF6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
            Portfolio
        </a>

        <div class="hidden md:flex items-center gap-7 text-sm font-medium text-[#4B4A57]">
            <a href="{{ route('products.index') }}" class="hover:text-[#14131F] transition">Templates</a>
            <a href="{{ route('courses.index') }}" class="hover:text-[#14131F] transition">Classes</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-[#14131F] transition">Dashboard</a>
            @endauth
        </div>

        <div class="hidden md:flex items-center gap-3">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-1 text-sm font-semibold text-[#14131F]">
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-[#4B4A57] hover:text-[#14131F]">Log in</a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-[#14131F] text-white text-sm font-semibold hover:bg-black transition whitespace-nowrap">
                    Register
                </a>
            @endauth
        </div>

        <button @click="open = ! open" class="md:hidden p-2 text-[#14131F]">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{ 'hidden': !open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak x-transition class="max-w-6xl mx-auto mt-2 px-2">
        <div class="bg-white text-[#14131F] rounded-2xl shadow-xl shadow-black/20 p-4 space-y-1">
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-black/5">Templates</a>
            <a href="{{ route('courses.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-black/5">Classes</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-black/5">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-black/5">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-black/5">Log Out</a>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-black/5">Log in</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#8B5CF6]">Register</a>
            @endauth
        </div>
    </div>
</nav>