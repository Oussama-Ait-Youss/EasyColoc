@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Membres du Collectif</h2>
            <p class="text-sm text-gray-500 mt-1">Opérateurs actifs au sein de la colocation : <span class="text-gray-900 font-semibold">{{ $colocation->name }}</span></p>
        </div>
        <a href="{{ route('invitations.index') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-gray-200">
            + Recruter un membre
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($members as $member)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
                
                <div class="h-1 w-full {{ $member->pivot->role === 'owner' ? 'bg-amber-400' : 'bg-emerald-500' }}"></div>

                <div class="p-6 space-y-6 flex-1">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-full bg-[#F9FAFB] border border-gray-200 flex items-center justify-center text-sm font-black text-gray-400">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-tight">{{ $member->name }}</h2>
                                <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest {{ $member->pivot->role === 'owner' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                    {{ $member->pivot->role }}
                                </span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Réputation</span>
                            <span class="text-lg font-black font-mono {{ $member->pivot->reputation >= 80 ? 'text-emerald-500' : 'text-amber-500' }}">
                                {{ $member->pivot->reputation }}%
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">ID Système</span>
                            <span class="text-[10px] font-mono text-gray-600">#USR-0{{ $member->id }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Activation</span>
                            <span class="text-[10px] text-gray-600 font-medium italic">{{ \Carbon\Carbon::parse($member->pivot->joined_at)->format('Y-m-d') }}</span>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->id !== $member->id && auth()->user()->activeColocation()->pivot->role === 'owner')
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-50 text-right">
                        <form action="{{ route('memberships.destroy', $member->pivot->id ?? $member->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-300 hover:text-red-500 transition-colors" 
                                    onclick="return confirm('Confirmer la révocation des accès pour ce membre ?')">
                                Révoquer l'accès
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection