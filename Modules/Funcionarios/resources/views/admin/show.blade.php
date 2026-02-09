@extends('admin.layouts.admin')

@section('title', 'Dossiê do Colaborador: ' . $funcionario->nome)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="user-tie" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Perfil: <span class="text-emerald-600">{{ $funcionario->nome }}</span></span>
            </h1>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <a href="{{ route('admin.funcionarios.index') }}" class="hover:text-emerald-600 transition-colors">Funcionários</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <span class="text-emerald-600">Dossiê do Agente</span>
            </nav>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.funcionarios.senha.show', $funcionario->id) }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all dark:bg-blue-900/10 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30">
                <x-icon name="key" style="duotone" class="w-4 h-4" />
                Credenciais
            </a>
            <a href="{{ route('admin.funcionarios.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna de Perfil -->
        <div class="lg:col-span-1 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-emerald-600 to-teal-700 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>
                <div class="px-8 pb-8 text-center">
                    <div class="relative -mt-16 mb-6 inline-block">
                        <div class="w-32 h-32 rounded-[2.5rem] border-8 border-white dark:border-slate-800 bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center text-4xl font-black shadow-2xl transform hover:rotate-3 transition-transform">
                            {{ strtoupper(substr($funcionario->nome, 0, 1)) }}
                        </div>
                        <div class="absolute bottom-2 right-2 w-8 h-8 rounded-2xl border-4 border-white dark:border-slate-800 {{ $funcionario->ativo ? 'bg-emerald-500 shadow-[0_0_15px_theme(colors.emerald.500)]' : 'bg-rose-500 shadow-[0_0_15px_theme(colors.rose.500)]' }} flex items-center justify-center">
                            <x-icon name="{{ $funcionario->ativo ? 'check' : 'xmark' }}" class="w-3.5 h-3.5 text-white" />
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</h2>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em] mb-6 italic">ID: {{ $funcionario->codigo ?? $funcionario->id }}</p>

                    <div class="flex items-center justify-center gap-3 py-3 px-5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <x-icon name="shield-halved" style="duotone" class="w-5 h-5 {{ $funcionario->ativo ? 'text-emerald-500' : 'text-rose-500' }}" />
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 dark:text-slate-300">Status: {{ $funcionario->ativo ? 'Ativo' : 'Inativo' }}</span>
                    </div>
                </div>
            </div>

            <!-- Dados Operacionais -->
            <div class="premium-card p-8 space-y-6">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <x-icon name="network-wired" style="duotone" class="w-4 h-4 text-emerald-500" />
                    Dados Funcionais
                </h3>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-5 bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/20 rounded-3xl group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-emerald-600 shadow-sm group-hover:scale-110 transition-transform">
                            <x-icon name="briefcase" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-0.5">Cargo / Função</p>
                            <p class="text-sm font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-tighter">{{ $funcionario->funcao ?? 'Não Definido' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-3xl group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                            <x-icon name="users-gear" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-0.5">Equipes Vinculadas</p>
                            <p class="text-sm font-black text-blue-900 dark:text-blue-300 uppercase tracking-tighter">
                                {{ isset($funcionario->equipes) ? $funcionario->equipes->count() . ' Equipe(s)' : 'Nenhuma' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna de Detalhes -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Dados de Contato e Pessoais -->
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="address-card" style="duotone" class="w-5 text-emerald-500" />
                        Dossiê de Identificação
                    </h2>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Nome Completo</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</p>
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">CPF</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white font-mono tracking-widest">{{ $funcionario->cpf ?? 'NÃO INFORMADO' }}</p>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">E-mail</label>
                                <p class="text-sm font-black text-blue-600 dark:text-blue-400 tracking-tight">{{ $funcionario->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Telefone</label>
                                <p class="text-sm font-black text-emerald-600 dark:text-emerald-400 tracking-widest">{{ $funcionario->telefone ?? 'SEM TELEFONE' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histórico de Ordens -->
            @if(isset($ordensServico) && $ordensServico->count() > 0)
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="clipboard-list" style="duotone" class="w-5 text-emerald-500" />
                        Atividades Recentes
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-gray-50/30 dark:bg-slate-900/30">
                                <th class="px-8 py-4 text-[9px] font-black uppercase text-gray-400 tracking-widest italic">O.S #</th>
                                <th class="px-8 py-4 text-[9px] font-black uppercase text-gray-400 tracking-widest italic">Equipe</th>
                                <th class="px-8 py-4 text-[9px] font-black uppercase text-gray-400 tracking-widest italic">Status</th>
                                <th class="px-8 py-4 text-right text-[9px] font-black uppercase text-gray-400 tracking-widest italic">Ver</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                            @foreach($ordensServico as $ordem)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-8 py-4">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">#{{ $ordem->numero }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">{{ $ordem->equipe->nome ?? '-' }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    @php
                                        $statusStyle = match($ordem->status) {
                                            'pendente' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'em_execucao' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            'concluida' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                            'cancelada' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                            default => 'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-slate-400'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                        {{ str_replace('_', ' ', $ordem->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all inline-block">
                                        <x-icon name="arrow-right" class="w-5 h-5" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
