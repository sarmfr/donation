<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GiveHope | M-Pesa Donation Platform</title>
        <meta name="description" content="Empowering communities through seamless digital giving. Join Kenya's most transparent giving community and support verified causes instantly via M-Pesa.">
        <meta name="keywords" content="donation, mpesa, charity, kenya, givehope, fundraising">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="GiveHope | M-Pesa Donation Platform">
        <meta property="og:description" content="Empowering communities through seamless digital giving. Support verified causes instantly via M-Pesa.">
        <meta property="og:image" content="{{ asset('images/brand/hero.png') }}">

        <!-- Tailwind CSS (via CDN for local prototyping) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            .glass {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .bg-glass-gradient {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 100%);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            .animate-float { animation: float 6s ease-in-out infinite; }
            .animate-float-delayed { animation: float 8s ease-in-out infinite; animation-delay: 2s; }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-20px); }
            }
            .text-shadow-premium { text-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col">
        
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Premium Hero Section -->
        <div class="relative min-h-[85vh] flex items-center pt-20 overflow-hidden bg-slate-900">
            <!-- Background Image with Parallax-like Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/hero_bg.png') }}" class="w-full h-full object-cover opacity-60 scale-110">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 via-slate-900/60 to-slate-50"></div>
            </div>

            <!-- Floating Decorative Blobs -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-green-500/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-500/20 rounded-full blur-[120px] animate-pulse delay-1000"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-left space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-black uppercase tracking-widest animate-fade-in">
                            <span class="flex h-2 w-2 rounded-full bg-green-400 animate-ping"></span>
                            Trusted by 10k+ Global Donors
                        </div>
                        
                        <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] tracking-tighter text-shadow-premium">
                            Empowering <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">Dreams</span>,<br/> 
                            One Hope at a Time.
                        </h1>
                        
                        <p class="text-lg md:text-xl text-slate-100/80 font-medium max-w-xl leading-relaxed">
                            Join Kenya's most transparent giving community. Support verified causes instantly using seamless M-Pesa integration.
                        </p>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="#campaigns" class="px-8 md:px-10 py-4 md:py-5 rounded-2xl bg-green-500 text-white font-black text-base md:text-lg hover:bg-green-400 transition-all shadow-2xl shadow-green-500/30 transform hover:-translate-y-1 flex items-center gap-3">
                                Start Giving Today
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="{{ route('impact') }}" class="px-8 md:px-10 py-4 md:py-5 rounded-2xl bg-white/20 backdrop-blur-md border border-white/40 text-white font-black text-base md:text-lg hover:bg-white/30 transition-all transform hover:-translate-y-1">
                                Our Impact
                            </a>
                        </div>
                    </div>

                    <!-- Floating Stats Cards -->
                    <div class="hidden lg:block relative h-[500px]">
                        <div class="absolute top-10 right-0 w-64 p-6 rounded-[2rem] bg-glass-gradient animate-float">
                            <p class="text-[10px] font-black text-slate-200 uppercase tracking-widest mb-1">Total Raised</p>
                            <p class="text-3xl font-black text-white">KES {{ number_format($grandTotalRaised / 1000000, 1) }}M+</p>
                            <div class="mt-4 flex -space-x-2">
                                @for($i = 0; $i < min(3, $totalDonorsCount); $i++)
                                    <div class="w-8 h-8 rounded-full bg-green-400 border-2 border-slate-900 shadow-xl"></div>
                                @endfor
                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-800 border-2 border-slate-900 text-[8px] font-bold text-white shadow-xl">+{{ $totalDonorsCount }}</div>
                            </div>
                        </div>

                        <div class="absolute bottom-20 left-10 w-72 p-8 rounded-[2.5rem] bg-glass-gradient animate-float-delayed">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-green-400/20 rounded-2xl">
                                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-white">Verified Causes</h4>
                            </div>
                            <p class="text-sm text-slate-100/70 leading-relaxed font-medium">
                                Every campaign on GiveHope is manually vetted by our team to ensure direct impact.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaigns Grid Section -->
        <div id="campaigns" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 pb-32 flex-grow">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800">Active Causes</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
            </div>

            @if($campaigns->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium tracking-tight text-slate-900">No active campaigns</h3>
                    <p class="mt-1 text-slate-500">Check back later for new causes to support.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($campaigns as $campaign)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 overflow-hidden group flex flex-col">
                            
                            <!-- Campaign Image -->
                            <div class="h-48 w-full bg-slate-200 relative overflow-hidden">
                                @if($campaign->image_path)
                                    <img src="{{ asset($campaign->image_path) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <img src="https://source.unsplash.com/800x600/?charity,{{ urlencode($campaign->title) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                                @endif
                                @if($campaign->end_date)
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-xs font-bold px-3 py-1 text-slate-700 rounded-full shadow-sm z-10">
                                        Ends {{ \Carbon\Carbon::parse($campaign->end_date)->diffForHumans() }}
                                    </div>
                                @endif
                                @if($campaign->is_verified)
                                    <div class="absolute top-4 left-4 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-lg shadow-emerald-500/30 flex items-center gap-1.5 z-10 border border-emerald-400/50">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L9.03 17.159a1.656 1.656 0 002.939 0l6.865-12.26a.73.73 0 00-.618-1.1H2.784a.73.73 0 00-.618 1.1zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Verified Trusted
                                    </div>
                                @endif
                            </div>

                            <div class="p-8 flex-grow flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-black text-slate-900 leading-tight group-hover:text-green-600 transition">{{ $campaign->title }}</h3>
                                    
                                    <!-- Social Share -->
                                    <div class="flex gap-2">
                                        <a href="https://wa.me/?text={{ urlencode('I just supported ' . $campaign->title . ' on HopeWire. Join me in making a difference! ' . route('home')) }}" target="_blank" class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:text-green-500 hover:bg-green-50 transition" title="Share on WhatsApp">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.431 5.63 1.432h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text={{ urlencode('Join me in supporting ' . $campaign->title . ' on HopeWire! Every bit counts. ' . route('home')) }}" target="_blank" class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:text-blue-400 hover:bg-blue-50 transition" title="Share on Twitter">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        </a>
                                        <button onclick="copyCampaignLink('{{ route('home') }}?campaign={{ $campaign->id }}', this)" class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 transition relative" title="Copy Link">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                            <span class="copy-feedback hidden absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] px-2 py-1 rounded">Copied!</span>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-slate-600 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $campaign->description }}</p>

                                <div class="flex items-center gap-3 mb-6">
                                    <a href="{{ route('campaigns.show', $campaign) }}" class="flex-grow py-2.5 rounded-xl border-2 border-slate-100 text-slate-600 font-bold text-xs text-center hover:bg-slate-50 transition">
                                        View Details
                                    </a>
                                </div>

                                <!-- Latest Milestone Update -->
                                @if($campaign->updates->count() > 0)
                                    @php $latestUpdate = $campaign->updates->last(); @endphp
                                    <div class="mb-6 flex items-start gap-3 p-3 rounded-xl bg-amber-50/50 border border-amber-100/50 animate-pulse-slow">
                                        <div class="p-1.5 rounded-lg bg-amber-100 text-amber-600">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.001 0 01-1.564-.317z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none mb-1">Latest Update</p>
                                            <p class="text-xs font-bold text-slate-700 line-clamp-1 italic">"{{ $latestUpdate->title }}"</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm font-medium mb-1">
                                        <span class="text-green-600 font-bold">KES {{ number_format($campaign->totalRaised()) }} raised</span>
                                        @if($campaign->goal_amount)
                                            <span class="text-slate-500">of KES {{ number_format($campaign->goal_amount) }}</span>
                                        @else
                                            <span class="text-blue-500 font-bold uppercase text-[10px] tracking-widest">Open Contribution</span>
                                        @endif
                                    </div>
                                    
                                    @if($campaign->goal_amount)
                                        <div class="w-full bg-slate-100 rounded-full h-2.5 mb-2 overflow-hidden">
                                            @php
                                                $percentage = $campaign->progressPercentage();
                                                $remaining = $campaign->remainingAmount();
                                            @endphp
                                            <div class="progress-bar-fill bg-gradient-to-r from-green-400 to-emerald-500 h-2.5 rounded-full transition-all duration-[1.5s] ease-out shadow-[0_0_10px_rgba(52,211,153,0.5)]" 
                                                 data-target="{{ $percentage }}"
                                                 style="width: 0%"></div>
                                        </div>
                                        @if($remaining > 0)
                                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold text-right">
                                                KES {{ number_format($remaining) }} to go
                                            </p>
                                        @else
                                            <p class="text-[10px] text-green-500 uppercase tracking-widest font-bold text-right italic">
                                                Goal Reached!
                                            </p>
                                        @endif
                                    @else
                                        <div class="pt-2">
                                            <div class="w-full bg-blue-50 py-1 px-3 rounded-lg border border-blue-100/50">
                                                <p class="text-[9px] text-blue-500 font-black uppercase tracking-tighter text-center">Open for all contributions</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Wall of Hope (Top Donors) -->
                                <div class="mb-6 p-4 rounded-xl bg-slate-50/50 border border-slate-100/50">
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-3 flex items-center gap-2">
                                        <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        Wall of Hope - Top Donors
                                    </h4>
                                    <div class="space-y-2">
                                        @forelse($campaign->donations->where('status', '!=', 'failed')->sortByDesc('amount')->take(3) as $donation)
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 rounded-full bg-white border border-slate-100 flex items-center justify-center text-[10px] shadow-sm">
                                                        {{ $donation->is_anonymous ? '?' : substr($donation->user->username ?? $donation->user->name ?? 'D', 0, 1) }}
                                                    </div>
                                                    <span class="text-xs font-bold text-slate-700">
                                                        {{ $donation->is_anonymous ? 'Anonymous Donor' : ($donation->user->username ?? $donation->user->name ?? 'Guest Donor') }}
                                                    </span>
                                                </div>
                                                <span class="text-[10px] font-black text-green-600">KES {{ number_format($donation->amount) }}</span>
                                            </div>
                                        @empty
                                            <p class="text-[10px] text-slate-400 italic">Be the first to donate!</p>
                                        @endforelse
                                    </div>
                                </div>

                                <button onclick="openDonateModal({{ $campaign->id }}, '{{ addslashes($campaign->title) }}')" class="w-full py-3 rounded-xl bg-slate-900 text-white font-semibold flex items-center justify-center gap-2 hover:bg-slate-800 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    Donate via M-Pesa
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Fake Footer -->
        <footer class="relative bg-slate-900 text-slate-400 py-16 text-center overflow-hidden">
            <img src="{{ asset('images/brand/footer.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay">
            <div class="relative z-10 max-w-7xl mx-auto px-4">
                <div class="mb-6">
                    <span class="text-3xl font-black text-white tracking-tighter">GiveHope.</span>
                </div>
                <p class="text-slate-500 font-medium">Empowering communities through seamless digital giving.</p>
                <div class="mt-8 pt-8 border-t border-white/5">
                    <p class="text-xs">&copy; {{ date('Y') }} GiveHope Foundation. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Donation Modal -->
        @include('components.donation-modal')
        <x-chat-icon />
    </body>
</html>
