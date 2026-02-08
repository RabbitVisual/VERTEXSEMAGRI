@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Pessoa')

@section('content')
@php
    use App\Helpers\LgpdHelper;
    $canViewSensitiveData = LgpdHelper::canViewSensitiveData();
@endphp
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pessoas" class="w-6 h-6" />
                {{ $pessoa->nom_pessoa ?? 'Pessoa' }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes do cadastro</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-pessoas::button href="{{ route('pessoas.edit', $pessoa) }}" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Editar
            </x-pessoas::button>
            <x-pessoas::button href="{{ route('pessoas.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </x-pessoas::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-pessoas::alert type="success" dismissible>
            {{ session('success') }}
        </x-pessoas::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informações Básicas -->
        <x-pessoas::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Informações Básicas
                </h3>
            </x-slot>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                    <div class="text-base font-semibold text-gray-900 dark:text-white">
                        @if($canViewSensitiveData)
                            {{ $pessoa->nom_pessoa ?? 'N/A' }}
                        @else
                            {{ LgpdHelper::maskName($pessoa->nom_pessoa) }}
                        @endif
                    </div>
                </div>

                @if($pessoa->nom_apelido_pessoa)
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Apelido/Nome Social</label>
                    <div class="text-sm text-gray-900 dark:text-white">
                        @if($canViewSensitiveData)
                            {{ $pessoa->nom_apelido_pessoa }}
                        @else
                            {{ LgpdHelper::maskName($pessoa->nom_apelido_pessoa) }}
                        @endif
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">NIS</label>
                    @if($pessoa->num_nis_pessoa_atual)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200">
                            @if($canViewSensitiveData)
                                {{ $pessoa->nis_formatado }}
                            @else
                                {{ LgpdHelper::maskNis($pessoa->num_nis_pessoa_atual) }}
                            @endif
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">CPF</label>
                    @if($pessoa->num_cpf_pessoa)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200">
                            @if($canViewSensitiveData)
                                {{ $pessoa->cpf_formatado }}
                            @else
                                {{ LgpdHelper::maskCpf($pessoa->num_cpf_pessoa) }}
                            @endif
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Nascimento</label>
                    @if($pessoa->data_nascimento)
                        <div class="text-sm text-gray-900 dark:text-white">
                            @if($canViewSensitiveData)
                                {{ $pessoa->data_nascimento->format('d/m/Y') }}
                                @if($pessoa->idade)
                                    <span class="text-gray-500 dark:text-gray-400">({{ $pessoa->idade }} anos)</span>
                                @endif
                            @else
                                {{ LgpdHelper::maskBirthDate($pessoa->data_nascimento) }}
                            @endif
                        </div>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sexo</label>
                    <div>
                        <x-pessoas::badge :variant="$pessoa->sexo_cor">{{ $pessoa->sexo_texto }}</x-pessoas::badge>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código Familiar</label>
                    @if($pessoa->cod_familiar_fam)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200">
                            {{ $pessoa->cod_familiar_fam }}
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                    @if($pessoa->localidade)
                        <a href="{{ route('localidades.show', $pessoa->localidade) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            {{ $pessoa->localidade->nome }}
                        </a>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">Não vinculada</span>
                    @endif
                </div>
            </div>
        </x-pessoas::card>

        <!-- Informações Adicionais -->
        <x-pessoas::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h69.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Informações Adicionais
                </h3>
            </x-slot>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Beneficiária PBF</label>
                    @if($pessoa->recebe_pbf)
                        <x-pessoas::badge variant="success">
                            <svg class="w-3 h-3 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sim
                        </x-pessoas::badge>
                    @else
                        <x-pessoas::badge variant="default">Não</x-pessoas::badge>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ref. CadÚnico</label>
                    @if($pessoa->ref_cad)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200">
                            {{ $pessoa->ref_cad }}
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ref. PBF</label>
                    @if($pessoa->ref_pbf)
                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200">
                            {{ $pessoa->ref_pbf }}
                        </code>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>

                @if($pessoa->nom_completo_mae_pessoa)
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome da Mãe</label>
                    <div class="text-sm text-gray-900 dark:text-white">
                        @if($canViewSensitiveData)
                            {{ $pessoa->nom_completo_mae_pessoa }}
                        @else
                            {{ LgpdHelper::maskName($pessoa->nom_completo_mae_pessoa) }}
                        @endif
                    </div>
                </div>
                @endif

                @if($pessoa->nom_completo_pai_pessoa)
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome do Pai</label>
                    <div class="text-sm text-gray-900 dark:text-white">
                        @if($canViewSensitiveData)
                            {{ $pessoa->nom_completo_pai_pessoa }}
                        @else
                            {{ LgpdHelper::maskName($pessoa->nom_completo_pai_pessoa) }}
                        @endif
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                    @if($pessoa->ativo)
                        <x-pessoas::badge variant="success">Ativo</x-pessoas::badge>
                    @else
                        <x-pessoas::badge variant="danger">Inativo</x-pessoas::badge>
                    @endif
                </div>
            </div>
        </x-pessoas::card>
    </div>

    <!-- Família -->
    @if($familia->count() > 0)
    <x-pessoas::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Membros da Família
            </h3>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIS</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">CPF</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Nasc.</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($familia as $membro)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            @if($canViewSensitiveData)
                                {{ $membro->nom_pessoa }}
                            @else
                                {{ LgpdHelper::maskName($membro->nom_pessoa) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($membro->num_nis_pessoa_atual)
                                <code class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-800 dark:text-gray-200">
                                    @if($canViewSensitiveData)
                                        {{ $membro->nis_formatado }}
                                    @else
                                        {{ LgpdHelper::maskNis($membro->num_nis_pessoa_atual) }}
                                    @endif
                                </code>
                            @else
                                <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($membro->num_cpf_pessoa)
                                <code class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-800 dark:text-gray-200">
                                    @if($canViewSensitiveData)
                                        {{ $membro->cpf_formatado }}
                                    @else
                                        {{ LgpdHelper::maskCpf($membro->num_cpf_pessoa) }}
                                    @endif
                                </code>
                            @else
                                <span class="text-sm text-gray-400 dark:text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            @if($membro->data_nascimento)
                                @if($canViewSensitiveData)
                                    {{ $membro->data_nascimento->format('d/m/Y') }}
                                @else
                                    {{ LgpdHelper::maskBirthDate($membro->data_nascimento) }}
                                @endif
                            @else
                                <span class="text-gray-400 dark:text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('pessoas.show', $membro) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                <svg class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-pessoas::card>
    @endif

    <!-- Observações -->
    @if($pessoa->observacoes)
    <x-pessoas::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Observações
            </h3>
        </x-slot>

        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $pessoa->observacoes }}</p>
    </x-pessoas::card>
    @endif
</div>
@endsection
