@extends('admin.layouts.admin')

@section('title', 'Monitoramento Tático de Efetivos')

@push('styles')
<style>
    .glow-emerald { box-shadow: 0 0 20px rgba(16, 185, 129, 0.2); }
    .glow-amber { box-shadow: 0 0 20px rgba(245, 158, 11, 0.2); }

    @keyframes tactical-pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }
    .pulse-tactical { animation: tactical-pulse 2s infinite; }
</style>
@endpush

@section('content')
<div class="space-y-8 md:space-y-12 animate-fade-in pb-12">
    <!-- Header de Vigilância -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 pb-8 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-slate-900 rounded-[2rem] flex items-center justify-center text-emerald-500 shadow-2xl border border-emerald-500/20 relative group overflow-hidden">
                <div class="absolute inset-0 bg-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <x-icon name="tower-broadcast" style="duotone" class="w-8 h-8 relative z-10" />
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">Radar de Efetivos</h1>
                <div class="flex items-center gap-3 mt-3">
                    <span class="flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[8px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest italic">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Transmissão em Tempo Real
                    </span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Central de Comando RH</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="px-6 py-3 bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl flex flex-col items-end">
                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Próximo Varredura</p>
                <div class="flex items-center gap-2">
                    <span id="proximo-update" class="text-sm font-black text-emerald-600 tabular-nums tracking-tighter">15s</span>
                    <div class="w-4 h-4 rounded-full border-2 border-slate-200 dark:border-slate-700 border-t-emerald-500 animate-spin"></div>
                </div>
            </div>

            <button onclick="atualizarAgora()" class="h-14 px-8 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:opacity-90 active:scale-95 transition-all shadow-xl flex items-center gap-3 group">
                <x-icon id="refresh-icon" name="arrows-rotate" class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" />
                Sincronizar
            </button>
        </div>
    </div>

    <!-- Dash de Operação -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        @php
            $stat_configs = [
                'total' => ['label' => 'Força Total', 'icon' => 'user-group', 'color' => 'slate', 'id' => 'stat-total'],
                'disponiveis' => ['label' => 'Em Reserva', 'icon' => 'user-check', 'color' => 'emerald', 'id' => 'stat-disponiveis'],
                'em_atendimento' => ['label' => 'Engajados', 'icon' => 'user-gear', 'color' => 'amber', 'id' => 'stat-atendimento'],
                'pausados' => ['label' => 'Em Pausa', 'icon' => 'user-clock', 'color' => 'blue', 'id' => 'stat-pausados'],
                'offline' => ['label' => 'Desconectados', 'icon' => 'user-slash', 'color' => 'rose', 'id' => 'stat-offline'],
            ];
        @endphp

        @foreach($stat_configs as $key => $conf)
        <div class="premium-card p-6 group hover:border-{{ $conf['color'] }}-500 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $conf['color'] }}-50 dark:bg-{{ $conf['color'] }}-900/20 flex items-center justify-center text-{{ $conf['color'] }}-600 dark:text-{{ $conf['color'] }}-400 group-hover:bg-{{ $conf['color'] }}-500 group-hover:text-white transition-all">
                    <x-icon name="{{ $conf['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                @if($key === 'em_atendimento')
                    <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-tactical"></span>
                @endif
            </div>
            <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic">{{ $conf['label'] }}</p>
            <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter" id="{{ $conf['id'] }}">{{ $estatisticas[$key] ?? 0 }}</p>
        </div>
        @endforeach
    </div>

    <!-- Tabela de Monitoramento -->
    <div class="premium-card overflow-hidden border-indigo-500/10">
        <div class="px-10 py-8 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between bg-gray-50/30 dark:bg-slate-900/30">
            <div>
                <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight">Status da Frota Humana</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 italic">Acompanhamento de geolocalização e atividade operacional</p>
            </div>
            <div class="text-right">
                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic">Última Varredura</p>
                <p class="text-xs font-black text-indigo-600 dark:text-indigo-400 tabular-nums tracking-tighter" id="ultima-atualizacao">{{ now()->format('H:i:s') }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                        <th class="px-10 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Identidade Operacional</th>
                        <th class="px-10 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Posição / Função</th>
                        <th class="px-10 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Frequência / Status</th>
                        <th class="px-10 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Protocolo Atual</th>
                        <th class="px-10 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Tempo Engajado</th>
                        <th class="px-10 py-5 text-right text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Ações</th>
                    </tr>
                </thead>
                <tbody id="funcionarios-tbody" class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($funcionarios as $funcionario)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-slate-800/50 transition-colors" data-funcionario-id="{{ $funcionario->id }}">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-black border border-white dark:border-slate-600 shadow-lg group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($funcionario->nome, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</p>
                                    <p class="text-[9px] font-black font-mono text-emerald-600 uppercase tracking-widest mt-1 italic">{{ $funcionario->codigo }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ $funcionario->funcao_formatada }}</span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-{{ $funcionario->status_campo_cor }}-500 {{ $funcionario->status_campo === 'em_atendimento' ? 'pulse-tactical' : '' }}"></div>
                                <span class="text-[10px] font-black text-{{ $funcionario->status_campo_cor }}-600 dark:text-{{ $funcionario->status_campo_cor }}-400 uppercase tracking-widest italic">
                                    {{ $funcionario->status_campo_texto }}
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            @if($funcionario->ordemServicoAtual)
                                <a href="{{ route('admin.ordens.show', $funcionario->ordemServicoAtual->id) }}" class="inline-flex items-center gap-2 group/link">
                                    <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest decoration-2 underline-offset-4 group-hover/link:underline">#{{ $funcionario->ordemServicoAtual->numero }}</span>
                                    <x-icon name="arrow-up-right-from-square" class="w-3 h-3 text-slate-300 group-hover/link:text-indigo-500 transition-colors" />
                                </a>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1 italic truncate max-w-[150px]">
                                    {{ $funcionario->ordemServicoAtual->demanda->localidade->nome ?? 'N/A' }}
                                </p>
                            @else
                                <span class="text-[10px] font-black text-slate-300 uppercase italic">Aguardando Missão</span>
                            @endif
                        </td>
                        <td class="px-10 py-6">
                            @if($funcionario->tempo_atendimento)
                                <span class="text-sm font-black text-gray-900 dark:text-white tabular-nums tracking-tighter">{{ $funcionario->tempo_atendimento }}</span>
                            @else
                                <span class="text-sm font-black text-slate-300">-</span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center gap-3">
                                @if($funcionario->estaEmAtendimento())
                                    <button onclick="forcarLiberacao({{ $funcionario->id }}, '{{ $funcionario->nome }}')" class="w-10 h-10 flex items-center justify-center bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-600 hover:text-white transition-all border border-rose-100 dark:border-rose-900/30 shadow-sm" title="Abordagem Emergencial">
                                        <x-icon name="hand-stop" class="w-4 h-4" />
                                    </button>
                                @endif
                                <button onclick="verDetalhes({{ $funcionario->id }})" class="w-10 h-10 flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100 dark:border-emerald-900/30 shadow-sm">
                                    <x-icon name="eye" class="w-5 h-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-24 text-center">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 text-slate-200">
                                <x-icon name="sensor-slash" style="duotone" class="w-10 h-10" />
                            </div>
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] italic">Nenhum Analógico Detectado</h3>
                            <p class="text-[10px] text-slate-500 font-medium mt-2">Os sinais funcionais aparecerão aqui durante o turno de operação.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Emergencial (Forçar Liberação) -->
