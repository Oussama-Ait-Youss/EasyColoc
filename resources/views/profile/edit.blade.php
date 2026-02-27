<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- reputation score card --}}
            @if(isset($colocation) && $colocation)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400">Votre Réputation</h3>
                            <p class="text-xs text-gray-500 mt-1">Score au sein de {{ $colocation->name }}</p>
                        </div>
                        <div class="text-right">
                            @php
                                $reputation = $colocation->pivot->reputation ?? 100;
                                $textColor = $reputation >= 80 ? 'text-emerald-500' : ($reputation >= 50 ? 'text-amber-500' : 'text-red-500');
                                $status = $reputation >= 80 ? 'Excellent' : ($reputation >= 50 ? 'Bon' : 'En Amélioration');
                            @endphp
                            <div class="{{ $textColor }} text-5xl font-black font-mono">
                                {{ $reputation }}<span class="text-2xl">%</span>
                            </div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-2">
                                {{ $status }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- current colocation info --}}
            @if(isset($colocation))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl space-y-4">
                        <h3 class="text-lg font-bold text-gray-900">Colocation actuelle</h3>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Nom</span>
                            <span>{{ $colocation->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Rôle</span>
                            <span class="uppercase font-bold {{ $role === 'owner' ? 'text-amber-600' : 'text-emerald-600' }}">
                                {{ $role }}
                            </span>
                        </div>

                        @if($role === 'member')
                            <div class="pt-4">
                                <form action="{{ route('memberships.destroy', $colocation->pivot->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-50 border border-red-200 text-red-600 px-4 py-2 rounded text-sm font-bold uppercase tracking-wider hover:bg-red-100 transition-colors"
                                            onclick="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?')">
                                        Quitter la colocation
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
