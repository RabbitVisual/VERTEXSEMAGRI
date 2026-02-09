@extends('admin.layouts.admin')

@section('title', 'Dossiê do Líder: ' . $lider->nome)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="id-badge" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Perfil: <span class="text-blue-600">{{ $lider->nome }}</span></span>
            </h1>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-blue-600 transition-colors">Líderes</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <span class="text-blue-600">Dossiê do Agente</span>
            </nav>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.lideres-comunidade.edit', $lider) }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-xl transition-all dark:bg-amber-900/10 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                <x-icon name="user-pen" style="duotone" class="w-4 h-4" />
                Editar Dados
            </a>
            <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna de Perfil -->
        <div class="lg:col-span-1 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>
                <div class="px-8 pb-8 text-center">
                    <div class="relative -mt-16 mb-6 inline-block">
                        <div class="w-32 h-32 rounded-[2.5rem] border-8 border-white dark:border-slate-800 bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-4xl font-black shadow-2xl transform hover:rotate-3 transition-transform">
                            {{ strtoupper(substr($lider->nome, 0, 1)) }}
                        </div>
                        <div class="absolute bottom-2 right-2 w-8 h-8 rounded-2xl border-4 border-white dark:border-slate-800 {{ $lider->status === 'ativo' ? 'bg-emerald-500 shadow-[0_0_15px_theme(colors.emerald.500)]' : 'bg-rose-500 shadow-[0_0_15px_theme(colors.rose.500)]' }} flex items-center justify-center">
                            <x-icon name="{{ $lider->status === 'ativo' ? 'check' : 'xmark' }}" class="w-3.5 h-3.5 text-white" />
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $lider->nome }}</h2>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em] mb-6 italic">COD: {{ $lider->codigo }}</p>

                    <div class="flex items-center justify-center gap-3 py-3 px-5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <x-icon name="shield-halved" style="duotone" class="w-5 h-5 {{ $lider->status === 'ativo' ? 'text-emerald-500' : 'text-rose-500' }}" />
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 dark:text-slate-300">Status: {{ $lider->status_texto }}</span>
                    </div>
                </div>
            </div>

            <!-- Dados Operacionais -->
            <div class="premium-card p-8 space-y-6">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <x-icon name="network-wired" style="duotone" class="w-4 h-4 text-blue-500" />
                    Elo de Vinculação
                </h3>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-5 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-3xl group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                            <x-icon name="location-dot" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-0.5">Localidade Base</p>
                            <p class="text-sm font-black text-blue-900 dark:text-blue-300 uppercase tracking-tighter">{{ $lider->localidade->nome ?? 'Área Indefinida' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20 rounded-3xl group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-indigo-600 shadow-sm group-hover:scale-110 transition-transform">
                            <x-icon name="faucet-drip" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-indigo-600 uppercase tracking-widest mb-0.5">Poço Mapeado</p>
                            <p class="text-sm font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-tighter">{{ $lider->poco->nome_mapa ?? $lider->poco->codigo ?? 'Nenhum Ativo' }}</p>
                        </div>
                    </div>

                    @if($lider->user)
                    <div class="pt-4 mt-2 border-t border-gray-100 dark:border-slate-800">
                        <a href="{{ route('admin.users.show', $lider->user->id) }}" class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-white">
                                    <x-icon name="fingerprint" class="w-4 h-4" />
                                </div>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">ID Usuário: {{ $lider->user->id }}</span>
                            </div>
                            <x-icon name="arrow-up-right-from-square" class="w-3.5 h-3.5 text-slate-300 group-hover:text-blue-500 transition-colors" />
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Coluna de Performance -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Painel de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="premium-card p-8 bg-gradient-to-br from-emerald-500 to-teal-700 text-white group overflow-hidden relative">
                    <x-icon name="hand-holding-dollar" style="duotone" class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" />
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-2">Total Arrecadado (30d)</p>
                    <h3 class="text-4xl font-black tracking-tighter mb-4">
                        <span class="text-lg font-bold mr-1 opacity-70">R$</span>{{ number_format($estatisticas['total_arrecadado'] ?? 0, 2, ',', '.') }}
                    </h3>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[9px] font-black uppercase tracking-widest">
                        <x-icon name="chart-line" class="w-3 h-3" />
                        Meta Operacional: 92%
                    </div>
                </div>

                <div class="premium-card p-8 bg-gradient-to-br from-blue-600 to-indigo-800 text-white group overflow-hidden relative">
                    <x-icon name="users" style="duotone" class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" />
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-2">População Assistida</p>
                    <h3 class="text-4xl font-black tracking-tighter mb-4">
                        {{ number_format($estatisticas['usuarios_ativos'] ?? 0, 0, ',', '.') }}<span class="text-lg font-bold ml-1 opacity-70">FAMÍLIAS</span>
                    </h3>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[9px] font-black uppercase tracking-widest">
                        <x-icon name="house-water" class="w-3 h-3" />
                        Poço {{ $lider->poco->codigo ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <!-- Dados de Contato e Pessoais -->
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="address-card" style="duotone" class="w-5 text-amber-500" />
                        Dossiê de Identificação
                    </h2>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Nome Civil</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $lider->nome }}</p>
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Cadastro de Pessoa Física (CPF)</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white font-mono tracking-widest">{{ $lider->cpf ?? 'NÃO INFORMADO' }}</p>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Comunicação Oficial (E-mail)</label>
                                <p class="text-sm font-black text-blue-600 dark:text-blue-400 tracking-tight">{{ $lider->email ?? $lider->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Linha de Contato (Telefone)</label>
                                <p class="text-sm font-black text-emerald-600 dark:text-emerald-400 tracking-widest">{{ $lider->telefone ?? 'SEM TELEFONE' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Complementares -->
                    <div class="mt-12 pt-10 border-t border-gray-100 dark:border-slate-800">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Anotações da Gestão Municipal</label>
                        <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-3xl min-h-[100px]">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-tight leading-relaxed italic">
                                {{ $lider->observacoes ?? 'Sem anotações complementares registradas pelo administrador central.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