<div id="modal-forcar-liberacao" class="hidden fixed inset-0 z-[100] bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-6 animate-fade-in">
    <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-white/10 overflow-hidden animate-scale-in">
        <div class="p-10 border-b border-gray-100 dark:border-slate-800 bg-rose-500/5 flex items-center gap-6">
            <div class="w-14 h-14 bg-rose-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-rose-600/20">
                <x-icon name="triangle-exclamation" style="duotone" class="w-7 h-7" />
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Abortar Efetivo</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic mt-1">Intervenção de liberação manual: <span id="modal-funcionario-nome" class="text-rose-500"></span></p>
            </div>
        </div>

        <form id="form-forcar-liberacao" method="POST" class="p-10 space-y-8">
            @csrf
            <div class="space-y-2">
                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Justificativa do Protocolo</label>
                <textarea name="motivo" required rows="3" placeholder="DESCREVA O MOTIVO PARA A INTERRUPÇÃO DA ATIVIDADE..." class="w-full p-6 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-xs font-medium text-slate-600 dark:text-slate-300 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all"></textarea>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="fecharModal()" class="flex-1 h-14 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-rose-600 transition-colors">Abortar Operação</button>
                <button type="submit" class="flex-[2] h-14 bg-rose-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-xl shadow-rose-600/20 active:scale-95">Confirmar Liberação</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let updateInterval;
    let countdownInterval;
    let countdown = 15;

    function iniciarAtualizacaoAutomatica() {
        updateInterval = setInterval(() => { atualizarDados(); countdown = 15; }, 15000);
        countdownInterval = setInterval(() => {
            countdown--;
            document.getElementById('proximo-update').textContent = countdown + 's';
            if (countdown <= 0) countdown = 15;
        }, 1000);
    }

    async function atualizarDados() {
        try {
            const res = await fetch('{{ route("admin.funcionarios.status.atualizar") }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success) {
                ['total', 'disponiveis', 'em_atendimento', 'pausados', 'offline'].forEach(k => {
                    const el = document.getElementById(`stat-${k === 'em_atendimento' ? 'atendimento' : k}`);
                    if(el) el.textContent = data.estatisticas[k];
                });
                document.getElementById('ultima-atualizacao').textContent = data.timestamp;
                atualizarTabelaFuncionarios(data.funcionarios);
            }
        } catch (e) { console.error(e); }
    }

    function atualizarTabelaFuncionarios(funcionarios) {
        const tbody = document.getElementById('funcionarios-tbody');
        funcionarios.forEach(f => {
            const row = tbody.querySelector(`tr[data-funcionario-id="${f.id}"]`);
            if (!row) return;

            // Status Cell (Index 2 in visual order, 3 from the left)
            const statusCell = row.querySelector('td:nth-child(3)');
            statusCell.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-${f.status_campo_cor}-500 ${f.status_campo === 'em_atendimento' ? 'pulse-tactical' : ''}"></div>
                    <span class="text-[10px] font-black text-${f.status_campo_cor}-600 dark:text-${f.status_campo_cor}-400 uppercase tracking-widest italic">
                        ${f.status_campo_texto}
                    </span>
                </div>
            `;

            // Order Cell
            const ordemCell = row.querySelector('td:nth-child(4)');
            if (f.ordem_atual) {
                ordemCell.innerHTML = `
                    <a href="/admin/ordens/${f.ordem_atual.id}" class="inline-flex items-center gap-2 group/link">
                        <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest decoration-2 underline-offset-4 group-hover/link:underline">#${f.ordem_atual.numero}</span>
                        <x-icon name="arrow-up-right-from-square" class="w-3 h-3 text-slate-300 group-hover/link:text-indigo-500 transition-colors" />
                    </a>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1 italic truncate max-w-[150px]">
                        ${f.ordem_atual.localidade}
                    </p>
                `;
            } else {
                ordemCell.innerHTML = '<span class="text-[10px] font-black text-slate-300 uppercase italic">Aguardando Missão</span>';
            }

            // Time Cell
            const tempoCell = row.querySelector('td:nth-child(5)');
            tempoCell.innerHTML = f.tempo_atendimento ?
                `<span class="text-sm font-black text-gray-900 dark:text-white tabular-nums tracking-tighter">${f.tempo_atendimento}</span>` :
                '<span class="text-sm font-black text-slate-300">-</span>';
        });
    }

    function atualizarAgora() {
        const icon = document.getElementById('refresh-icon');
        icon.classList.add('animate-spin');
        atualizarDados().finally(() => { setTimeout(() => icon.classList.remove('animate-spin'), 500); });
        countdown = 15;
    }

    function forcarLiberacao(id, nome) {
        document.getElementById('modal-funcionario-nome').textContent = nome;
        document.getElementById('form-forcar-liberacao').action = `/admin/funcionarios/status/${id}/forcar-liberacao`;
        document.getElementById('modal-forcar-liberacao').classList.remove('hidden');
    }

    function fecharModal() { document.getElementById('modal-forcar-liberacao').classList.add('hidden'); }

    async function verDetalhes(id) {
        try {
            const res = await fetch(`/admin/funcionarios/status/${id}/detalhes`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success) {
                const f = data.funcionario;
                alert(`DETALHES DO EFETIVO:\n\nNome: ${f.nome}\nMatrícula: ${f.codigo}\nFunção: ${f.funcao}\nStatus Ativo: ${f.status}\n\nATIVIDADES EM CURSO:\n${f.ordem_atual ? `OS #${f.ordem_atual.numero} - ${f.ordem_atual.localidade}` : 'Nenhuma OS ativa.'}`);
            }
        } catch (e) { console.error(e); }
    }

    document.addEventListener('DOMContentLoaded', iniciarAtualizacaoAutomatica);
</script>
@endpush
