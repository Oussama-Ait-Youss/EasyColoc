@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Remboursement</h2>
            <p class="text-sm text-gray-500 mt-1">Enregistrez une réception de fonds pour équilibrer les balances.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            Transaction Ledger
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Détails du flux entrant</h3>
        </div>

        <form action="{{ route('payments.store') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            <input type="hidden" name="colocation_id" value="{{ auth()->user()->activeColocation()->id }}">

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Montant perçu (DH)</label>
                <div class="relative">
                    <input type="number" name="amount" step="0.01" required
                        class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 pl-10 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-gray-300 @error('amount') border-red-400 @enderror"
                        placeholder="0.00">
                    <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold italic">DH</span>
                </div>
                @error('amount') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Source du remboursement</label>
                <select name="from_user_id" required
                    class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('from_user_id') border-red-400 @enderror">
                    <option value="">-- Sélectionner l'émetteur --</option>
                    @foreach(auth()->user()->activeColocation()->users as $member)
                        @if($member->id !== auth()->id())
                            <option value="{{ $member->id }}">{{ strtoupper($member->name) }}</option>
                        @endif
                    @endforeach
                </select>
                @error('from_user_id') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }} @enderror
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-between items-center">
                <a href="{{ route('payments.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">
                    Annuler l'opération
                </a>
                <button type="submit" 
                    class="bg-gray-900 text-white px-10 py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-gray-200">
                    Marque paye
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center space-x-3 p-4 bg-gray-50 border border-gray-100 rounded-lg">
        <span class="text-emerald-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </span>
        <p class="text-[9px] text-gray-400 uppercase tracking-wider leading-relaxed">
            Cette action est irréversible. Une fois validée, la balance de l'émetteur sera créditée et la vôtre sera débitée en conséquence dans le registre global.
        </p>
    </div>
</div>
@endsection