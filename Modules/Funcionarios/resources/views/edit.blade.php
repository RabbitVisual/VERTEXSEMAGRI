@extends('Co-Admin.layouts.app')

@section('title', 'Editar Funcionário')

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
                    <h1 class="text-3xl font-bold">Editar Funcionário</h1>
                    <p class="text-emerald-100 dark:text-emerald-200 mt-2 text-sm md:text-base">
                        {{ $funcionario->nome }}
                    </p>
                </div>
            </div>
            <x-funcionarios::button href="{{ route('funcionarios.show', $funcionario) }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                <x-funcionarios::icon name="arrow-left" class="w-5 h-5 mr-2" />
                Voltar
            </x-funcionarios::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-funcionarios::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-funcionarios::icon name="check-circle" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-funcionarios::alert>
    @endif

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

                <form action="{{ route('funcionarios.update', $funcionario) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                                    value="{{ old('nome', $funcionario->nome) }}"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código
                                </label>
                                @if($funcionario->codigo)
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value="{{ $funcionario->codigo }}"
                                            disabled
                                            readonly
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-white font-mono cursor-not-allowed"
                                        />
                                        <div class="absolute inset-0 flex items-center justify-end pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
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
                                @endif
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @if($funcionario->codigo)
                                        Código já atribuído. Será gerado automaticamente se estiver vazio ao salvar.
                                    @else
                                        Será gerado automaticamente ao salvar
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-funcionarios::form.input
                                label="CPF"
                                name="cpf"
                                type="text"
                                value="{{ old('cpf', $funcionario->cpf) }}"
                                placeholder="000.000.000-00"
                            />
                            <x-funcionarios::form.select
                                label="Função"
                                name="funcao"
                                required
                            >
                                <option value="">Selecione</option>
                                <option value="eletricista" {{ old('funcao', $funcionario->funcao) == 'eletricista' ? 'selected' : '' }}>Eletricista</option>
                                <option value="encanador" {{ old('funcao', $funcionario->funcao) == 'encanador' ? 'selected' : '' }}>Encanador</option>
                                <option value="operador" {{ old('funcao', $funcionario->funcao) == 'operador' ? 'selected' : '' }}>Operador</option>
                                <option value="motorista" {{ old('funcao', $funcionario->funcao) == 'motorista' ? 'selected' : '' }}>Motorista</option>
                                <option value="supervisor" {{ old('funcao', $funcionario->funcao) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="tecnico" {{ old('funcao', $funcionario->funcao) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="outro" {{ old('funcao', $funcionario->funcao) == 'outro' ? 'selected' : '' }}>Outro</option>
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
                                value="{{ old('telefone', $funcionario->telefone) }}"
                                placeholder="(00) 00000-0000"
                            />
                            <x-funcionarios::form.input
                                label="Email"
                                name="email"
                                type="email"
                                value="{{ old('email', $funcionario->email) }}"
                            />
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
                                value="{{ old('data_admissao', $funcionario->data_admissao?->format('Y-m-d')) }}"
                            />
                            <x-funcionarios::form.input
                                label="Data de Demissão"
                                name="data_demissao"
                                type="date"
                                value="{{ old('data_demissao', $funcionario->data_demissao?->format('Y-m-d')) }}"
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
                            value="{{ old('observacoes', $funcionario->observacoes) }}"
                        />
                    </div>

                    <!-- Status -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $funcionario->ativo) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Funcionário ativo
                            </label>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-funcionarios::button href="{{ route('funcionarios.show', $funcionario) }}" variant="outline">
                            Cancelar
                        </x-funcionarios::button>
                        <x-funcionarios::button type="submit" variant="primary">
                            <x-funcionarios::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Atualizar Funcionário
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
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-funcionarios::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações
                        </h3>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                        <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $funcionario->id }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $funcionario->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($funcionario->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $funcionario->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
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
});
</script>
@endpush
@endsection
