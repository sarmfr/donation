<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 border-l-4 border-green-500 pl-3">
            {{ __('Donation Preferences') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Manage your M-Pesa details and default anonymity settings for faster, safer giving.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- hidden fields to keep the rest of the profile intact since Breeze fill() is used -->
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="username" value="{{ $user->username }}">

        <div>
            <x-input-label for="mpesa_number" :value="__('Default M-Pesa Number')" />
            <x-text-input id="mpesa_number" name="mpesa_number" type="text" class="mt-1 block w-full" :value="old('mpesa_number', $user->mpesa_number)" placeholder="2547XXXXXXXX" />
            <p class="mt-1 text-[10px] text-slate-400 font-medium italic">Format: 254 followed by 9 digits</p>
            <x-input-error class="mt-2" :messages="$errors->get('mpesa_number')" />
        </div>

        <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
            <input type="checkbox" name="default_anonymous" id="default_anonymous" value="1" {{ old('default_anonymous', $user->default_anonymous) ? 'checked' : '' }} class="w-5 h-5 rounded text-green-600 focus:ring-green-500 border-slate-300 transition">
            <label for="default_anonymous" class="text-sm font-semibold text-slate-700 cursor-pointer">
                {{ __('Always donate anonymously by default') }}
            </label>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="bg-slate-900 hover:bg-slate-800">{{ __('Save Preferences') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 font-bold text-green-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
