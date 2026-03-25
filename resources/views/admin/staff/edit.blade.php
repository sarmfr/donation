<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.staff.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:text-slate-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Edit Staff Member') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="glass rounded-[2rem] p-10 shadow-2xl border border-white/40 bg-white/80">
            <form action="{{ route('admin.staff.update', $staff) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $staff->name) }}" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm">
                    @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 italic">Change Password (Leave blank to keep current)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">New Password</label>
                            <input type="password" name="password" class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm">
                            @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 text-white font-black text-lg hover:shadow-xl hover:shadow-slate-500/30 transform hover:-translate-y-1 transition-all">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
