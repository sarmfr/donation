<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
            <p class="text-sm text-slate-500 mt-1">Please enter your details to sign in.</p>
        </div>

        <!-- Email Address -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1" for="email">{{ __('Email Address') }}</label>
            <input id="email" class="w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1" for="password">{{ __('Password') }}</label>
            <input id="password" class="w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-500 shadow-sm focus:ring-green-500" name="remember">
                <span class="ms-2 text-sm text-slate-600 font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-700 font-medium transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-lg hover:shadow-lg hover:shadow-green-500/30 transform hover:-translate-y-0.5 transition-all">
                {{ __('Sign In') }}
            </button>
        </div>
        
        <p class="text-center text-sm text-slate-600 mt-6 font-medium">
            Don't have an account? <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-bold transition">Sign up</a>
        </p>
    </form>
</x-guest-layout>
