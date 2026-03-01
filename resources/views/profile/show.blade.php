@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Profil Apprenant</h2>
            <p class="text-sm text-gray-500 mt-1">Analyse des paramètres du nœud utilisateur et indice de fiabilité.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            User Node: #{{ auth()->id() }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Détails du compte</h3>
                </div>
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Nom Complet</label>
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Adresse Email</label>
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Statut YouCode</label>
                            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-tighter italic">Apprenant Actif</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Date d'inscription</label>
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @php $coloc = auth()->user()->activeColocation(); @endphp
            <div class="bg-white border {{ $coloc ? 'border-red-100' : 'border-gray-200' }} rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b {{ $coloc ? 'border-red-50 bg-red-50/10' : 'border-gray-50 bg-gray-50/30' }} flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-widest {{ $coloc ? 'text-red-400' : 'text-gray-400' }}">
                        {{ $coloc ? 'Zone de Danger' : 'Statut du Canal' }}
                    </h3>
                    <span class="text-[9px] font-bold uppercase italic tracking-widest {{ $coloc ? 'text-red-400' : 'text-emerald-500' }}">
                        {{ $coloc ? 'Action Irréversible' : 'Nœud Isolé' }}
                    </span>
                </div>

                <div class="p-8 flex items-center justify-between">
                    @if($coloc)
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-800 uppercase tracking-tight">Quitter le canal actif</p>
                            <p class="text-[10px] text-gray-400 leading-relaxed">
                                Vous perdrez l'accès à l'historique de : <span class="font-bold text-gray-600">{{ $coloc->name }}</span>
                            </p>
                        </div>
                        
                        <form action="{{ route('memberships.leave', $coloc->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-red-500 border border-red-200 px-6 py-2 rounded-lg hover:bg-red-50 transition-all">
                                Quitter la coloc
                            </button>
                        </form>
                    @else
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-800 uppercase tracking-tight">Aucune colocation active</p>
                            <p class="text-[10px] text-gray-400 leading-relaxed">
                                Vous n'êtes actuellement rattaché à aucun canal de dépense.
                            </p>
                        </div>
                        <a href="{{ route('colocation.create') }}" class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 border border-emerald-100 px-6 py-2 rounded-lg hover:bg-emerald-50 transition-all">
                            Créer ou Rejoindre
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-8">
            
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Indice de Fiabilité</h3>
                </div>
                <div class="p-8 flex flex-col items-center">
                    @php $reputation = $coloc ? ($coloc->pivot->reputation ?? 0) : 0; @endphp
                    <div class="relative flex items-center justify-center">
                        <svg class="w-28 h-28 transform -rotate-90">
                            <circle cx="56" cy="56" r="48" stroke="currentColor" stroke-width="6" fill="transparent" class="text-gray-100" />
                            <circle cx="56" cy="56" r="48" stroke="currentColor" stroke-width="6" fill="transparent" 
                                stroke-dasharray="301.6" 
                                stroke-dashoffset="{{ 301.6 - (301.6 * $reputation / 100) }}" 
                                class="text-emerald-500 transition-all duration-1000 ease-out" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-3xl font-black text-gray-900">{{ $reputation }}</span>
                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-[0.2em]">Score</span>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-widest {{ $reputation >= 80 ? 'text-emerald-500' : ($coloc ? 'text-amber-500' : 'text-gray-300') }}">
                            @if(!$coloc)
                                Hors Réseau
                            @else
                                {{ $reputation >= 80 ? 'Excellent Opérateur' : 'Profil à surveiller' }}
                            @endif
                        </p>
                        <p class="text-[9px] text-gray-400 mt-2 leading-relaxed italic px-2">
                            {{ $coloc ? 'Mise à jour synchronisée avec vos transactions.' : 'Rejoignez une coloc pour activer votre indice.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-8 text-white shadow-xl">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-8 border-b border-gray-800 pb-4">Activité Réseau</h3>
                <div class="space-y-8">
                    <div>
                        <p class="text-[9px] text-gray-500 uppercase font-bold tracking-widest mb-2">Dépenses Enregistrées</p>
                        <p class="text-3xl font-black text-white">{{ auth()->user()->expenses()->count() }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 uppercase font-bold tracking-widest mb-2">Canaux de Colocation</p>
                        <p class="text-3xl font-black text-white">{{ auth()->user()->colocations()->count() }}</p>
                    </div>
                </div>
                <div class="mt-10 pt-6 border-t border-gray-800 flex justify-between items-center">
                    <span class="text-[9px] text-gray-500 uppercase italic tracking-wider">Node Status</span>
                    <span class="flex items-center text-[9px] font-bold uppercase text-emerald-500 tracking-widest">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Verified
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection