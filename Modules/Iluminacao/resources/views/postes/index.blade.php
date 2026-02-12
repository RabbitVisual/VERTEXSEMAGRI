@extends('Co-Admin.layouts.app')

@section('title', 'Inventário de Postes')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Premium Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-inner border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="utility-pole" class="w-8 h-8" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Inventário de <span class="text-indigo-600 dark:text-indigo-400">Postes</span>
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Gestão técnica de ativos da rede de iluminação</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-iluminacao::button href="{{ route('co-admin.iluminacao.postes.create') }}" variant="primary" size="lg" icon="plus" class="shadow-xl">
                    Novo Poste
                </x-iluminacao::button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="animate-slide-up">
            <x-iluminacao::alert type="success" dismissible>
                {{ session('success') }}
            </x-iluminacao::alert>
        </div>
    @endif

    <!-- Main Content Area -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden animate-slide-up">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/20">
            <x-iluminacao::filter-bar
                action="{{ route('co-admin.iluminacao.postes.index') }}"
                :filters="[]"
                search-placeholder="Buscar por código, logradouro ou bairro..."
                :search-value="request('search')"
            />
        </div>

        <div class="overflow-x-auto">
            @if($postes->count() > 0)
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/40 border-b border-slate-200 dark:border-slate-700/50">
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Código</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Localização</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center">Técnica</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50">
                        @foreach($postes as $poste)
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-all duration-200">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 dark:group-hover:bg-indigo-900/30 dark:group-hover:text-indigo-400 transition-colors">
                                            <x-icon name="barcode" class="w-5 h-5" />
                                        </div>
                                        <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400">#{{ $poste->codigo }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-400">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-700 dark:text-slate-200 line-clamp-1 italic">{{ $poste->logradouro }}</span>
                                        <span class="text-xs opacity-75 flex items-center gap-1">
                                            <x-icon name="map-pin" class="w-3 h-3" />
                                            {{ $poste->bairro ?? 'Não informado' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        @if($poste->tipo_lampada)
                                            <span class="px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest border border-indigo-100/50 dark:border-indigo-800/50">
                                                {{ ucfirst($poste->tipo_lampada) }}
                                            </span>
                                        @endif
                                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                                            {{ $poste->potencia ? $poste->potencia . 'W' : 'S/ Potência' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $color = match($poste->condicao) {
                                            'bom' => 'emerald',
                                            'regular' => 'amber',
                                            'ruim' => 'orange',
                                            'critico' => 'rose',
                                            default => 'slate'
                                        };
                                        $label = match($poste->condicao) {
                                            'bom' => 'Excelente',
                                            'regular' => 'Regular',
                                            'ruim' => 'Necessita Reparo',
                                            'critico' => 'Crítico',
                                            default => 'N/D'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-{{ $color }}-50 dark:bg-{{ $color }}-900/30 text-{{ $color }}-600 dark:text-{{ $color }}-400 border border-{{ $color }}-100/50 dark:border-{{ $color }}-800/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500 animate-pulse"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('co-admin.iluminacao.postes.show', $poste->id) }}"
                                           class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 dark:hover:text-indigo-400 dark:hover:border-indigo-800 transition-all shadow-sm"
                                           title="Ver Detalhes">
                                            <x-icon name="eye" class="w-5 h-5" />
                                        </a>
                                        <a href="{{ route('co-admin.iluminacao.postes.edit', $poste->id) }}"
                                           class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-amber-600 hover:border-amber-200 dark:hover:text-amber-400 dark:hover:border-amber-800 transition-all shadow-sm"
                                           title="Editar">
                                            <x-icon name="pen-to-square" class="w-5 h-5" />
                                        </a>
                                        <form action="{{ route('co-admin.iluminacao.postes.destroy', $poste->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este poste permanentemente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-red-600 hover:border-red-200 dark:hover:text-red-400 dark:hover:border-red-800 transition-all shadow-sm" title="Excluir">
                                                <x-icon name="trash-can" class="w-5 h-5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                    <div class="w-24 h-24 rounded-3xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-6">
                        <x-icon name="utility-pole" class="w-12 h-12 text-slate-300 dark:text-slate-700" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 dark:text-white mb-2 italic">Nenhum poste no inventário</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-md">Não encontramos nenhum poste cadastrado seguindo esses critérios.</p>
                </div>
            @endif
        </div>

        @if($postes->hasPages())
            <div class="p-6 border-t border-slate-200 dark:border-slate-700/50 bg-slate-50/30">
                {{ $postes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
