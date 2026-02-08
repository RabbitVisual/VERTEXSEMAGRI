@extends('admin.layouts.admin')

@section('title', 'Detalhes do Token de API')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <span>Detalhes do Token</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.api.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">API</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ $token->name }}</span>
            </nav>
        </div>
        <a href="{{ route('admin.api.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>

    @if(session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-4 text-emerald-800 border border-emerald-300 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 text-sm font-medium">{!! session('success') !!}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex h-8 w-8 dark:bg-emerald-900/20 dark:text-emerald-400 dark:hover:bg-emerald-900/30" data-dismiss-target="#alert-success" aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informações do Token - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Token</h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $token->name }}</dd>
                    </div>

                    @if($token->description)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $token->description }}</dd>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuário</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $token->user->name }} ({{ $token->user->email }})</dd>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>
                            @if($token->isActive())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    Ativo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    Inativo
                                </span>
                            @endif
                        </dd>
                    </div>

                    <div class="flex flex-col gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Token</dt>
                        <dd>
                            <div class="flex items-center gap-2">
                                <code class="flex-1 text-xs bg-gray-50 dark:bg-slate-700 px-3 py-2 rounded font-mono border border-gray-300 dark:border-slate-600 break-all">{{ $token->token }}</code>
                                <button onclick="navigator.clipboard.writeText('{{ $token->token }}')" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors" title="Copiar">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638A7.5 7.5 0 001.5 12.75v4.5A2.25 2.25 0 003.75 19.5h10.5A2.25 2.25 0 0016.5 17.25v-4.5a7.5 7.5 0 00-1.834-5.862zM13.5 3.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3a.75.75 0 01.75-.75z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                Guarde este token com segurança. Ele não será exibido novamente.
                            </p>
                        </dd>
                    </div>

                    <div class="flex flex-col gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Permissões</dt>
                        <dd>
                            @if(in_array('*', $token->abilities ?? []))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">Todas (*)</span>
                            @else
                                <div class="flex flex-wrap gap-1">
                                    @foreach($token->abilities ?? [] as $ability)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-300">{{ $ability }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </dd>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Último Uso</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">
                            {{ $token->last_used_at ? $token->last_used_at->format('d/m/Y H:i:s') : 'Nunca utilizado' }}
                        </dd>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expira em</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">
                            {{ $token->expires_at ? $token->expires_at->format('d/m/Y H:i') : 'Sem expiração' }}
                        </dd>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Limite de Requisições</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $token->rate_limit }} por minuto</dd>
                    </div>

                    @if($token->ip_whitelist)
                    <div class="flex flex-col gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">IP Whitelist</dt>
                        <dd>
                            <div class="flex flex-wrap gap-1">
                                @foreach($token->ip_whitelist as $ip)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">{{ $ip }}</span>
                                @endforeach
                            </div>
                        </dd>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Criado em</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $token->created_at->format('d/m/Y H:i:s') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Ações - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ações</h2>
            </div>
            <div class="p-6 space-y-3">
                @if($token->isActive())
                <form action="{{ route('admin.api.revoke', $token->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-amber-700 bg-amber-50 border border-amber-200 rounded-lg hover:bg-amber-100 focus:ring-4 focus:ring-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800 dark:hover:bg-amber-900/30 dark:focus:ring-amber-800 transition-colors" onclick="return confirm('Tem certeza que deseja revogar este token?')">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Revogar Token
                    </button>
                </form>
                @endif

                <form action="{{ route('admin.api.regenerate', $token->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:ring-4 focus:ring-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800 dark:hover:bg-blue-900/30 dark:focus:ring-blue-800 transition-colors" onclick="return confirm('Tem certeza? Um novo token será gerado e este será desativado.')">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Regenerar Token
                    </button>
                </form>

                <form action="{{ route('admin.api.destroy', $token->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 focus:ring-4 focus:ring-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/30 dark:focus:ring-red-800 transition-colors" onclick="return confirm('Tem certeza que deseja remover permanentemente este token?')">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Remover Token
                    </button>
                </form>

                <a href="{{ route('api.documentation') }}" target="_blank" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                    Ver Documentação da API
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
