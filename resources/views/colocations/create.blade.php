@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-20 space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Configuration Initiale</h2>
            <p class="text-sm text-gray-500 mt-1">Créez votre espace de travail partagé pour commencer le triage.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            Step 01: Setup
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Identité du groupe</h3>
        </div>

        <form action="{{ route('colocation.store') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            <div class="space-y-3">
                <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">
                    Nom de la Colocation
                </label>
                <input type="text" name="name" id="name" required
                    class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-gray-300 @error('name') border-red-400 @enderror"
                    placeholder="ex: Appartement Centre-Ville, Résidence YouCode..."
                    value="{{ old('name') }}">
                
                @error('name')
                    <p class="text-red-500 text-[10px] font-bold uppercase tracking-tighter mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-gray-50">
                <button type="submit" class="w-full bg-gray-900 text-white py-3.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-gray-200">
                    Déployer l'espace colocation
                </button>
            </div>
        </form>

        <div class="px-8 py-5 bg-gray-50/50 border-t border-gray-50 text-center">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                Déjà membre ? 
                <a href="{{ route('invitations.join') }}" class="text-emerald-600 hover:text-emerald-700 ml-1 transition-colors underline decoration-emerald-200 decoration-2 underline-offset-4">
                    Utiliser un jeton d'invitation
                </a>
            </p>
        </div>
    </div>
</div>
@endsection