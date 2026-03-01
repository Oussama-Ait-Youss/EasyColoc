@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $colocation->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Gérez les paramètres globaux et l'accès à votre espace.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            Espace Actif
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Paramètres du Groupe</h3>
            </div>
            
            <form action="{{ route('colocation.update', $colocation->id) }}" method="POST" class="p-8 space-y-8">
                @csrf
                @method('PUT')
                
                <div class="space-y-3">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Nom de la colocation</label>
                    <input type="text" name="name" 
                           value="{{ old('name', $colocation->name) }}" 
                           class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('name') border-red-400 @enderror">
                    
                    @error('name')
                        <p class="text-red-500 text-[10px] font-bold uppercase tracking-tighter mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-gray-50 flex justify-between items-center">
                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-widest italic">
                        Créé le {{ $colocation->created_at->format('d/m/Y') }}
                    </span>
                    <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-gray-200">
                        Mettre à jour l'identité
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Accès Rapide</h3>
            </div>
            
            <div class="p-8 flex-1 flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-gray-500 mb-4 leading-relaxed">
                        Utilisez ce jeton pour authentifier de nouveaux membres sur ce canal.
                    </p>
                    
                    <div class="relative group">
                        <div class="bg-[#F9FAFB] border border-dashed border-gray-300 rounded-lg p-4 text-center break-all">
                            <code class="text-emerald-600 font-mono font-bold text-xs">{{ $colocation->invite_token }}</code>
                        </div>
                        <button onclick="copyToken('{{ $colocation->invite_token }}')" 
                                class="mt-4 w-full flex items-center justify-center space-x-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-emerald-600 transition-colors py-2 border border-gray-100 rounded hover:bg-gray-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            <span>Copier le jeton</span>
                        </button>
                    </div>
                    <p id="copy-msg" class="text-[10px] text-emerald-500 mt-2 font-bold uppercase tracking-widest text-center hidden italic">✓ Jeton copié avec succès</p>
                </div>

                <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-[9px] text-gray-400 uppercase leading-tight">
                        <strong class="text-gray-600">Note :</strong> Ne partagez ce code que via des canaux sécurisés.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToken(token) {
    navigator.clipboard.writeText(token).then(() => {
        const msg = document.getElementById('copy-msg');
        msg.classList.remove('hidden');
        setTimeout(() => msg.classList.add('hidden'), 2500);
    });
}
</script>
@endsection