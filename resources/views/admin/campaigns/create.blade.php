<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.campaigns.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:text-slate-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Create New Campaign') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="glass rounded-[2rem] p-10 shadow-2xl border border-white/40 bg-white/80">
            <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Campaign Owner (Optional)</label>
                        <select name="user_id" class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm bg-white appearance-none">
                            <option value="">-- No Owner (Admin Managed) --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Campaign Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="e.g. Save the Forest Initiative">
                        @error('title') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="5" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="Tell the story of your cause...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Goal Amount (KES)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold">KSh</span>
                            </div>
                            <input type="number" name="goal_amount" value="{{ old('goal_amount') }}" min="1" class="pl-16 w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="e.g. 50000 (Leave blank for no target)">
                        </div>
                        @error('goal_amount') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                        <select name="status" class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm bg-white appearance-none">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-3 h-full pt-8">
                        <input type="checkbox" name="is_verified" value="1" id="is_verified" class="w-6 h-6 rounded-lg text-green-500 border-slate-300 focus:ring-green-500/20 transition cursor-pointer" {{ old('is_verified') ? 'checked' : '' }}>
                        <label for="is_verified" class="text-sm font-bold text-slate-700 cursor-pointer flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L9.03 17.159a1.656 1.656 0 002.939 0l6.865-12.26a.73.73 0 00-.618-1.1H2.784a.73.73 0 00-.618 1.1zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            Verified Trusted Cause
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Campaign Image</label>
                    <div class="relative group">
                        <input type="file" name="image" id="image" class="hidden" onchange="updateFileName(this)">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-green-500 transition cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-slate-400 mb-2 group-hover:text-green-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <p class="text-sm text-slate-500" id="file-name">Click to select an image</p>
                                <p class="text-xs text-slate-400 uppercase tracking-widest mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                            </div>
                        </label>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <script>
                    function updateFileName(input) {
                        const fileName = input.files[0] ? input.files[0].name : 'Click to select an image';
                        document.getElementById('file-name').innerText = fileName;
                    }
                </script>

                <div class="pt-6">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-black text-lg hover:shadow-xl hover:shadow-green-500/30 transform hover:-translate-y-1 transition-all">
                        Launch Campaign
                    </button>
                    <p class="text-center text-slate-400 text-xs mt-4 font-medium uppercase tracking-widest">Authorized Administrative Action</p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
