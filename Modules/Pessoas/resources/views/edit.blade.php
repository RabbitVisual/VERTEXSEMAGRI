@extends('Co-Admin.layouts.app')

@section('title', \App\Helpers\TranslationHelper::translateLabel('Editar Pessoa'))

@section('content')
@php
    use App\Helpers\TranslationHelper;
    $canViewSensitiveData = \App\Helpers\LgpdHelper::canViewSensitiveData();
@endphp
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pessoas" class="w-6 h-6" />
                {{ TranslationHelper::translateLabel('Editar Pessoa') }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                @if($canViewSensitiveData)
                    {{ $pessoa->nom_pessoa ?? 'Pessoa' }}
                @else
                    {{ \App\Helpers\LgpdHelper::maskName($pessoa->nom_pessoa) }}
                @endif
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-pessoas::button href="{{ route('pessoas.show', $pessoa) }}" variant="outline">
                <x-icon name="arrow-left" class="w-5 h-5" />
                {{ TranslationHelper::translateButton('Voltar') }}
            </x-pessoas::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-pessoas::alert type="success" dismissible>
            {{ session('success') }}
        </x-pessoas::alert>
    @endif

    @if($errors->any())
        <x-pessoas::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-pessoas::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-pessoas::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        {{ TranslationHelper::translateLabel('Informações da Pessoa') }}
                    </h3>
                </x-slot>

                <form action="{{ route('pessoas.update', $pessoa) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @php
                        $isCadastroManual = is_null($pessoa->ref_cad);
                    @endphp

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <div class="p-4 {{ $isCadastroManual ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800' : 'bg-gray-50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-700' }} rounded-lg border">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                @if($isCadastroManual)
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    {{ TranslationHelper::translateLabel('Dados Básicos (Cadastro Manual - Editável)') }}
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    {{ TranslationHelper::translateLabel('Dados do Cadastro Único (Somente Leitura)') }}
                                @endif
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Nome') }}</label>
                                    @if($isCadastroManual)
                                        <input type="text"
                                               name="nom_pessoa"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white sm:text-sm"
                                               value="{{ old('nom_pessoa', $pessoa->nom_pessoa) }}"
                                               required>
                                    @else
                                        <input type="text"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                               value="{{ $canViewSensitiveData ? $pessoa->nom_pessoa : \App\Helpers\LgpdHelper::maskName($pessoa->nom_pessoa) }}"
                                               disabled>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('NIS') }}</label>
                                    @if($isCadastroManual)
                                        <input type="text"
                                               name="num_nis_pessoa_atual"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white sm:text-sm"
                                               value="{{ old('num_nis_pessoa_atual', $pessoa->num_nis_pessoa_atual) }}">
                                    @else
                                        <input type="text"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                               value="{{ $canViewSensitiveData ? $pessoa->num_nis_pessoa_atual : \App\Helpers\LgpdHelper::maskNis($pessoa->num_nis_pessoa_atual) }}"
                                               disabled>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('CPF') }}</label>
                                    @if($isCadastroManual)
                                        <input type="text"
                                               name="num_cpf_pessoa"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white sm:text-sm"
                                               value="{{ old('num_cpf_pessoa', $pessoa->num_cpf_pessoa) }}"
                                               required>
                                    @else
                                        <input type="text"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                               value="{{ $canViewSensitiveData ? $pessoa->num_cpf_pessoa : \App\Helpers\LgpdHelper::maskCpf($pessoa->num_cpf_pessoa) }}"
                                               disabled>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Data de Nascimento') }}</label>
                                    @if($isCadastroManual)
                                        <input type="date"
                                               name="dta_nasc_pessoa"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white sm:text-sm"
                                               value="{{ old('dta_nasc_pessoa', $pessoa->dta_nasc_pessoa ? $pessoa->dta_nasc_pessoa->format('Y-m-d') : '') }}"
                                               required>
                                    @else
                                        <input type="text"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                               value="{{ $pessoa->data_nascimento ? ($canViewSensitiveData ? $pessoa->data_nascimento->format('d/m/Y') : \App\Helpers\LgpdHelper::maskBirthDate($pessoa->data_nascimento)) : 'N/A' }}"
                                               disabled>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Sexo') }}</label>
                                    @if($isCadastroManual)
                                        <select name="cod_sexo_pessoa"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white sm:text-sm"
                                                required>
                                            <option value="">{{ TranslationHelper::translateLabel('Selecione') }}</option>
                                            <option value="1" {{ old('cod_sexo_pessoa', $pessoa->cod_sexo_pessoa) == '1' ? 'selected' : '' }}>{{ TranslationHelper::translateLabel('Masculino') }}</option>
                                            <option value="2" {{ old('cod_sexo_pessoa', $pessoa->cod_sexo_pessoa) == '2' ? 'selected' : '' }}>{{ TranslationHelper::translateLabel('Feminino') }}</option>
                                        </select>
                                    @else
                                        <input type="text"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                               value="{{ $pessoa->sexo_texto ?? 'N/A' }}"
                                               disabled>
                                    @endif
                                </div>
                            </div>
                            @if($isCadastroManual)
                                <p class="mt-3 text-xs text-emerald-700 dark:text-emerald-300">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    {{ TranslationHelper::translateLabel('Este é um cadastro manual. Você pode editar os dados básicos.') }}
                                </p>
                            @else
                                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    {{ TranslationHelper::translateLabel('Dados do Cadastro Único não podem ser alterados diretamente') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Dados do Cadastro Único (Sempre bloqueados) -->
                    @if(!$isCadastroManual)
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            {{ TranslationHelper::translateLabel('Dados do Sistema e Cadastro Único (Bloqueados)') }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Ref. CadÚnico') }}</label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value="{{ $pessoa->ref_cad ?? 'N/A' }}"
                                       disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Ref. PBF') }}</label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value="{{ $pessoa->ref_pbf ?? 'N/A' }}"
                                       disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Código IBGE') }}</label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value="{{ $pessoa->cd_ibge ?? 'N/A' }}"
                                       disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Código Familiar') }}</label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value="{{ $pessoa->cod_familiar_fam ?? 'N/A' }}"
                                       disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ TranslationHelper::translateLabel('Sexo') }}</label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value="{{ $pessoa->sexo_texto ?? 'N/A' }}"
                                       disabled>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Dados Familiares (Apenas para cadastros manuais) -->
                    @if($isCadastroManual)
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            {{ TranslationHelper::translateLabel('Informações Familiares (Editável)') }}
                        </h4>

                        <x-pessoas::form.input
                            label="{{ TranslationHelper::translateLabel('Nome da Mãe') }}"
                            name="nom_completo_mae_pessoa"
                            type="text"
                            value="{{ old('nom_completo_mae_pessoa', $pessoa->nom_completo_mae_pessoa) }}"
                            placeholder="{{ TranslationHelper::translateLabel('Nome completo da mãe') }}"
                        />

                        <x-pessoas::form.input
                            label="{{ TranslationHelper::translateLabel('Nome do Pai') }}"
                            name="nom_completo_pai_pessoa"
                            type="text"
                            value="{{ old('nom_completo_pai_pessoa', $pessoa->nom_completo_pai_pessoa) }}"
                            placeholder="{{ TranslationHelper::translateLabel('Nome completo do pai') }}"
                        />
                    </div>
                    @endif

                    <!-- Campos Editáveis -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            {{ TranslationHelper::translateLabel('Vinculação e Status') }}
                        </h4>

                        <div class="mb-4">
                            <label for="localidade_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ TranslationHelper::translateLabel('Localidade') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="localidade_id"
                                    name="localidade_id"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                <option value="">{{ TranslationHelper::translateLabel('Selecione uma localidade') }}</option>
                                @foreach($localidades as $localidade)
                                    <option value="{{ $localidade->id }}" {{ old('localidade_id', $pessoa->localidade_id) == $localidade->id ? 'selected' : '' }}>
                                        {{ $localidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ TranslationHelper::translateLabel('Vincule esta pessoa a uma localidade para melhor mapeamento') }}</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $pessoa->ativo) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                {{ TranslationHelper::translateStatus('Ativo') }}
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ TranslationHelper::translateLabel('Desative apenas se necessário (ex: pessoa falecida ou mudou de município)') }}
                        </p>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-pessoas::button href="{{ route('pessoas.show', $pessoa) }}" variant="outline">
                            {{ TranslationHelper::translateButton('Cancelar') }}
                        </x-pessoas::button>
                        <x-pessoas::button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ TranslationHelper::translateButton('Salvar Alterações') }}
                        </x-pessoas::button>
                    </div>
                </form>
            </x-pessoas::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1">
            <x-pessoas::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        {{ TranslationHelper::translateLabel('Informações') }}
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">{{ TranslationHelper::translateLabel('Nota Importante') }}</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    {{ TranslationHelper::translateLabel('Os dados do Cadastro Único são importados de fontes oficiais e não devem ser alterados diretamente neste sistema.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ TranslationHelper::translateLabel('Você pode:') }}</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ TranslationHelper::translateLabel('Vincular a pessoa a uma localidade') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ TranslationHelper::translateLabel('Adicionar observações') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ TranslationHelper::translateLabel('Ativar/desativar o registro') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Informações Rápidas -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ TranslationHelper::translateLabel('Informações Rápidas') }}</h4>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ TranslationHelper::translateLabel('ID:') }}</span>
                                <span class="text-gray-900 dark:text-white font-medium">#{{ $pessoa->id }}</span>
                            </div>
                            @if($pessoa->cod_familiar_fam)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ TranslationHelper::translateLabel('Família:') }}</span>
                                <code class="text-gray-900 dark:text-white font-medium">{{ $pessoa->cod_familiar_fam }}</code>
                            </div>
                            @endif
                            @if($pessoa->recebe_pbf)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 dark:text-gray-400">{{ TranslationHelper::translateLabel('PBF:') }}</span>
                                <x-pessoas::badge variant="success" size="sm">{{ TranslationHelper::translateLabel('Sim') }}</x-pessoas::badge>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-pessoas::card>
        </div>
    </div>
</div>
@endsection
