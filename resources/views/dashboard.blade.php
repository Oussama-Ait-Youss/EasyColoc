@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">
    
    <div class="flex items-end justify-between border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Vue d'ensemble</h2>
            <p class="text-sm text-gray-500 mt-1">Analyse des flux financiers pour la colocation : <span class="text-gray-900 font-semibold">{{ $colocation->name }}</span></p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('expenses.create') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-gray-200">
                + Nouvelle Dépense
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Total Dépenses</p>
                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-tighter">Live</span>
            </div>
            <p class="text-3xl font-black text-gray-900 mt-4">{{ number_format($totalExpenses, 2) }} <span class="text-sm font-medium text-gray-400">DH</span></p>
            <div class="mt-4 w-full bg-gray-50 h-1 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-1" style="width: 70%"></div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-center">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Part par personne</p>
            <p class="text-3xl font-black text-gray-900 mt-4">{{ number_format($sharePerPerson, 2) }} <span class="text-sm font-medium text-gray-400">DH</span></p>
            <p class="text-[9px] text-gray-400 uppercase mt-2 tracking-widest italic">Calculé sur {{ $memberCount }} membres</p>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 shadow-xl text-white">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Canal de colocation</p>
            <div class="flex items-center justify-between mt-4">
                <div class="flex -space-x-3">
                    @foreach($memberBalances->take(4) as $mb)
                        <div class="h-10 w-10 rounded-full border-2 border-gray-900 bg-gray-700 flex items-center justify-center text-xs font-bold uppercase tracking-tighter">
                            {{ substr($mb['name'], 0, 1) }}
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('memberships.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 hover:text-emerald-400">Détails →</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Triage par Catégorie</h3>
            </div>
            <div class="p-8 h-80">
                @if($categoriesData->isEmpty())
                    <div class="h-full flex items-center justify-center">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-300 italic">Aucune donnée de triage détectée</span>
                    </div>
                @else
                    <canvas id="categoriesChart"></canvas>
                @endif
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Analyse de solde</h3>
            </div>
            <div class="p-8 flex-1 flex flex-col justify-between">
                <p class="text-[10px] font-medium text-gray-500 leading-relaxed uppercase tracking-wide">
                    Le modèle sémantique calcule l'écart entre l'investissement réel et la charge théorique.
                </p>
                <div class="space-y-4 mt-8">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-emerald-500">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Créditeur
                        </span>
                        <span class="text-[10px] text-gray-400 italic">À recevoir</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-amber-500">
                            <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span> Débiteur
                        </span>
                        <span class="text-[10px] text-gray-400 italic">À payer</span>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-gray-50 text-center">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 italic italic">System Status: Optimal</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Registre des Membres</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50 bg-gray-50/20">
                        <th class="px-8 py-4">Opérateur</th>
                        <th class="px-8 py-4 text-center">Valeur Investie</th>
                        <th class="px-8 py-4 text-right">Solde du Canal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($memberBalances as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center space-x-3">
                                <div class="h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-400 border border-gray-200">
                                    {{ substr($data['name'], 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-700 uppercase text-xs tracking-tight">{{ $data['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center font-mono text-xs text-gray-500">
                            {{ number_format($data['paid'], 2) }} DH
                        </td>
                        <td class="px-8 py-5 text-right">
                            @if($data['balance'] > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">
                                    + {{ number_format($data['balance'], 2) }}
                                </span>
                            @elseif($data['balance'] < 0)
                                <span class="inline-flex items-center px-3 py-1 rounded text-[10px] font-black bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-widest">
                                    {{ number_format($data['balance'], 2) }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded text-[10px] font-black bg-gray-100 text-gray-400 uppercase tracking-widest">
                                    Synchronisé
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('categoriesChart');
        if (ctx) {
            const chartData = @json($categoriesData);
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartData.map(item => item.label),
                    datasets: [{
                        data: chartData.map(item => item.total),
                        backgroundColor: ['#10B981', '#111827', '#6B7280', '#D1D5DB', '#F3F4F6'],
                        borderWidth: 0,
                        hoverOffset: 20
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 25,
                                font: { size: 10, weight: 'bold', family: 'Inter' },
                                boxWidth: 6
                            }
                        }
                    },
                    cutout: '82%'
                }
            });
        }
    });
</script>
@endsection