@extends('Co-Admin.layouts.app')

@section('title', \App\Helpers\TranslationHelper::translateLabel('Pessoas'))

@section('content')
@php
    use App\Helpers\TranslationHelper;
@endphp
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pessoas" class="w-6 h-6" />
                {{ TranslationHelper::translateLabel('Pessoas') }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ TranslationHelper::translateLabel('Gerenciamento de pessoas - Alguns dados são migrados do Cadastro Único e outros são manuais') }}</p>
        </div>
            <x-pessoas::button href="{{ route('pessoas.create') }}" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
                {{ TranslationHelper::translateButton('Nova Pessoa') }}
            </x-pessoas::button>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-pessoas::alert type="success" dismissible>
            {{ session('success') }}
        </x-pessoas::alert>
    @endif

    @if(session('warning'))
        <x-pessoas::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-pessoas::alert>
    @endif

    @if(session('error'))
        <x-pessoas::alert type="danger" dismissible>
            {{ session('error') }}
        </x-pessoas::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-pessoas::stat-card
            title="{{ TranslationHelper::translateLabel('Total de Pessoas') }}"
            :value="$estatisticas['total'] ?? 0"
            icon="clipboard-check"
            color="primary"
        />
        <x-pessoas::stat-card
            title="{{ TranslationHelper::translateLabel('Beneficiárias PBF') }}"
            :value="$estatisticas['beneficiarias_pbf'] ?? 0"
            icon="check-circle"
            color="success"
        />
    </div>
    @endif

    <!-- Filtros -->
    <x-pessoas::filter-bar
        action="{{ route('pessoas.index') }}"
        :filters="[
            [
                'name' => 'localidade_id',
                'label' => TranslationHelper::translateLabel('Localidade'),
                'type' => 'select',
                'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => TranslationHelper::translateLabel('Todas')],
            ],
            [
                'name' => 'sexo',
                'label' => TranslationHelper::translateLabel('Sexo'),
                'type' => 'select',
                'options' => [
                    '' => TranslationHelper::translateLabel('Todos'),
                    '1' => TranslationHelper::translateLabel('Masculino'),
                    '2' => TranslationHelper::translateLabel('Feminino')
                ],
            ],
            [
                'name' => 'beneficiaria_pbf',
                'label' => TranslationHelper::translateLabel('Beneficiária PBF'),
                'type' => 'select',
                'options' => [
                    '' => TranslationHelper::translateLabel('Todas'),
                    '1' => TranslationHelper::translateLabel('Sim')
                ],
            ]
        ]"
        search-placeholder="{{ TranslationHelper::translateLabel('Buscar por nome, NIS, CPF ou código familiar...') }}"
    />

    <!-- Tabela de Pessoas -->
    <div class="overflow-x-auto">
        <x-pessoas::data-table
            :headers="[
                TranslationHelper::translateLabel('Nome'),
                TranslationHelper::translateLabel('NIS'),
                TranslationHelper::translateLabel('CPF'),
                TranslationHelper::translateLabel('Data Nasc.'),
                TranslationHelper::translateLabel('Sexo'),
                TranslationHelper::translateLabel('Localidade'),
                TranslationHelper::translateLabel('PBF'),
                TranslationHelper::translateLabel('Status')
            ]"
            :data="$pessoas"
            :export-route="route('pessoas.export')"
            table-classes="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
        >
        @forelse($pessoas as $pessoa)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $pessoa->nom_pessoa ?? 'N/A' }}
                        </div>
                        @if($pessoa->nom_apelido_pessoa)
                            <div class="text-sm text-gray-500 dark:text-gray-400">Apelido: {{ $pessoa->nom_apelido_pessoa }}</div>
                        @endif
                        @if($pessoa->cod_familiar_fam)
                            <div class="text-xs text-gray-400 dark:text-gray-500">Família: {{ $pessoa->cod_familiar_fam }}</div>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pessoa->num_nis_pessoa_atual)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-800 dark:text-gray-200">
                            {{ $pessoa->nis_formatado }}
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pessoa->num_cpf_pessoa)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-800 dark:text-gray-200">
                            {{ $pessoa->cpf_formatado }}
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pessoa->data_nascimento)
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $pessoa->data_nascimento->format('d/m/Y') }}
                        </div>
                        @if($pessoa->idade)
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $pessoa->idade }} anos</div>
                        @endif
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-pessoas::badge :variant="$pessoa->sexo_cor">
                        {{ $pessoa->sexo_texto }}
                    </x-pessoas::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pessoa->localidade)
                        <a href="{{ route('localidades.show', $pessoa->localidade->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            {{ $pessoa->localidade->nome }}
                        </a>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">Não vinculada</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pessoa->recebe_pbf)
                        <x-pessoas::badge variant="success">
                            <svg class="w-3 h-3 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sim
                        </x-pessoas::badge>
                    @else
                        <x-pessoas::badge variant="default">{{ TranslationHelper::translateLabel('Não') }}</x-pessoas::badge>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pessoa->ativo)
                        <x-pessoas::badge variant="success">{{ TranslationHelper::translateStatus('Ativo') }}</x-pessoas::badge>
                    @else
                        <x-pessoas::badge variant="danger">{{ TranslationHelper::translateStatus('Inativo') }}</x-pessoas::badge>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @if(isset($pessoa->id) && $pessoa->id)
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('pessoas.show', $pessoa->id) }}"
                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                               title="Ver detalhes">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('pessoas.edit', $pessoa->id) }}"
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                               title="Editar">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">-</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ TranslationHelper::translateLabel('Nenhuma pessoa encontrada') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ TranslationHelper::translateLabel('Tente ajustar os filtros de busca.') }}</p>
                </td>
            </tr>
        @endforelse
        </x-pessoas::data-table>
    </div>
@endsection
