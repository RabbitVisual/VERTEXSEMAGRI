@extends('Co-Admin.layouts.app')

@section('title', 'Monitoramento Tático: Efetivos em Campo')

@section('content')
<div class="space-y-8 md:space-y-12 animate-fade-in pb-12">
    <!-- Header de Monitoramento -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 rounded-[2.5rem] shadow-2xl p-10 md:p-14 text-white">
        <div class="absolute top-0 right-0 -mt-24 -mr-24 opacity-10 pointer-events-none">
            <x-icon name="tower-broadcast" style="duotone" class="w-[30rem] h-[30rem]" />
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-12">
            <div class="flex items-center gap-8">
                <div class="w-24 h-24 bg-white/5 rounded-[2rem] backdrop-blur-3xl flex items-center justify-center border border-white/10 shadow-2xl group">
                    <x-icon name="tower-broadcast" style="duotone" class="w-12 h-12 text-indigo-400 animate-pulse" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight uppercase leading-none mb-4">Radar de Efetivos</h1>
                    <div class="flex items-center gap-4">
                        <span class="px-4 py-1.5 bg-indigo-500/20 border border-indigo-500/30 rounded-full text-[10px] font-black uppercase tracking-widest text-indigo-300 italic">Vigilância Ativa</span>
                        <div class="h-1 w-1 rounded-full bg-slate-500"></div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] italic">Varredura: <span id="ultima-atualizacao-header" class="text-white">{{ now()->format('H:i:s') }}</span></p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <div class="px-8 py-4 bg-black/20 backdrop-blur-xl rounded-2xl border border-white/5 flex flex-col items-end">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Próximo Scan</p>
                    <span id="proximo-update" class="text-xl font-black text-indigo-400 tabular-nums tracking-tighter">15s</span>
                </div>
                <button onclick="atualizarAgora()" class="h-full px-10 bg-white text-slate-900 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-100 active:scale-95 transition-all shadow-xl flex items-center gap-3">
                    <x-icon id="refresh-icon" name="rotate" class="w-4 h-4" />
                    Sincronizar
                </button>
            </div>
        </div>
    </div>

    <!-- Estatísticas de Operação -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        @php
            $co_stats = [
                'total' => ['label' => 'Quadro Total', 'icon' => 'user-group', 'color' => 'indigo', 'id' => 'stat-total'],
                'disponiveis' => ['label' => 'Disponíveis', 'icon' => 'user-check', 'color' => 'emerald', 'id' => 'stat-disponiveis'],
                'em_atendimento' => ['label' => 'Em Campo', 'icon' => 'truck-fast', 'color' => 'amber', 'id' => 'stat-atendimento'],
                'pausados' => ['label' => 'Suspensos', 'icon' => 'pause', 'color' => 'blue', 'id' => 'stat-pausados'],
                'offline' => ['label' => 'Offline', 'icon' => 'wifi-slash', 'color' => 'rose', 'id' => 'stat-offline'],
            ];
        @endphp

        @foreach($co_stats as $key => $s)
        <div class="premium-card p-6 flex flex-col justify-between group hover:border-{{ $s['color'] }}-500 transition-all duration-500 overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 pointer-events-none group-hover:scale-125 transition-transform">
                <x-icon name="{{ $s['icon'] }}" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $s['color'] }}-50 dark:bg-{{ $s['color'] }}-900/20 flex items-center justify-center text-{{ $s['color'] }}-600 dark:text-{{ $s['color'] }}-400 group-hover:bg-{{ $s['color'] }}-500 group-hover:text-white transition-all shadow-sm">
                    <x-icon name="{{ $s['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                @if($key === 'em_atendimento')
                    <div class="flex gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse [animation-delay:200ms]"></span>
                    </div>
                @endif
            </div>
            <div>
                <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest leading-none mb-2">{{ $s['label'] }}</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter" id="{{ $s['id'] }}">{{ $estatisticas[$key] ?? 0 }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tabela de Monitoramento Tático -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Unidade de Efetivo</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Especialidade</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Sinal de Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Operação Vinculada</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Crono-Campo</th>
                        <th class="px-10 py-6 text-right text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Ver</th>
                    </tr>
                </thead>
                <tbody id="funcionarios-tbody" class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($funcionarios as $funcionario)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-slate-700/30 transition-all duration-300" data-funcionario-id="{{ $funcionario->id }}">
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-200 dark:from-slate-900 dark:to-slate-800 flex items-center justify-center text-slate-600 font-black border-2 border-white dark:border-slate-700 shadow-xl group-hover:scale-105 group-hover:rotate-2 transition-all">
                                    {{ strtoupper(substr($funcionario->nome, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</span>
                                    <span class="text-[9px] font-black font-mono text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mt-1 italic">{{ $funcionario->codigo }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-7">
                            <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ $funcionario->funcao_formatada }}</span>
                        </td>
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-{{ $funcionario->status_campo_cor }}-500 {{ $funcionario->status_campo === 'em_atendimento' ? 'animate-pulse' : '' }}"></div>
                                <span class="text-[10px] font-black text-{{ $funcionario->status_campo_cor }}-600 dark:text-{{ $funcionario->status_campo_cor }}-400 uppercase tracking-widest italic">
                                    {{ $funcionario->status_campo_texto }}
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-7">
                            @if($funcionario->ordemServicoAtual)
                                <a href="{{ route('co-admin.ordens.show', $funcionario->ordemServicoAtual->id) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-lg group/os">
                                    <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">OS #{{ $funcionario->ordemServicoAtual->numero }}</span>
                                    <x-icon name="arrow-right" class="w-3 h-3 text-indigo-400 group-hover/os:translate-x-1 transition-transform" />
                                </a>
                            @else
                                <span class="text-[10px] font-black text-slate-300 uppercase italic">Inativo</span>
                            @endif
                        </td>
                        <td class="px-10 py-7 whitespace-nowrap">
                            @if($funcionario->tempo_atendimento)
                                <span class="text-sm font-black text-gray-900 dark:text-white tabular-nums tracking-tighter">{{ $funcionario->tempo_atendimento }}</span>
                            @else
                                <span class="text-sm font-black text-slate-300">-</span>
                            @endif
                        </td>
                        <td class="px-10 py-7 text-right">
                            <button onclick="verDetalhes({{ $funcionario->id }})" class="w-12 h-12 flex items-center justify-center bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-indigo-600 rounded-2xl transition-all border border-transparent hover:border-indigo-200 dark:hover:border-indigo-900/50 hover:shadow-lg">
                                <x-icon name="eye" class="w-6 h-6" />
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-32 text-center">
                            <div class="max-w-xs mx-auto space-y-6">
                                <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[3rem] flex items-center justify-center mx-auto text-slate-200 border border-dashed border-slate-300">
                                    <x-icon name="wifi-slash" style="duotone" class="w-12 h-12" />
                                </div>
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-[0.3em] leading-loose italic">Silêncio Operacional: Nenhum sinal detectado na rede.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Dossiê Rápido -->
<div id="modal-detalhes" class="hidden fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-6 transition-all duration-500">
    <div class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-[3.5rem] shadow-2xl border border-white/10 overflow-hidden scale-95 opacity-0 transition-all duration-300" id="modal-container">
        <div class="relative h-40 bg-gradient-to-r from-indigo-950 to-slate-900 flex items-center px-12 overflow-hidden">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <x-icon name="fingerprint" class="w-96 h-96 -mt-24 -ml-24" />
            </div>
            <div class="relative z-10 flex items-center gap-8">
                <div id="modal-avatar" class="w-20 h-20 rounded-[1.5rem] bg-indigo-500 text-white flex items-center justify-center text-3xl font-black shadow-2xl border-4 border-white/10"></div>
                <div>
                    <h3 id="modal-name" class="text-2xl font-black text-white uppercase tracking-tight">---</h3>
                    <p id="modal-code" class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mt-1 italic">---</p>
                </div>
            </div>
            <button onclick="fecharModalDetalhes()" class="absolute top-8 right-8 w-12 h-12 flex items-center justify-center bg-white/5 hover:bg-white/10 text-white rounded-2xl border border-white/10 transition-all">
                <x-icon name="xmark" class="w-6 h-6" />
            </button>
        </div>

        <div class="p-12 space-y-10" id="modal-detalhes-content">
            <!-- Injected via JS -->
        </div>

        <div class="p-8 bg-gray-50/50 dark:bg-slate-950/50 border-t border-gray-100 dark:border-slate-800 flex justify-end">
            <button onclick="fecharModalDetalhes()" class="px-10 py-4 text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors">Fechar Dossiê</button>
        </div>
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
            const res = await fetch('{{ route("co-admin.funcionarios.status.atualizar") }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success) {
                ['total', 'disponiveis', 'em_atendimento', 'pausados', 'offline'].forEach(k => {
                    const el = document.getElementById(`stat-${k === 'em_atendimento' ? 'atendimento' : k}`);
                    if(el) el.textContent = data.estatisticas[k];
                });
                document.getElementById('ultima-atualizacao-header').textContent = data.timestamp;
                atualizarTabelaFuncionarios(data.funcionarios);
            }
        } catch (e) { console.error(e); }
    }

    function atualizarTabelaFuncionarios(funcionarios) {
        const tbody = document.getElementById('funcionarios-tbody');
        funcionarios.forEach(f => {
            const row = tbody.querySelector(`tr[data-funcionario-id="${f.id}"]`);
            if (!row) return;

            const statusCell = row.querySelector('td:nth-child(3)');
            statusCell.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-${f.status_campo_cor}-500 ${f.status_campo === 'em_atendimento' ? 'animate-pulse' : ''}"></div>
                    <span class="text-[10px] font-black text-${f.status_campo_cor}-600 dark:text-${f.status_campo_cor}-400 uppercase tracking-widest italic">
                        ${f.status_campo_texto}
                    </span>
                </div>
            `;

            const ordemCell = row.querySelector('td:nth-child(4)');
            if (f.ordem_atual) {
                ordemCell.innerHTML = `
                    <a href="/co-admin/ordens/${f.ordem_atual.id}" class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-lg group/os">
                        <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">OS #${f.ordem_atual.numero}</span>
                        <x-icon name="arrow-right" class="w-3 h-3 text-indigo-400 group-hover/os:translate-x-1 transition-transform" />
                    </a>
                `;
            } else {
                ordemCell.innerHTML = '<span class="text-[10px] font-black text-slate-300 uppercase italic">Inativo</span>';
            }

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

    async function verDetalhes(id) {
        try {
            const res = await fetch(`{{ url('/co-admin/funcionarios/status') }}/${id}/detalhes`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success) {
                const f = data.funcionario;
                document.getElementById('modal-avatar').textContent = f.nome.substring(0, 1).toUpperCase();
                document.getElementById('modal-name').textContent = f.nome;
                document.getElementById('modal-code').textContent = f.codigo;

                let html = `
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Especialidade</p>
                            <p class="text-sm font-black text-slate-700 dark:text-slate-200 uppercase">${f.funcao}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Sinal de Rede</p>
                            <p class="text-sm font-black text-indigo-600 uppercase italic underline underline-offset-4 decoration-2">${f.status}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Canal Digital</p>
                            <p class="text-sm font-black text-slate-700 dark:text-slate-200 lowercase">${f.email || 'N/A'}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Voz Direta</p>
                            <p class="text-sm font-black text-slate-700 dark:text-slate-200">${f.telefone || 'N/A'}</p>
                        </div>
                    </div>
                `;

                if (f.ordem_atual) {
                    html += `
                        <div class="p-8 bg-indigo-50 dark:bg-indigo-950/30 rounded-[2.5rem] border border-indigo-100 dark:border-indigo-900/30">
                            <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                                <x-icon name="satellite" class="w-4 h-4" />
                                Transmissão de Atividade
                            </h4>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-black text-indigo-900 dark:text-indigo-200">OS #${f.ordem_atual.numero}</span>
                                <span class="text-sm font-black font-mono text-indigo-600">${f.tempo_atendimento || '---'}</span>
                            </div>
                            <p class="text-xs font-medium text-slate-600 dark:text-slate-400">${f.ordem_atual.tipo_servico}</p>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2 italic">${f.ordem_atual.localidade}</p>
                        </div>
                    `;
                }

                document.getElementById('modal-detalhes-content').innerHTML = html;
                const modal = document.getElementById('modal-detalhes');
                const container = document.getElementById('modal-container');
                modal.classList.remove('hidden');
                setTimeout(() => { container.classList.remove('scale-95', 'opacity-0'); }, 10);
            }
        } catch (e) { console.error(e); }
    }

    function fecharModalDetalhes() {
        const modal = document.getElementById('modal-detalhes');
        const container = document.getElementById('modal-container');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }

    document.addEventListener('DOMContentLoaded', iniciarAtualizacaoAutomatica);
</script>
@endpush
