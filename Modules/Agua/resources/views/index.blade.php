@extends('Co-Admin.layouts.app')

@section('title', 'Redes de Água')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Agua" class="w-6 h-6" />
                Redes de Água
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de redes de água</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-agua::button href="{{ route('agua.create') }}" variant="primary">
                <x-agua::icon name="plus-circle" class="w-4 h-4 mr-2" />
                Nova Rede
            </x-agua::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-agua::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-agua::alert>
    @endif

    @if(session('success'))
        <x-agua::alert type="success" dismissible>
            {{ session('success') }}
        </x-agua::alert>
    @endif

    <!-- Filtros -->
    <x-agua::filter-bar
        action="{{ route('agua.index') }}"
        :filters="[
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'funcionando' => 'Funcionando',
                    'com_vazamento' => 'Com Vazamento',
                    'interrompida' => 'Interrompida'
                ],
                'col' => 3
            ],
            [
                'name' => 'tipo_rede',
                'label' => 'Tipo',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'principal' => 'Principal',
                    'secundaria' => 'Secundária',
                    'ramal' => 'Ramal'
                ],
                'col' => 3
            ],
            [
                'name' => 'localidade_id',
                'label' => 'Localidade',
                'type' => 'select',
                'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => 'Todas'],
                'col' => 3
            ]
        ]"
        search-placeholder="Buscar por código ou material..."
    />

    <!-- Tabela de Redes -->
    <x-agua::data-table
        :headers="['Código', 'Localidade', 'Tipo', 'Diâmetro', 'Extensão (m)', 'Status']"
        :data="$redes"
        export-route="{{ route('agua.index') }}"
    >
        @forelse($redes as $rede)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <strong class="text-indigo-600 dark:text-indigo-400">{{ $rede->codigo ?? 'N/A' }}</strong>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($rede->localidade)
                        <a href="{{ route('localidades.show', $rede->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 flex items-center gap-1">
                            <x-agua::icon name="map-pin" class="w-4 h-4" />
                            {{ $rede->localidade->nome }}
                        </a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-agua::badge variant="info">
                        {{ ucfirst($rede->tipo_rede) }}
                    </x-agua::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    {{ $rede->diametro ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    @if($rede->extensao_metros)
                        {{ number_format($rede->extensao_metros, 2, ',', '.') }} m
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'funcionando' => 'success',
                            'com_vazamento' => 'warning',
                            'interrompida' => 'danger'
                        ];
                        $statusVariant = $statusVariants[$rede->status] ?? 'secondary';
                    @endphp
                    <x-agua::badge :variant="$statusVariant">
                        <x-agua::icon :name="$rede->status == 'funcionando' ? 'check-circle' : ($rede->status == 'com_vazamento' ? 'exclamation-triangle' : 'x-circle')" class="w-3 h-3 mr-1" />
                        {{ ucfirst(str_replace('_', ' ', $rede->status)) }}
                    </x-agua::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('agua.show', $rede) }}"
                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                           title="Ver detalhes">
                            <x-agua::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('agua.edit', $rede) }}"
                           class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300"
                           title="Editar">
                            <x-agua::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('agua.destroy', $rede) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Deseja realmente deletar esta rede?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                    title="Deletar">
                                <x-agua::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <x-agua::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhuma rede encontrada</p>
                    <x-agua::button href="{{ route('agua.create') }}" variant="primary">
                        <x-agua::icon name="plus-circle" class="w-4 h-4 mr-2" />
                        Criar Primeira Rede
                    </x-agua::button>
                </td>
            </tr>
        @endforelse
    </x-agua::data-table>
</div>
@endsection
