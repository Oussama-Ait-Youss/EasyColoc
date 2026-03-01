@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-red-600 tracking-tight uppercase">Administration Globale</h2>
            <p class="text-sm text-gray-500 mt-1">Supervision du réseau EasyColoc et modération des nœuds système.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-red-500 italic">
            Root Access: Active
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($stats as $label => $value)
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    {{ strtoupper(str_replace('_', ' ', $label)) }}
                </p>
                <p class="text-2xl font-black text-gray-900 mt-2">
                    {{ number_format($value, $label == 'total_expenses' ? 2 : 0) }}
                    @if($label == 'total_expenses') <span class="text-xs font-medium text-gray-400">DH</span> @endif
                </p>
            </div>
        @endforeach
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Contrôle des Accès Utilisateurs</h3>
        </div>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
                    <th class="px-6 py-4">Opérateur</th>
                    <th class="px-6 py-4">Identifiant Email</th>
                    <th class="px-6 py-4">Date Inscription</th>
                    <th class="px-6 py-4">Statut Réseau</th>
                    <th class="px-6 py-4 text-right">Contrôle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @foreach($users as $user)
                    <tr class="group hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center space-x-3">
                                <div class="w-7 h-7 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-400">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-800 tracking-tight">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-500 font-mono text-xs">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-5 text-gray-400 text-xs font-medium">
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-5">
                            @if($user->is_banned)
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-red-50 text-red-600 border border-red-100">
                                     Banni
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-emerald-50 text-emerald-600 border border-emerald-100">
                                     Actif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            {{-- Sécurité : Empêcher l'admin de se bannir lui-même --}}
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.ban', $user) }}" method="POST" onsubmit="return confirm('Confirmer la modification du statut de cet utilisateur ?')">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold uppercase tracking-widest {{ $user->is_banned ? 'text-emerald-500 hover:text-emerald-700' : 'text-red-400 hover:text-red-600' }} transition-colors">
                                        {{ $user->is_banned ? 'Reactiver' : 'Revoquer' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-[9px] font-bold uppercase tracking-widest text-gray-300 italic">Administrateur</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection