<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.campaigns.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:text-slate-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Edit Campaign') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="glass rounded-[2rem] p-10 shadow-2xl border border-white/40 bg-white/80">
            <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Campaign Owner (Optional)</label>
                        <select name="user_id" class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm bg-white appearance-none">
                            <option value="">-- No Owner (Admin Managed) --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $campaign->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Campaign Title</label>
                        <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="e.g. Save the Forest Initiative">
                        @error('title') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="5" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="Tell the story of your cause...">{{ old('description', $campaign->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="goal_amount" :value="__('Goal Amount (KES)')" />
                        <x-text-input id="goal_amount" name="goal_amount" type="number" class="mt-1 block w-full" :value="old('goal_amount', $campaign->goal_amount)" placeholder="e.g. 50000 (Leave blank for no goal)" />
                        <x-input-error class="mt-2" :messages="$errors->get('goal_amount')" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-1 block w-full rounded-xl border-slate-200 text-slate-700 font-medium focus:ring-green-500 focus:border-green-500 shadow-sm py-3 px-4">
                            <option value="active" {{ old('status', $campaign->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="paused" {{ old('status', $campaign->status) == 'paused' ? 'selected' : '' }}>Paused</option>
                            <option value="closed" {{ old('status', $campaign->status) == 'closed' ? 'selected' : '' }}>Closed (Show Story)</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>
                </div>

                <div class="flex items-center gap-3 py-4">
                    <input type="checkbox" name="is_verified" value="1" id="is_verified" class="w-6 h-6 rounded-lg text-green-500 border-slate-300 focus:ring-green-500/20 transition cursor-pointer" {{ old('is_verified', $campaign->is_verified) ? 'checked' : '' }}>
                    <label for="is_verified" class="text-sm font-bold text-slate-700 cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Verified Trusted Cause
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Campaign Image</label>
                    
                    @if($campaign->image_path)
                    <div class="mb-4 relative w-full h-48 rounded-2xl overflow-hidden shadow-inner border border-slate-100 bg-slate-50">
                        <img src="{{ asset($campaign->image_path) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                            <span class="text-white font-bold bg-black/40 px-4 py-2 rounded-lg backdrop-blur text-xs">Current Image</span>
                        </div>
                    </div>
                    @endif

                    <div class="relative group">
                        <input type="file" name="image" id="image" class="hidden" onchange="updateFileName(this)">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-green-500 transition cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-slate-400 mb-2 group-hover:text-green-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <p class="text-sm text-slate-500" id="file-name">{{ $campaign->image_path ? 'Change Image' : 'Click to select an image' }}</p>
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
                        Save Changes
                    </button>
                    <p class="text-center text-slate-400 text-xs mt-4 font-medium uppercase tracking-widest">Authorized Administrative Action</p>
                </div>
            </form>
        </div>

        <!-- milestone updates section -->
        <div class="mt-12 glass rounded-[2rem] p-10 shadow-2xl border border-white/40 bg-white/80">
            <h3 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                Post Milestone Update
            </h3>

            <form action="{{ route('admin.campaigns.updates.store', $campaign) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Update Title</label>
                    <input type="text" name="title" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="e.g. First 50 Desks Distributed!">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Update Content</label>
                    <textarea name="content" rows="4" required class="w-full rounded-2xl border-slate-200 border px-5 py-4 text-slate-900 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="Tell donors about the impact..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Update Image (Optional)</label>
                    <input type="file" name="update_image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition">
                </div>

                <button type="submit" class="px-8 py-3 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition shadow-lg">
                    Post My Update
                </button>
            </form>

            @if($campaign->updates->count() > 0)
            <div class="mt-10 pt-10 border-t border-slate-100">
                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Recent Updates</h4>
                <div class="space-y-4">
                    @foreach($campaign->updates()->latest()->get() as $update)
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex gap-4">
                        @if($update->image_path)
                        <img src="{{ asset($update->image_path) }}" class="w-20 h-20 rounded-xl object-cover shadow-sm">
                        @endif
                        <div>
                            <p class="font-bold text-slate-900">{{ $update->title }}</p>
                            <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $update->content }}</p>
                            <p class="text-[10px] text-slate-400 mt-2 font-bold">{{ $update->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
