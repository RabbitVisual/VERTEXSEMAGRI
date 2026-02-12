@extends('Co-Admin.layouts.app')

@section('title', 'Estradas e Vicinais')

@section('content')
<div class="space-y-6">
    <!-- Premium Header Area -->
    <div class="relative overflow-hidden bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl mb-8">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px]"></div>

        <div class="relative px-8 py-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-5 bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl">
                            <x-icon module="estradas" class="w-10 h-10 text-white" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Infraestrutura</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Estradas e Vicinais</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            Controle de <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Malha Viária</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-estradas::button href="{{ route('estradas.create') }}" variant="primary" size="lg" class="shadow-xl bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1 transition-all">
                        <x-icon name="plus" class="w-5 h-5 mr-2" />
                        Novo Trecho
                    </x-estradas::button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-estradas::stat-card
            title="Total de Trechos"
            value="{{ $trechos->total() }}"
            icon="map"
            variant="indigo"
        />
        <x-estradas::stat-card
            title="Extensão Total"
            value="{{ number_format($trechos->sum('extensao_km'), 1) }} km"
            icon="arrows-left-right"
            variant="blue"
        />
        <x-estradas::stat-card
            title="Condição Boa"
            value="{{ $trechos->where('condicao', 'boa')->count() }}"
            icon="circle-check"
            variant="success"
        />
        <x-estradas::stat-card
            title="Necessita Reparo"
            value="{{ $trechos->whereIn('condicao', ['ruim', 'pessima'])->count() }}"
            icon="triangle-exclamation"
            variant="danger"
        />
    </div>

    <!-- Filtros -->
    <x-estradas::filter-bar
        action="{{ route('estradas.index') }}"
        :filters="[
            [
                'name' => 'tipo',
                'label' => 'Tipo',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'vicinal' => 'Vicinal',
                    'principal' => 'Principal',
                    'secundaria' => 'Secundária'
                ],
            ],
            [
                'name' => 'condicao',
                'label' => 'Condição',
                'type' => 'select',
                'options' => [
                    '' => 'Todas',
                    'boa' => 'Boa',
                    'regular' => 'Regular',
                    'ruim' => 'Ruim',
                    'pessima' => 'Péssima'
                ],
            ],
            [
                'name' => 'localidade_id',
                'label' => 'Localidade',
                'type' => 'select',
                'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => 'Todas'],
            ]
        ]"
        search-placeholder="Buscar por nome ou código..."
    />

    <!-- Tabela de Trechos -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Identificação do Trecho</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Tipo e Localidade</th>
                        <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Extensão</th>
                        <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Estado de Conservação</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50">
        @forelse($trechos as $trecho)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all duration-300">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500/10 to-blue-500/10 flex items-center justify-center border border-indigo-500/20 group-hover:scale-110 transition-transform duration-500">
                                        <x-icon module="estradas" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-slate-100 dark:bg-slate-700 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                                        <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ $trecho->nome }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $trecho->codigo ?? 'SEM CÓDIGO' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <x-estradas::badge variant="info" class="text-[9px] py-0 px-2">{{ strtoupper($trecho->tipo) }}</x-estradas::badge>
                                @if($trecho->localidade)
                                    <span class="text-[10px] font-bold text-slate-500 flex items-center gap-1">
                                        <x-icon name="location-dot" class="w-3 h-3" />
                                        {{ $trecho->localidade->nome }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm font-black text-slate-700 dark:text-slate-300">
                                {{ $trecho->extensao_km ? number_format($trecho->extensao_km, 1, ',', '.') . ' km' : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $condVariant = match($trecho->condicao) {
                                    'boa' => 'success',
                                    'regular' => 'info',
                                    'ruim' => 'warning',
                                    'pessima' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <x-estradas::badge :variant="$condVariant" class="shadow-sm">{{ ucfirst($trecho->condicao) }}</x-estradas::badge>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                                <x-estradas::button href="{{ route('estradas.show', $trecho->id) }}" variant="secondary" size="sm" class="hover:bg-indigo-600 hover:text-white border-none shadow-none">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </x-estradas::button>
                                <x-estradas::button href="{{ route('estradas.edit', $trecho->id) }}" variant="secondary" size="sm" class="hover:bg-amber-500 hover:text-white border-none shadow-none">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </x-estradas::button>
                                <form action="{{ route('estradas.destroy', $trecho->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmar exclusão?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-estradas::button type="submit" variant="secondary" size="sm" class="hover:bg-red-500 hover:text-white border-none shadow-none">
                                        <x-icon name="trash-can" class="w-4 h-4" />
                                    </x-estradas::button>
                                </form>
                            </div>
                        </td>
                    </tr>
        @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center border border-dashed border-slate-200 dark:border-slate-700 mb-4 text-slate-300 dark:text-slate-600">
                                    <x-icon module="estradas" class="w-8 h-8" />
                                </div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Nenhum Trecho Encontrado</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Não foram encontrados registros com os filtros aplicados</p>
                                <div class="mt-6">
                                    <x-estradas::button href="{{ route('estradas.create') }}" variant="secondary" size="sm" class="shadow-sm">
                                        Cadastrar Novo Trecho
                                    </x-estradas::button>
                                </div>
                            </div>
                        </td>
                    </tr>
        @endforelse
                </tbody>
            </table>
        </div>
        @if($trechos->hasPages())
        <div class="px-8 py-4 bg-slate-50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700">
            {{ $trechos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
