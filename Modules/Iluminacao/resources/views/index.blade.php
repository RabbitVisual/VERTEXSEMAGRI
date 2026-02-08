@extends('Co-Admin.layouts.app')

@section('title', 'Pontos de Luz')

@section('content')
<div x-data="{ loading: false }" class="space-y-6">
    <!-- Loading Overlay -->
    <div x-show="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-700 dark:text-gray-300 font-medium">Processando...</p>
        </div>
    </div>

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Iluminacao" class="w-6 h-6" />
                Pontos de Luz
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de pontos de iluminação pública</p>
        </div>
        
        <div class="flex flex-wrap gap-2 items-center">
            <a href="{{ route('iluminacao.export-neoenergia') }}" 
               @click="loading = true; setTimeout(() => loading = false, 3000)"
               class="inline-flex items-center px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                <x-iluminacao::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                Exportar
            </a>
            
            <form action="{{ route('iluminacao.import-neoenergia') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-1" @submit="loading = true">
                @csrf
                <label class="cursor-pointer inline-flex items-center px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                    <x-iluminacao::icon name="document-text" class="w-4 h-4 mr-2" />
                    <span class="truncate max-w-[100px]">Importar CSV</span>
                    <input type="file" name="file" accept=".csv,.txt" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <x-iluminacao::button href="{{ route('iluminacao.create') }}" variant="primary">
                <x-iluminacao::icon name="plus-circle" class="w-4 h-4 mr-2" />
                Novo Ponto
            </x-iluminacao::button>
        </div>
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
                    'desligado' => 'Desligado',
                ],
                'value' => ['status'] ?? ''
            ],
            [
                'name' => 'tipo_lampada',
                'label' => 'Tipo Lâmpada',
                'type' => 'text',
                'value' => ['tipo_lampada'] ?? '',
                'placeholder' => 'Ex: LED'
            ],
            [
                'name' => 'localidade_id',
                'label' => 'Localidade',
                'type' => 'select',
                'options' => ->pluck('nome', 'id')->prepend('Todas', '')->toArray(),
                'value' => ['localidade_id'] ?? ''
            ]
        ]"
        search-placeholder="Buscar por código, endereço, trafo ou barramento..."
        :search-value="['search'] ?? ''"
    />

    <!-- Tabela -->
    @if(->count() > 0)
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Código</th>
                        <th scope="col" class="px-6 py-3">Localidade</th>
                        <th scope="col" class="px-6 py-3">Endereço</th>
                        <th scope="col" class="px-6 py-3">Tipo Lâmpada</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( as )
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ ->codigo }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <x-iluminacao::icon name="map-pin" class="w-4 h-4 mr-1 text-gray-400" />
                                    {{ ->localidade->nome ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 truncate max-w-xs" title="{{ ->endereco }}">
                                {{ ->endereco }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ->tipo_lampada ?? '-' }}
                                @if(->potencia)
                                    <span class="text-xs text-gray-400">({{ ->potencia }}W)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                     = [
                                        'funcionando' => 'success',
                                        'com_defeito' => 'warning',
                                        'desligado' => 'danger'
                                    ];
                                     = [
                                        'funcionando' => 'check-circle',
                                        'com_defeito' => 'exclamation-triangle',
                                        'desligado' => 'x-circle'
                                    ];
                                @endphp
                                <x-iluminacao::badge :variant="[->status] ?? 'secondary'">
                                    <x-iluminacao::icon :name="[->status] ?? 'question-mark-circle'" class="w-3 h-3 mr-1" />
                                    {{ ucfirst(str_replace('_', ' ', ->status)) }}
                                </x-iluminacao::badge>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('iluminacao.show', ) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <x-iluminacao::icon name="eye" class="w-5 h-5" />
                                    </a>
                                    <a href="{{ route('iluminacao.edit', ) }}" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">
                                        <x-iluminacao::icon name="pencil" class="w-5 h-5" />
                                    </a>
                                    <form action="{{ route('iluminacao.destroy', ) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar este ponto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                            <x-iluminacao::icon name="trash" class="w-5 h-5" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ ->appends()->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
            <x-iluminacao::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
            <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhum ponto encontrado</p>
            <div class="flex justify-center gap-2">
                <x-iluminacao::button href="{{ route('iluminacao.create') }}" variant="primary">
                    <x-iluminacao::icon name="plus-circle" class="w-4 h-4 mr-2" />
                    Novo Ponto
                </x-iluminacao::button>
            </div>
        </div>
    @endif
</div>
@endsection
