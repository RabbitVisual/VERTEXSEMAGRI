@extends('admin.layouts.admin')

@section('title', 'Dossiê do Líder: ' . $lider->nome)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header Premium -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 dark:bg-blue-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="id-badge" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Perfil: <span class="text-blue-600 dark:text-blue-400">{{ $lider->nome }}</span>
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Líderes</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-gray-900 dark:text-white font-bold">Dossiê do Agente</span>
                    </nav>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.lideres-comunidade.edit', $lider) }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-xl transition-all border border-amber-100 active:scale-95">
                    <x-icon name="pencil" style="duotone" class="w-5 h-5" />
                    Editar Dados
                </a>
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna de Perfil -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>
                <div class="px-8 pb-8 text-center">
                    <div class="relative -mt-16 mb-6 inline-block">
                        <div class="w-32 h-32 rounded-[2.5rem] border-8 border-white dark:border-slate-800 bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-4xl font-bold shadow-2xl transform hover:rotate-3 transition-transform">
                            {{ strtoupper(substr($lider->nome, 0, 1)) }}
                        </div>
                        <div class="absolute bottom-2 right-2 w-8 h-8 rounded-2xl border-4 border-white dark:border-slate-800 {{ $lider->status === 'ativo' ? 'bg-emerald-500' : 'bg-rose-500' }} flex items-center justify-center shadow-sm">
                            <x-icon name="{{ $lider->status === 'ativo' ? 'check' : 'xmark' }}" class="w-3.5 h-3.5 text-white" />
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $lider->nome }}</h2>
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-6">COD: {{ $lider->codigo }}</p>

                    <div class="flex items-center justify-center gap-3 py-3 px-5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-700">
                        <x-icon name="shield-halved" style="duotone" class="w-5 h-5 {{ $lider->status === 'ativo' ? 'text-emerald-500' : 'text-rose-500' }}" />
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-slate-300">Status: {{ $lider->status_texto }}</span>
                    </div>
                </div>
            </div>

            <!-- Dados Operacionais -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 space-y-6">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <x-icon name="network-wired" style="duotone" class="w-4 h-4 text-blue-500" />
                    Elo de Vinculação
                </h3>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-5 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-3xl group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-105 transition-transform">
                            <x-icon name="location-dot" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-0.5">Localidade Base</p>
                            <p class="text-sm font-bold text-blue-900 dark:text-blue-300">{{ $lider->localidade->nome ?? 'Área Indefinida' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20 rounded-3xl group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-indigo-600 shadow-sm group-hover:scale-105 transition-transform">
                            <x-icon name="faucet-drip" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-0.5">Poço Mapeado</p>
                            <p class="text-sm font-bold text-indigo-900 dark:text-indigo-300">{{ $lider->poco->nome_mapa ?? $lider->poco->codigo ?? 'Nenhum Ativo' }}</p>
                        </div>
                    </div>

                    @if($lider->user)
                    <div class="pt-4 mt-2 border-t border-gray-100 dark:border-slate-700">
                        <a href="{{ route('admin.users.show', $lider->user->id) }}" class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-white">
                                    <x-icon name="fingerprint" class="w-4 h-4" />
                                </div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider group-hover:text-slate-700 dark:group-hover:text-slate-300 transition-colors">ID Usuário: {{ $lider->user->id }}</span>
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
                <div class="bg-gradient-to-br from-emerald-500 to-teal-700 rounded-3xl shadow-lg shadow-emerald-500/10 p-8 text-white group overflow-hidden relative border border-emerald-400/20">
                    <x-icon name="hand-holding-dollar" style="duotone" class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" />
                    <p class="text-xs font-bold uppercase tracking-wider opacity-80 mb-2">Total Arrecadado (30d)</p>
                    <h3 class="text-4xl font-bold tracking-tight mb-4">
                        <span class="text-lg font-semibold mr-1 opacity-70">R$</span>{{ number_format($estatisticas['total_arrecadado'] ?? 0, 2, ',', '.') }}
                    </h3>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold uppercase tracking-widest backdrop-blur-sm">
                        <x-icon name="chart-line" class="w-3 h-3" />
                        Meta Operacional: 92%
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-3xl shadow-lg shadow-blue-500/10 p-8 text-white group overflow-hidden relative border border-blue-400/20">
                    <x-icon name="users" style="duotone" class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" />
                    <p class="text-xs font-bold uppercase tracking-wider opacity-80 mb-2">População Assistida</p>
                    <h3 class="text-4xl font-bold tracking-tight mb-4">
                        {{ number_format($estatisticas['usuarios_ativos'] ?? 0, 0, ',', '.') }}<span class="text-lg font-semibold ml-1 opacity-70">FAMÍLIAS</span>
                    </h3>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold uppercase tracking-widest backdrop-blur-sm">
                        <x-icon name="house-water" class="w-3 h-3" />
                        Poço {{ $lider->poco->codigo ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <!-- Dados de Contato e Pessoais -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="address-card" style="duotone" class="w-5 h-5 text-amber-500" />
                        Dossiê de Identificação
                    </h2>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-8">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nome Civil</label>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $lider->nome }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Cadastro de Pessoa Física (CPF)</label>
                                <p class="text-sm font-bold text-gray-900 dark:text-white font-mono tracking-wide">{{ $lider->cpf ?? 'NÃO INFORMADO' }}</p>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Comunicação Oficial (E-mail)</label>
                                <p class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $lider->email ?? $lider->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Linha de Contato (Telefone)</label>
                                <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ $lider->telefone ?? 'SEM TELEFONE' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Complementares -->
                    <div class="mt-12 pt-10 border-t border-gray-100 dark:border-slate-700">
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Anotações da Gestão Municipal</label>
                        <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-700 rounded-3xl min-h-[100px]">
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed italic">
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
