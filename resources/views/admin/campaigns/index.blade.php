<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Manage Campaigns') }}
            </h2>
            <a href="{{ route('admin.campaigns.create') }}" class="px-6 py-3 rounded-xl bg-green-500 text-white font-bold hover:bg-green-600 transition shadow-lg shadow-green-500/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Campaign
            </a>
        </div>
    </x-slot>

    @if(session('success'))
    <div class="mb-8 p-4 rounded-2xl bg-green-50 border border-green-100 text-green-700 font-bold flex items-center gap-3 glass">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="glass rounded-[2rem] shadow-2xl border border-white/40 bg-white/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-slate-500 font-bold uppercase text-xs tracking-widest">Campaign Details</th>
                        <th class="px-8 py-6 text-slate-500 font-bold uppercase text-xs tracking-widest">Goal Status</th>
                        <th class="px-8 py-6 text-slate-500 font-bold uppercase text-xs tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($campaigns as $campaign)
                    <tr class="hover:bg-green-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex-shrink-0 flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-black text-slate-900 text-lg leading-tight">{{ $campaign->title }}</p>
                                        @if($campaign->is_verified)
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold mt-1 {{ $campaign->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="max-w-[180px]">
                                <div class="flex justify-between text-xs font-bold mb-1">
                                    <span class="text-slate-500">KES {{ number_format($campaign->donations->sum('amount')) }}</span>
                                    <span class="text-green-600">{{ number_format($campaign->goal_amount) }}</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 shadow-inner">
                                    @php
                                        $percent = $campaign->goal_amount > 0 ? ($campaign->donations->sum('amount') / $campaign->goal_amount) * 100 : 0;
                                        $percent = min($percent, 100);
                                    @endphp
                                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-2 rounded-full shadow-md" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Delete this campaign? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <p class="text-slate-400 font-medium">No campaigns found. Start by creating one!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($campaigns->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
            {{ $campaigns->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
