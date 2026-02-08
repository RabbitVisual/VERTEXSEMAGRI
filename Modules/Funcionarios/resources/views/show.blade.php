@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Funcionário')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 dark:from-indigo-800 dark:via-indigo-900 dark:to-indigo-950 rounded-2xl shadow-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm shadow-lg">
                    <x-module-icon module="Funcionarios" class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-2">
                        {{ $funcionario->nome }}
                        @if($funcionario->codigo)
                            <span class="text-indigo-100 dark:text-indigo-200 text-2xl font-normal">({{ $funcionario->codigo }})</span>
                        @endif
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Detalhes completos do funcionário
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-funcionarios::button href="{{ route('funcionarios.edit', $funcionario) }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                    <x-funcionarios::icon name="pencil" class="w-5 h-5 mr-2" />
                    Editar
                </x-funcionarios::button>
                <x-funcionarios::button href="{{ route('funcionarios.index') }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                    <x-funcionarios::icon name="arrow-left" class="w-5 h-5 mr-2" />
                    Voltar
                </x-funcionarios::button>
            </div>
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

    @if(session('error'))
        <x-funcionarios::alert type="danger" dismissible>
            <div class="flex items-center gap-2">
                <x-funcionarios::icon name="exclamation-triangle" class="w-5 h-5" />
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </x-funcionarios::alert>
    @endif

    @if(session('warning'))
        <x-funcionarios::alert type="warning" dismissible>
            <div class="flex items-center gap-2">
                <x-funcionarios::icon name="exclamation-triangle" class="w-5 h-5" />
                <span class="font-medium">{!! session('warning') !!}</span>
            </div>
        </x-funcionarios::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-funcionarios::icon name="information-circle" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-funcionarios::icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        <!-- Tab Detalhes -->
        <div data-tab-panel="detalhes">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informações Básicas -->
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

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $funcionario->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @if($funcionario->ativo)
                                            <x-funcionarios::badge variant="success">
                                                <x-funcionarios::icon name="check-circle" class="w-3 h-3 mr-1" />
                                                Ativo
                                            </x-funcionarios::badge>
                                        @else
                                            <x-funcionarios::badge variant="danger">
                                                <x-funcionarios::icon name="x-circle" class="w-3 h-3 mr-1" />
                                                Inativo
                                            </x-funcionarios::badge>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $funcionario->nome }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Função</label>
                                    <div>
                                        <x-funcionarios::badge variant="info">
                                            <x-funcionarios::icon name="briefcase" class="w-3 h-3 mr-1" />
                                            {{ ucfirst($funcionario->funcao) }}
                                        </x-funcionarios::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">CPF</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $funcionario->cpf ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Telefone</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        @if($funcionario->telefone)
                                            <x-funcionarios::icon name="phone" class="w-4 h-4" />
                                            {{ $funcionario->telefone }}
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($funcionario->email)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                                <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                    <x-funcionarios::icon name="envelope" class="w-4 h-4" />
                                    {{ $funcionario->email }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-funcionarios::card>

                    <!-- Datas e Observações -->
                    @if($funcionario->data_admissao || $funcionario->data_demissao || $funcionario->observacoes)
                    <x-funcionarios::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <x-funcionarios::icon name="calendar" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Datas e Observações
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            @if($funcionario->data_admissao || $funcionario->data_demissao)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($funcionario->data_admissao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Admissão</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-funcionarios::icon name="calendar" class="w-4 h-4" />
                                        {{ $funcionario->data_admissao->format('d/m/Y') }}
                                    </div>
                                </div>
                                @endif
                                @if($funcionario->data_demissao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Demissão</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-funcionarios::icon name="calendar-x-mark" class="w-4 h-4" />
                                        {{ $funcionario->data_demissao->format('d/m/Y') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($funcionario->observacoes)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $funcionario->observacoes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-funcionarios::card>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <x-funcionarios::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                    <x-funcionarios::icon name="bolt" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Ações Rápidas
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-3">
                            <x-funcionarios::button href="{{ route('funcionarios.edit', $funcionario) }}" variant="primary" class="w-full">
                                <x-funcionarios::icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Funcionário
                            </x-funcionarios::button>
                            @if($funcionario->email && filter_var($funcionario->email, FILTER_VALIDATE_EMAIL))
                            <form action="{{ route('funcionarios.reenviar-email', $funcionario) }}" method="POST" class="w-full" onsubmit="return confirm('Deseja realmente reenviar o email de credenciais para {$funcionario->email}?')">
                                @csrf
                                <x-funcionarios::button type="submit" variant="info" class="w-full">
                                    <x-funcionarios::icon name="envelope" class="w-4 h-4 mr-2" />
                                    Reenviar Email de Credenciais
                                    <span class="text-xs opacity-75 block">Para: {{ $funcionario->email }}</span>
                                </x-funcionarios::button>
                            </form>
                            @endif
                            @if(Route::has('equipes.index'))
                            <x-funcionarios::button href="{{ route('equipes.index') }}" variant="success" class="w-full">
                                <x-funcionarios::icon name="users" class="w-4 h-4 mr-2" />
                                Gerenciar Equipes
                            </x-funcionarios::button>
                            @endif
                            <form action="{{ route('funcionarios.destroy', $funcionario) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar este funcionário?')">
                                @csrf
                                @method('DELETE')
                                <x-funcionarios::button type="submit" variant="danger" class="w-full">
                                    <x-funcionarios::icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-funcionarios::button>
                            </form>
                        </div>
                    </x-funcionarios::card>

                    <!-- Informações -->
                    <x-funcionarios::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <x-funcionarios::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
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
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Equipes vinculadas</label>
                                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $funcionario->equipes->count() }}</div>
                            </div>
                        </div>
                    </x-funcionarios::card>
                </div>
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <x-funcionarios::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <x-funcionarios::icon name="user-group" class="w-5 h-5 text-green-600 dark:text-green-400" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Equipes
                            </h3>
                        </div>
                        <x-funcionarios::badge variant="primary">{{ $funcionario->equipes->count() }} equipe(s)</x-funcionarios::badge>
                    </div>
                </x-slot>

                @if($funcionario->equipes && $funcionario->equipes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($funcionario->equipes as $equipe)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $equipe->codigo ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-funcionarios::badge variant="info">{{ ucfirst($equipe->tipo) }}</x-funcionarios::badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($equipe->ativo)
                                                <x-funcionarios::badge variant="success">Ativo</x-funcionarios::badge>
                                            @else
                                                <x-funcionarios::badge variant="danger">Inativo</x-funcionarios::badge>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if(Route::has('equipes.show'))
                                                <a href="{{ route('equipes.show', $equipe) }}"
                                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                    <x-funcionarios::icon name="eye" class="w-5 h-5" />
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-funcionarios::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                        <p class="text-gray-500 dark:text-gray-400 mb-2">Este funcionário não está vinculado a nenhuma equipe</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">Para adicionar este funcionário a uma equipe, acesse o módulo de Equipes</p>
                        @if(Route::has('equipes.index'))
                            <x-funcionarios::button href="{{ route('equipes.index') }}" variant="primary">
                                <x-funcionarios::icon name="users" class="w-4 h-4 mr-2" />
                                Ver Equipes
                            </x-funcionarios::button>
                        @endif
                    </div>
                @endif
            </x-funcionarios::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab-target');

            // Remove active state from all buttons and panels
            tabButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            tabPanels.forEach(panel => {
                panel.classList.add('hidden');
            });

            // Add active state to clicked button and corresponding panel
            button.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            button.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            document.querySelector(`[data-tab-panel="${targetTab}"]`).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection
