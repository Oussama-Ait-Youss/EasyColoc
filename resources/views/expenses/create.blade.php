@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Nouvelle Dépense</h2>
            <p class="text-sm text-gray-500 mt-1">Saisissez les détails de l'achat pour la colocation.</p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            Financial Record
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Configuration du ticket</h3>
        </div>

        <form action="{{ route('expenses.store') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Titre de la dépense</label>
                <input type="text" name="title" value="{{ old('title') }}" 
                    class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-gray-300 @error('title') border-red-400 @enderror" 
                    placeholder="Ex: Facture Lydec Janvier">
                @error('title') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Montant (DH)</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" 
                            class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 pl-10 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('amount') border-red-400 @enderror"
                            placeholder="0.00">
                        <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold">DH</span>
                    </div>
                    @error('amount') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Date d'opération</label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" 
                        class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('date') border-red-400 @enderror">
                    @error('date') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Catégorie de triage</label>
                <select name="category_id" 
                    class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('category_id') border-red-400 @enderror">
                    <option value="">-- Sélectionner l'intention --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ strtoupper($category->name) }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
            </div>

            <input type="hidden" name="colocation_id" value="{{ auth()->user()->activeColocation()->id }}">

            <div class="pt-6 border-t border-gray-50 flex justify-between items-center">
                <a href="{{ route('expenses.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">
                    Annuler l'entrée
                </a>
                <button type="submit" class="bg-gray-900 text-white px-10 py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-gray-200">
                    Enregistrer le ticket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection