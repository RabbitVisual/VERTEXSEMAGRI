@extends('Co-Admin.layouts.app')

@section('title', 'Pontos de Luz')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Iluminacao" class="w-6 h-6" />
                Pontos de Luz
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de pontos de iluminação pública</p>
        </div>
        <x-iluminacao::button href="{{ route('iluminacao.create') }}" variant="primary">
            <x-iluminacao::icon name="plus-circle" class="w-4 h-4 mr-2" />
            Novo Ponto
        </x-iluminacao::button>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-iluminacao::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-iluminacao::alert>
    @endif

    @if(session('success'))
        <x-iluminacao::alert type="success" dismissible>
            {{ session('success') }}
        </x-iluminacao::alert>
    @endif

    @if(session('error'))
        <x-iluminacao::alert type="danger" dismissible>
            {{ session('error') }}
        </x-iluminacao::alert>
    @endif

    <!-- Filtros -->
    <x-iluminacao::filter-bar
        action="{{ route('iluminacao.index') }}"
        :filters="[
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'funcionando' => 'Funcionando',
                    'com_defeito' => 'Com Defeito',
                    'desligado' => 'Desligado'
                ],
            ],
            [
                'name' => 'tipo_lampada',
                'label' => 'Tipo Lâmpada',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'led' => 'LED',
                    'fluorescente' => 'Fluorescente',
                    'incandescente' => 'Incandescente',
                    'vapor_sodio' => 'Vapor de Sódio',
                    'mercurio' => 'Mercúrio'
                ],
            ],
            [
                'name' => 'localidade_id',
                'label' => 'Localidade',
                'type' => 'select',
                'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => 'Todas'],
            ]
        ]"
        search-placeholder="Buscar por código ou endereço..."
    />

    <!-- Tabela de Pontos -->
    <x-iluminacao::data-table
        :headers="['Código', 'Endereço', 'Localidade', 'Tipo Lâmpada', 'Potência', 'Status']"
        :data="$pontos"
        export-route="{{ route('iluminacao.index') }}"
    >
        @forelse($pontos as $ponto)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <strong class="text-indigo-600 dark:text-indigo-400">{{ $ponto->codigo ?? 'N/A' }}</strong>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->endereco }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($ponto->localidade)
                        <a href="{{ route('localidades.show', $ponto->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
                            <x-iluminacao::icon name="map-pin" class="w-4 h-4" />
                            {{ $ponto->localidade->nome }}
                        </a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-iluminacao::badge variant="info">
                        {{ ucfirst(str_replace('_', ' ', $ponto->tipo_lampada ?? 'N/A')) }}
                    </x-iluminacao::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($ponto->potencia)
                        <strong class="text-gray-900 dark:text-white">{{ $ponto->potencia }}W</strong>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusColors = [
                            'funcionando' => 'success',
                            'com_defeito' => 'warning',
                            'desligado' => 'danger'
                        ];
                        $statusIcons = [
                            'funcionando' => 'check-circle',
                            'com_defeito' => 'exclamation-triangle',
                            'desligado' => 'x-circle'
                        ];
                    @endphp
                    <x-iluminacao::badge :variant="$statusColors[$ponto->status] ?? 'secondary'">
                        <x-iluminacao::icon :name="$statusIcons[$ponto->status] ?? 'question-mark-circle'" class="w-3 h-3 mr-1" />
                        {{ ucfirst(str_replace('_', ' ', $ponto->status)) }}
                    </x-iluminacao::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('iluminacao.show', $ponto) }}"
                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                           title="Ver detalhes">
                            <x-iluminacao::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('iluminacao.edit', $ponto) }}"
                           class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300"
                           title="Editar">
                            <x-iluminacao::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('iluminacao.destroy', $ponto) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Deseja realmente deletar este ponto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                    title="Deletar">
                                <x-iluminacao::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <x-iluminacao::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhum ponto encontrado</p>
                    <x-iluminacao::button href="{{ route('iluminacao.create') }}" variant="primary">
                        <x-iluminacao::icon name="plus-circle" class="w-4 h-4 mr-2" />
                        Criar Primeiro Ponto
                    </x-iluminacao::button>
                </td>
            </tr>
        @endforelse
    </x-iluminacao::data-table>
</div>
@endsection
