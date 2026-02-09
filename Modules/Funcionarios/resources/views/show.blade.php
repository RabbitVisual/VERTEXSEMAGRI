@extends('Co-Admin.layouts.app')

@section('title', 'Dossiê: ' . $funcionario->nome)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Header de Identificação -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-6">
            <div class="relative">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2rem] flex items-center justify-center text-white shadow-2xl text-2xl font-black transform hover:rotate-6 transition-transform">
                    {{ substr($funcionario->nome, 0, 1) }}
                </div>
                <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-lg bg-white dark:bg-slate-800 flex items-center justify-center shadow-lg border border-gray-100 dark:border-slate-700 text-emerald-600">
                    <x-icon name="fingerprint" class="w-3.5 h-3.5" />
                </div>
            </div>
            <div>
                <h1 class="text-2xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">{{ $funcionario->nome }}</h1>
                <div class="flex flex-wrap items-center gap-4 mt-3">
                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <x-icon name="id-badge" class="w-4 h-4 text-emerald-500" />
                        Matrícula: <span class="text-emerald-600 tracking-tighter">{{ $funcionario->codigo ?? 'S/M' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <x-icon name="shield-halved" class="w-4 h-4 text-emerald-500" />
                        Status: <span class="{{ $funcionario->ativo ? 'text-emerald-600' : 'text-rose-600' }}">{{ $funcionario->ativo ? 'ATIVO' : 'INATIVO' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-xl transition-all dark:bg-indigo-900/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30 shadow-sm active:scale-95">
                <x-icon name="pen-to-square" style="duotone" class="w-4 h-4" />
                Editar Registro
            </a>
            <a href="{{ route('funcionarios.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Perfil Operacional -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Card de Função -->
            <div class="premium-card p-8 bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-900">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                    <x-icon name="id-card-clip" style="duotone" class="w-5 h-5 text-emerald-500" />
                    Perfil Qualificado
                </h3>

                <div class="space-y-6">
                    <div class="p-6 bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm group hover:border-emerald-500/50 transition-all duration-300">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 italic">Especialidade Técnica</p>
                        <div class="flex items-center gap-3">
                            <x-icon name="briefcase" style="duotone" class="w-6 h-6 text-emerald-500" />
                            <p class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $funcionario->funcao ?? 'Agente Comum' }}</p>
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm group hover:border-blue-500/50 transition-all duration-300">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 italic">Situação de Escala</p>
                        <div class="flex items-center gap-3">
                            <x-icon name="user-group" style="duotone" class="w-6 h-6 text-blue-500" />
                            <p class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                {{ $funcionario->equipes && $funcionario->equipes->count() > 0 ? 'ALOCADO EM EQUIPE' : 'AGENTE AVULSO' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dados Operacionais Históricos -->
            <div class="premium-card p-8 space-y-6">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 flex items-center gap-3 italic">
                    <x-icon name="calendar-days" style="duotone" class="w-5 h-5 text-emerald-500" />
                    Cronologia de Serviço
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-50 dark:border-slate-800">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Admissão</span>
                        <span class="text-xs font-black text-gray-900 dark:text-white">{{ $funcionario->data_admissao ? $funcionario->data_admissao->format('d/m/Y') : 'NÃO REGISTRADO' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-50 dark:border-slate-800">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tempo de Casa</span>
                        <span class="text-xs font-black text-emerald-600 uppercase tracking-tighter">
                            {{ $funcionario->data_admissao ? $funcionario->data_admissao->diffForHumans(null, true) : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Dados Detalhados -->
        <div class="lg:col-span-2 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                    <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-3 italic">
                        <x-icon name="address-card" style="duotone" class="w-5 text-emerald-500" />
                        Informações Estruturais
                    </h2>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-8">
                            <div class="group">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Identificação Pessoal (CPF)</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white font-mono tracking-[0.2em] group-hover:text-emerald-600 transition-colors">{{ $funcionario->cpf ?? 'NÃO INFORMADO' }}</p>
                            </div>
                            <div class="group">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Canal de Comunicação (E-mail)</label>
                                <p class="text-sm font-black text-indigo-600 dark:text-indigo-400 tracking-tight lowercase group-hover:underline">{{ $funcionario->email ?? 'ENDEREÇO NÃO CADASTRADO' }}</p>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div class="group">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Contato Direto</label>
                                <p class="text-sm font-black text-emerald-600 dark:text-emerald-400 tracking-widest group-hover:scale-105 origin-left transition-transform">{{ $funcionario->telefone ?? 'SEM TELEFONE' }}</p>
                            </div>
                            <div class="group italic">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Observações Disponíveis</label>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                    {{ $funcionario->observacoes ?? 'Nenhuma observação técnica anexada a este dossiê.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listagem de Equipes (Relacionamento) -->
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                    <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-3 italic">
                        <x-icon name="network-wired" style="duotone" class="w-5 text-blue-500" />
                        Vínculos em Equipes
                    </h2>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-[9px] font-black uppercase tracking-widest border border-blue-200 dark:border-blue-800">
                        {{ $funcionario->equipes ? $funcionario->equipes->count() : 0 }} TOTAL
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-gray-50/30 dark:bg-slate-900/30">
                                <th class="px-8 py-4 text-[9px] font-black uppercase text-slate-400 tracking-widest italic">Nomenclatura da Equipe</th>
                                <th class="px-8 py-4 text-[9px] font-black uppercase text-slate-400 tracking-widest italic">Tipo de Operação</th>
                                <th class="px-8 py-4 text-right text-[9px] font-black uppercase text-slate-400 tracking-widest italic">Acessar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                            @forelse($funcionario->equipes as $equipe)
                            <tr class="hover:bg-blue-50/20 dark:hover:bg-slate-800/30 transition-all duration-200 group">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-blue-600 transition-colors">{{ $equipe->nome }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded text-[8px] font-black uppercase tracking-widest italic">{{ $equipe->tipo ?? 'GERAL' }}</span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('admin.equipes.show', $equipe->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-xl transition-all inline-block">
                                        <x-icon name="arrow-up-right-from-square" class="w-4 h-4" />
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-10 text-center">
                                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest italic leading-relaxed">Este agente não possui alocação tática em equipes no momento.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Informativo -->
            <div class="flex items-center justify-between px-8 py-6 bg-amber-50/50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 rounded-3xl">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-white shadow-lg">
                        <x-icon name="circle-info" class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-amber-800 dark:text-amber-400 uppercase tracking-widest">Protocolo de Registro</p>
                        <p class="text-xs font-medium text-amber-700 dark:text-amber-500 opacity-80">Documento gerado automaticamente pelo sistema de gestão Vertex.</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest uppercase italic">Última Auditoria</p>
                    <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">{{ $funcionario->updated_at ? $funcionario->updated_at->format('d/m/Y H:i') : 'SEM REGISTRO' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
