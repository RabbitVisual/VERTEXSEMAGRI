@extends('admin.layouts.admin')

@section('title', $equipe->nome . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Equipes" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $equipe->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <a href="{{ route('admin.equipes.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Equipes</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $equipe->codigo ?? 'Detalhes' }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('equipes.show', $equipe->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800 dark:hover:bg-emerald-900/50 transition-colors">
                <x-icon name="eye" class="w-4 h-4" />
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stat-card
            title="Total Funcionários"
            :value="$equipe->funcionarios->count()"
            icon="users"
            color="blue"
        />
        <x-stat-card
            title="Ordens Ativas"
            :value="$equipe->ordensServico->whereIn('status', ['pendente', 'em_execucao'])->count()"
            icon="clipboard-list"
            color="amber"
        />
        <x-stat-card
            title="Ordens Concluídas"
            :value="$equipe->ordensServico->where('status', 'concluida')->count()"
            icon="check-circle"
            color="emerald"
        />
        <x-stat-card
            title="Status da Equipe"
            :value="$equipe->ativo ? 'ATIVA' : 'INATIVA'"
            icon="signal"
            :color="$equipe->ativo ? 'emerald' : 'red'"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Details Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="information-circle" class="w-5 h-5 text-gray-500" />
                        Informações Gerais
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Código da Equipe</label>
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-mono font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-slate-700 px-3 py-1 rounded-lg border border-gray-200 dark:border-slate-600">
                                    {{ $equipe->codigo ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Tipo de Equipe</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                {{ ucfirst($equipe->tipo) }}
                            </span>
                        </div>
                    </div>

                    @if($equipe->lider)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Líder Responsável</label>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl border border-gray-100 dark:border-slate-700">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold">
                                {{ substr($equipe->lider->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $equipe->lider->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $equipe->lider->email }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($equipe->descricao)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Descrição</label>
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed bg-gray-50 dark:bg-slate-700/30 p-4 rounded-lg border border-gray-100 dark:border-slate-700">
                            {{ $equipe->descricao }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Funcionários -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="user-group" class="w-5 h-5 text-gray-500" />
                        Membros da Equipe
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-slate-700 text-xs font-medium text-gray-600 dark:text-gray-300">
                        {{ $equipe->funcionarios->count() }} Funcionários
                    </span>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($equipe->funcionarios as $funcionario)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <x-icon name="user" class="w-5 h-5" />
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $funcionario->nome }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <span>{{ ucfirst($funcionario->funcao) }}</span>
                                    @if($funcionario->codigo)
                                    <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                    <span class="font-mono">{{ $funcionario->codigo }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="p-2 text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <x-icon name="users" class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" />
                        <p>Nenhum funcionário vinculado a esta equipe.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="{{ route('equipes.edit', $equipe->id) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-colors shadow-sm shadow-indigo-200 dark:shadow-none">
                        <x-icon name="pencil" class="w-4 h-4" />
                        Editar Equipe
                    </a>
                </div>
            </div>

            <!-- Ordens Recentes (Compact) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Ordens Recentes</h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-slate-700">
                    @if(isset($ordensRecentes) && $ordensRecentes->count() > 0)
                        @foreach($ordensRecentes->take(5) as $ordem)
                        <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-xs font-medium text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $ordem->numero }}</span>
                                <span class="text-xs text-gray-400">{{ $ordem->created_at->format('d/m') }}</span>
                            </div>
                            <div class="font-medium text-sm text-gray-900 dark:text-white mb-2 line-clamp-1">
                                {{ $ordem->demanda->titulo ?? 'Ordem de Serviço' }}
                            </div>
                            <div class="flex items-center gap-2">
                                @php
                                    $statusColors = [
                                        'pendente' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        'em_execucao' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'concluida' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'cancelada' => 'bg-red-50 text-red-700 border-red-200'
                                    ];
                                    $color = $statusColors[$ordem->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="text-[10px] font-bold uppercase tracking-wide px-2 py-0.5 rounded border {{ $color }}">
                                    {{ str_replace('_', ' ', $ordem->status) }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                        <a href="{{ route('admin.ordens.index', ['equipe_id' => $equipe->id]) }}" class="block p-3 text-center text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                            Ver todas as ordens →
                        </a>
                    @else
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            <p class="text-sm">Nenhuma ordem recente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
