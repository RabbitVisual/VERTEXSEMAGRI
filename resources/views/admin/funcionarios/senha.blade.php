@extends('admin.layouts.admin')

@section('title', 'Credenciais de Acesso: ' . $funcionario->nome)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="key" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Gestão de <span class="text-indigo-600 dark:text-indigo-400">Acessos</span></span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors italic">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <a href="{{ route('admin.funcionarios.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors italic">Funcionários</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors italic">{{ $funcionario->nome }}</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px]">Credenciais</span>
            </nav>
        </div>

        <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 focus:ring-4 focus:ring-gray-100 dark:focus:ring-slate-700 transition-all">
            <x-icon name="arrow-left" class="w-5 h-5" style="solid" />
            Voltar ao Dossiê
        </a>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Info do Usuário -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="p-8 text-center bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center text-3xl font-bold shadow-xl">
                            {{ substr($funcionario->nome, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center shadow-md border border-gray-100 dark:border-slate-700">
                            <x-icon name="fingerprint" class="w-4 h-4 text-indigo-600" />
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $funcionario->nome }}</h3>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">{{ $funcionario->codigo ?? 'S/ MATRÍCULA' }}</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-700">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status da Conta</span>
                            <span class="text-sm font-bold uppercase tracking-tight {{ $user && $user->active ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $user && $user->active ? 'Ativado' : 'Bloqueado' }}
                            </span>
                        </div>
                        <div class="w-3 h-3 rounded-full {{ $user && $user->active ? 'bg-emerald-500 shadow-emerald-500/50 shadow-lg' : 'bg-rose-500 shadow-rose-500/50 shadow-lg' }}"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <x-icon name="at" style="duotone" class="w-5 h-5" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">ID de Acesso (E-mail)</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $user->email ?? $funcionario->email }}">
                                    {{ $user->email ?? ($funcionario->email ?? 'NÃO CADASTRADO') }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-slate-700">
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl">
                                <h4 class="text-[10px] font-bold text-blue-700 dark:text-blue-300 uppercase tracking-widest mb-3 flex items-center gap-2">
                                    <x-icon name="information-circle" class="w-4 h-4" />
                                    Protocolo de Segurança
                                </h4>
                                <ul class="text-[11px] text-blue-800/80 dark:text-blue-200/80 space-y-2 font-medium">
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
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl flex items-center gap-3 animate-fade-in-up">
                    <x-icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                    <span class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Painel de Destaque: Credenciais Geradas -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden relative">
                <div class="absolute -right-8 -top-8 text-indigo-500/5 rotate-12 pointer-events-none">
                    <x-icon name="identification" class="w-64 h-64" />
                </div>

                <div class="p-8 md:p-12 relative z-10">
                    @if($senhaTemporaria)
                        <div class="text-center mb-10">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[10px] font-bold uppercase tracking-widest mb-4">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                Credenciais Criadas com Sucesso
                            </span>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Cofre de Acesso Temporário</h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Acesso exclusivo para entrega ao colaborador</p>
                        </div>

                        <div class="max-w-md mx-auto space-y-6">
                            <div class="p-8 bg-gray-50 dark:bg-slate-900 rounded-[2rem] border-2 border-dashed border-indigo-200 dark:border-indigo-800 relative group cursor-pointer transition-all hover:border-indigo-400 hover:bg-white dark:hover:bg-slate-800 shadow-sm hover:shadow-md" onclick="copiarSenha(event)">
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                                    Clique para Copiar
                                </div>

                                <div class="space-y-8 text-center">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">ID DE USUÁRIO</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white tracking-widest break-all">{{ $user->email ?? $funcionario->email }}</p>
                                    </div>
                                    <div class="pt-8 border-t border-gray-200 dark:border-slate-700">
                                        <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-2">SENHA TEMPORÁRIA</p>
                                        <p class="text-4xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400 tracking-wider font-mono py-2" id="senhaDisplay">{{ $senhaTemporaria }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <a href="{{ route('admin.funcionarios.senha.comprovante', $funcionario->id) }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg shadow-emerald-500/20 active:scale-95 transition-all">
                                    <x-icon name="printer" style="duotone" class="w-5 h-5" />
                                    Imprimir Comprovante
                                </a>
                                <form action="{{ route('admin.funcionarios.senha.visualizada', $funcionario->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto h-full px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl transition-all">
                                        Concluir & Ocultar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Estado de Espera -->
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-100 dark:border-slate-700">
                                <x-icon name="lock-closed" style="duotone" class="w-10 h-10 text-slate-300 dark:text-slate-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Nenhuma Senha em Exibição</h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto leading-relaxed">
                                O sistema de segurança Vertex bloqueia a visualização contínua de senhas. Utilize as ferramentas abaixo para redefinir o acesso.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Painel de Gerenciamento -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Gerador Automático -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <x-icon name="sparkles" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Gerador Inteligente</h3>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Alta segurança aleatória</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.funcionarios.senha.gerar', $funcionario->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-slate-900 dark:bg-indigo-600 text-white text-xs font-bold uppercase tracking-widest hover:shadow-lg hover:shadow-slate-900/20 dark:hover:shadow-indigo-500/20 transition-all active:scale-95">
                            <x-icon name="key" class="w-4 h-4" />
                            Gerar Novo Acesso
                        </button>
                    </form>
                </div>

                <!-- Definição Manual -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-fuchsia-50 dark:bg-fuchsia-900/20 flex items-center justify-center text-fuchsia-600 dark:text-fuchsia-400">
                            <x-icon name="pencil-square" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Redefinição Manual</h3>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Definir senha específica</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.funcionarios.senha.alterar', $funcionario->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <input type="password" name="nova_senha" required minlength="8" placeholder="Digite a Nova Senha" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400">
                        </div>
                        <div>
                            <input type="password" name="nova_senha_confirmation" required minlength="8" placeholder="Repetir Senha" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400">
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white font-bold text-xs uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                            <x-icon name="check" class="w-4 h-4" />
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
