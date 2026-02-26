@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-12">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Invitations</h2>
            <p class="text-sm text-gray-500 mt-1">Gérez les accès de vos futurs colocataires par email.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            Secure Invites
        </div>
    </div>

    {{-- Only the owner of the current active colocation may send invitations --}}
    @if(optional(auth()->user()->activeColocation()->pivot)->role === 'owner')
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Nouvelle invitation</h3>
        </div>
        <form action="{{ route('invitations.store') }}" method="POST" class="p-8">
            @csrf
            <div class="flex flex-col md:flex-row gap-6 items-end">
                <div class="flex-1 space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Adresse Email du destinataire</label>
                    <input type="email" name="email" required 
                        class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-gray-300" 
                        placeholder="nom@exemple.com">
                </div>
                <button type="submit" class="h-[46px] bg-gray-900 text-white px-8 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-gray-200">
                    Envoyer le ticket
                </button>
            </div>
            @error('email')
                <p class="text-red-500 text-[10px] mt-2 font-bold uppercase tracking-tighter">{{ $message }}</p>
            @enderror
        </form>
    </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Destinataire</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Statut</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 text-center">Expiration</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 text-right">Contrôle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($invitations as $invitation)
                    <tr class="group hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-5 font-medium text-gray-700">{{ $invitation->email }}</td>
                        <td class="px-6 py-5">
                            @if($invitation->status === 'pending')
                                <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-amber-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span> En attente
                                </span>
                            @else
                                <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-emerald-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span> Acceptée
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center text-gray-400 font-mono text-xs">
                            {{ $invitation->expires_at }}
                        </td>
                        <td class="px-6 py-5 text-right">
                            <form action="{{ route('invitations.destroy', $invitation) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-[10px] font-bold uppercase tracking-widest text-gray-300 hover:text-red-500 transition-colors">
                                    Révoquer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-300 italic">Aucune donnée de triage</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection