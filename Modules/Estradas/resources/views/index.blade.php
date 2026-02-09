@extends('Co-Admin.layouts.app')

@section('title', 'Estradas e Vicinais')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="estradas" class="w-6 h-6" />
                Estradas e Vicinais
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de trechos de estradas e vicinais</p>
        </div>
        <x-estradas::button href="{{ route('estradas.create') }}" variant="primary">
            <x-estradas::icon name="plus-circle" class="w-4 h-4 mr-2" />
            Novo Trecho
        </x-estradas::button>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-estradas::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-estradas::alert>
    @endif

    @if(session('success'))
        <x-estradas::alert type="success" dismissible>
            {{ session('success') }}
        </x-estradas::alert>
    @endif

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
    <x-estradas::data-table
        :headers="['Nome', 'Código', 'Localidade', 'Tipo', 'Extensão', 'Condição']"
        :data="$trechos"
        export-route="{{ route('estradas.index') }}"
    >
        @forelse($trechos as $trecho)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $trecho->nome }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $trecho->codigo ?? 'N/A' }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($trecho->localidade)
                        <a href="{{ route('localidades.show', $trecho->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
                            <x-estradas::icon name="map-pin" class="w-4 h-4" />
                            {{ $trecho->localidade->nome }}
                        </a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-estradas::badge variant="info">
                        {{ ucfirst($trecho->tipo) }}
                    </x-estradas::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    @if($trecho->extensao_km)
                        <strong>{{ number_format($trecho->extensao_km, 2, ',', '.') }} km</strong>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $condicaoColors = [
                            'boa' => 'success',
                            'regular' => 'info',
                            'ruim' => 'warning',
                            'pessima' => 'danger'
                        ];
                        $condicaoIcons = [
                            'boa' => 'check-circle',
                            'regular' => 'information-circle',
                            'ruim' => 'exclamation-triangle',
                            'pessima' => 'x-circle'
                        ];
                    @endphp
                    <x-estradas::badge :variant="$condicaoColors[$trecho->condicao] ?? 'secondary'">
                        <x-estradas::icon :name="$condicaoIcons[$trecho->condicao] ?? 'question-mark-circle'" class="w-3 h-3 mr-1" />
                        {{ ucfirst($trecho->condicao) }}
                    </x-estradas::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('estradas.show', $trecho) }}"
                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                           title="Ver detalhes">
                            <x-estradas::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('estradas.edit', $trecho) }}"
                           class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300"
                           title="Editar">
                            <x-estradas::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('estradas.destroy', $trecho) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Deseja realmente deletar este trecho?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                    title="Deletar">
                                <x-estradas::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <x-estradas::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhum trecho encontrado</p>
                    <x-estradas::button href="{{ route('estradas.create') }}" variant="primary">
                        <x-estradas::icon name="plus-circle" class="w-4 h-4 mr-2" />
                        Criar Primeiro Trecho
                    </x-estradas::button>
                </td>
            </tr>
        @endforelse
    </x-estradas::data-table>
</div>
@endsection
