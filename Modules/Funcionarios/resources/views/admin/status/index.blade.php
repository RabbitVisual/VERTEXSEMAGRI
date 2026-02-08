@extends('admin.layouts.admin')

@section('title', 'Monitoramento de Funcionários em Tempo Real')

@push('styles')
<style>
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .status-indicator.pulse {
        animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse-dot {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <x-icon name="rotate-right" class="w-5 h-5" />
                Atualizar
            </button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg dark:bg-emerald-900/20 dark:border-emerald-800">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1" id="stat-total">{{ $estatisticas['total'] }}</p>
                </div>
                <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Disponíveis -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Disponíveis</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-500 mt-1" id="stat-disponiveis">{{ $estatisticas['disponiveis'] }}</p>
                </div>
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Em Atendimento -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Em Atendimento</p>
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-500 mt-1" id="stat-atendimento">{{ $estatisticas['em_atendimento'] }}</p>
                </div>
                <div class="p-3 bg-amber-100 dark:bg-amber-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-500 pulse-animation" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pausados -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pausados</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-500 mt-1" id="stat-pausados">{{ $estatisticas['pausados'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Offline -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Offline</p>
                    <p class="text-3xl font-bold text-gray-600 dark:text-gray-500 mt-1" id="stat-offline">{{ $estatisticas['offline'] }}</p>
                </div>
                <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l8.735 8.735m0 0a.374.374 0 11.53.53m-.53-.53l.53.53m0 0L21 21M14.652 9.348a3.75 3.75 0 010 5.304m2.121-7.425a6.75 6.75 0 010 9.546m2.121-11.667c3.808 3.807 3.808 9.98 0 13.788m-9.546-4.242a3.733 3.733 0 01-1.06-2.122m-1.061 4.243a6.75 6.75 0 01-1.625-6.929m-.496 9.05c-3.068-3.067-3.664-7.67-1.79-11.334M12 12h.008v.008H12V12z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Última Atualização -->
    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
        <span>Última atualização: <strong id="ultima-atualizacao">{{ now()->format('H:i:s') }}</strong></span>
        <span>Próxima atualização em: <strong id="proximo-update">15s</strong></span>
    </div>

    <!-- Lista de Funcionários -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Funcionários Ativos</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Monitoramento em tempo real do status de todos os funcionários</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Funcionário
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Função
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Ordem Atual
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tempo em Atendimento
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="funcionarios-tbody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($funcionarios as $funcionario)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" data-funcionario-id="{{ $funcionario->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-semibold">
                                        {{ substr($funcionario->nome, 0, 2) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $funcionario->nome }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $funcionario->codigo }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900 dark:text-white">{{ $funcionario->funcao_formatada }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge">
                                <span class="status-indicator {{ $funcionario->status_campo === 'em_atendimento' ? 'pulse' : '' }} bg-{{ $funcionario->status_campo_cor }}-500"></span>
                                <span class="text-sm font-medium text-{{ $funcionario->status_campo_cor }}-700 dark:text-{{ $funcionario->status_campo_cor }}-400">
                                    {{ $funcionario->status_campo_texto }}
                                </span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($funcionario->ordemServicoAtual)
                                <a href="{{ route('admin.ordens.show', $funcionario->ordemServicoAtual->id) }}" class="text-sm text-emerald-600 dark:text-emerald-500 hover:underline">
                                    OS #{{ $funcionario->ordemServicoAtual->numero }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $funcionario->ordemServicoAtual->demanda->localidade->nome ?? 'N/A' }}
                                </p>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($funcionario->tempo_atendimento)
                                <span class="text-sm text-gray-900 dark:text-white font-medium">{{ $funcionario->tempo_atendimento }}</span>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($funcionario->estaEmAtendimento())
                                <button onclick="forcarLiberacao({{ $funcionario->id }}, '{{ $funcionario->nome }}')" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400 mr-3">
                                    Forçar Liberação
                                </button>
                            @endif
                            <button onclick="verDetalhes({{ $funcionario->id }})" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-500 dark:hover:text-emerald-400">
                                Detalhes
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            <p class="mt-2">Nenhum funcionário ativo encontrado</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Forçar Liberação -->
<div id="modal-forcar-liberacao" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Forçar Liberação</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Você está prestes a forçar a liberação do funcionário <strong id="modal-funcionario-nome"></strong>.
            Por favor, informe o motivo:
        </p>
        <form id="form-forcar-liberacao" method="POST">
            @csrf
            <textarea name="motivo" rows="3" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white" placeholder="Motivo da liberação forçada..."></textarea>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="fecharModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                    Confirmar Liberação
                </button>
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

// Atualização automática
function iniciarAtualizacaoAutomatica() {
    // Atualizar a cada 15 segundos
    updateInterval = setInterval(() => {
        atualizarDados();
        countdown = 15;
    }, 15000);

    // Countdown
    countdownInterval = setInterval(() => {
        countdown--;
        document.getElementById('proximo-update').textContent = countdown + 's';
        if (countdown <= 0) {
            countdown = 15;
        }
    }, 1000);
}

// Atualizar dados via AJAX
async function atualizarDados() {
    try {
        const response = await fetch('{{ route("admin.funcionarios.status.atualizar") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Erro na requisição');

        const data = await response.json();

        if (data.success) {
            // Atualizar estatísticas
            document.getElementById('stat-total').textContent = data.estatisticas.total;
            document.getElementById('stat-disponiveis').textContent = data.estatisticas.disponiveis;
            document.getElementById('stat-atendimento').textContent = data.estatisticas.em_atendimento;
            document.getElementById('stat-pausados').textContent = data.estatisticas.pausados;
            document.getElementById('stat-offline').textContent = data.estatisticas.offline;

            // Atualizar timestamp
            document.getElementById('ultima-atualizacao').textContent = data.timestamp;

            // Atualizar tabela de funcionários
            atualizarTabelaFuncionarios(data.funcionarios);
        }
    } catch (error) {
        console.error('Erro ao atualizar dados:', error);
    }
}

// Atualizar tabela
function atualizarTabelaFuncionarios(funcionarios) {
    const tbody = document.getElementById('funcionarios-tbody');

    funcionarios.forEach(func => {
        const row = tbody.querySelector(`tr[data-funcionario-id="${func.id}"]`);
        if (!row) return;

        // Atualizar status
        const statusCell = row.querySelector('td:nth-child(3)');
        const statusIndicatorClass = func.status_campo === 'em_atendimento' ? 'pulse' : '';
        statusCell.innerHTML = `
            <span class="status-badge">
                <span class="status-indicator ${statusIndicatorClass} bg-${func.status_campo_cor}-500"></span>
                <span class="text-sm font-medium text-${func.status_campo_cor}-700 dark:text-${func.status_campo_cor}-400">
                    ${func.status_campo_texto}
                </span>
            </span>
        `;

        // Atualizar ordem atual
        const ordemCell = row.querySelector('td:nth-child(4)');
        if (func.ordem_atual) {
            ordemCell.innerHTML = `
                <a href="/admin/ordens/${func.ordem_atual.id}" class="text-sm text-emerald-600 dark:text-emerald-500 hover:underline">
                    OS #${func.ordem_atual.numero}
                </a>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    ${func.ordem_atual.localidade}
                </p>
            `;
        } else {
            ordemCell.innerHTML = '<span class="text-sm text-gray-500 dark:text-gray-400">-</span>';
        }

        // Atualizar tempo
        const tempoCell = row.querySelector('td:nth-child(5)');
        if (func.tempo_atendimento) {
            tempoCell.innerHTML = `<span class="text-sm text-gray-900 dark:text-white font-medium">${func.tempo_atendimento}</span>`;
        } else {
            tempoCell.innerHTML = '<span class="text-sm text-gray-500 dark:text-gray-400">-</span>';
        }
    });
}

// Atualizar agora
function atualizarAgora() {
    const icon = document.getElementById('refresh-icon');
    icon.classList.add('animate-spin');

    atualizarDados().finally(() => {
        setTimeout(() => {
            icon.classList.remove('animate-spin');
        }, 500);
    });

    countdown = 15;
}

// Forçar liberação
function forcarLiberacao(id, nome) {
    document.getElementById('modal-funcionario-nome').textContent = nome;
    document.getElementById('form-forcar-liberacao').action = `/admin/funcionarios/status/${id}/forcar-liberacao`;
    document.getElementById('modal-forcar-liberacao').classList.remove('hidden');
}

// Fechar modal
function fecharModal() {
    document.getElementById('modal-forcar-liberacao').classList.add('hidden');
}

// Ver detalhes
async function verDetalhes(id) {
    try {
        const response = await fetch(`/admin/funcionarios/status/${id}/detalhes`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Erro na requisição');

        const data = await response.json();

        if (data.success) {
            // Mostrar detalhes em um modal ou alert (você pode criar um modal mais bonito)
            const func = data.funcionario;
            let info = `Funcionário: ${func.nome}\n`;
            info += `Código: ${func.codigo}\n`;
            info += `Função: ${func.funcao}\n`;
            info += `Status: ${func.status}\n`;

            if (func.ordem_atual) {
                info += `\nOrdem Atual:\n`;
                info += `- OS #${func.ordem_atual.numero}\n`;
                info += `- Tipo: ${func.ordem_atual.tipo_servico}\n`;
                info += `- Localidade: ${func.ordem_atual.localidade}\n`;
                info += `- Tempo: ${func.tempo_atendimento || 'N/A'}\n`;
            }

            alert(info);
        }
    } catch (error) {
        console.error('Erro ao buscar detalhes:', error);
        alert('Erro ao buscar detalhes do funcionário');
    }
}

// Iniciar ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    iniciarAtualizacaoAutomatica();
});

// Limpar intervalos ao sair
window.addEventListener('beforeunload', () => {
    if (updateInterval) clearInterval(updateInterval);
    if (countdownInterval) clearInterval(countdownInterval);
});
</script>
@endpush

