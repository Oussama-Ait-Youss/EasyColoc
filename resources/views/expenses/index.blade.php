@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Registre des Dépenses</h2>
            <p class="text-sm text-gray-500 mt-1">Historique complet des flux financiers de la colocation.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-gray-200">
            + Nouvelle Entrée
        </a>
    </div>

    <div class="flex space-x-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
        <span class="text-emerald-500 border-b-2 border-emerald-500 pb-1 cursor-pointer">Toutes les dépenses</span>
        <span class="hover:text-gray-600 cursor-pointer transition-colors">Mes dépenses</span>
        <span class="hover:text-gray-600 cursor-pointer transition-colors">En attente de validation</span>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Désignation</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Montant net</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Opérateur</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Triage</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Horodatage</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 text-right">Contrôle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($expenses as $expense)
                    <tr class="group hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-5 font-semibold text-gray-800">
                            {{ $expense->title }}
                        </td>
                        <td class="px-6 py-5">
                            <span class="font-mono font-bold text-gray-900">{{ number_format($expense->amount, 2) }}</span>
                            <span class="text-[10px] text-gray-400 ml-1">DH</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-500 mr-2">
                                    {{ substr($expense->user->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-gray-600">{{ $expense->user->name ?? 'Inconnu' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest bg-gray-100 text-gray-500 border border-gray-200">
                                {{ $expense->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-gray-400 font-medium text-xs">
                            {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-5 text-right space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('expenses.edit', $expense) }}" class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 hover:text-emerald-700">
                                Rectifier
                            </a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600" onclick="return confirm('Confirmer la suppression du ticket ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-16 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-300 italic">Aucune donnée de transaction détectée</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection