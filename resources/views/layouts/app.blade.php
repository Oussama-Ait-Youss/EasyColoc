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
        /* Cache la scrollbar mais permet le défilement horizontal sur mobile */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F9FAFB] text-[#111827] h-full flex flex-col">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-[1600px] mx-auto flex flex-col md:flex-row items-center h-auto md:h-16 px-4 md:px-6">
            
            <div class="flex items-center justify-between w-full md:w-auto py-4 md:py-0 md:pr-8 md:border-r md:border-gray-200 h-full">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold tracking-widest uppercase text-gray-900">
                    EasyColoc<span class="text-emerald-500">.</span>
                </a>
                
                <div class="md:hidden flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-2"></span>
                    <span class="text-[8px] font-bold uppercase tracking-widest text-gray-400">Live</span>
                </div>
            </div>

            <nav class="w-full md:flex-1 flex h-12 md:h-full overflow-x-auto scrollbar-hide border-t border-gray-100 md:border-t-0">
                @php
                    $navItems = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'num' => '01'],
                        ['route' => 'expenses.index', 'label' => 'Dépenses', 'num' => '02'],
                        ['route' => 'payments.index', 'label' => 'Paiements', 'num' => '03'],
                        ['route' => 'memberships.index', 'label' => 'Membres', 'num' => '04'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex-none md:flex-1 flex items-center justify-center px-4 md:px-6 text-[10px] md:text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 transition-all {{ request()->routeIs($item['route'] . '*') ? 'text-emerald-600 bg-emerald-50/30 border-b-2 border-b-emerald-500 md:border-b-0' : 'text-gray-400' }}">
                        <span class="hidden lg:inline mr-2 text-gray-300">{{ $item['num'] }}.</span> 
                        {{ $item['label'] }}
                    </a>
                @endforeach

                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex-none md:flex-1 flex items-center justify-center px-4 md:px-6 text-[10px] md:text-xs font-semibold uppercase tracking-wider border-r border-gray-100 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.*') ? 'text-red-600 bg-red-50/30' : 'text-gray-400' }}">
                        <span class="mr-2 text-red-500 font-bold">!</span> Admin
                    </a>
                @endif
            </nav>

            <div class="hidden md:flex items-center pl-6 space-x-6 h-full">
                <a href="{{ route('profile.show') }}" class="text-[10px] font-bold uppercase tracking-widest {{ request()->routeIs('profile.*') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-900' }} transition-colors">
                    Mon Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="w-full bg-gray-100 h-[2px]">
        <div class="bg-emerald-500 h-[2px] transition-all duration-500" style="width: 65%;"></div>
    </div>

    <main class="flex-1 flex flex-col overflow-hidden">
        <div class="flex-1 overflow-y-auto p-4 md:p-8 lg:p-12">
            
            <div class="max-w-6xl mx-auto">
                @if(session()->has('success'))
                    <div class="flex items-center p-4 bg-emerald-50 border border-emerald-100 rounded-lg text-emerald-800 text-[10px] font-bold uppercase tracking-widest mb-6 shadow-sm">
                        <span class="mr-3 bg-emerald-500 text-white rounded-full w-4 h-4 flex items-center justify-center italic">i</span>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-3 px-6 flex flex-col md:flex-row justify-between items-center gap-2">
        <span class="text-[9px] text-gray-400 uppercase tracking-[0.2em]">Formation YouCode &copy; 2026</span>
        
        <div class="md:hidden flex space-x-4 border-t border-gray-100 pt-2 w-full justify-center">
            <a href="{{ route('profile.show') }}" class="text-[9px] font-black uppercase tracking-widest text-gray-400">Profil</a>
            <span class="text-gray-200">|</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-[9px] font-black uppercase tracking-widest text-red-400">Logout</button>
            </form>
        </div>

        <div class="hidden md:flex space-x-6">
            <span class="text-[9px] text-gray-400 uppercase tracking-[0.2em] font-bold">Node: <span class="text-emerald-500 italic">Verified</span></span>
        </div>
    </footer>

</body>
</html>