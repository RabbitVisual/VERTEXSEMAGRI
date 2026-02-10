@extends('Co-Admin.layouts.app')

@section('title', 'Gerenciar Chat')

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-80 h-80 bg-green-50/50 dark:bg-green-900/10 rounded-full -mr-40 -mt-40 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-8">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-green-600 to-emerald-700 rounded-[2rem] flex items-center justify-center shadow-lg shadow-green-500/20 text-white transition-transform hover:rotate-6">
                    <x-icon module="chat" class="w-8 h-8 md:w-10 md:h-10" style="duotone" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">
                        Atendimento
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
                        <a href="{{ route('co-admin.dashboard') }}" class="hover:text-green-600 transition-colors">Painel</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-slate-600 dark:text-slate-300">Chat Online</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('co-admin.chat.realtime') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 text-sm font-black text-white bg-green-600 rounded-2xl hover:bg-green-700 shadow-xl shadow-green-500/20 transition-all active:scale-95 border-b-4 border-green-800 uppercase tracking-widest group">
                    <x-icon name="bolt" style="duotone" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                    Tempo Real
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats - Glass Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Waiting -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="clock" style="duotone" class="w-32 h-32 text-amber-600" />
            </div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="clock" style="duotone" class="w-7 h-7" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aguardando</div>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white leading-none">{{ $stats['waiting'] ?? 0 }}</div>
        </div>

        <!-- Active -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="message-dots" style="duotone" class="w-32 h-32 text-green-600" />
            </div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="message-dots" style="duotone" class="w-7 h-7" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Ativos</div>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white leading-none">{{ $stats['active'] ?? 0 }}</div>
        </div>

        <!-- Today -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="comments" style="duotone" class="w-32 h-32 text-blue-600" />
            </div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="comments" style="duotone" class="w-7 h-7" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Hoje</div>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white leading-none">{{ $stats['messages_today'] ?? 0 }}</div>
        </div>

        <!-- Closed -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity rotate-12">
                <x-icon name="check-double" style="duotone" class="w-32 h-32 text-slate-600" />
            </div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-slate-50 dark:bg-slate-900/20 text-slate-600 rounded-2xl flex items-center justify-center">
                    <x-icon name="check-double" style="duotone" class="w-7 h-7" />
                </div>
                <div class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Concluídos</div>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white leading-none">{{ $stats['closed'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Filters Panel -->
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <form method="GET" action="{{ route('co-admin.chat.index') }}" class="p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <div class="md:col-span-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1 mb-3 block">Pesquisar</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none text-slate-400 group-focus-within:text-green-500 transition-colors">
                            <x-icon name="magnifying-glass" style="duotone" class="w-5 h-5" />
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-green-500/20 focus:bg-white dark:focus:bg-slate-900 text-slate-900 dark:text-white text-sm font-bold pl-14 p-4.5 transition-all shadow-inner"
                            placeholder="Nome, CPF ou E-mail...">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1 mb-3 block">Estado</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none text-slate-400 group-focus-within:text-green-500 transition-colors z-10">
                            <x-icon name="circle-dot" style="duotone" class="w-4 h-4" />
                        </div>
                        <select name="status"
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-green-500/20 focus:bg-white dark:focus:bg-slate-900 text-slate-900 dark:text-white text-sm font-bold pl-12 p-4.5 transition-all shadow-inner appearance-none relative">
                            <option value="">Todos os Status</option>
                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Aguardando</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativos</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Encerrados</option>
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                             <x-icon name="chevron-down" class="w-3 h-3" />
                        </div>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1 mb-3 block">Atendente</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none text-slate-400 group-focus-within:text-green-500 transition-colors z-10">
                            <x-icon name="user" style="duotone" class="w-4 h-4" />
                        </div>
                        <select name="assigned_to"
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-green-500/20 focus:bg-white dark:focus:bg-slate-900 text-slate-900 dark:text-white text-sm font-bold pl-12 p-4.5 transition-all shadow-inner appearance-none relative">
                            <option value="">Todos os Atendentes</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ request('assigned_to') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                             <x-icon name="chevron-down" class="w-3 h-3" />
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 flex items-end gap-3">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4.5 text-sm font-black text-white bg-slate-900 dark:bg-green-600 rounded-2xl hover:bg-black dark:hover:bg-green-700 transition-all shadow-lg active:scale-95 group">
                        <x-icon name="filter" style="duotone" class="w-4 h-4 group-hover:rotate-12 transition-transform" />
                        Filtrar
                    </button>
                    <a href="{{ route('co-admin.chat.index') }}" class="p-4.5 text-slate-400 hover:text-green-600 bg-slate-50 dark:bg-slate-900/50 rounded-2xl transition-all shadow-inner hover:bg-white dark:hover:bg-slate-900 group">
                        <x-icon name="rotate-right" class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" />
                    </a>
                </div>
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
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Visitante</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Estado</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Duração / Atividade</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Responsável</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                        @foreach($sessions as $session)
                            <tr class="hover:bg-green-50/30 dark:hover:bg-green-900/10 transition-all group">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-5">
                                        <div class="relative">
                                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-green-200 dark:shadow-none transition-transform group-hover:rotate-6">
                                                {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                                            </div>
                                            @if($session->unread_count_user > 0)
                                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-[10px] font-black text-white border-2 border-white dark:border-slate-800 animate-bounce shadow-sm">
                                                {{ $session->unread_count_user }}
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-900 dark:text-white group-hover:text-green-600 transition-colors text-lg leading-tight">{{ $session->visitor_name ?? 'V. Anônimo' }}</div>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                                <x-icon name="envelope" class="w-3 h-3" />
                                                {{ $session->visitor_email ?? $session->session_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    @php
                                        $statusConfig = [
                                            'waiting' => ['bg' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/30', 'label' => 'Aguardando', 'icon' => 'clock'],
                                            'active' => ['bg' => 'bg-green-50 text-green-600 border-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800/30', 'label' => 'Em Atendimento', 'icon' => 'message-dots'],
                                            'closed' => ['bg' => 'bg-slate-50 text-slate-600 border-slate-100 dark:bg-slate-900/20 dark:text-slate-400 dark:border-slate-800/30', 'label' => 'Encerrado', 'icon' => 'check-double'],
                                        ];
                                        $s = $statusConfig[$session->status] ?? ['bg' => 'bg-slate-50', 'label' => $session->status, 'icon' => 'circle-question'];
                                    @endphp
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full {{ $s['bg'] }} text-[10px] font-black uppercase tracking-widest border shadow-sm">
                                        <x-icon name="{{ $s['icon'] }}" style="duotone" class="w-3.5 h-3.5" />
                                        {{ $s['label'] }}
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="text-sm font-black text-slate-700 dark:text-slate-300">
                                        {{ $session->last_activity_at ? $session->last_activity_at->diffForHumans() : $session->created_at->diffForHumans() }}
                                    </div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase mt-1.5 tracking-wider flex items-center gap-1.5">
                                        <x-icon name="calendar-days" class="w-2.5 h-2.5" />
                                        Iniciado: {{ $session->created_at->format('d/m/Y - H:i') }}
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    @if($session->assignedTo)
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-xs font-black text-slate-600 dark:text-slate-300 uppercase shadow-sm border border-slate-200/50">
                                                {{ substr($session->assignedTo->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-black text-slate-700 dark:text-slate-300 block leading-none uppercase tracking-tight">{{ $session->assignedTo->name }}</span>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Atendente</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest border-b-2 border-dashed border-slate-100 dark:border-slate-700 pb-1">Livre para Atribuição</span>
                                    @endif
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <a href="{{ route('co-admin.chat.show', $session->id) }}"
                                       class="inline-flex items-center gap-3 px-8 py-4 text-sm font-black text-white bg-slate-900 dark:bg-green-600 rounded-2xl hover:bg-black dark:hover:bg-green-700 shadow-xl shadow-green-500/10 transition-all active:scale-95 border-b-4 border-slate-700 dark:border-green-800 uppercase tracking-widest group">
                                        <x-icon name="eye" style="duotone" class="w-4 h-4 group-hover:scale-110 transition-transform" />
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($sessions->hasPages())
            <div class="px-10 py-8 bg-slate-50/30 dark:bg-slate-900/30 border-t border-slate-100 dark:border-slate-700">
                {{ $sessions->links() }}
            </div>
            @endif
        @else
            <div class="p-24 text-center">
                <div class="w-28 h-28 bg-slate-50 dark:bg-slate-900/50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 shadow-inner border-4 border-dashed border-slate-100 dark:border-slate-800 transition-transform hover:rotate-6">
                    <x-icon name="message-slash" style="duotone" class="w-14 h-14 text-slate-300" />
                </div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4 tracking-tight uppercase">Sem Atendimentos</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-12 max-w-sm mx-auto font-medium leading-relaxed">Não foram encontradas sessões de chat com os critérios selecionados.</p>
                <a href="{{ route('co-admin.chat.index') }}" class="inline-flex items-center gap-3 px-10 py-5 text-sm font-black text-slate-700 bg-slate-100 rounded-2xl hover:bg-slate-200 transition-all uppercase tracking-widest active:scale-95">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                    Limpar Filtros
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
