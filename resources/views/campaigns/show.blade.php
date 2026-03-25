<x-app-layout>
    <x-slot name="header">
        @section('meta')
            <meta name="description" content="{{ Str::limit(strip_tags($campaign->description), 160) }}">
            <meta name="keywords" content="donation, charity, {{ $campaign->title }}, GiveHope, help, community">
            <meta property="og:title" content="{{ $campaign->title }} | {{ config('app.name') }}">
            <meta property="og:description" content="{{ Str::limit(strip_tags($campaign->description), 160) }}">
            <meta property="og:image" content="{{ $campaign->image_path ? asset($campaign->image_path) : 'https://source.unsplash.com/1600x900/?charity' }}">
        @endsection
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="text-xs font-medium text-slate-500 hover:text-green-600 transition">
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="text-xs font-medium text-slate-400">Campaign Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-3xl text-slate-900 leading-tight">
                    {{ $campaign->title }}
                </h2>
            </div>
            @if($campaign->is_verified)
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-bold uppercase tracking-wider">Verified Trusted Cause</span>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Campaign Hero/Image -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Premium Parallax Hero -->
                <div class="relative rounded-[3rem] overflow-hidden shadow-2xl border border-white/20 aspect-[16/9] group">
                    @if($campaign->image_path)
                        <img src="{{ asset($campaign->image_path) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover transform scale-105 group-hover:scale-100 transition duration-[2s]">
                    @else
                        <img src="https://source.unsplash.com/1600x900/?charity,{{ urlencode($campaign->title) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover transform scale-105 group-hover:scale-100 transition duration-[2s]" onerror="this.src='https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'">
                    @endif
                    
                    <!-- Overlays -->
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                    
                    <!-- Content Overlays -->
                    <div class="absolute bottom-10 left-10 right-10 flex flex-wrap items-end justify-between gap-6">
                        @if($campaign->end_date)
                            <div class="bg-white/10 backdrop-blur-xl px-8 py-4 rounded-[2rem] border border-white/20 shadow-2xl animate-float">
                                <p class="text-[10px] font-black text-slate-200 uppercase tracking-widest leading-none mb-2">Campaign Lifeline</p>
                                <p class="text-2xl font-black text-white">{{ \Carbon\Carbon::parse($campaign->end_date)->diffForHumans(null, true) }} left</p>
                            </div>
                        @endif

                        <div class="flex gap-4">
                            @if($campaign->is_verified)
                                <div class="px-6 py-3 bg-emerald-500/90 backdrop-blur-md rounded-2xl text-white flex items-center gap-3 shadow-xl border border-emerald-400">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L9.03 17.159a1.656 1.656 0 002.939 0l6.865-12.26a.73.73 0 00-.618-1.1H2.784a.73.73 0 00-.618 1.1zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-xs font-black uppercase tracking-tighter">Verified Cause</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Story Section -->
                <div class="glass rounded-[2rem] p-8 md:p-12 shadow-xl border border-white/40">
                    <h3 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                        <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                        The Story
                    </h3>
                    <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed font-medium">
                        {!! nl2br(e($campaign->description)) !!}
                    </div>
                </div>

                <!-- Updates Timeline -->
                <div class="space-y-8">
                    <h3 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                        <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
                        Journey Updates
                        <span class="text-sm font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full uppercase">{{ $campaign->updates->count() }}</span>
                    </h3>

                    @forelse($campaign->updates as $update)
                        <div class="relative pl-8 border-l-2 border-slate-200 ml-4 pb-12 last:pb-0">
                            <!-- DOT -->
                            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-amber-500 ring-4 ring-amber-100"></div>
                            
                            <div class="glass rounded-3xl p-6 shadow-lg border border-white/40 group hover:border-amber-200 transition-colors">
                                <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2 block">
                                    {{ $update->created_at->format('M d, Y') }}
                                </span>
                                <h4 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-amber-600 transition">{{ $update->title }}</h4>
                                
                                @if($update->image_path)
                                    <div class="mb-6 rounded-2xl overflow-hidden shadow-md">
                                        <img src="{{ asset($update->image_path) }}" alt="{{ $update->title }}" class="w-full h-auto">
                                    </div>
                                @endif
                                
                                <p class="text-slate-600 leading-loose">
                                    {{ $update->content }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center glass rounded-3xl border border-dashed border-slate-300">
                            <p class="text-slate-400 font-bold">No updates has been posted yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar / Donation Area -->
            <div class="space-y-8">
                <!-- Donation Card -->
                <div class="sticky top-24 glass rounded-[2.5rem] p-8 shadow-2xl border border-white/60 bg-white/40 overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-green-400/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="mb-8">
                            <div class="flex justify-between items-end mb-3">
                                <h4 class="text-4xl font-black text-slate-900">
                                    <span class="text-sm font-bold text-slate-400 uppercase tracking-tighter block mb-1">Raised</span>
                                    KES {{ number_format($campaign->totalRaised()) }}
                                </h4>
                                @if($campaign->goal_amount)
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-slate-400 uppercase tracking-tighter block mb-1">Goal</span>
                                        <span class="text-lg font-bold text-slate-600">KES {{ number_format($campaign->goal_amount) }}</span>
                                    </div>
                                @endif
                            </div>

                            @if($campaign->goal_amount)
                                <div class="w-full bg-slate-200/50 rounded-full h-4 mb-3 overflow-hidden shadow-inner">
                                    @php
                                        $percentage = $campaign->progressPercentage();
                                    @endphp
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-full rounded-full transition-all duration-[2s] ease-out shadow-[0_0_15px_rgba(16,185,129,0.4)]" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <p class="text-xs font-black text-green-600 uppercase tracking-widest text-center">
                                    {{ round($percentage, 1) }}% of target reached
                                </p>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-white/60 p-4 rounded-2xl border border-white/40 text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Supporters</p>
                                <p class="text-xl font-black text-slate-900">{{ $campaign->donations->count() }}</p>
                            </div>
                            <div class="bg-white/60 p-4 rounded-2xl border border-white/40 text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Updates</p>
                                <p class="text-xl font-black text-slate-900">{{ $campaign->updates->count() }}</p>
                            </div>
                        </div>

                        <button onclick="window.openDonateModal({{ $campaign->id }}, '{{ addslashes($campaign->title) }}')" class="w-full py-5 rounded-2xl bg-slate-900 text-white font-bold text-xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 transform hover:-translate-y-1 mb-6 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            Donate Now
                        </button>

                        <!-- Wall of Hope Mini -->
                        <div class="space-y-4 pt-6 border-t border-slate-200">
                            <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                Recent Supporters
                            </h5>
                            <div class="space-y-3">
                                @forelse($campaign->donations->take(5) as $donation)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-white/40 ring-1 ring-slate-100 shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-[10px] font-bold shadow-md">
                                                {{ $donation->is_anonymous ? '?' : substr($donation->user->username ?? $donation->user->name ?? 'D', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800 leading-none">
                                                    {{ $donation->is_anonymous ? 'Anonymous' : ($donation->user->username ?? $donation->user->name ?? 'Hero Donor') }}
                                                </p>
                                                <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $donation->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-black text-green-600">KES {{ number_format($donation->amount) }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <p class="text-xs text-slate-400 italic">Be the first to leave a mark!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reuse the Donation Modal from Welcome -->
    @include('components.donation-modal')

    @push('scripts')
    <script>
        // Make openDonateModal globally available if it's in a component
        window.openDonateModal = function(id, title) {
            if (typeof openDonateModal === 'function') {
                openDonateModal(id, title);
            } else {
                // Fallback if component is not yet implemented or script is separate
                document.getElementById('modal_campaign_id').value = id;
                document.getElementById('modal_campaign_title').innerText = title;
                const modal = document.getElementById('donateModal');
                modal.classList.remove('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>
