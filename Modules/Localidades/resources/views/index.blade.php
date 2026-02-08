@extends('Co-Admin.layouts.app')

@section('title', 'Localidades')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Localidades" class="w-6 h-6" />
                Localidades
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de localidades do município</p>
        </div>
        <x-localidades::button href="{{ route('localidades.create') }}" variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Nova Localidade
        </x-localidades::button>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-localidades::alert type="success" dismissible>
            {{ session('success') }}
        </x-localidades::alert>
    @endif

    @if(session('warning'))
        <x-localidades::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-localidades::alert>
    @endif

    @if(session('error'))
        <x-localidades::alert type="danger" dismissible>
            {{ session('error') }}
        </x-localidades::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas) && !empty($estatisticas))
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
                <div class="text-sm text-gray-600 dark:text-gray-400">Total</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalGeral ?? $localidades->total() }}</div>
            </div>
            @foreach($estatisticas as $tipo => $total)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ ucfirst(str_replace('_', ' ', $tipo)) }}</div>
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Filtros -->
    <x-localidades::filter-bar
        action="{{ route('localidades.index') }}"
        :filters="[
            [
                'name' => 'tipo',
                'label' => 'Tipo',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'alameda' => 'Alameda',
                    'avenida' => 'Avenida',
                    'bairro' => 'Bairro',
                    'beco' => 'Beco',
                    'comunidade' => 'Comunidade',
                    'distrito' => 'Distrito',
                    'estrada' => 'Estrada',
                    'fazenda' => 'Fazenda',
                    'jardim' => 'Jardim',
                    'povoado' => 'Povoado',
                    'praca' => 'Praça',
                    'rua' => 'Rua',
                    'sitio' => 'Sítio',
                    'zona_rural' => 'Zona Rural',
                    'outro' => 'Outro'
                ],
            ],
            [
                'name' => 'ativo',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Ativo',
                    '0' => 'Inativo'
                ],
            ],
            [
                'name' => 'cidade',
                'label' => 'Cidade',
                'type' => 'text',
            ]
        ]"
        search-placeholder="Buscar por nome, código ou cidade..."
    />

    <!-- Tabela de Localidades -->
    <x-localidades::data-table
        :headers="['Código', 'Nome', 'Tipo', 'Cidade/Estado', 'Moradores', 'Status']"
        :data="$localidades"
        :export-route="route('localidades.index')"
        :localidades="$localidades"
    >
        @forelse($localidades as $localidade)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-200 dark:border-gray-700">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $localidade->codigo ?? 'N/A' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900 dark:text-white">{{ $localidade->nome }}</div>
                    @if($localidade->lider_comunitario)
                        <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            {{ $localidade->lider_comunitario }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $tipoLabels = [
                            'alameda' => 'Alameda',
                            'avenida' => 'Avenida',
                            'bairro' => 'Bairro',
                            'beco' => 'Beco',
                            'comunidade' => 'Comunidade',
                            'distrito' => 'Distrito',
                            'estrada' => 'Estrada',
                            'fazenda' => 'Fazenda',
                            'jardim' => 'Jardim',
                            'povoado' => 'Povoado',
                            'praca' => 'Praça',
                            'rua' => 'Rua',
                            'sitio' => 'Sítio',
                            'zona_rural' => 'Zona Rural',
                            'outro' => 'Outro'
                        ];
                        $tipoLabel = $tipoLabels[$localidade->tipo] ?? ucfirst(str_replace('_', ' ', $localidade->tipo));
                    @endphp
                    <x-localidades::badge variant="info">
                        {{ $tipoLabel }}
                    </x-localidades::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($localidade->cidade)
                        <div class="text-gray-900 dark:text-white">{{ $localidade->cidade }}</div>
                        @if($localidade->estado)
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $localidade->estado }}</div>
                        @endif
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($localidade->numero_moradores)
                        <div class="flex items-center gap-1 text-gray-900 dark:text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            {{ number_format($localidade->numero_moradores, 0, ',', '.') }}
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($localidade->ativo)
                        <x-localidades::badge variant="success">Ativo</x-localidades::badge>
                    @else
                        <x-localidades::badge variant="danger">Inativo</x-localidades::badge>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <x-localidades::button href="{{ route('localidades.show', $localidade) }}" variant="outline" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-localidades::button>
                        <x-localidades::button href="{{ route('localidades.edit', $localidade) }}" variant="outline" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </x-localidades::button>
                        <form action="{{ route('localidades.destroy', $localidade) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente deletar esta localidade?')">
                            @csrf
                            @method('DELETE')
                            <x-localidades::button type="submit" variant="danger" size="sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </x-localidades::button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhuma localidade encontrada</p>
                    <x-localidades::button href="{{ route('localidades.create') }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Criar Primeira Localidade
                    </x-localidades::button>
                </td>
            </tr>
        @endforelse
    </x-localidades::data-table>
</div>
@endsection
