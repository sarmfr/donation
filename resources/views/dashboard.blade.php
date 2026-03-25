<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-slate-900 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Welcome Card -->
        <div class="lg:col-span-3 glass rounded-3xl p-8 shadow-xl border border-white/40">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-500/30">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-slate-600 mt-1">You're logged into your GiveHope account. Ready to make a difference today?</p>
                </div>
            </div>
        </div>

        <!-- Stats Shortcut -->
        <div class="glass rounded-3xl p-6 shadow-lg border border-white/40 group hover:scale-[1.02] transition-transform">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-900">KES {{ number_format(Auth::user()->totalDonationsAmount()) }}</h4>
            <p class="text-slate-500 text-sm mt-1">Total amount you've donated to help others.</p>
        </div>

        <div class="glass rounded-3xl p-6 shadow-lg border border-white/40 group hover:scale-[1.02] transition-transform">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-900">Favorite Causes</h4>
            <p class="text-slate-500 text-sm mt-1">Manage the campaigns you follow.</p>
        </div>

        <div class="glass rounded-3xl p-6 shadow-lg border border-white/40 group hover:scale-[1.02] transition-transform">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-900">{{ $donations->count() }} Contributions</h4>
            <p class="text-slate-500 text-sm mt-1">Number of times you've stepped up to give hope.</p>
        </div>

        <!-- Donation History Table -->
        <div class="lg:col-span-3 glass rounded-3xl shadow-xl border border-white/40 bg-white/60 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-900">Donation History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-slate-500 font-bold uppercase text-xs tracking-widest">Cause</th>
                            <th class="px-8 py-4 text-slate-500 font-bold uppercase text-xs tracking-widest">Amount</th>
                            <th class="px-8 py-4 text-slate-500 font-bold uppercase text-xs tracking-widest">Date</th>
                            <th class="px-8 py-4 text-slate-500 font-bold uppercase text-xs tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($donations as $donation)
                        <tr class="hover:bg-white/50 transition-colors">
                            <td class="px-8 py-5">
                                <p class="font-bold text-slate-900 leading-none">{{ $donation->campaign->title }}</p>
                                @if($donation->is_anonymous)
                                    <span class="text-[10px] text-slate-400 uppercase font-black tracking-tighter mt-1 block">Anonymous Contribution</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-green-600 font-black">KES {{ number_format($donation->amount) }}</span>
                            </td>
                            <td class="px-8 py-5 text-slate-500 text-sm">
                                {{ $donation->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $donation->status === 'success' ? 'bg-green-100 text-green-700' : ($donation->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-medium">
                                You haven't made any donations yet. 
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Celebration Script -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                const duration = 3 * 1000;
                const end = Date.now() + duration;

                (function frame() {
                    confetti({
                        particleCount: 3,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0 },
                        colors: ['#10b981', '#34d399', '#6ee7b7']
                    });
                    confetti({
                        particleCount: 3,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1 },
                        colors: ['#10b981', '#34d399', '#6ee7b7']
                    });

                    if (Date.now() < end) {
                        requestAnimationFrame(frame);
                    }
                }());
            @endif
        });
    </script>
</x-app-layout>
