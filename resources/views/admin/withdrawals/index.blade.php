<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Withdrawal Requests') }}
            </h2>
            <div class="flex gap-4">
                <div class="glass px-6 py-3 rounded-2xl border border-white/40">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Payouts</p>
                    <p class="text-xl font-black text-green-600">KES {{ number_format(\App\Models\Withdrawal::where('status', 'completed')->sum('amount')) }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 border border-green-100 text-green-700 font-bold flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700 font-bold flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Admin: Create New Withdrawal --}}
        <div x-data="{ open: false }" class="glass rounded-[2rem] border border-white/40 bg-white/60 shadow-xl overflow-hidden">
            <button @click="open = !open" class="w-full flex items-center justify-between px-8 py-5 text-left group">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                    <span class="font-black text-slate-900 text-lg">New Withdrawal Request</span>
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-transition class="border-t border-slate-100 px-8 py-8">
                <form action="{{ route('admin.withdrawals.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Campaign</label>
                        <select name="campaign_id" required class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900 bg-white">
                            <option value="">— Select Campaign —</option>
                            @foreach($campaigns as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Amount (KES)</label>
                        <input type="number" name="amount" min="10" required placeholder="e.g. 5000"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Recipient M-Pesa (254…)</label>
                        <input type="text" name="recipient_phone" required placeholder="254712345678"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Remarks</label>
                        <input type="text" name="remarks" placeholder="Optional note"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-green-500 focus:ring-green-500 font-bold text-slate-900">
                    </div>
                    <div class="md:col-span-2 lg:col-span-4 flex justify-end">
                        <button type="submit" class="px-10 py-4 bg-green-600 text-white font-black rounded-2xl hover:bg-green-700 transition shadow-lg shadow-green-600/20">
                            Create Withdrawal Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="glass rounded-[2.5rem] shadow-xl border border-white/40 bg-white/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-slate-500 font-black uppercase text-xs tracking-widest">Campaign</th>
                            <th class="px-8 py-6 text-slate-500 font-black uppercase text-xs tracking-widest">Amount</th>
                            <th class="px-8 py-6 text-slate-500 font-black uppercase text-xs tracking-widest">Recipient</th>
                            <th class="px-8 py-6 text-slate-500 font-black uppercase text-xs tracking-widest">Status</th>
                            <th class="px-8 py-6 text-slate-500 font-black uppercase text-xs tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($withdrawals as $withdrawal)
                        <tr class="hover:bg-white/50 transition-colors">
                            <td class="px-8 py-6">
                                <p class="font-black text-slate-900 leading-tight">{{ $withdrawal->campaign->title }}</p>
                                <p class="text-[10px] text-slate-400 uppercase font-bold mt-1">Ref: {{ $withdrawal->mpesa_reference ?? 'N/A' }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-slate-900 font-black text-lg">KES {{ number_format($withdrawal->amount) }}</span>
                            </td>
                            <td class="px-8 py-6 text-slate-600 font-medium">
                                {{ $withdrawal->recipient_phone }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    @if($withdrawal->status === 'completed') bg-green-100 text-green-700 
                                    @elseif($withdrawal->status === 'pending') bg-amber-100 text-amber-700 
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ $withdrawal->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($withdrawal->status === 'pending')
                                    <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" onsubmit="return confirm('Initiate M-Pesa B2C payout for KES {{ number_format($withdrawal->amount) }}?')">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
                                            Approve Payout
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-300 text-[10px] font-black uppercase tracking-widest">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold italic">No withdrawal requests found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($withdrawals->hasPages())
                <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
