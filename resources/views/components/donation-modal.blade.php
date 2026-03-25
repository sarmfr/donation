<!-- Donation Modal -->
<div id="donateModal" class="fixed inset-0 z-50 flex items-center justify-center hidden" x-data="{ open: false }">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeDonateModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0 duration-300">
        <button onclick="closeDonateModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900">Make a Donation</h3>
            <p class="text-slate-500 mt-1 text-sm" id="modal_campaign_title">Supporting Campaign</p>
        </div>

        <form action="{{ route('donate') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="campaign_id" id="modal_campaign_id">
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Amount (KES)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm font-semibold">KSh</span>
                    </div>
                    <input type="number" name="amount" required min="10" class="pl-14 w-full rounded-xl border-slate-200 border px-4 py-3 text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" placeholder="1000">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" required 
                    value="{{ auth()->check() ? auth()->user()->email : '' }}"
                    class="w-full rounded-xl border-slate-200 border px-4 py-3 text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="your@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">M-Pesa Number</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-400 font-bold text-xs">+254</span>
                    </div>
                    <input type="text" name="phone" id="modal_phone" required 
                        value="{{ auth()->check() ? (str_starts_with(auth()->user()->mpesa_number, '254') ? substr(auth()->user()->mpesa_number, 3) : auth()->user()->mpesa_number) : '' }}"
                        class="pl-12 w-full rounded-xl border-slate-200 border px-4 py-3 text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition shadow-sm" placeholder="7XXXXXXXX">
                </div>
            </div>
            
            <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl border border-slate-100">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" 
                    {{ (auth()->check() && auth()->user()->default_anonymous) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-green-600 focus:ring-green-500 border-slate-300 transition cursor-pointer">
                <label for="is_anonymous" class="text-xs font-semibold text-slate-600 cursor-pointer">Donate Anonymously</label>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-lg hover:shadow-lg hover:shadow-green-500/30 transform hover:-translate-y-0.5 transition-all mt-4">
                Send via M-Pesa Integration
            </button>
            <p class="text-xs text-center text-slate-400 mt-3 flex items-center justify-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Secure payment processing
            </p>
        </form>
    </div>
</div>

<script>
function openDonateModal(campaignId, title) {
    document.getElementById('modal_campaign_id').value = campaignId;
    document.getElementById('modal_campaign_title').innerText = title;
    const modal = document.getElementById('donateModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
    }, 10);
}

function closeDonateModal() {
    const modal = document.getElementById('donateModal');
    modal.querySelector('.bg-white').classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}
</script>
