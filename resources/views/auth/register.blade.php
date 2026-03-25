<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Create Account</h2>
            <p class="text-sm text-slate-500 mt-1">Join us and start making a difference.</p>
        </div>

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1" for="name">{{ __('Full Name') }}</label>
            <input id="name" class="w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1" for="email">{{ __('Email Address') }}</label>
            <input id="email" class="w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1" for="password">{{ __('Password') }}</label>
            <input id="password" class="w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-lg hover:shadow-lg hover:shadow-green-500/30 transform hover:-translate-y-0.5 transition-all">
                {{ __('Create Account') }}
            </button>
        </div>
        
        <p class="text-center text-sm text-slate-600 mt-6 font-medium">
            Already registered? <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-bold transition">Sign in</a>
        </p>

    </form>
</x-guest-layout>
