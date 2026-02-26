@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Historique des Dépenses</h1>
    <a href="{{ route('expenses.create') }}" class="bg-green-500 text-white px-4 py-2 rounded shadow">
        + Ajouter une dépense
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 font-semibold text-gray-700">Titre</th>
                <th class="p-4 font-semibold text-gray-700">Montant</th>
                <th class="p-4 font-semibold text-gray-700">Payé par</th>
                <th class="p-4 font-semibold text-gray-700">Catégorie</th>
                <th class="p-4 font-semibold text-gray-700">Date</th>
                <th class="p-4 font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $expense->title }}</td>
                    <td class="p-4 font-bold">{{ $expense->amount }} DH</td>
                    <td class="p-4">{{ $expense->user->name }}</td>
                    <td class="p-4 italic text-gray-600">{{ $expense->category->name }}</td>
                    <td class="p-4">{{ $expense->date }}</td>
                    <td class="p-4 flex space-x-2">
                        <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600">Modifier</a>
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Aucune dépense enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection