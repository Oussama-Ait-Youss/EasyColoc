<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - Gestion de Colocation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('colocation.index') }}" class="text-xl font-bold">🏠 EasyColoc</a>
            <div class="space-x-4">
                <a href="{{ route('expenses.index') }}" class="hover:underline">Dépenses</a>
                <a href="{{ route('payments.index') }}" class="hover:underline">Paiements</a>
                <a href="{{ route('memberships.index') }}" class="hover:underline">Membres</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4">
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>