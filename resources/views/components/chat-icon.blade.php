<div x-data="{ open: false, sent: false, name: '', email: '', message: '' }" class="fixed bottom-8 right-8 z-[100]">
    <!-- Chat Button -->
    <button @click="open = !open" 
            class="group relative flex items-center justify-center w-16 h-16 rounded-full bg-slate-900 text-white shadow-2xl hover:shadow-green-500/20 hover:scale-110 active:scale-95 transition-all duration-300 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-green-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        <!-- Icon -->
        <svg x-show="!open" x-transition:enter="transition duration-300" x-transition:enter-start="rotate-90 opacity-0" x-transition:enter-end="rotate-0 opacity-100"
             class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        
        <!-- Close Icon -->
        <svg x-show="open" x-transition:enter="transition duration-300" x-transition:enter-start="-rotate-90 opacity-0" x-transition:enter-end="rotate-0 opacity-100"
             class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>

        <!-- Notification Dot -->
        <span class="absolute top-4 right-4 flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
        </span>
    </button>

    <!-- Chat Panel -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="absolute bottom-20 right-0 w-[380px] max-w-[calc(100vw-2rem)] glass rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-white/40 overflow-hidden"
         style="display: none;">
        
        <!-- Header -->
        <div class="bg-slate-900 p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
            <h3 class="text-xl font-black mb-1 leading-tight">Hello there! 👋</h3>
            <p class="text-slate-400 text-sm font-medium">How can we help you today?</p>
        </div>

        <!-- Content -->
        <div class="p-8 space-y-4 max-h-[400px] overflow-y-auto bg-white/50">
            <div class="space-y-4">
                <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition cursor-pointer group">
                    <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-1">Support</p>
                    <h4 class="font-bold text-slate-800 group-hover:text-green-600 transition">Chat with an expert</h4>
                    <p class="text-xs text-slate-500 mt-1">Our team is typically online.</p>
                </div>
                
                <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition cursor-pointer group">
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Help Center</p>
                    <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition">Browse our FAQs</h4>
                    <p class="text-xs text-slate-500 mt-1">Find quick answers to common questions.</p>
                </div>
            </div>

            <!-- Contact Form Mini -->
            <template x-if="!sent">
                <form action="{{ route('contact.store') }}" method="POST" @submit.prevent="
                    fetch('{{ route('contact.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name: name, email: email, message: message })
                    }).then(() => sent = true)
                " class="space-y-4 pt-4 border-t border-slate-100">
                    <input type="text" x-model="name" required placeholder="Your Name" class="w-full rounded-xl border-slate-100 bg-white/80 text-sm py-3 px-4 focus:ring-green-500/20 focus:border-green-500 transition">
                    <input type="email" x-model="email" placeholder="Your Email (Optional)" class="w-full rounded-xl border-slate-100 bg-white/80 text-sm py-3 px-4 focus:ring-green-500/20 focus:border-green-500 transition">
                    <textarea x-model="message" required placeholder="How can we help?" rows="3" class="w-full rounded-xl border-slate-100 bg-white/80 text-sm py-3 px-4 focus:ring-green-500/20 focus:border-green-500 transition"></textarea>
                    <button type="submit" class="w-full py-3 bg-green-500 text-white text-sm font-black rounded-xl hover:bg-green-600 transition shadow-lg shadow-green-500/20">
                        Send Message
                    </button>
                </form>
            </template>
            <template x-if="sent">
                <div class="pt-8 pb-4 text-center animate-fade-in">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h4 class="font-bold text-slate-900">Message Sent!</h4>
                    <p class="text-xs text-slate-500 mt-2">We've received your inquiry and will get back to you shortly.</p>
                    <button @click="sent = false; name = ''; email = ''; message = ''" class="mt-6 text-xs font-black text-green-600 uppercase tracking-widest hover:text-green-700 transition">Send another</button>
                </div>
            </template>
        </div>

        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Typically responds in under an hour</p>
        </div>
    </div>
</div>
