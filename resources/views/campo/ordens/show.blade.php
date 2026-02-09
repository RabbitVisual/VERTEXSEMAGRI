@extends('campo.layouts.app')

@section('title', 'Dossiê O.S: ' . $ordem->numero)

@section('breadcrumbs')
    <x-icon name="chevron-right" class="w-2 h-2" />
    <a href="{{ route('campo.ordens.index') }}" class="hover:text-emerald-600">Fila de Operações</a>
    <x-icon name="chevron-right" class="w-2 h-2" />
    <span class="text-emerald-600">Dossiê #{{ $ordem->numero }}</span>
@endsection

@section('content')
<div class="space-y-6 md:space-y-10 animate-fade-in pb-12">
    <!-- Header de Inteligência -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-8 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-[2rem] flex items-center justify-center text-white shadow-2xl shadow-emerald-500/20 transform -rotate-3 group hover:rotate-0 transition-all duration-300">
                <x-icon name="clipboard-list" style="duotone" class="w-10 h-10" />
            </div>
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tighter uppercase leading-none">{{ $ordem->numero }}</h1>
                    @php
                        $s_colors = ['pendente' => 'amber', 'em_execucao' => 'blue', 'concluida' => 'emerald', 'cancelada' => 'rose'];
                        $c = $s_colors[$ordem->status] ?? 'slate';
                    @endphp
                    <span class="px-3 py-1 bg-{{ $c }}-100 dark:bg-{{ $c }}-900/30 text-{{ $c }}-600 dark:text-{{ $c }}-400 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border border-{{ $c }}-200 dark:border-{{ $c }}-800">
                        {{ strtoupper($ordem->status) }}
                    </span>
                </div>
                <div class="flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest italic">
                    <span class="flex items-center gap-2">
                        <x-icon name="calendar-day" class="w-3 h-3 text-emerald-500" />
                        Emissão: {{ $ordem->created_at->format('d/m/Y H:i') }}
                    </span>
                    <span class="flex items-center gap-2">
                        <x-icon name="user-check" class="w-3 h-3 text-emerald-500" />
                        Responsável: {{ Auth::user()->name }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @if($ordem->status === 'pendente')
                <form method="POST" action="{{ route('campo.ordens.iniciar', $ordem->id) }}" onsubmit="return confirm('Deseja ativar este protocolo operacional?')">
                    @csrf
                    <button type="submit" class="h-14 px-10 flex items-center gap-3 bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-600/20 active:scale-95">
                        <x-icon name="circle-play" class="w-5 h-5" />
                        Iniciar Execução
                    </button>
                </form>
            @elseif($ordem->status === 'em_execucao')
                <button onclick="concluirOrdem()" class="h-14 px-10 flex items-center gap-3 bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-600/20 active:scale-95">
                    <x-icon name="circle-check" class="w-5 h-5" />
                    Finalizar Operação
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Coluna de Detalhes Técnicos -->
        <div class="lg:col-span-8 space-y-10">
            <!-- Descrição e Localidade -->
            <div class="premium-card p-10 overflow-hidden relative">
                <div class="absolute right-0 top-0 p-8 opacity-[0.03] pointer-events-none">
                    <x-icon name="file-invoice" class="w-32 h-32" />
                </div>

                <div class="flex items-center gap-6 mb-8 pb-6 border-b border-gray-50 dark:border-slate-800">
                    <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                        <x-icon name="location-dot" style="duotone" class="w-7 h-7" />
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1 italic">Vetor de Atendimento</h3>
                        <p class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $ordem->demanda->localidade->nome ?? 'Localidade Central' }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">Descrição da Demanda</h4>
                    <p class="text-lg font-medium text-slate-600 dark:text-slate-300 leading-relaxed bg-slate-50 dark:bg-slate-900/50 p-8 rounded-[2rem] border border-gray-100 dark:border-slate-800 italic">
                        "{{ $ordem->descricao }}"
                    </p>
                </div>
            </div>

            <!-- Galeria de Evidências (Antes) -->
            <div class="premium-card p-10">
                <div class="flex items-center justify-between mb-10">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner">
                            <x-icon name="camera" style="duotone" class="w-7 h-7" />
                        </div>
                        <div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1 italic">Registro Fotográfico</h3>
                            <p class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Estado Antecedente (Antes)</p>
                        </div>
                    </div>
                    @if($ordem->status === 'em_execucao')
                    <button onclick="document.getElementById('input-fotos-antes').click()" class="h-12 px-6 flex items-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-500 hover:text-white transition-all shadow-sm active:scale-95">
                        <x-icon name="plus" class="w-4 h-4" />
                        Anexar Evidência
                    </button>
                    <form id="form-fotos-antes" action="{{ route('campo.ordens.fotos', $ordem->id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="hidden" name="tipo" value="antes">
                        <input type="file" id="input-fotos-antes" name="fotos[]" multiple onchange="this.form.submit()">
                    </form>
                    @endif
                </div>

                @if(!empty($ordem->fotos_antes) && is_array($ordem->fotos_antes))
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($ordem->fotos_antes as $foto)
                    <div class="relative group aspect-square rounded-3xl overflow-hidden border-2 border-slate-100 dark:border-slate-800 shadow-lg">
                        <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                            <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-900 hover:bg-emerald-500 hover:text-white transition-all">
                                <x-icon name="expand" class="w-5 h-5" />
                            </a>
                            @if($ordem->status === 'em_execucao')
                            <button onclick="removerFoto('{{ $foto }}', 'antes')" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-rose-600 hover:bg-rose-500 hover:text-white transition-all">
                                <x-icon name="trash" class="w-5 h-5" />
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="py-16 text-center bg-slate-50 dark:bg-slate-900/50 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <x-icon name="images" class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-4" />
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Nenhuma evidência antecedente registrada.</p>
                </div>
                @endif
            </div>

            <!-- Reservas de Material -->
            <div class="premium-card p-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                            <x-icon name="box-open" style="duotone" class="w-7 h-7" />
                        </div>
                        <div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1 italic">Logística de Suprimentos</h3>
                            <p class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Materiais e Reservas</p>
                        </div>
                    </div>

                    @if($ordem->status === 'em_execucao')
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-3 px-4 py-2 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 cursor-pointer hover:bg-white dark:hover:bg-slate-800 transition-all">
                            <input type="checkbox" id="sem_material" name="sem_material" value="1" {{ $ordem->sem_material ? 'checked' : '' }} onchange="toggleMaterialForm()" class="w-5 h-5 rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500 bg-white dark:bg-slate-800">
                            <span class="text-[10px] font-black uppercase text-slate-600 dark:text-slate-300">Não exige material</span>
                        </label>
                    </div>
                    @endif
                </div>

                @if($ordem->status === 'em_execucao')
                <div id="formAdicionarMaterial" class="mb-10 p-8 bg-slate-50 dark:bg-slate-900/50 rounded-[2rem] border border-slate-100 dark:border-slate-800 {{ $ordem->sem_material ? 'hidden' : '' }}">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                        <div class="md:col-span-7">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 italic">Selecionar Item de Estoque</label>
                            <select id="material_id" onchange="verificarEstoqueMaterial(this)" class="w-full py-4 bg-white dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white appearance-none cursor-pointer">
                                <option value="">LISTA DE MATERIAIS DISPONÍVEIS</option>
                                @foreach($materiais ?? [] as $material)
                                    @php $temEstoque = $material->estoque_atual > 0; @endphp
                                    <option value="{{ $material->id }}"
                                            data-estoque="{{ $material->estoque_atual }}"
                                            data-tem-estoque="{{ $temEstoque ? '1' : '0' }}"
                                            data-material-nome="{{ $material->nome }}"
                                            data-material-codigo="{{ $material->codigo }}"
                                            data-unidade="{{ $material->unidade_medida }}"
                                            {{ !$temEstoque ? 'disabled' : '' }}>
                                        {{ strtoupper($material->nome) }} (ESTOQUE: {{ $material->estoque_atual }} {{ $material->unidade_medida }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 italic">Carga Requisitada</label>
                            <input type="number" id="quantidade_material" step="0.01" class="w-full py-4 bg-white dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white" placeholder="0.00">
                        </div>
                        <div class="md:col-span-2">
                            <button type="button" onclick="adicionarMaterial()" class="w-full h-14 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all active:scale-95">
                                <x-icon name="plus" class="w-6 h-6" />
                            </button>
                        </div>
                    </div>

                    <div id="material-sem-estoque-alerta" class="hidden mt-6 p-5 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/30 rounded-2xl flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <x-icon name="triangle-exclamation" class="w-5 text-rose-600" />
                            <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Estoque Insuficiente. Requer Solicitação Manual.</p>
                        </div>
                        <button onclick="abrirModalSolicitarMaterial()" class="px-5 py-2.5 bg-rose-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-sm">
                            Abrir Requisição
                        </button>
                    </div>
                </div>
                @endif

                <div id="materiais-container" class="space-y-4">
                    @forelse($ordem->materiais as $materialOrdem)
                    <div class="flex items-center justify-between p-6 bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 group hover:border-emerald-500 transition-all shadow-sm" data-material-id="{{ $materialOrdem->id }}">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-xl flex items-center justify-center text-slate-400">
                                <x-icon name="box" class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $materialOrdem->material->nome ?? 'Material Indefinido' }}</p>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 italic">
                                    Consumo: {{ number_format($materialOrdem->quantidade, 2, ',', '.') }} {{ $materialOrdem->material->unidade_medida ?? '' }}
                                </p>
                            </div>
                        </div>
                        @if($ordem->status === 'em_execucao')
                        <button onclick="removerMaterial({{ $materialOrdem->id }})" class="p-3 text-slate-300 hover:text-rose-500 transition-colors">
                            <x-icon name="trash-can" class="w-5 h-5" />
                        </button>
                        @endif
                    </div>
                    @empty
                    <div class="py-12 text-center bg-slate-50/50 dark:bg-slate-900/30 rounded-[2rem] border-2 border-dashed border-slate-100 dark:border-slate-800">
                        <p class="text-[10px] font-black text-slate-300 uppercase italic">Nenhum item consumido neste protocolo.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Coluna de Status e Ações -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Card de Situação Operacional -->
            <div class="premium-card p-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-3 italic">
                    <x-icon name="gauge-high" style="duotone" class="w-5 h-5 text-emerald-500" />
                    Status da Unidade
                </h3>

                <div class="space-y-8">
                    @php
                        $priory = [
                            'urgente' => ['color' => 'rose', 'icon' => 'fire'],
                            'alta' => ['color' => 'orange', 'icon' => 'bolt'],
                            'media' => ['color' => 'amber', 'icon' => 'triangle-exclamation'],
                            'baixa' => ['color' => 'emerald', 'icon' => 'check-double']
                        ][$ordem->prioridade] ?? ['color' => 'slate', 'icon' => 'info'];
                    @endphp
                    <div class="p-8 bg-{{ $priory['color'] }}-500 rounded-[2.5rem] text-white text-center shadow-xl shadow-{{ $priory['color'] }}-500/20 relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 opacity-10 pointer-events-none group-hover:scale-125 transition-transform duration-700">
                            <x-icon name="{{ $priory['icon'] }}" class="w-24 h-24" />
                        </div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.3em] opacity-80 mb-2 italic">Nível de Prioridade</h4>
                        <p class="text-3xl font-black uppercase tracking-tighter">{{ $ordem->prioridade }}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-6 bg-gray-50 dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Execução Iniciada</p>
                            <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                {{ $ordem->data_inicio ? $ordem->data_inicio->format('d/m/Y H:i') : 'AGUARDANDO ATIVAÇÃO' }}
                            </p>
                        </div>
                        <div class="p-6 bg-gray-50 dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Tempo em Aberto</p>
                            <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                {{ $ordem->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Interação -->
            <div class="premium-card p-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-3 italic">
                    <x-icon name="toolbox" style="duotone" class="w-5 h-5 text-indigo-500" />
                    Central de Comandos
                </h3>

                <div class="flex flex-col gap-4">
                    <a href="{{ route('campo.chat.page', ['os' => $ordem->numero]) }}" class="w-full h-14 flex items-center justify-center gap-3 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                        <x-icon name="comments" class="w-5 h-5" />
                        Chat Relacionado
                    </a>

                    <button type="button" class="w-full h-14 flex items-center justify-center gap-3 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all border border-gray-100 dark:border-slate-700 shadow-sm active:scale-95">
                        <x-icon name="shield-virus" class="w-5 h-5" />
                        Reportar Incidente
                    </button>

                    <a href="{{ route('campo.ordens.index') }}" class="w-full h-14 flex items-center justify-center gap-3 bg-slate-50 dark:bg-slate-900 text-slate-400 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:text-emerald-600 transition-all border border-transparent hover:border-emerald-500/20 active:scale-95">
                        <x-icon name="arrow-left" class="w-4 h-4" />
                        Voltar à Fila
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Finalização Premium -->
<div id="modalConcluir" class="hidden fixed inset-0 z-[100] bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-6 animate-fade-in" x-data="{ saving: false }">
    <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-white/10 overflow-hidden animate-scale-in">
        <form action="{{ route('campo.ordens.concluir', $ordem->id) }}" method="POST" enctype="multipart/form-data" @submit="saving = true">
            @csrf

            <div class="p-10 border-b border-gray-100 dark:border-slate-800 bg-emerald-500/5 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-500/20">
                        <x-icon name="check-double" style="duotone" class="w-8 h-8" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Relatório de Encerramento</h2>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic mt-1">Protocolo #{{ $ordem->numero }}</p>
                    </div>
                </div>
                <button type="button" onclick="fecharModalConcluir()" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-rose-600 transition-colors flex items-center justify-center">
                    <x-icon name="xmark" class="w-6 h-6" />
                </button>
            </div>

            <div class="p-10 space-y-10 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <div class="space-y-6">
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest italic ml-2">Diagnóstico e Execução Efetuada</label>
                    <textarea name="relatorio_execucao" required rows="6" placeholder="DESCREVA DETALHADAMENTE AS INTERVENÇÕES REALIZADAS, PEÇAS SUBSTITUÍDAS E O ESTADO FINAL DO EQUIPAMENTO/LOCAL..." class="w-full p-8 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-[2rem] text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest italic ml-2">Observações Adicionais</label>
                        <textarea name="observacoes" rows="3" placeholder="NOTA TÉCNICA OU RESSALVAS (OPCIONAL)" class="w-full p-6 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-xs font-medium text-slate-600 dark:text-slate-300 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"></textarea>
                    </div>

                    <div class="space-y-6">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest italic ml-2">Evidências de Conclusão (Depois)</label>
                        <div class="relative">
                            <input type="file" name="fotos_depois[]" multiple onchange="previewFotosModal(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="p-8 border-2 border-dashed border-emerald-200 dark:border-emerald-800 rounded-[2rem] bg-emerald-50/20 dark:bg-emerald-900/10 text-center group-hover:border-emerald-500 transition-all">
                                <x-icon name="cloud-arrow-up" class="w-8 h-8 text-emerald-500 mx-auto mb-2" />
                                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Clique ou arraste as fotos aqui</p>
                            </div>
                        </div>
                        <div id="preview-fotos-modal" class="hidden grid grid-cols-4 gap-4 pt-4"></div>
                    </div>
                </div>

                <div class="p-8 bg-slate-50 dark:bg-slate-950/50 rounded-[2rem] border border-gray-100 dark:border-slate-800">
                    <h5 class="text-[9px] font-black uppercase text-slate-400 tracking-widest mb-4 italic">Recapitulação de Recursos</h5>
                    <div class="flex items-center gap-8">
                        <div class="flex items-center gap-3">
                            <x-icon name="box" class="w-4 h-4 text-blue-500" />
                            <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Materiais: <span id="resumo-materiais-count">{{ count($ordem->materiais) }}</span> itens</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-icon name="camera" class="w-4 h-4 text-amber-500" />
                            <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Evidências Antes: {{ is_array($ordem->fotos_antes) ? count($ordem->fotos_antes) : 0 }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-icon name="camera-retro" class="w-4 h-4 text-emerald-500" />
                            <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Evidências Depois: <span id="resumo-fotos-depois">0</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-10 bg-gray-50 dark:bg-slate-950/80 border-t border-gray-100 dark:border-slate-800 flex items-center justify-end gap-4">
                <button type="button" onclick="fecharModalConcluir()" class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-rose-600 transition-colors">Abortar Operação</button>
                <button type="submit" x-bind:disabled="saving" class="h-16 px-12 bg-emerald-600 text-white rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 active:scale-95 disabled:opacity-50">
                    <span x-show="!saving">Confirmar Entrega Técnica</span>
                    <span x-show="saving" class="flex items-center gap-3">
                        <x-icon name="spinner" class="w-5 h-5 animate-spin" /> PROCESANDO...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Solicitação de Material Premium -->
<div id="modalSolicitarMaterial" class="hidden fixed inset-0 z-[110] bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-6 animate-fade-in">
    <div class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-white/10 overflow-hidden animate-scale-in">
        <div class="p-10 border-b border-gray-100 dark:border-slate-800 bg-rose-500/5 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-rose-500/20">
                    <x-icon name="cart-plus" style="duotone" class="w-8 h-8" />
                </div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Requisição de Insumos</h2>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic mt-1">Material Sem Disponibilidade em Estoque</p>
                </div>
            </div>
            <button onclick="fecharModalSolicitarMaterial()" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-rose-600 transition-colors flex items-center justify-center">
                <x-icon name="xmark" class="w-6 h-6" />
            </button>
        </div>

        <form id="formSolicitarMaterial" onsubmit="event.preventDefault(); enviarSolicitacaoMaterial();" class="p-10 space-y-8">
            <input type="hidden" id="solicitar_material_id" name="material_id">
            <input type="hidden" name="ordem_servico_id" value="{{ $ordem->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Material Identificado</label>
                    <input type="text" id="solicitar_material_nome" name="material_nome" readonly class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-500">
                </div>
                <div class="space-y-2">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Código Interno</label>
                    <input type="text" id="solicitar_material_codigo" name="material_codigo" readonly class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Quantidade Necesaria</label>
                    <input type="number" name="quantidade" step="0.01" required class="w-full p-5 bg-white dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 dark:text-white">
                </div>
                <div class="space-y-2">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Unidade de Medida</label>
                    <select id="solicitar_unidade_medida" name="unidade_medida" class="w-full p-5 bg-white dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest appearance-none">
                        <option value="unidade">UNIDADE</option>
                        <option value="metro">METRO</option>
                        <option value="litro">LITRO</option>
                        <option value="kg">KG</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Justificativa da Demanda</label>
                <textarea name="justificativa" required rows="3" class="w-full p-6 bg-white dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-xs font-medium text-slate-600 dark:text-slate-300 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all"></textarea>
            </div>

            <div class="pt-6 flex justify-end gap-4">
                <button type="button" onclick="fecharModalSolicitarMaterial()" class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-rose-600 transition-colors">Cancelar</button>
                <button type="submit" class="h-16 px-12 bg-rose-600 text-white rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-xl shadow-rose-500/20 active:scale-95">
                    Enviar Requisição
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleMaterialForm() {
        const checkbox = document.getElementById('sem_material');
        const formMaterial = document.getElementById('formAdicionarMaterial');
        if (checkbox && formMaterial) {
            formMaterial.classList.toggle('hidden', checkbox.checked);
            salvarSemMaterial(checkbox.checked);
        }
    }

    function salvarSemMaterial(semMaterial) {
        fetch('{{ route("campo.ordens.sem-material", $ordem->id) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ sem_material: semMaterial })
        });
    }

    function removerFoto(path, tipo) {
        if (!confirm('Deseja remover esta evidência?')) return;
        fetch('{{ route("campo.ordens.fotos.remover", $ordem->id) }}', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ path, tipo })
        }).then(res => res.json()).then(data => data.success && location.reload());
    }

    function adicionarMaterial() {
        const id = document.getElementById('material_id').value;
        const q = document.getElementById('quantidade_material').value;
        if (!id || !q) return alert('Selecione o material e informe a carga.');

        fetch('{{ route("campo.ordens.materiais", $ordem->id) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ material_id: id, quantidade: q })
        }).then(res => res.json()).then(data => data.success ? location.reload() : alert(data.error));
    }

    function removerMaterial(mid) {
        if (!confirm('Deseja cancelar esta reserva de material?')) return;
        fetch('{{ route("campo.ordens.materiais.remover", [$ordem->id, ":mid"]) }}'.replace(':mid', mid), {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(res => res.json()).then(data => data.success ? location.reload() : alert('Erro ao remover.'));
    }

    function verificarEstoqueMaterial(select) {
        const opt = select.options[select.selectedIndex];
        const alerta = document.getElementById('material-sem-estoque-alerta');
        if (opt.getAttribute('data-tem-estoque') === '0' && opt.value) {
            alerta.classList.remove('hidden');
            window.matSel = { id: opt.value, nome: opt.dataset.materialNome, codigo: opt.dataset.materialCodigo, un: opt.dataset.unidade };
        } else {
            alerta.classList.add('hidden');
        }
    }

    function abrirModalSolicitarMaterial() {
        if (!window.matSel) return;
        document.getElementById('solicitar_material_nome').value = window.matSel.nome;
        document.getElementById('solicitar_material_codigo').value = window.matSel.codigo;
        document.getElementById('solicitar_material_id').value = window.matSel.id;
        document.getElementById('solicitar_unidade_medida').value = window.matSel.un;
        document.getElementById('modalSolicitarMaterial').classList.remove('hidden');
    }

    function fecharModalSolicitarMaterial() {
        document.getElementById('modalSolicitarMaterial').classList.add('hidden');
    }

    function enviarSolicitacaoMaterial() {
        const formData = new FormData(document.getElementById('formSolicitarMaterial'));
        fetch('{{ route("campo.materiais.solicitar.store") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        }).then(res => res.json()).then(data => {
            if (data.success) {
                alert('Requisição enviada ao centro de comando.');
                fecharModalSolicitarMaterial();
            }
        });
    }

    function concluirOrdem() { document.getElementById('modalConcluir').classList.remove('hidden'); }
    function fecharModalConcluir() { document.getElementById('modalConcluir').classList.add('hidden'); }

    function previewFotosModal(input) {
        const container = document.getElementById('preview-fotos-modal');
        container.innerHTML = '';
        container.classList.remove('hidden');
        Array.from(input.files).forEach(f => {
            const rd = new FileReader();
            rd.onload = e => {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-xl overflow-hidden border border-emerald-500';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                container.appendChild(div);
            };
            rd.readAsDataURL(f);
        });
        document.getElementById('resumo-fotos-depois').textContent = input.files.length;
    }
</script>
@endpush
@endsection
