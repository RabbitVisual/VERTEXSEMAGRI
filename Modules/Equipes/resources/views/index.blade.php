@extends('Co-Admin.layouts.app')

@section('title', 'Equipes')

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
                        Gestão de Equipes
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Organize funcionários em equipes para execução de serviços
                    </p>
                </div>
            </div>
            <x-equipes::button href="{{ route('equipes.create') }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                <x-equipes::icon name="plus-circle" class="w-5 h-5 mr-2" />
                Nova Equipe
            </x-equipes::button>
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

    <!-- Estatísticas -->
    @if(isset($stats))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-stretch">
        <x-equipes::stat-card
            title="Total de Equipes"
            :value="$stats['total'] ?? 0"
            icon="user-group"
            color="primary"
            subtitle="Todas as equipes cadastradas"
        />
        <x-equipes::stat-card
            title="Equipes Ativas"
            :value="$stats['ativas'] ?? 0"
            icon="check-circle"
            color="success"
            subtitle="Em operação no sistema"
        />
        <x-equipes::stat-card
            title="Com Funcionários"
            :value="$stats['com_funcionarios'] ?? 0"
            icon="users"
            color="info"
            subtitle="Equipes com membros"
        />
        <x-equipes::stat-card
            title="Sem Funcionários"
            :value="$stats['sem_funcionarios'] ?? 0"
            icon="user-minus"
            color="warning"
            subtitle="Equipes vazias"
        />
    </div>
    @endif

    <!-- Filtros -->
    <x-equipes::filter-bar
        action="{{ route('equipes.index') }}"
        :filters="[
            [
                'name' => 'tipo',
                'label' => 'Tipo',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'eletricistas' => 'Eletricistas',
                    'encanadores' => 'Encanadores',
                    'operadores' => 'Operadores',
                    'motoristas' => 'Motoristas',
                    'mista' => 'Mista'
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
            ]
        ]"
        search-placeholder="Buscar por nome ou código..."
    />

    <!-- Informações de Resultados e Paginação Superior -->
    @if($equipes->total() > 0)
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl px-6 py-4 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                    <x-equipes::icon name="information-circle" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                        <span class="text-lg text-indigo-600 dark:text-indigo-400">{{ $equipes->total() }}</span>
                        {{ $equipes->total() == 1 ? 'equipe encontrada' : 'equipes encontradas' }}
                    </p>
                    @if(request()->hasAny(['search', 'tipo', 'ativo']))
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                            Com os filtros aplicados
                        </p>
                    @endif
                </div>
            </div>
            @if($equipes->hasPages())
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm">
                <x-equipes::icon name="document-text" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">
                    Página <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $equipes->currentPage() }}</span> de <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $equipes->lastPage() }}</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tabela de Equipes -->
    <x-equipes::data-table
        :headers="['Nome', 'Código', 'Tipo', 'Líder', 'Membros', 'Status']"
        :data="$equipes"
        export-route="{{ route('equipes.index') }}"
    >
        @forelse($equipes as $equipe)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-xl shadow-sm">
                            <x-equipes::icon name="user-group" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $equipe->nome }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-800 dark:from-indigo-900/30 dark:to-indigo-800/30 dark:text-indigo-300 shadow-sm">
                        {{ $equipe->codigo ?? 'N/A' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-equipes::badge variant="info">
                        <x-equipes::icon name="users" class="w-3 h-3 mr-1" />
                        {{ ucfirst($equipe->tipo) }}
                    </x-equipes::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    @if($equipe->lider)
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-equipes::icon name="user-circle" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <span class="font-medium">{{ $equipe->lider->name }}</span>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <x-equipes::icon name="user-group" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                        </div>
                        <strong class="text-base font-bold text-gray-900 dark:text-white">
                            {{ $equipe->funcionarios->count() }}
                        </strong>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
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
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('equipes.show', $equipe) }}"
                           class="p-2.5 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-all hover:scale-110"
                           title="Ver detalhes">
                            <x-equipes::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('equipes.edit', $equipe) }}"
                           class="p-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all hover:scale-110"
                           title="Editar">
                            <x-equipes::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('equipes.destroy', $equipe) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja deletar esta equipe? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all hover:scale-110"
                                    title="Deletar">
                                <x-equipes::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center max-w-md mx-auto">
                        <div class="p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                            <x-equipes::icon name="inbox" class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Nenhuma equipe encontrada
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 text-center leading-relaxed">
                            @if(request()->hasAny(['search', 'tipo', 'ativo']))
                                Não encontramos equipes com os filtros aplicados. Tente ajustar os filtros ou limpar a busca para ver todas as equipes disponíveis.
                            @else
                                Comece criando sua primeira equipe no sistema para organizar funcionários e executar serviços de forma eficiente.
                            @endif
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if(request()->hasAny(['search', 'tipo', 'ativo']))
                                <a href="{{ route('equipes.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                                    <x-equipes::icon name="arrow-path" class="w-4 h-4" />
                                    Limpar Filtros
                                </a>
                            @endif
                            <x-equipes::button href="{{ route('equipes.create') }}" variant="primary" class="shadow-lg hover:shadow-xl transition-all">
                                <x-equipes::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Criar Primeira Equipe
                            </x-equipes::button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-equipes::data-table>
</div>
@endsection
