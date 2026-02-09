@extends('admin.layouts.admin')

@section('title', 'Detalhes da Notificação')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon module="notificacoes" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Detalhes da Notificação</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.notificacoes.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Notificações</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.notificacoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <form action="{{ route('admin.notificacoes.destroy', $notification->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar esta notificação?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Deletar
                </button>
            </form>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Informações da Notificação - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações da Notificação</h3>
        </div>
        <div class="p-6">
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                <div>
                    @php
                        $typeCores = [
                            'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                            'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                            'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                            'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            'error' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            'alert' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                            'system' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
                        ];
                        $typeClass = $typeCores[$notification->type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                    @endphp
                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $typeClass }}">{{ $notification->type_texto }}</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                <div>
                    @if($notification->is_read)
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">Lida</span>
                        @if($notification->read_at)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Lida em: {{ $notification->read_at->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    @else
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300">Não lida</span>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Título</label>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $notification->title }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Destinatário</label>
                <p class="text-gray-900 dark:text-white">
                    {{ $notification->user->name ?? ($notification->role ?? 'Todos os usuários') }}
                </p>
            </div>

            @if($notification->module_source)
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Módulo</label>
                <p class="text-gray-900 dark:text-white">{{ $notification->module_source }}</p>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Criação</label>
                <p class="text-gray-900 dark:text-white">
                    {{ $notification->created_at->format('d/m/Y H:i:s') }}
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        ({{ $notification->created_at->diffForHumans() }})
                    </span>
                </p>
            </div>

            @if($notification->read_at)
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Leitura</label>
                <p class="text-gray-900 dark:text-white">
                    {{ $notification->read_at->format('d/m/Y H:i:s') }}
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        ({{ $notification->read_at->diffForHumans() }})
                    </span>
                </p>
            </div>
            @endif

            @if($notification->entity_type && $notification->entity_id)
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Entidade Relacionada</label>
                <p class="text-gray-900 dark:text-white">
                    <span class="px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                        {{ $notification->entity_type }} #{{ $notification->entity_id }}
                    </span>
                </p>
            </div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Mensagem</label>
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $notification->message }}</p>
            </div>
        </div>

        @if($notification->action_url)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL de Ação</label>
            <a href="{{ $notification->action_url }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                {{ $notification->action_url }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
        @endif

        @if($notification->data)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dados Adicionais</label>
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                <pre class="text-sm text-gray-900 dark:text-white overflow-x-auto font-mono">{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif

        <!-- Informações de Broadcasting -->
        <div class="mt-6 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z" />
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200 mb-1">Status de Broadcasting</h4>
                    <p class="text-sm text-indigo-800 dark:text-indigo-300 mb-2">
                        Esta notificação foi enviada em tempo real através do sistema de broadcasting.
                    </p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @if($notification->user_id)
                            <span class="px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                Canal: private-user.{{ $notification->user_id }}
                            </span>
                        @elseif($notification->role)
                            <span class="px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                Canal: role.{{ $notification->role }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                Canal: notifications (público)
                            </span>
                        @endif
                        <span class="px-2 py-1 rounded text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                            Evento: notificacao.criada
                        </span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

