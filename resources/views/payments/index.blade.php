@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Journal des Flux</h2>
            <p class="text-sm text-gray-500 mt-1">Traçabilité des remboursements effectués entre les membres.</p>
        </div>
        <a href="{{ route('payments.create') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-gray-200">
            + Enregistrer un flux
        </a>
    </div>

    <div class="flex space-x-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
        <span class="text-emerald-500 border-b-2 border-emerald-500 pb-1 cursor-pointer">Historique Global</span>
        <span class="hover:text-gray-600 cursor-pointer transition-colors">Mes Reçus</span>
        <span class="hover:text-gray-600 cursor-pointer transition-colors">Mes Envois</span>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Horodatage</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 text-center">Transfert de fonds</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 text-right">Valeur</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 text-right">Contrôle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($payments as $payment)
                    <tr class="group hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-5 text-gray-400 font-medium text-xs font-mono">
                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d H:i') }}
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center space-x-6">
                                <div class="flex flex-col items-center">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Source</span>
                                    <span class="font-bold text-gray-700">{{ strtoupper($payment->fromUser->name) }}</span>
                                </div>
                                
                                <div class="flex flex-col items-center">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>

                                <div class="flex flex-col items-center">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Cible</span>
                                    <span class="font-bold text-gray-700">{{ strtoupper($payment->toUser->name) }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded bg-emerald-50 border border-emerald-100 text-emerald-700 font-mono font-black text-xs">
                                {{ number_format($payment->amount, 2) }} DH
                            </span>
                        </td>

                        <td class="px-6 py-5 text-right opacity-0 group-hover:opacity-100 transition-opacity">
                            @if(auth()->id() === $payment->from_user_id)
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors" onclick="return confirm('Révoquer cette transaction ?')">
                                        Révoquer
                                    </button>
                                </form>
                            @else
                                <span class="text-[9px] font-bold uppercase text-gray-300 italic tracking-widest">Lecture seule</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-16 text-center">
                            <span class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-300 italic">Aucun mouvement financier détecté</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection