<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('My Withdrawals') }}
            </h2>
            <div class="text-sm font-bold text-slate-400 uppercase tracking-widest">
                Manage your campaign funds
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold flex items-center gap-3 animate-fade-in">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold flex items-center gap-3 animate-fade-in">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Campaign Balances -->
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                        Active Campaign Balances
                    </h3>

                    @forelse($campaigns as $campaign)
                        <div class="glass rounded-[2rem] p-8 shadow-xl border border-white/40 bg-white/40 overflow-hidden relative group transition-all hover:border-green-200">
                            <div class="relative z-10">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                    <div>
                                        <h4 class="text-2xl font-black text-slate-900 mb-2">{{ $campaign->title }}</h4>
                                        <div class="flex items-center gap-4">
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Raised</span>
                                                <span class="text-lg font-bold text-slate-700">KES {{ number_format($campaign->totalRaised()) }}</span>
                                            </div>
                                            <div class="w-px h-8 bg-slate-200"></div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-black text-green-600 uppercase tracking-widest">Available for Payout</span>
                                                <span class="text-lg font-black text-green-600">KES {{ number_format($campaign->payoutBalance()) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($campaign->payoutBalance() >= 10)
                                        <button onclick="document.getElementById('withdrawal_form_{{ $campaign->id }}').classList.toggle('hidden')" class="px-8 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 whitespace-nowrap">
                                            Request Withdrawal
                                        </button>
                                    @else
                                        <button disabled class="px-8 py-4 bg-slate-100 text-slate-400 font-bold rounded-2xl cursor-not-allowed">
                                            Balance Too Low
                                        </button>
                                    @endif
                                </div>

                                <!-- Withdrawal Form (Hidden by default) -->
                                <div id="withdrawal_form_{{ $campaign->id }}" class="hidden mt-8 pt-8 border-t border-slate-100">
                                    <form action="{{ route('campaigns.withdraw.request', $campaign) }}" method="POST" class="space-y-6 max-w-lg">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Amount to Withdraw</label>
                                                <div class="relative">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">KES</span>
                                                    <input type="number" name="amount" value="{{ $campaign->payoutBalance() }}" max="{{ $campaign->payoutBalance() }}" min="10" required 
                                                        class="w-full pl-12 pr-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Recipient M-Pesa Number</label>
                                                <input type="text" name="phone" value="{{ auth()->user()->mpesa_number }}" placeholder="2547XXXXXXXX" required 
                                                    class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Remarks / Purpose</label>
                                            <input type="text" name="remarks" placeholder="e.g. Hospital bill payment" 
                                                class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900">
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit" class="px-10 py-4 bg-green-600 text-white font-bold rounded-2xl hover:bg-green-700 transition shadow-lg shadow-green-600/20">
                                                Submit Request
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center glass rounded-3xl border border-dashed border-slate-300">
                            <p class="text-slate-400 font-bold">You don't have any campaigns with available balances yet.</p>
                        </div>
                    @endforelse
                </div>

                <!-- History Sidebar -->
                <div class="space-y-6">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
                        Recent Payouts
                    </h3>

                    <div class="glass rounded-[2rem] p-6 shadow-xl border border-white/40 bg-white/40 space-y-4">
                        @php
                            $allWithdrawals = $campaigns->pluck('withdrawals')->flatten()->sortByDesc('created_at')->take(10);
                        @endphp

                        @forelse($allWithdrawals as $withdrawal)
                            <div class="p-4 rounded-2xl bg-white/60 border border-white/80 shadow-sm flex items-center justify-between group">
                                <div>
                                    <p class="text-xs font-bold text-slate-900 leading-none mb-1">{{ $withdrawal->campaign->title }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $withdrawal->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-slate-900">KES {{ number_format($withdrawal->amount) }}</p>
                                    <span class="text-[9px] font-black uppercase tracking-tighter {{ $withdrawal->status === 'paid' ? 'text-green-600' : ($withdrawal->status === 'pending' ? 'text-amber-600' : 'text-red-600') }}">
                                        {{ $withdrawal->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-xs text-slate-400 italic">No payout history yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-6 bg-slate-900 rounded-[2rem] text-white shadow-2xl relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-green-500/20 rounded-full blur-3xl"></div>
                        <h4 class="text-lg font-bold mb-2">Need help?</h4>
                        <p class="text-xs text-slate-400 leading-relaxed mb-4">Payouts are typically processed within 24 hours of approval. If you have any issues, please contact support.</p>
                        <a href="mailto:support@givehope.org" class="inline-flex text-xs font-black uppercase tracking-widest text-green-400 hover:text-green-300 transition">Contact Support →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
