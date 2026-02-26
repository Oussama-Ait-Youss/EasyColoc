@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
        <h2 class="text-lg font-bold mb-4">Rejoindre une colocation</h2>
        <form action="{{ route('memberships.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Token d'invitation</label>
                <input type="text" name="token" value="{{ request('token') }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
            </div>
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-md">Rejoindre</button>
        </form>
    </div>
</div>
@endsection