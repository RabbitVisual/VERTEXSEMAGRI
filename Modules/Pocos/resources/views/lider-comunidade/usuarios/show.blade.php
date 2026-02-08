@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.usuarios.index') }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">{{ $usuario->nome }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Detalhes do perfil do morador</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('lider-comunidade.usuarios.edit', $usuario->id) }}" class="px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                Editar Perfil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="premium-card p-6">
            <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3">Informações Pessoais</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                <div class="sm:col-span-2">
                    <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nome Completo</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $usuario->nome }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">CPF</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $usuario->cpf_formatado ?: 'Não informado' }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Telefone / WhatsApp</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $usuario->telefone ?: 'Não informado' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Endereço Residencial</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $usuario->endereco }}{{ $usuario->numero_casa ? ', ' . $usuario->numero_casa : '' }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Código de Acesso</dt>
                    <dd class="text-xl font-black text-blue-600 dark:text-blue-400 tracking-tight">{{ $usuario->codigo_acesso }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status da Conta</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $usuario->status === 'ativo' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : ($usuario->status === 'suspenso' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                            {{ $usuario->status_texto }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="premium-card p-6">
            <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3">Histórico Recente</h2>
            <div class="space-y-4">
                @forelse($usuario->pagamentos()->orderBy('data_pagamento', 'desc')->limit(10)->get() as $pagamento)
                <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl flex items-center justify-between group hover:border-blue-200 dark:hover:border-blue-900/50 transition-all">
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">Mensalidade {{ $pagamento->mensalidade->mes_ano }}</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight italic">Pago em {{ $pagamento->data_pagamento->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-emerald-600 dark:text-emerald-400">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $pagamento->forma_pagamento_texto }}</p>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center">
                    <svg class="w-10 h-10 text-gray-200 dark:text-slate-800 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest">Nenhum pagamento</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('lider-comunidade.usuarios.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600">
            Voltar
        </a>
        <a href="{{ route('lider-comunidade.usuarios.edit', $usuario->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            Editar
        </a>
    </div>
</div>
@endsection
