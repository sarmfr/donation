<nav x-data="{ open: false }" class="glass border-b border-white/20 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">
                        {{ config('site.name') }}.
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 gap-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-green-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-bold leading-5 transition duration-150 ease-in-out">
                            {{ __('Dashboard') }}
                        </a>
                    @endauth

                    <a href="{{ route('impact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('impact') ? 'border-green-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-bold leading-5 transition duration-150 ease-in-out">
                        {{ __('Our Impact') }}
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-green-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-bold leading-5 transition duration-150 ease-in-out">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('admin.campaigns.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.campaigns.*') ? 'border-green-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-bold leading-5 transition duration-150 ease-in-out">
                                {{ __('Campaigns') }}
                            </a>
                            <a href="{{ route('admin.donations.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.donations.*') ? 'border-green-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-bold leading-5 transition duration-150 ease-in-out">
                                {{ __('Transactions') }}
                            </a>
                            <a href="{{ route('admin.withdrawals.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.withdrawals.*') ? 'border-green-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-bold leading-5 transition duration-150 ease-in-out">
                                {{ __('Withdrawals') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <div @click="open = ! open">
                            <button class="inline-flex items-center px-4 py-2 bg-white/50 border border-slate-200 text-sm leading-4 font-bold rounded-xl text-slate-700 hover:text-slate-900 focus:outline-none transition ease-in-out duration-150 glass">
                                <div>{{ Auth::user()->username ?? Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-2 w-48 rounded-2xl shadow-xl glass border border-white/40 ring-1 ring-black ring-opacity-5 py-1"
                                style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-green-50 transition">
                                {{ __('Profile Settings') }}
                            </a>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-green-50 transition">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-slate-900 transition">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-500/20">
                                {{ __('Join Us') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-white/50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50' }} text-base font-bold transition">
                    {{ __('Dashboard') }}
                </a>
            @endauth

            <a href="{{ route('impact') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('impact') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50' }} text-base font-bold transition">
                {{ __('Our Impact') }}
            </a>

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="pt-2 pb-1 border-t border-slate-100 bg-slate-50/50">
                        <p class="ps-3 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Admin Management</p>
                        <a href="{{ route('admin.dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50' }} text-base font-bold transition">
                            {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('admin.campaigns.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('admin.campaigns.*') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50' }} text-base font-bold transition">
                            {{ __('Campaigns') }}
                        </a>
                        <a href="{{ route('admin.donations.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('admin.donations.*') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50' }} text-base font-bold transition">
                            {{ __('Transactions') }}
                        </a>
                        <a href="{{ route('admin.withdrawals.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('admin.withdrawals.*') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50' }} text-base font-bold transition">
                            {{ __('Withdrawals') }}
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/20">
            @auth
                <div class="px-4">
                    <div class="font-bold text-base text-slate-800">{{ Auth::user()->username ?? Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 transition">
                        {{ __('Profile Settings') }}
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 space-y-2">
                    <a href="{{ route('login') }}" class="block text-base font-bold text-slate-600 hover:text-slate-900 transition">{{ __('Log in') }}</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-base font-bold text-green-600 hover:text-green-700 transition">{{ __('Join Us') }}</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
