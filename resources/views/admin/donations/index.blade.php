<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-slate-900 leading-tight">
            {{ __('M-Pesa Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass rounded-3xl p-6 shadow-xl border border-white/40">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Volume</p>
                    <p class="text-3xl font-black text-slate-900">KES {{ number_format($globalStats['total_volume']) }}</p>
                    <p class="text-xs text-green-600 font-bold mt-2">Successful Transactions</p>
                </div>
                <div class="glass rounded-3xl p-6 shadow-xl border border-white/40">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pending Requests</p>
                    <p class="text-3xl font-black text-slate-900">{{ $globalStats['pending_count'] }}</p>
                    <p class="text-xs text-amber-600 font-bold mt-2">Awaiting Callback</p>
                </div>
                <div class="glass rounded-3xl p-6 shadow-xl border border-white/40">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Records</p>
                    <p class="text-3xl font-black text-slate-900">{{ $globalStats['total_count'] }}</p>
                    <p class="text-xs text-slate-500 font-bold mt-2">All Statuses</p>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="glass rounded-[2rem] shadow-2xl border border-white/60 bg-white/40 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-900">Transaction History</h3>
                    <a href="{{ route('admin.donations.export') }}" class="px-4 py-2 bg-green-50 text-green-600 border border-green-200 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-green-600 hover:text-white transition">
                        Export to CSV
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">ID</th>
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">Contributor</th>
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">Campaign</th>
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">Amount</th>
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">M-Pesa Ref</th>
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">Status</th>
                                <th class="px-8 py-4 text-slate-500 font-black uppercase text-[10px] tracking-widest">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($donations as $donation)
                            <tr class="hover:bg-white/60 transition-colors group">
                                <td class="px-8 py-5 text-sm font-bold text-slate-400">#{{ $donation->id }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 shadow-inner">
                                            {{ $donation->is_anonymous ? '?' : substr($donation->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 leading-none">
                                                {{ $donation->is_anonymous ? 'Anonymous' : ($donation->user->name ?? 'Guest') }}
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-medium mt-1">{{ $donation->user->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <a href="{{ route('campaigns.show', $donation->campaign) }}" class="text-sm font-bold text-slate-700 hover:text-green-600 transition truncate max-w-[200px] block">
                                        {{ $donation->campaign->title }}
                                    </a>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-black text-slate-900">KES {{ number_format($donation->amount) }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <code class="text-[10px] bg-slate-100 px-2 py-1 rounded-lg text-slate-500 font-mono">
                                        {{ $donation->transaction_reference ?? 'N/A' }}
                                    </code>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                                        {{ $donation->status === 'success' ? 'bg-green-100 text-green-700 border border-green-200' : 
                                           ($donation->status === 'pending' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 
                                           'bg-red-100 text-red-700 border border-red-200') }}">
                                        {{ $donation->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-[11px] text-slate-500 font-bold whitespace-nowrap">
                                    {{ $donation->created_at->format('M d, Y') }}
                                    <span class="block text-[9px] text-slate-300">{{ $donation->created_at->format('H:i A') }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-slate-400 font-bold">No transactions found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($donations->hasPages())
                <div class="px-8 py-6 border-t border-slate-100">
                    {{ $donations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
