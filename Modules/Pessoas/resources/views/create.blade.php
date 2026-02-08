@extends('Co-Admin.layouts.app')

@section('title', 'Cadastrar Pessoa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pessoas" class="w-6 h-6" />
                Cadastrar Pessoa
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cadastre uma nova pessoa no sistema</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-pessoas::button href="{{ route('pessoas.index') }}" variant="outline">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </x-pessoas::button>
        </div>
    </div>

    <!-- Alertas -->
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
                        Dados da Pessoa
                    </h3>
                </x-slot>

                <form action="{{ route('pessoas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informação sobre Cadastro Único vs Manual -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Sobre os Dados</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    <strong>Dados do Cadastro Único:</strong> Alguns dados são migrados do Cadastro Único (CadÚnico) e são identificados com o ícone
                                    <svg class="w-4 h-4 inline mx-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    <strong>Dados Manuais:</strong> Outros dados são cadastrados manualmente no sistema.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dados Básicos -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Informações Básicas (Manual)
                        </h4>

                        <x-pessoas::form.input
                            label="Nome Completo"
                            name="nom_pessoa"
                            type="text"
                            required
                            value="{{ old('nom_pessoa') }}"
                            placeholder="Digite o nome completo"
                        />

                        <x-pessoas::form.input
                            label="Apelido/Nome Social"
                            name="nom_apelido_pessoa"
                            type="text"
                            value="{{ old('nom_apelido_pessoa') }}"
                            placeholder="Opcional"
                        />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-pessoas::form.input
                                label="NIS"
                                name="num_nis_pessoa_atual"
                                type="text"
                                value="{{ old('num_nis_pessoa_atual') }}"
                                placeholder="000.00000.00-0"
                                help="Número de Identificação Social (Opcional)"
                            />

                            <x-pessoas::form.input
                                label="CPF"
                                name="num_cpf_pessoa"
                                type="text"
                                required
                                value="{{ old('num_cpf_pessoa') }}"
                                placeholder="000.000.000-00"
                                help="Cadastro de Pessoa Física (Obrigatório)"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-pessoas::form.select
                                label="Sexo"
                                name="cod_sexo_pessoa"
                                required
                            >
                                <option value="">Selecione</option>
                                <option value="1" {{ old('cod_sexo_pessoa') == '1' ? 'selected' : '' }}>Masculino</option>
                                <option value="2" {{ old('cod_sexo_pessoa') == '2' ? 'selected' : '' }}>Feminino</option>
                            </x-pessoas::form.select>

                            <x-pessoas::form.input
                                label="Data de Nascimento"
                                name="dta_nasc_pessoa"
                                type="date"
                                required
                                value="{{ old('dta_nasc_pessoa') }}"
                                help="Obrigatório"
                            />
                        </div>
                    </div>

                    <!-- Dados Familiares -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Informações Familiares (Manual)
                        </h4>

                        <x-pessoas::form.input
                            label="Nome da Mãe"
                            name="nom_completo_mae_pessoa"
                            type="text"
                            value="{{ old('nom_completo_mae_pessoa') }}"
                            placeholder="Nome completo da mãe"
                        />

                        <x-pessoas::form.input
                            label="Nome do Pai"
                            name="nom_completo_pai_pessoa"
                            type="text"
                            value="{{ old('nom_completo_pai_pessoa') }}"
                            placeholder="Nome completo do pai"
                        />

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Código Familiar
                                <svg class="w-4 h-4 inline ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" title="Campo bloqueado - Preenchido apenas em migração do Cadastro Único">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </label>
                            <input type="text"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                   value=""
                                   disabled
                                   placeholder="Bloqueado - Preenchido apenas em migração">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Código usado para agrupar membros da mesma família. Preenchido automaticamente em migração do Cadastro Único.
                            </p>
                        </div>
                    </div>

                    <!-- Dados do Sistema e Cadastro Único -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            Dados do Sistema e Cadastro Único
                            <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Bloqueados - Preenchidos apenas em migração)</span>
                        </h4>

                        <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                Estes campos são preenchidos automaticamente durante a migração de dados do Cadastro Único e não podem ser editados manualmente.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ref. CadÚnico
                                    <svg class="w-4 h-4 inline ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" title="Campo bloqueado">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value=""
                                       disabled
                                       placeholder="Bloqueado - Preenchido em migração">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Referência no Cadastro Único
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ref. PBF
                                    <svg class="w-4 h-4 inline ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" title="Campo bloqueado">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </label>
                                <input type="text"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                       value=""
                                       disabled
                                       placeholder="Bloqueado - Preenchido em migração">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Referência Programa Bolsa Família
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Código IBGE
                            </label>
                            <input type="text"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed sm:text-sm"
                                   value="2908903"
                                   disabled>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Código IBGE do município (padrão: 2908903)
                            </p>
                            <input type="hidden" name="cd_ibge" value="2908903">
                        </div>
                    </div>

                    <!-- Vinculação e Status -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            Vinculação e Status (Manual)
                        </h4>

                        <x-pessoas::form.select
                            label="Localidade"
                            name="localidade_id"
                            required
                            help="Vincule esta pessoa a uma localidade para melhor mapeamento (Obrigatório)"
                        >
                            <option value="">Selecione uma localidade</option>
                            @foreach($localidades as $localidade)
                                <option value="{{ $localidade->id }}" {{ old('localidade_id') == $localidade->id ? 'selected' : '' }}>
                                    {{ $localidade->nome }}
                                </option>
                            @endforeach
                        </x-pessoas::form.select>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Pessoa ativa
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Pessoas ativas aparecem nas listagens e podem ser vinculadas a demandas
                        </p>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-pessoas::button href="{{ route('pessoas.index') }}" variant="outline">
                            Cancelar
                        </x-pessoas::button>
                        <x-pessoas::button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Cadastrar Pessoa
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
                        Informações
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200 mb-1">Dados do Cadastro Único</h4>
                                <p class="text-xs text-indigo-800 dark:text-indigo-300">
                                    Alguns campos são marcados como "migrados do Cadastro Único". Estes são preenchidos automaticamente durante a importação de dados oficiais do CadÚnico.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-emerald-900 dark:text-emerald-200 mb-1">Dados Manuais</h4>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300">
                                    Os campos marcados como "Manual" podem ser preenchidos livremente e não dependem de importação do Cadastro Único.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Campos Obrigatórios:</h4>
                        <ul class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>Nome Completo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>CPF</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>Data de Nascimento</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>Sexo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>Localidade</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Dica:</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            Se esta pessoa já está cadastrada no Cadastro Único, você pode buscar por ela ao criar uma demanda. Caso contrário, cadastre aqui primeiro.
                        </p>
                    </div>
                </div>
            </x-pessoas::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara de CPF
    const cpfInput = document.getElementById('num_cpf_pessoa');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4');
                e.target.value = value;
            }
        });
    }

    // Máscara de NIS
    const nisInput = document.getElementById('num_nis_pessoa_atual');
    if (nisInput) {
        nisInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/^(\d{3})(\d{5})(\d{2})(\d{1}).*/, '$1.$2.$3-$4');
                e.target.value = value;
            }
        });
    }
});
</script>
@endpush
@endsection

