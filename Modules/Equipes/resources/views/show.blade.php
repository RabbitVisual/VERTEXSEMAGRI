@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Equipe')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 dark:from-indigo-800 dark:via-indigo-900 dark:to-indigo-950 rounded-2xl shadow-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm shadow-lg">
                    <x-module-icon module="Equipes" class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-2">
                        {{ $equipe->nome }}
                        @if($equipe->codigo)
                            <span class="text-indigo-100 dark:text-indigo-200 text-2xl font-normal">({{ $equipe->codigo }})</span>
                        @endif
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Detalhes completos da equipe
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-equipes::button href="{{ route('equipes.edit', $equipe) }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                    <x-equipes::icon name="pencil" class="w-5 h-5 mr-2" />
                    Editar
                </x-equipes::button>
                <x-equipes::button href="{{ route('equipes.index') }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                    <x-equipes::icon name="arrow-left" class="w-5 h-5 mr-2" />
                    Voltar
                </x-equipes::button>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-equipes::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-equipes::icon name="check-circle" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-equipes::alert>
    @endif

    @if(session('error'))
        <x-equipes::alert type="danger" dismissible>
            <div class="flex items-center gap-2">
                <x-equipes::icon name="exclamation-triangle" class="w-5 h-5" />
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </x-equipes::alert>
    @endif

    @if(session('warning'))
        <x-equipes::alert type="warning" dismissible>
            <div class="flex items-center gap-2">
                <x-equipes::icon name="exclamation-triangle" class="w-5 h-5" />
                <span class="font-medium">{!! session('warning') !!}</span>
            </div>
        </x-equipes::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-equipes::icon name="information-circle" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="membros" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-equipes::icon name="user-group" class="w-4 h-4 inline mr-2" />
                Funcionários
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-equipes::icon name="link" class="w-4 h-4 inline mr-2" />
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
                    <x-equipes::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <x-equipes::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Informações da Equipe
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $equipe->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @if($equipe->ativo)
                                            <x-equipes::badge variant="success">
                                                <x-equipes::icon name="check-circle" class="w-3 h-3 mr-1" />
                                                Ativo
                                            </x-equipes::badge>
                                        @else
                                            <x-equipes::badge variant="danger">
                                                <x-equipes::icon name="x-circle" class="w-3 h-3 mr-1" />
                                                Inativo
                                            </x-equipes::badge>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                    <div>
                                        <x-equipes::badge variant="info">
                                            <x-equipes::icon name="users" class="w-3 h-3 mr-1" />
                                            {{ ucfirst($equipe->tipo) }}
                                        </x-equipes::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Líder (Usuário)</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        @if($equipe->lider)
                                            <x-equipes::icon name="user-circle" class="w-4 h-4" />
                                            <strong>{{ $equipe->lider->name }}</strong>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Funcionários</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-equipes::icon name="user-group" class="w-4 h-4" />
                                        <strong>{{ $equipe->funcionarios->count() }} funcionário(s)</strong>
                                    </div>
                                </div>
                            </div>

                            @if($equipe->descricao)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Descrição</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $equipe->descricao }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-equipes::card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <x-equipes::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                    <x-equipes::icon name="bolt" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Ações Rápidas
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-3">
                            <x-equipes::button href="{{ route('equipes.edit', $equipe) }}" variant="primary" class="w-full">
                                <x-equipes::icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Equipe
                            </x-equipes::button>
                            @if(Route::has('ordens.create'))
                            <x-equipes::button href="{{ route('ordens.create', ['equipe_id' => $equipe->id]) }}" variant="success" class="w-full">
                                <x-equipes::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Criar OS
                            </x-equipes::button>
                            @endif
                            <form action="{{ route('equipes.destroy', $equipe) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar esta equipe?')">
                                @csrf
                                @method('DELETE')
                                <x-equipes::button type="submit" variant="danger" class="w-full">
                                    <x-equipes::icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-equipes::button>
                            </form>
                        </div>
                    </x-equipes::card>

                    <!-- Informações -->
                    <x-equipes::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <x-equipes::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Informações
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $equipe->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $equipe->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($equipe->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $equipe->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Funcionários</label>
                                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $equipe->funcionarios->count() }}</div>
                            </div>
                            @if($equipe->ordensServico->count() > 0)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ordens de Serviço</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $equipe->ordensServico->count() }}</div>
                            </div>
                            @endif
                        </div>
                    </x-equipes::card>
                </div>
            </div>
        </div>

        <!-- Tab Funcionários -->
        <div data-tab-panel="membros" class="hidden">
            <x-equipes::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <x-equipes::icon name="user-group" class="w-5 h-5 text-green-600 dark:text-green-400" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Funcionários da Equipe
                            </h3>
                        </div>
                        <x-equipes::badge variant="primary">{{ $equipe->funcionarios->count() }} funcionário(s)</x-equipes::badge>
                    </div>
                </x-slot>

                @if($equipe->funcionarios->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Função</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Telefone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($equipe->funcionarios as $funcionario)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $funcionario->codigo ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <x-equipes::icon name="user" class="w-5 h-5 text-gray-400" />
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $funcionario->nome }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-equipes::badge variant="info">{{ ucfirst($funcionario->funcao) }}</x-equipes::badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if($funcionario->telefone)
                                                <div class="flex items-center gap-1">
                                                    <x-equipes::icon name="phone" class="w-4 h-4" />
                                                    {{ $funcionario->telefone }}
                                                </div>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if($funcionario->email)
                                                <div class="flex items-center gap-1">
                                                    <x-equipes::icon name="envelope" class="w-4 h-4" />
                                                    {{ $funcionario->email }}
                                                </div>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if(Route::has('funcionarios.show'))
                                                <a href="{{ route('funcionarios.show', $funcionario) }}"
                                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                    <x-equipes::icon name="eye" class="w-5 h-5" />
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
                        <x-equipes::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                        <p class="text-gray-500 dark:text-gray-400 mb-2">Nenhum funcionário cadastrado nesta equipe</p>
                        <x-equipes::button href="{{ route('equipes.edit', $equipe) }}" variant="primary" class="mt-4">
                            <x-equipes::icon name="plus-circle" class="w-4 h-4 mr-2" />
                            Adicionar Funcionários
                        </x-equipes::button>
                    </div>
                @endif
            </x-equipes::card>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <x-equipes::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <x-equipes::icon name="link" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Ordens de Serviço Atribuídas
                        </h3>
                    </div>
                </x-slot>

                @if($equipe->ordensServico && $equipe->ordensServico->count() > 0)
                    <div class="space-y-2">
                        @foreach($equipe->ordensServico->take(10) as $os)
                            <a href="{{ route('ordens.show', $os) }}" class="block p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $os->numero ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $os->tipo_servico ?? 'N/A' }}</div>
                                    </div>
                                    <x-equipes::icon name="arrow-right" class="w-5 h-5 text-gray-400" />
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-equipes::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                        <p class="text-gray-500 dark:text-gray-400">Nenhuma ordem de serviço atribuída a esta equipe</p>
                    </div>
                @endif
            </x-equipes::card>
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
