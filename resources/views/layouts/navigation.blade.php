<nav x-data="{ open: false }" class="bg-[#FAF9F6] border-b border-black/10">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="font-['JetBrains_Mono'] font-bold text-[#16181D]">
                    &gt;_
                </a>

                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('products.index') }}"
                       class="text-sm font-medium {{ request()->routeIs('products.*') ? 'text-[#1F6F50]' : 'text-[#6B7280] hover:text-[#16181D]' }}">
                        Templates
                    </a>
                    <a href="{{ route('courses.index') }}"
                       class="text-sm font-medium {{ request()->routeIs('courses.*') ? 'text-[#1F6F50]' : 'text-[#6B7280] hover:text-[#16181D]' }}">
                        Classes
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-[#1F6F50]' : 'text-[#6B7280] hover:text-[#16181D]' }}">
                            Dashboard
                        </a>
                    @endauth
                </div>
            </div>

            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-[#16181D] hover:text-[#1F6F50] transition">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6 gap-5">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-[#6B7280] hover:text-[#16181D]">Log in</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 rounded-md bg-[#1F6F50] text-white text-sm font-medium hover:bg-[#195A41] transition">
                        Register
                    </a>
                </div>
            @endauth

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-[#6B7280]">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-black/10">
        <div class="pt-2 pb-3 space-y-1 px-6">
            <a href="{{ route('products.index') }}" class="block py-2 text-sm font-medium text-[#16181D]">Templates</a>
            <a href="{{ route('courses.index') }}" class="block py-2 text-sm font-medium text-[#16181D]">Classes</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block py-2 text-sm font-medium text-[#16181D]">Dashboard</a>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-black/10 px-6">
                <div class="font-medium text-sm text-[#16181D]">{{ Auth::user()->name }}</div>
                <div class="text-sm text-[#6B7280]">{{ Auth::user()->email }}</div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block py-1 text-sm text-[#6B7280]">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="block py-1 text-sm text-[#6B7280]">Log Out</a>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-black/10 px-6 space-y-1">
                <a href="{{ route('login') }}" class="block py-1 text-sm text-[#6B7280]">Log in</a>
                <a href="{{ route('register') }}" class="block py-1 text-sm text-[#1F6F50] font-medium">Register</a>
            </div>
        @endauth
    </div>
</nav>