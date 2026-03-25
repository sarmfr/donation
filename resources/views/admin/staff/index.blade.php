<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-slate-900 leading-tight">
                {{ __('Staff Management') }}
            </h2>
            <a href="{{ route('admin.staff.create') }}" class="px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition shadow-xl">
                Add New Staff
            </a>
        </div>
    </x-slot>

    <div class="glass rounded-[2rem] overflow-hidden shadow-2xl border border-white/40 bg-white/80">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-900 text-white">
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest">Name</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest">Email</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest">Joined</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($staff as $member)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-700">{{ $member->name }}</td>
                    <td class="px-8 py-5 text-slate-500">{{ $member->email }}</td>
                    <td class="px-8 py-5 text-sm text-slate-400 font-medium uppercase tracking-tighter">{{ $member->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.staff.edit', $member) }}" class="p-2 rounded-lg bg-slate-100 text-slate-500 hover:text-green-600 hover:bg-green-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            @if($member->id !== auth()->id())
                            <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this staff member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg bg-slate-100 text-slate-500 hover:text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-8 py-6 border-t border-slate-100 italic text-xs text-slate-400 font-bold uppercase tracking-widest">
            Showing {{ $staff->count() }} of {{ $staff->total() }} administrative staff members
        </div>
    </div>
</x-app-layout>
