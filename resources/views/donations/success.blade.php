<x-app-layout>
    <div class="relative min-h-screen flex items-center justify-center pt-20 pb-12 overflow-hidden bg-slate-50">
        <!-- Background Decorations -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-green-200/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-emerald-200/20 rounded-full blur-[120px] animate-pulse delay-1000"></div>
        </div>

        <div class="relative z-10 max-w-2xl mx-auto px-4 w-full text-center">
            <div class="glass rounded-[3rem] p-8 md:p-16 shadow-2xl border border-white/60 bg-white/40 backdrop-blur-2xl animate-fade-in">
                <!-- Success Icon Wrapper -->
                <div class="relative w-32 h-32 mx-auto mb-10">
                    <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-20"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white shadow-2xl shadow-green-500/40">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>

                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                    Thank You for <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">Giving Hope!</span>
                </h1>
                
                <p class="text-xl text-slate-600 mb-10 leading-relaxed font-medium">
                    We've initiated the M-Pesa payment prompt on your phone. Please enter your PIN to complete the donation to <span class="font-bold text-slate-900">{{ $campaign->title ?? 'this cause' }}</span>.
                </p>

                <div class="space-y-4 mb-10">
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/60 rounded-2xl border border-white shadow-sm ring-1 ring-slate-100">
                        <span class="flex h-2 w-2 rounded-full bg-green-500 animate-ping"></span>
                        <span class="text-xs font-black uppercase tracking-widest text-slate-500">Awaiting Confirmation</span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Your generosity is changing lives.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('dashboard') }}" class="py-4 rounded-2xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition shadow-xl shadow-slate-900/20">
                        View My Dashboard
                    </a>
                    <a href="{{ route('home') }}" class="py-4 rounded-2xl bg-white text-slate-900 font-bold border border-slate-200 hover:bg-slate-50 transition">
                        Back to Home
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-12 flex justify-center gap-12 text-slate-400 animate-fade-in delay-500">
                <div class="text-center">
                    <p class="text-2xl font-black text-slate-900">100%</p>
                    <p class="text-[10px] font-black uppercase tracking-widest">Secure</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-slate-900">Live</p>
                    <p class="text-[10px] font-black uppercase tracking-widest">Tracking</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Celebration Script -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const duration = 5 * 1000;
            const end = Date.now() + duration;

            (function frame() {
                confetti({
                    particleCount: 4,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0, y: 0.6 },
                    colors: ['#10b981', '#34d399', '#6ee7b7', '#3b82f6']
                });
                confetti({
                    particleCount: 4,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1, y: 0.6 },
                    colors: ['#10b981', '#34d399', '#6ee7b7', '#3b82f6']
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        });
    </script>
</x-app-layout>
