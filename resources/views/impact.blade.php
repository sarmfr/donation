<x-app-layout>
    <div class="relative min-h-screen bg-slate-50 font-sans text-slate-900 selection:bg-green-100 selection:text-green-700 overflow-x-hidden">
        
        <!-- Premium Hero Section -->
        <div class="relative min-h-[60vh] flex items-center pt-20 overflow-hidden bg-slate-900">
            <!-- Background Image with Parallax-like Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/hero_bg.png') }}" class="w-full h-full object-cover opacity-40 scale-110">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/80 to-slate-50"></div>
            </div>

            <!-- Floating Decorative Blobs -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-green-500/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-[120px] animate-pulse delay-1000"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-widest animate-fade-in mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-green-400 animate-ping"></span>
                    The Proof of Your Generosity
                </div>
                <h1 class="text-6xl md:text-8xl font-black tracking-tight mb-8 text-white">
                    Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">Impact.</span>
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-medium">
                    Proof that every contribution counts. Discover the success stories and transformations made possible by the GiveHope community.
                </p>
            </div>
        </div>

        <!-- Success Stories Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32 -mt-16 relative z-10">
            @forelse($closedCampaigns as $campaign)
                <div class="glass rounded-[3rem] shadow-2xl border border-white/40 overflow-hidden mb-16 flex flex-col md:flex-row transition-all hover:border-white/60 group">
                    <!-- Image Half -->
                    <div class="w-full md:w-2/5 relative h-80 md:h-auto overflow-hidden">
                        <img src="{{ $campaign->image_path ? asset($campaign->image_path) : 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop' }}" 
                             alt="{{ $campaign->title }}" 
                             class="absolute inset-0 w-full h-full object-cover transform scale-105 group-hover:scale-100 transition duration-[2s]">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                        <div class="absolute bottom-8 left-8">
                            <span class="inline-flex items-center px-6 py-3 rounded-2xl bg-green-500 text-white text-xs font-black uppercase tracking-widest shadow-2xl border border-green-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Mission Accomplished
                            </span>
                        </div>
                    </div>

                    <!-- Content Half -->
                    <div class="w-full md:w-3/5 p-10 md:p-16">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h2 class="text-4xl font-black text-slate-900 mb-4">{{ $campaign->title }}</h2>
                                <p class="text-slate-500 leading-relaxed text-lg font-medium">{{ $campaign->description }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8 mb-12">
                            <div class="p-6 rounded-3xl bg-white/40 border border-white shadow-sm ring-1 ring-slate-100">
                                <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-2">Total Impact</p>
                                <p class="text-3xl font-black text-slate-900">KES {{ number_format($campaign->totalRaised()) }}</p>
                            </div>
                            <div class="p-6 rounded-3xl bg-white/40 border border-white shadow-sm ring-1 ring-slate-100">
                                <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2">Total Donors</p>
                                <p class="text-3xl font-black text-slate-900">{{ $campaign->donations->count() }}</p>
                            </div>
                        </div>

                        <!-- Milestone Timeline -->
                        <div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3">
                                <span class="w-2 h-6 bg-green-500 rounded-full"></span>
                                Journey to Success
                            </h3>
                            <div class="space-y-8 relative border-l-2 border-slate-100 ml-3">
                                @foreach($campaign->updates as $update)
                                    <div class="relative pl-10">
                                        <div class="absolute left-[-11px] top-0 w-5 h-5 rounded-full bg-white border-4 border-green-500 shadow-sm"></div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ $update->created_at->format('M d, Y') }}</p>
                                        <h4 class="text-xl font-bold text-slate-900 mb-2">{{ $update->title }}</h4>
                                        <p class="text-slate-600 font-medium leading-relaxed">{{ $update->content }}</p>
                                        @if($update->image_path)
                                            <div class="mt-4 rounded-2xl overflow-hidden shadow-lg border border-white/40">
                                                <img src="{{ asset($update->image_path) }}" class="w-full h-auto max-h-64 object-cover">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-32 glass rounded-[3rem] border-2 border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900">First Success Stories Coming Soon</h3>
                    <p class="text-slate-500 mt-3 font-medium">Help us make an impact today by donating to an active campaign.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-10 py-5 mt-10 rounded-2xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition shadow-2xl shadow-slate-900/20">
                        View Active Causes
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
