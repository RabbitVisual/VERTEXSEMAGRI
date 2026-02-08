@extends('admin.layouts.admin')

@section('title', 'Gerenciar Credenciais - ' . $funcionario->nome)

@section('content')
<div class="space-y-6">
    <!-- Header Simples e Direto -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar ao Perfil
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Esquerda: Informações e Status (Sticky) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Cartão do Funcionário -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden sticky top-6">
                <div class="p-6 bg-gray-50 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700 text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-3 shadow-lg">
                        {{ substr($funcionario->nome, 0, 1) }}
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $funcionario->nome }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-mono mt-1">{{ $funcionario->codigo ?? 'SEM MATRÍCULA' }}</p>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-slate-700">
                        <span class="text-sm text-gray-500">Status da Conta</span>
                        @if($user && $user->active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Ativo
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Inativo / Sem Acesso
                            </span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-slate-700">
                        <span class="text-sm text-gray-500">Usuário (Login)</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]" title="{{ $user->email ?? $funcionario->email }}">
                            {{ $user->email ?? ($funcionario->email ?? 'Não cadastrado') }}
                        </span>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mt-4">
                        <h4 class="text-xs font-bold text-blue-800 dark:text-blue-300 uppercase tracking-wider mb-2">Como Funciona</h4>
                        <ul class="text-xs text-blue-700 dark:text-blue-400 space-y-2">
                            <li class="flex gap-2">
                                <span class="text-blue-500">•</span>
                                Gerar ou Alterar a senha <strong>ativa a conta</strong> imediatamente.
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-500">•</span>
                                A senha só é exibida <strong>uma vez</strong> por segurança.
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-500">•</span>
                                Sempre imprima o <strong>Comprovante</strong> para o funcionário.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Direita: Ações Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 animate-fade-in-down">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Área de Destaque: Credenciais Atuais -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-indigo-100 dark:border-slate-700 overflow-hidden relative">
                <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                    <svg class="w-32 h-32 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="p-8">
                    @if($senhaTemporaria)
                        <div class="text-center mb-8">
                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold uppercase tracking-wider mb-3">Senha Gerada com Sucesso</span>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Credenciais Temporárias Ativas</h2>
                            <p class="text-gray-500 dark:text-gray-400">Entregue estas informações ao funcionário imediatamente.</p>
                        </div>

                        <div class="bg-gray-100 dark:bg-slate-900 rounded-xl p-6 border-2 border-dashed border-gray-300 dark:border-slate-700 mb-8 max-w-lg mx-auto relative group">
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-white dark:bg-slate-800 px-3 py-1 rounded-full border border-gray-200 dark:border-slate-700 shadow-sm text-xs font-mono text-gray-500">
                                CLIQUE PARA COPIAR
                            </div>

                            <div class="grid gap-6 text-center cursor-pointer" onclick="copiarSenha(event)">
                                <div>
                                    <p class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-1">USUÁRIO / EMAIL</p>
                                    <p class="text-lg font-mono font-medium text-gray-900 dark:text-white">{{ $user->email ?? $funcionario->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-indigo-600 font-bold tracking-wider mb-1">SENHA DE ACESSO</p>
                                    <p class="text-3xl font-mono font-bold text-indigo-600 dark:text-indigo-400 tracking-wider" id="senhaDisplay">{{ $senhaTemporaria }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('admin.funcionarios.senha.comprovante', $funcionario->id) }}" target="_blank" class="flex-1 max-w-xs inline-flex items-center justify-center gap-2 px-6 py-3.5 text-base font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-200 dark:shadow-none hover:translate-y-[-2px] transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg>
                                Imprimir Comprovante
                            </a>
                            <form action="{{ route('admin.funcionarios.senha.visualizada', $funcionario->id) }}" method="POST" class="flex-none">
                                @csrf
                                <button type="submit" class="w-full h-full px-4 py-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-700 transition-colors">
                                    Ocultar
                                </button>
                            </form>
                        </div>

                    @else
                        <!-- Estado Vazio / Inicial -->
                        <div class="text-center py-6">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-slate-600">
                                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhuma Senha Visível</h2>
                            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                                Utilize as opções abaixo para gerar uma nova senha aleatória ou definir uma senha manualmente para este funcionário.
                            </p>
                            @if(!$user)
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-800 text-xs font-medium border border-amber-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                Ao gerar senha, o usuário será criado automaticamente.
                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Grid de Ações Secundárias -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Opção 1: Gerar Automático -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Gerar Aleatória</h3>
                            <p class="text-xs text-gray-500">Senha forte de 12 dígitos</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.funcionarios.senha.gerar', $funcionario->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-bold hover:opacity-90 transition-opacity">
                            Gerar Nova Senha
                        </button>
                    </form>
                </div>

                <!-- Opção 2: Definir Manual -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-fuchsia-50 dark:bg-fuchsia-900/20 rounded-lg text-fuchsia-600 dark:text-fuchsia-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Definir Manualmente</h3>
                            <p class="text-xs text-gray-500">Escolha uma senha específica</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.funcionarios.senha.alterar', $funcionario->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="password" name="nova_senha" required minlength="8" placeholder="Nova Senha (min. 8)" class="w-full text-sm rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 focus:ring-indigo-500 focus:border-indigo-500">
                        <input type="password" name="nova_senha_confirmation" required minlength="8" placeholder="Confirmar Senha" class="w-full text-sm rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 focus:ring-indigo-500 focus:border-indigo-500">

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Salvar Senha
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
        // Feedback visual toast ou tooltip poderia ser adicionado aqui
        const el = event.currentTarget;
        const originalBg = el.style.backgroundColor;

        // Efeito de flash verde
        el.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50');
        setTimeout(() => {
            el.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50');
        }, 300);

        alert('Senha copiada para a área de transferência!');
    });
}
</script>
@endpush
@endsection
