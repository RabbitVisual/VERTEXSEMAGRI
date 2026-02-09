@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon module="caf" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Cadastro CAF - {{ $cadastro->protocolo ?? $cadastro->codigo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.caf.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">CAF</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $cadastro->protocolo ?? $cadastro->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.caf.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('caf.cadastrador.pdf', $cadastro->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition-colors">
                <x-icon name="file-pdf" class="w-5 h-5" />
                Gerar PDF
            </a>
        </div>
    </div>

    <!-- Status e Ações -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($cadastro->status == 'aprovado') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                    @elseif($cadastro->status == 'completo') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                    @elseif($cadastro->status == 'enviado_caf') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400
                    @elseif($cadastro->status == 'rejeitado') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                    @elseif($cadastro->status == 'em_andamento') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                    @endif">
                    {{ $cadastro->status_texto }}
                </span>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Protocolo:</span> {{ $cadastro->protocolo ?? 'N/A' }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Código:</span> {{ $cadastro->codigo }}
                </div>
            </div>
            <div class="flex gap-2">
                @if($cadastro->status == 'completo')
                    <form method="POST" action="{{ route('admin.caf.aprovar', $cadastro->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <x-icon name="check-circle" class="w-5 h-5" />
                            Aprovar
                        </button>
                    </form>
                @endif
                @if($cadastro->status == 'aprovado' && !$cadastro->enviado_caf_at)
                    <button onclick="openEnviarModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        <x-icon name="paper-airplane" class="w-5 h-5" />
                        Enviar ao CAF
                    </button>
                @endif
                @if($cadastro->status != 'enviado_caf')
                    <button onclick="openRejeitarModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <x-icon name="x-circle" class="w-5 h-5" />
                        Rejeitar
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Conteúdo igual ao show do cadastrador -->
    @include('caf::cadastrador.show')
</div>

<!-- Modal Rejeitar -->
<div id="rejeitarModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Rejeitar Cadastro</h3>
            <form method="POST" action="{{ route('admin.caf.rejeitar', $cadastro->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações <span class="text-red-500">*</span></label>
                    <textarea name="observacoes" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Informe o motivo da rejeição..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejeitarModal()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Rejeitar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Enviar CAF -->
<div id="enviarModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Enviar ao CAF Oficial</h3>
            <form method="POST" action="{{ route('admin.caf.enviar-caf', $cadastro->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Protocolo CAF Oficial (Opcional)</label>
                    <input type="text" name="protocolo_caf_oficial" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Protocolo recebido do sistema CAF oficial">
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEnviarModal()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openRejeitarModal() {
        document.getElementById('rejeitarModal').classList.remove('hidden');
    }
    function closeRejeitarModal() {
        document.getElementById('rejeitarModal').classList.add('hidden');
    }
    function openEnviarModal() {
        document.getElementById('enviarModal').classList.remove('hidden');
    }
    function closeEnviarModal() {
        document.getElementById('enviarModal').classList.add('hidden');
    }
    // Fechar ao clicar fora
    document.getElementById('rejeitarModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeRejeitarModal();
    });
    document.getElementById('enviarModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEnviarModal();
    });
</script>
@endpush
@endsection

