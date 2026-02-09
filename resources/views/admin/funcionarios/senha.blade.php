@extends('admin.layouts.admin')

@section('title', 'Credenciais de Acesso: ' . $funcionario->nome)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="key" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Gestão de <span class="text-indigo-600">Acessos</span></span>
            </h1>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.funcionarios.index') }}" class="hover:text-indigo-600 transition-colors">Funcionários</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="hover:text-indigo-600 transition-colors">{{ $funcionario->nome }}</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <span class="text-indigo-600">Controle de Credenciais</span>
            </nav>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar ao Dossiê
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Info do Usuário -->
        <div class="lg:col-span-1 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="p-8 text-center bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center text-3xl font-black shadow-xl">
                            {{ substr($funcionario->nome, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center shadow-md border border-gray-100 dark:border-slate-700">
                            <x-icon name="fingerprint" class="w-4 h-4 text-indigo-600" />
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1 italic">{{ $funcionario->codigo ?? 'S/ MATRÍCULA' }}</p>
                </div>

                <div class="p-8 space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 group">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Status da Conta</span>
                            <span class="text-sm font-black uppercase tracking-tighter {{ $user && $user->active ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $user && $user->active ? 'Ativado' : 'Bloqueado / Inexistente' }}
                            </span>
                        </div>
                        <div class="w-3 h-3 rounded-full {{ $user && $user->active ? 'bg-emerald-500 shadow-[0_0_8px_theme(colors.emerald.500)]' : 'bg-rose-500 shadow-[0_0_8px_theme(colors.rose.500)]' }}"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <x-icon name="at" style="duotone" class="w-5 h-5" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">ID de Acesso (E-mail)</p>
                                <p class="text-sm font-black text-gray-900 dark:text-white truncate" title="{{ $user->email ?? $funcionario->email }}">
                                    {{ $user->email ?? ($funcionario->email ?? 'NÃO CADASTRADO') }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-slate-800">
                            <div class="p-5 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-2xl">
                                <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3 flex items-center gap-2">
                                    <x-icon name="circle-info" class="w-3.5 h-3.5" />
                                    Protocolo de Segurança
                                </h4>
                                <ul class="text-[10px] text-blue-800/70 dark:text-blue-400/70 space-y-2 font-bold uppercase tracking-tight italic">
                                    <li class="flex items-start gap-2">
                                        <span class="text-blue-500">•</span>
                                        Nova senha ativa o acesso imediatamente.
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-blue-500">•</span>
                                        A visualização é única por geração.
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-blue-500">•</span>
                                        Obrigatório entregar comprovante impresso.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna de Ações -->
        <div class="lg:col-span-2 space-y-8">
            @if(session('success'))
                <div class="p-6 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/20 rounded-2xl flex items-center gap-4 animate-scale-in">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                        <x-icon name="check-double" class="w-6 h-6" />
                    </div>
                    <span class="text-sm font-black text-emerald-800 dark:text-emerald-400 uppercase tracking-tight">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Painel de Destaque: Credenciais Geradas -->
            <div class="premium-card overflow-hidden relative">
                <div class="absolute -right-8 -top-8 text-indigo-500/5 rotate-12">
                    <x-icon name="id-card" class="w-64 h-64" />
                </div>

                <div class="p-8 md:p-12">
                    @if($senhaTemporaria)
                        <div class="text-center mb-10">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[9px] font-black uppercase tracking-widest mb-4">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                Credenciais Criadas com Sucesso
                            </span>
                            <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Cofre de Acesso Temporário</h2>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-2 italic">Acesso exclusivo para entrega ao colaborador</p>
                        </div>

                        <div class="max-w-md mx-auto space-y-6">
                            <div class="p-8 bg-gray-50 dark:bg-slate-900 rounded-[2rem] border-2 border-dashed border-indigo-200 dark:border-indigo-900/50 relative group cursor-pointer transition-all hover:border-indigo-400 hover:bg-white dark:hover:bg-slate-800 shadow-xl" onclick="copiarSenha(event)">
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all">
                                    Clique para Copiar
                                </div>

                                <div class="space-y-8 text-center">
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 leading-none italic">ID DE USUÁRIO</p>
                                        <p class="text-xl font-black text-gray-900 dark:text-white tracking-widest">{{ $user->email ?? $funcionario->email }}</p>
                                    </div>
                                    <div class="pt-8 border-t border-gray-100 dark:border-slate-800">
                                        <p class="text-[9px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-3 leading-none italic">SENHA TEMPORÁRIA</p>
                                        <p class="text-5xl font-black text-indigo-600 dark:text-indigo-400 tracking-[0.15em] font-mono leading-none py-2" id="senhaDisplay">{{ $senhaTemporaria }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <a href="{{ route('admin.funcionarios.senha.comprovante', $funcionario->id) }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 text-[11px] font-black uppercase tracking-widest text-white bg-emerald-600 hover:bg-emerald-700 rounded-2xl shadow-xl shadow-emerald-500/20 active:scale-95 transition-all">
                                    <x-icon name="print" style="duotone" class="w-5 h-5" />
                                    Imprimir Comprovante
                                </a>
                                <form action="{{ route('admin.funcionarios.senha.visualizada', $funcionario->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto h-full px-8 py-4 text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-all">
                                        Concluir & Ocultar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Estado de Espera -->
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-gray-100 dark:border-slate-800 scale-125">
                                <x-icon name="shield-keyhole" style="duotone" class="w-12 h-12 text-slate-300 dark:text-slate-700" />
                            </div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Nenhuma Senha em Exibição</h2>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-2 font-black uppercase tracking-widest leading-relaxed italic">
                                O sistema de segurança Vertex bloqueia a visualização contínua de senhas. Utilize as ferramentas abaixo para redefinir o acesso.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Painel de Gerenciamento -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Gerador Automático -->
                <div class="premium-card p-8 group hover:scale-105 transition-all">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-sm border border-indigo-100 dark:border-indigo-900/30">
                            <x-icon name="wand-magic-sparkles" style="duotone" class="w-7 h-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tight">Gerador Inteligente</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none mt-1">Alta Intensidade Alpha-Numeric</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.funcionarios.senha.gerar', $funcionario->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 py-4 rounded-2xl bg-slate-900 dark:bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest hover:shadow-xl hover:shadow-slate-900/20 dark:hover:shadow-blue-500/20 transition-all active:scale-95">
                            <x-icon name="key-skeleton" class="w-4 h-4" />
                            Forçar Novo Acesso
                        </button>
                    </form>
                </div>

                <!-- Definição Manual -->
                <div class="premium-card p-8 group hover:scale-105 transition-all">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-fuchsia-50 dark:bg-fuchsia-900/20 flex items-center justify-center text-fuchsia-600 dark:text-fuchsia-400 shadow-sm border border-fuchsia-100 dark:border-fuchsia-900/30">
                            <x-icon name="signature" style="duotone" class="w-7 h-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tight">Redefinição Manual</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none mt-1">Criptografia Personalizada</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.funcionarios.senha.alterar', $funcionario->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="relative group/field">
                            <input type="password" name="nova_senha" required minlength="8" placeholder="Digite a Nova Senha" class="w-full pl-5 pr-5 py-3.5 bg-gray-50 dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-fuchsia-500/10 focus:border-fuchsia-500 transition-all dark:text-white placeholder:text-slate-400">
                        </div>
                        <div class="relative group/field">
                            <input type="password" name="nova_senha_confirmation" required minlength="8" placeholder="Repetir Senha" class="w-full pl-5 pr-5 py-3.5 bg-gray-50 dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-fuchsia-500/10 focus:border-fuchsia-500 transition-all dark:text-white placeholder:text-slate-400">
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-3 py-4 rounded-2xl border-2 border-slate-900 dark:border-slate-700 text-slate-900 dark:text-white text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white dark:hover:bg-slate-800 transition-all active:scale-95">
                            <x-icon name="floppy-disk" class="w-4 h-4" />
                            Atualizar Manual
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copiarSenha(event) {
    const senha = document.getElementById('senhaDisplay').innerText;
    navigator.clipboard.writeText(senha).then(() => {
        const el = event.currentTarget;
        el.classList.add('ring-4', 'ring-emerald-500/30', 'bg-emerald-50/10');
        setTimeout(() => {
            el.classList.remove('ring-4', 'ring-emerald-500/30', 'bg-emerald-50/10');
        }, 300);

        // Custom simple toast
        alert('Credenciais copiadas para a área de transferência com segurança.');
    });
}
</script>
@endpush
@endsection
