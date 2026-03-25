<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
                    Overview
                </a>
                <a href="{{ route('admin.campaigns.create') }}" class="px-6 py-2.5 rounded-xl bg-green-500 text-white font-bold hover:bg-green-600 transition shadow-lg shadow-green-500/20">
                    + New Campaign
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="glass rounded-3xl p-8 shadow-xl border border-white/40 flex items-center gap-6">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 font-bold text-sm uppercase tracking-wider">Total Donations</p>
                <h4 class="text-3xl font-black text-slate-900">KES {{ number_format($stats['total_donations']) }}</h4>
            </div>
        </div>

        <div class="glass rounded-3xl p-8 shadow-xl border border-white/40 flex items-center gap-6">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 font-bold text-sm uppercase tracking-wider">Active Causes</p>
                <h4 class="text-3xl font-black text-slate-900">{{ $stats['active_campaigns'] }}</h4>
            </div>
        </div>

        <div class="glass rounded-3xl p-8 shadow-xl border border-white/40 flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 font-bold text-sm uppercase tracking-wider">Platform Users</p>
                <h4 class="text-3xl font-black text-slate-900">{{ $stats['total_users'] }}</h4>
            </div>
        </div>
    </div>

    <!-- Main Admin Content Area -->
    <div class="glass rounded-[2rem] p-10 shadow-2xl border border-white/40 bg-white/80 overflow-hidden">
        <h3 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
            <div class="w-2 h-8 bg-green-500 rounded-full"></div>
            System Overview & Management
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="space-y-6">
                <a href="{{ route('admin.campaigns.index') }}" class="block p-6 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition cursor-pointer">
                    <h5 class="font-bold text-slate-900 mb-2">Campaign Management</h5>
                    <p class="text-slate-500 text-sm">Create, edit, or close fundraising campaigns. Real-time tracking of goal progress.</p>
                </a>
                <a href="{{ route('admin.donations.index') }}" class="block p-6 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition cursor-pointer text-slate-900">
                    <h5 class="font-bold mb-2">Transaction History</h5>
                    <p class="text-slate-500 text-sm">View all successful M-Pesa donations. Export reports as CSV for accounting.</p>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="block p-6 rounded-2xl bg-slate-900 text-white group hover:bg-slate-800 transition cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        @if($stats['unread_messages'] > 0)
                            <span class="flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                        @endif
                    </div>
                    <h5 class="font-bold mb-1">Incoming Messages</h5>
                    <p class="text-slate-400 text-sm">You have {{ $stats['unread_messages'] }} unread inquiries from the chat interface.</p>
                </a>
            </div>
            
            <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-white min-h-[300px] flex flex-col justify-end shadow-2xl shadow-green-500/20">
                <div class="absolute top-0 right-0 p-8">
                    <div class="w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
                </div>
                <h4 class="text-2xl font-black mb-2 leading-tight">Control Center</h4>
                <p class="text-slate-400 text-sm mb-6 max-w-xs">Use the sidebar and top controls to manage your foundation's impact metrics and user engagement.</p>
                <div class="flex gap-2">
                    <div class="px-3 py-1 bg-white/10 rounded-lg text-xs font-bold uppercase tracking-tighter">Live Status</div>
                    <div class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-xs font-bold uppercase tracking-tighter">API Connected</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
