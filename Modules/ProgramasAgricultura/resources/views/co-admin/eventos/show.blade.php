@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Evento - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="calendar-days" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                {{ $evento->titulo }}
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('co-admin.eventos.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Eventos</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Detalhes</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('co-admin.eventos.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-semibold">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('co-admin.eventos.edit', $evento->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-none font-bold">
                <x-icon name="pencil" class="w-5 h-5" />
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Card de Informações -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="circle-info" class="w-5 h-5 text-indigo-500" />
                    Informações do Evento
                </h3>
            </div>
            <div class="p-6">
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-slate-300">{{ $evento->descricao ?: 'Sem descrição detalhada.' }}</p>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold capitalize">{{ $evento->tipo }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Localidade</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold">{{ $evento->localidade->nome ?? 'Não definida' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Endereço</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold">{{ $evento->endereco ?: 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Início</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold flex items-center gap-2">
                            <x-icon name="calendar" class="w-5 h-5 text-gray-400" />
                            {{ $evento->data_inicio->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Término</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold flex items-center gap-2">
                            <x-icon name="calendar-check" class="w-5 h-5 text-gray-400" />
                            {{ $evento->data_fim ? $evento->data_fim->format('d/m/Y H:i') : 'Não definido' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Inscritos -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="users" class="w-5 h-5 text-indigo-500" />
                    Inscritos Recentes
                </h3>
                <a href="{{ route('co-admin.inscricoes.index', ['evento_id' => $evento->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-bold">Ver todos</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">CPF</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse($evento->inscricoes()->latest()->take(5)->get() as $insc)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                {{ $insc->pessoa->nom_pessoa }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $insc->pessoa->num_cpf_pessoa }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">{{ $insc->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">Nenhuma inscrição até o momento.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Coluna Lateral -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Capacidade e Status</p>
            <div class="flex items-center gap-3 mb-4">
                @php
                    $statusColors = [
                        'agendado' => 'bg-blue-500',
                        'em_andamento' => 'bg-amber-500',
                        'concluido' => 'bg-emerald-500',
                        'cancelado' => 'bg-red-500',
                    ];
                    $dotColor = $statusColors[$evento->status] ?? 'bg-gray-500';
                @endphp
                <span class="h-3 w-3 rounded-full {{ $dotColor }}"></span>
                <span class="text-xl font-bold text-gray-900 dark:text-white uppercase">{{ $evento->status }}</span>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Vagas Preenchidas:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $evento->inscricoes_count }}/{{ $evento->vagas_totais ?: '∞' }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                    @php
                        $perc = $evento->vagas_totais > 0 ? ($evento->inscricoes_count / $evento->vagas_totais) * 100 : 0;
                        $perc = min(100, $perc);
                    @endphp
                    <div class="bg-indigo-600 h-full" style="width: {{ $perc }}%"></div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase mb-4 pb-2 border-b border-gray-100 dark:border-slate-700">Ações</h4>
            <div class="space-y-3">
                <a href="{{ route('co-admin.inscricoes.create', ['evento_id' => $evento->id]) }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-bold shadow-sm">
                    <x-icon name="user-plus" class="w-5 h-5" />
                    Nova Inscrição
                </a>
                <button onclick="window.print()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-bold">
                    <x-icon name="file-export" class="w-5 h-5" />
                    Lista de Presença
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
