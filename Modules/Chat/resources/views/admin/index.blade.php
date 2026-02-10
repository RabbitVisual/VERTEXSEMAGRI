@extends('admin.layouts.admin')

@section('title', 'Chat - Sessões')

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 transform hover:rotate-6 transition-transform">
                    <x-icon module="chat" class="w-7 h-7 text-white" style="duotone" />
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Atendimentos</h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">Gerencie e monitore as sessões de chat em tempo real.</p>
                </div>
            </div>

            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <span class="text-slate-600 dark:text-slate-300">Chat</span>
            </nav>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.chat.config') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 transition-all shadow-sm active:scale-95">
                <x-icon name="gear" style="duotone" class="w-5 h-5 text-slate-400" />
                Configurações
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Sessions -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="message-dots" style="duotone" class="w-24 h-24 text-blue-600" />
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="message-dots" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Total</div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $stats['total'] ?? 0 }}</div>
        </div>

        <!-- Waiting Sessions -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="clock" style="duotone" class="w-24 h-24 text-amber-600" />
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="clock" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aguardando</div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $stats['waiting'] ?? 0 }}</div>
        </div>

        <!-- Active Sessions -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="comments" style="duotone" class="w-24 h-24 text-green-600" />
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="comments" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Em Atendimento</div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $stats['active'] ?? 0 }}</div>
        </div>

        <!-- Closed Sessions -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="check-double" style="duotone" class="w-24 h-24 text-slate-500" />
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900/20 text-slate-500 rounded-2xl flex items-center justify-center">
                    <x-icon name="check-double" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Encerrados</div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $stats['closed'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden p-6 md:p-8">
        <form action="{{ route('admin.chat.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Buscar Visitante</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-icon name="magnifying-glass" class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors" />
                    </div>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="Nome, e-mail, CPF..."
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent transition-all">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Status</label>
                <select name="status" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="">Todos os status</option>
                    <option value="waiting" {{ ($filters['status'] ?? '') == 'waiting' ? 'selected' : '' }}>Aguardando</option>
                    <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="closed" {{ ($filters['status'] ?? '') == 'closed' ? 'selected' : '' }}>Encerrado</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Atendente</label>
                <select name="assigned_to" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="">Todos atendentes</option>
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ ($filters['assigned_to'] ?? '') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-black dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                    <x-icon name="filter" style="duotone" class="w-4 h-4" />
                    Filtrar
                </button>
                <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-black text-slate-500 bg-slate-100 dark:bg-slate-700 dark:text-slate-300 rounded-2xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">
                    <x-icon name="rotate-right" style="duotone" class="w-4 h-4" />
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Sessions Table -->
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        @if($sessions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Visitante</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tipo</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Estado</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Atendente</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Última Atividade</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                    @foreach($sessions as $session)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $session->type === 'public' ? 'from-blue-500 to-blue-700' : 'from-purple-500 to-purple-700' }} flex items-center justify-center text-white font-black text-lg shadow-lg transition-transform group-hover:rotate-6">
                                        {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                                    </div>
                                    @if($session->unread_count_user > 0)
                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-[10px] font-black text-white border-2 border-white dark:border-slate-800 animate-bounce">
                                        {{ $session->unread_count_user }}
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors text-base">{{ $session->visitor_name ?? 'Anônimo' }}</div>
                                    <div class="flex flex-col text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                        <span>{{ $session->visitor_email ?? $session->session_id }}</span>
                                        @if($session->visitor_cpf)
                                        <span class="mt-0.5">CPF: {{ \Modules\Chat\App\Helpers\CpfHelper::format($session->visitor_cpf) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $session->type === 'public' ? 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/30' : 'bg-purple-50 text-purple-600 border-purple-100 dark:bg-purple-900/20 dark:text-purple-400 dark:border-purple-800/30' }}">
                                {{ $session->type === 'public' ? 'Público' : 'Interno' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusConfig = [
                                    'waiting' => ['bg' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/30', 'label' => 'Aguardando', 'icon' => 'clock'],
                                    'active' => ['bg' => 'bg-green-50 text-green-600 border-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800/30', 'label' => 'Ativo', 'icon' => 'message-dots'],
                                    'closed' => ['bg' => 'bg-slate-50 text-slate-600 border-slate-100 dark:bg-slate-900/20 dark:text-slate-400 dark:border-slate-800/30', 'label' => 'Encerrado', 'icon' => 'check-double'],
                                ];
                                $s = $statusConfig[$session->status] ?? ['bg' => 'bg-slate-50', 'label' => $session->status, 'icon' => 'circle-question'];
                            @endphp
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $s['bg'] }} text-[10px] font-black uppercase tracking-widest border shadow-sm">
                                <x-icon name="{{ $s['icon'] }}" style="duotone" class="w-3 h-3" />
                                {{ $s['label'] }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($session->assignedTo)
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ substr($session->assignedTo->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase underline decoration-2 decoration-blue-500/20 underline-offset-4">{{ $session->assignedTo->name }}</span>
                            </div>
                            @else
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest border-b border-dashed border-slate-200">Não atribuído</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-700 dark:text-slate-300">
                                {{ $session->last_activity_at ? $session->last_activity_at->diffForHumans() : ($session->lastMessage?->created_at?->diffForHumans() ?? $session->created_at->diffForHumans()) }}
                            </div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">
                                {{ $session->created_at->format('d/m/Y - H:i') }}
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.chat.show', $session->id) }}" class="inline-flex items-center gap-2 px-6 py-3 text-xs font-black text-white bg-slate-900 rounded-2xl hover:bg-black dark:bg-blue-600 dark:hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/10 active:scale-95 border-b-4 border-slate-700 dark:border-blue-800">
                                <x-icon name="eye" style="duotone" class="w-4 h-4" />
                                Visualizar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($sessions->hasPages())
        <div class="px-8 py-6 bg-slate-50/30 dark:bg-slate-900/30 border-t border-slate-100 dark:border-slate-700">
            {{ $sessions->links() }}
        </div>
        @endif
        @else
        <div class="p-20 text-center">
            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900/50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner border-2 border-dashed border-slate-200 dark:border-slate-700 transition-transform hover:rotate-12">
                <x-icon name="message-slash" style="duotone" class="w-12 h-12 text-slate-300" />
            </div>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3 tracking-tight">Sem Atendimentos</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-10 max-w-sm mx-auto font-medium leading-relaxed">Não foram encontradas sessões de chat com os critérios de busca selecionados no momento.</p>
            <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center gap-3 px-8 py-4 text-sm font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/25 active:scale-95">
                <x-icon name="rotate-right" style="duotone" class="w-5 h-5" />
                Limpar Filtros
            </a>
        </div>
        @endif
    </div>
</div>
