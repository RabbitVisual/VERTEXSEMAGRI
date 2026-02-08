@extends('Co-Admin.layouts.app')

@section('title', 'Novo Funcionário')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 dark:from-emerald-800 dark:to-emerald-900 rounded-2xl shadow-xl p-6 md:p-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-module-icon module="Funcionarios" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Cadastrar Novo Funcionário</h1>
                    <p class="text-emerald-100 dark:text-emerald-200 mt-2 text-sm md:text-base">
                        Preencha as informações abaixo para adicionar um novo funcionário ao sistema
                    </p>
                </div>
            </div>
            <x-funcionarios::button href="{{ route('funcionarios.index') }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                <x-funcionarios::icon name="arrow-left" class="w-5 h-5 mr-2" />
                Voltar
            </x-funcionarios::button>
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <x-funcionarios::alert type="danger" dismissible>
            <div class="flex items-start gap-2">
                <x-funcionarios::icon name="exclamation-triangle" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <div>
                    <p class="font-medium mb-2">Por favor, corrija os seguintes erros:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-funcionarios::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2 space-y-6">
            <x-funcionarios::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-funcionarios::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações do Funcionário
                        </h3>
                    </div>
                </x-slot>

                <form action="{{ route('funcionarios.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-funcionarios::icon name="user" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Básicas
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <x-funcionarios::form.input
                                    label="Nome"
                                    name="nome"
                                    type="text"
                                    required
                                    value="{{ old('nome') }}"
                                    placeholder="Nome completo"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        value=""
                                        placeholder="Será gerado automaticamente"
                                        disabled
                                        readonly
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                                    />
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Será gerado automaticamente ao salvar
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-funcionarios::form.input
                                label="CPF"
                                name="cpf"
                                type="text"
                                value="{{ old('cpf') }}"
                                placeholder="000.000.000-00"
                            />
                            <x-funcionarios::form.select
                                label="Função"
                                name="funcao"
                                required
                            >
                                <option value="">Selecione</option>
                                <option value="eletricista" {{ old('funcao') == 'eletricista' ? 'selected' : '' }}>Eletricista</option>
                                <option value="encanador" {{ old('funcao') == 'encanador' ? 'selected' : '' }}>Encanador</option>
                                <option value="operador" {{ old('funcao') == 'operador' ? 'selected' : '' }}>Operador</option>
                                <option value="motorista" {{ old('funcao') == 'motorista' ? 'selected' : '' }}>Motorista</option>
                                <option value="supervisor" {{ old('funcao') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="tecnico" {{ old('funcao') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="outro" {{ old('funcao') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </x-funcionarios::form.select>
                        </div>
                    </div>

                    <!-- Contato -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <x-funcionarios::icon name="phone" class="w-4 h-4 text-green-600 dark:text-green-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Contato
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-funcionarios::form.input
                                label="Telefone"
                                name="telefone"
                                type="text"
                                value="{{ old('telefone') }}"
                                placeholder="(00) 00000-0000"
                            />
                            <div>
                                <x-funcionarios::form.input
                                    label="Email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    placeholder="email@exemplo.com"
                                />
                                <div id="email_info_box" class="mt-2 hidden p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex items-start gap-2">
                                        <x-funcionarios::icon name="envelope" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                                        <div class="flex-1">
                                            <p class="text-sm text-emerald-800 dark:text-emerald-200">
                                                <strong>Email de Boas-vindas:</strong> Se o funcionário estiver ativo e tiver email cadastrado, será enviado automaticamente um email com as credenciais de acesso ao sistema.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <x-funcionarios::icon name="calendar" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Datas
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-funcionarios::form.input
                                label="Data de Admissão"
                                name="data_admissao"
                                type="date"
                                value="{{ old('data_admissao') }}"
                            />
                            <x-funcionarios::form.input
                                label="Data de Demissão"
                                name="data_demissao"
                                type="date"
                                value="{{ old('data_demissao') }}"
                            />
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                <x-funcionarios::icon name="document-text" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Observações
                            </h4>
                        </div>

                        <x-funcionarios::form.textarea
                            label="Observações"
                            name="observacoes"
                            rows="3"
                            value="{{ old('observacoes') }}"
                            placeholder="Informações adicionais sobre o funcionário"
                        />
                    </div>

                    <!-- Status -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Funcionário ativo
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Funcionários ativos aparecem nas listagens e podem ser adicionados a equipes
                        </p>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-funcionarios::button href="{{ route('funcionarios.index') }}" variant="outline">
                            Cancelar
                        </x-funcionarios::button>
                        <x-funcionarios::button type="submit" variant="primary">
                            <x-funcionarios::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Salvar Funcionário
                        </x-funcionarios::button>
                    </div>
                </form>
            </x-funcionarios::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1 space-y-6">
            <x-funcionarios::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <x-funcionarios::icon name="light-bulb" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Dicas
                        </h3>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <x-funcionarios::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Código</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Será gerado automaticamente no formato FUNC-FUNCAO-YYYYMMDD-XXXX se deixado em branco.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                        <div class="flex items-start gap-3">
                            <x-funcionarios::icon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">CPF</h4>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    Deve ser único para cada funcionário. O sistema validará automaticamente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-start gap-3">
                            <x-funcionarios::icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-emerald-900 dark:text-emerald-200 mb-1">Equipes</h4>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300">
                                    Após cadastrar, você poderá adicionar este funcionário a uma ou mais equipes no módulo de Equipes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <x-funcionarios::icon name="envelope" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Notificação por Email</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Se o funcionário estiver ativo e tiver email cadastrado, receberá automaticamente um email com as credenciais de acesso ao sistema.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-funcionarios::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara CPF
    const cpfField = document.getElementById('cpf');
    if (cpfField) {
        cpfField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });
    }

    // Máscara Telefone
    const telefoneField = document.getElementById('telefone');
    if (telefoneField) {
        telefoneField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                e.target.value = value;
            }
        });
    }

    // Mostrar/ocultar aviso de email
    const emailInput = document.getElementById('email');
    const ativoCheckbox = document.getElementById('ativo');
    const emailInfoBox = document.getElementById('email_info_box');

    function mostrarAvisoEmail() {
        if (emailInput && emailInfoBox) {
            const temEmail = emailInput.value.trim() !== '';
            const estaAtivo = ativoCheckbox && ativoCheckbox.checked;

            if (temEmail && estaAtivo) {
                emailInfoBox.classList.remove('hidden');
            } else {
                emailInfoBox.classList.add('hidden');
            }
        }
    }

    if (emailInput) {
        emailInput.addEventListener('input', mostrarAvisoEmail);
        emailInput.addEventListener('blur', mostrarAvisoEmail);
    }

    if (ativoCheckbox) {
        ativoCheckbox.addEventListener('change', mostrarAvisoEmail);
    }

    // Verificar ao carregar
    mostrarAvisoEmail();
});
</script>
@endpush
@endsection
