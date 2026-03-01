<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] text-[#111827] h-full flex flex-col">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-[1600px] mx-auto flex items-center h-16 px-6">
            <div class="flex items-center pr-8 border-r border-gray-200 h-full">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold tracking-widest uppercase text-gray-900">
                    EasyColoc<span class="text-emerald-500">.</span>
                </a>
            </div>

            <nav class="flex-1 flex h-full overflow-x-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 {{ request()->routeIs('dashboard') ? 'text-emerald-600 bg-emerald-50/30' : 'text-gray-400' }}">
                    <span class="mr-2">01.</span> Dashboard
                    @if(request()->routeIs('dashboard')) <span class="ml-2 text-emerald-500">✓</span> @endif
                </a>
                <a href="{{ route('expenses.index') }}" class="flex items-center px-6 text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 {{ request()->routeIs('expenses.*') ? 'text-emerald-600 bg-emerald-50/30' : 'text-gray-400' }}">
                    <span class="mr-2">02.</span> Dépenses
                </a>
                <a href="{{ route('payments.index') }}" class="flex items-center px-6 text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 {{ request()->routeIs('payments.*') ? 'text-emerald-600 bg-emerald-50/30' : 'text-gray-400' }}">
                    <span class="mr-2">03.</span> Paiements
                </a>
                <a href="{{ route('memberships.index') }}" class="flex items-center px-6 text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 {{ request()->routeIs('memberships.*') ? 'text-emerald-600 bg-emerald-50/30' : 'text-gray-400' }}">
                    <span class="mr-2">04.</span> Membres
                </a>
                
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 {{ request()->routeIs('admin.*') ? 'text-red-600 bg-red-50/30' : 'text-gray-400' }}">
                        <span class="mr-2 text-red-500 font-bold">!</span> Administration
                    </a>
                @endif
            </nav>

            <div class="flex items-center pl-6 space-x-6">
                <a href="{{ route('profile.show') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('profile.*') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-900' }} transition-colors">
                    Mon Profil
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="w-full bg-gray-100 h-1">
        <div class="bg-emerald-500 h-1 transition-all duration-500" style="width: 45%;"></div>
    </div>

    <main class="flex-1 flex overflow-hidden">
        <div class="flex-1 overflow-y-auto p-8 lg:p-12">
            
            <div class="max-w-6xl mx-auto">
                @if(session()->has('success'))
                    <div class="flex items-center p-4 bg-emerald-50 border border-emerald-100 rounded-lg text-emerald-800 text-[10px] font-bold uppercase tracking-widest mb-8 shadow-sm">
                        <span class="mr-3 bg-emerald-500 text-white rounded-full w-4 h-4 flex items-center justify-center italic">i</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="flex items-center p-4 bg-red-50 border border-red-100 rounded-lg text-red-800 text-[10px] font-bold uppercase tracking-widest mb-8 shadow-sm">
                        <span class="mr-3 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center font-bold">!</span>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-4 px-8 flex justify-between items-center">
        <span class="text-[10px] text-gray-400 uppercase tracking-[0.2em]">Formation YouCode &copy; 2026</span>
        <div class="flex space-x-6">
            <span class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-bold">Status: <span class="text-emerald-500 italic">Live</span></span>
        </div>
    </footer>

</body>
</html>