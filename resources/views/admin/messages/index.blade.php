<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Incoming Messages') }}
            </h2>
            <div class="px-4 py-2 bg-slate-100 rounded-full text-xs font-bold text-slate-500 uppercase tracking-widest">
                {{ $messages->total() }} Total Inquiries
            </div>
        </div>
    </x-slot>

    @if(session('success'))
    <div class="mb-8 p-4 rounded-2xl bg-green-50 border border-green-100 text-green-700 font-bold flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($messages as $message)
            <div class="glass rounded-3xl p-8 shadow-xl border {{ $message->status === 'unread' ? 'border-green-200 bg-green-50/10' : 'border-white/40 bg-white/60' }} transition-all">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold">
                                {{ substr($message->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-lg leading-none">{{ $message->name }}</h4>
                                <p class="text-xs text-slate-500 mt-1 font-medium">{{ $message->email ?? 'No email provided' }} • {{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            @if($message->status === 'unread')
                                <span class="px-2 py-1 bg-green-500 text-white text-[10px] font-black uppercase rounded-md tracking-tighter">New</span>
                            @endif
                        </div>
                        <div class="prose prose-slate prose-sm max-w-none text-slate-600 font-medium bg-white/40 p-6 rounded-2xl border border-white/60">
                            {!! nl2br(e($message->message)) !!}
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-col gap-2 justify-end">
                        @if($message->status === 'unread')
                            <form action="{{ route('messages.read', $message) }}" method="POST">
                                @csrf
                                <button class="w-full px-6 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition shadow-lg">
                                    Mark as Read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-32 text-center glass rounded-3xl border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-bold">No messages received yet.</p>
            </div>
        @endforelse

        @if($messages->hasPages())
            <div class="mt-8">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
