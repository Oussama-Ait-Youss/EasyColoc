@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Rectification de Ticket</h2>
            <p class="text-sm text-gray-500 mt-1">Mise à jour des paramètres financiers pour la dépense : <span class="text-gray-900 font-semibold">#{{ $expenses->id }}</span></p>
        </div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-500 italic">
            Edit Mode: Active
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Paramètres de la dépense</h3>
        </div>

        <form action="{{ route('expenses.update', $expenses) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT') {{-- Crucial pour les requêtes de mise à jour dans Laravel --}}
            
            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Désignation du ticket</label>
                <input type="text" name="title" value="{{ old('title', $expenses->title) }}" 
                    class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('title') border-red-400 @enderror">
                @error('title') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Valeur de transaction (DH)</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="amount" value="{{ old('amount', $expenses->amount) }}" 
                            class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 pl-10 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('amount') border-red-400 @enderror">
                        <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold italic font-mono">DH</span>
                    </div>
                    @error('amount') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Horodatage d'opération</label>
                    <input type="date" name="date" value="{{ old('date', $expenses->date) }}" 
                        class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('date') border-red-400 @enderror">
                    @error('date') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 ml-1">Triage Catégoriel</label>
                <select name="category_id" 
                    class="w-full bg-[#F9FAFB] border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id', $expenses->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ strtoupper($category->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-between items-center">
                <a href="{{ route('expenses.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">
                    Abandonner les modifications
                </a>
                <button type="submit" class="bg-gray-900 text-white px-10 py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-gray-200">
                    Mettre à jour le registre
                </button>
            </div>
        </form>
    </div>
</div>
@endsection