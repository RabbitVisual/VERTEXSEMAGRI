@extends('Co-Admin.layouts.app')

@section('title', 'Funcionários')

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
                        Gestão de Funcionários
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Cadastro de funcionários - Primeiro passo para criar equipes de trabalho
                    </p>
                </div>
            </div>
            <x-funcionarios::button href="{{ route('funcionarios.create') }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                <x-funcionarios::icon name="plus-circle" class="w-5 h-5 mr-2" />
                Novo Funcionário
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

    <!-- Estatísticas -->
    @if(isset($stats))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-stretch">
        <x-funcionarios::stat-card
            title="Total de Funcionários"
            :value="$stats['total'] ?? 0"
            icon="users"
            color="primary"
            subtitle="Todos os funcionários cadastrados"
        />
        <x-funcionarios::stat-card
            title="Funcionários Ativos"
            :value="$stats['ativos'] ?? 0"
            icon="check-circle"
            color="success"
            subtitle="Em operação no sistema"
        />
        <x-funcionarios::stat-card
            title="Com Equipe"
            :value="$stats['com_equipe'] ?? 0"
            icon="user-group"
            color="info"
            subtitle="Vinculados a equipes"
        />
        <x-funcionarios::stat-card
            title="Sem Equipe"
            :value="$stats['sem_equipe'] ?? 0"
            icon="user-minus"
            color="warning"
            subtitle="Aguardando alocação"
        />
    </div>
    @endif

    <!-- Filtros -->
    <x-funcionarios::filter-bar
        action="{{ route('funcionarios.index') }}"
        :filters="[
            [
                'name' => 'funcao',
                'label' => 'Função',
                'type' => 'select',
                'options' => [
                    '' => 'Todas',
                    'eletricista' => 'Eletricista',
                    'encanador' => 'Encanador',
                    'operador' => 'Operador',
                    'motorista' => 'Motorista',
                    'supervisor' => 'Supervisor',
                    'tecnico' => 'Técnico',
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
                'name' => 'com_equipe',
                'label' => 'Equipe',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Com Equipe',
                    '0' => 'Sem Equipe'
                ],
            ]
        ]"
        search-placeholder="Buscar por nome, código, CPF ou email..."
    />

    <!-- Informações de Resultados e Paginação Superior -->
    @if($funcionarios->total() > 0)
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl px-6 py-4 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                    <x-funcionarios::icon name="information-circle" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                        <span class="text-lg text-indigo-600 dark:text-indigo-400">{{ $funcionarios->total() }}</span>
                        {{ $funcionarios->total() == 1 ? 'funcionário encontrado' : 'funcionários encontrados' }}
                    </p>
                    @if(request()->hasAny(['search', 'funcao', 'ativo', 'com_equipe']))
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                            Com os filtros aplicados
                        </p>
                    @endif
                </div>
            </div>
            @if($funcionarios->hasPages())
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm">
                <x-funcionarios::icon name="document-text" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">
                    Página <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $funcionarios->currentPage() }}</span> de <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $funcionarios->lastPage() }}</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tabela de Funcionários -->
    <x-funcionarios::data-table
        :headers="['Código', 'Nome', 'CPF', 'Função', 'Equipes', 'Telefone', 'Status']"
        :data="$funcionarios"
        export-route="{{ route('funcionarios.index') }}"
    >
        @forelse($funcionarios as $funcionario)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-800 dark:from-indigo-900/30 dark:to-indigo-800/30 dark:text-indigo-300 shadow-sm">
                        {{ $funcionario->codigo ?? 'N/A' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-xl shadow-sm">
                            <x-funcionarios::icon name="user" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $funcionario->nome }}</div>
                            @if($funcionario->email)
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                    <x-funcionarios::icon name="envelope" class="w-3 h-3" />
                                    {{ $funcionario->email }}
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                    {{ $funcionario->cpf ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-funcionarios::badge variant="info">
                        <x-funcionarios::icon name="briefcase" class="w-3 h-3 mr-1" />
                        {{ ucfirst($funcionario->funcao) }}
                    </x-funcionarios::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($funcionario->equipes && $funcionario->equipes->count() > 0)
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <x-funcionarios::icon name="user-group" class="w-4 h-4 text-green-600 dark:text-green-400" />
                            </div>
                            <x-funcionarios::badge variant="success">
                                {{ $funcionario->equipes->count() }} equipe(s)
                            </x-funcionarios::badge>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500 text-sm">Sem equipe</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    @if($funcionario->telefone)
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-funcionarios::icon name="phone" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <span class="font-medium">{{ $funcionario->telefone }}</span>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
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
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('funcionarios.show', $funcionario) }}"
                           class="p-2.5 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-all hover:scale-110"
                           title="Ver detalhes">
                            <x-funcionarios::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('funcionarios.edit', $funcionario) }}"
                           class="p-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all hover:scale-110"
                           title="Editar">
                            <x-funcionarios::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('funcionarios.destroy', $funcionario) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja deletar este funcionário? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all hover:scale-110"
                                    title="Deletar">
                                <x-funcionarios::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center max-w-md mx-auto">
                        <div class="p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                            <x-funcionarios::icon name="inbox" class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Nenhum funcionário encontrado
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 text-center leading-relaxed">
                            @if(request()->hasAny(['search', 'funcao', 'ativo', 'com_equipe']))
                                Não encontramos funcionários com os filtros aplicados. Tente ajustar os filtros ou limpar a busca para ver todos os funcionários disponíveis.
                            @else
                                Comece cadastrando seu primeiro funcionário no sistema para formar equipes de trabalho e executar serviços de forma eficiente.
                            @endif
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if(request()->hasAny(['search', 'funcao', 'ativo', 'com_equipe']))
                                <a href="{{ route('funcionarios.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                                    <x-funcionarios::icon name="arrow-path" class="w-4 h-4" />
                                    Limpar Filtros
                                </a>
                            @endif
                            <x-funcionarios::button href="{{ route('funcionarios.create') }}" variant="primary" class="shadow-lg hover:shadow-xl transition-all">
                                <x-funcionarios::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Cadastrar Primeiro Funcionário
                            </x-funcionarios::button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-funcionarios::data-table>
</div>
@endsection
