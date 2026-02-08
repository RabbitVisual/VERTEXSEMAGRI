@extends('Co-Admin.layouts.app')

@section('title', 'Sessão de Chat - ' . ($session->visitor_name ?? 'Sem nome'))

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-7xl">
    <div class="space-y-6 md:space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <span>{{ $session->visitor_name ?? 'Sessão de Chat' }}</span>
                </h1>
                <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('co-admin.dashboard') }}" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Co-Admin</a>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <a href="{{ route('co-admin.chat.index') }}" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Chat</a>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <span class="text-gray-900 dark:text-white font-medium">Sessão</span>
                </nav>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('co-admin.chat.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-800 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Voltar
                </a>
                @if($session->status !== 'closed')
                <a href="{{ route('co-admin.chat.realtime', ['session' => $session->id]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg hover:from-green-600 hover:to-green-700 transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>
                    Atender Agora
                </a>
                <form action="{{ route('co-admin.chat.close', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja encerrar esta sessão?')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Encerrar
                    </button>
                </form>
                @else
                <form action="{{ route('co-admin.chat.reopen', $session->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Reabrir
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chat Messages -->
            <div class="lg:col-span-2 min-w-0">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                            Histórico de Mensagens
                        </h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $session->messages->count() }} mensagens</span>
                    </div>
                    <div id="chat-messages-container" class="p-6 h-[500px] overflow-y-auto space-y-4" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        @forelse($session->messages as $message)
                        <div class="flex {{ $message->sender_type === 'user' ? 'justify-end' : ($message->sender_type === 'system' ? 'justify-center' : 'justify-start') }}">
                            <div class="max-w-[75%] {{ $message->sender_type === 'system' ? 'max-w-[90%]' : '' }}">
                                @if($message->sender_type !== 'system')
                                <div class="flex items-center gap-2 mb-1 {{ $message->sender_type === 'user' ? 'justify-end' : '' }}">
                                    <span class="text-xs font-medium {{ $message->sender_type === 'user' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                        {{ $message->sender_name }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $message->created_at->format('d/m H:i') }}
                                    </span>
                                </div>
                                @endif
                                <div class="px-4 py-2.5 rounded-2xl shadow-sm
                                    {{ $message->sender_type === 'user' ? 'bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/40 dark:to-green-800/30 text-gray-900 dark:text-white rounded-br-md' : '' }}
                                    {{ $message->sender_type === 'visitor' ? 'bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-bl-md' : '' }}
                                    {{ $message->sender_type === 'system' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-sm text-center' : '' }}
                                ">
                                    <p class="whitespace-pre-wrap break-words">{{ $message->message }}</p>
                                    @if($message->sender_type === 'system')
                                    <p class="text-xs mt-1 opacity-70">{{ $message->created_at->format('d/m H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                            <p>Nenhuma mensagem nesta sessão</p>
                        </div>
                        @endforelse
                    </div>
                    
                    @if($session->status !== 'closed')
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                        <form id="message-form" class="flex gap-3">
                            @csrf
                            <input type="text" id="message-input" placeholder="Digite sua mensagem..." 
                                   class="flex-1 px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <button type="submit" class="px-6 py-2.5 text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 transition-all shadow-md flex items-center gap-2">
                                <span>Enviar</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 min-w-0 space-y-6">
                <!-- Informações do Visitante -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Informações do Visitante
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                                {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white text-lg">{{ $session->visitor_name ?? 'Visitante' }}</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full mt-1
                                    {{ $session->status === 'waiting' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : '' }}
                                    {{ $session->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $session->status === 'closed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                ">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        {{ $session->status === 'waiting' ? 'bg-amber-500' : '' }}
                                        {{ $session->status === 'active' ? 'bg-green-500' : '' }}
                                        {{ $session->status === 'closed' ? 'bg-gray-500' : '' }}
                                    "></span>
                                    {{ $session->status_texto }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                            @if($session->visitor_cpf)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">CPF</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ \Modules\Chat\App\Helpers\CpfHelper::format($session->visitor_cpf) }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($session->visitor_email)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">E-mail</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->visitor_email }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($session->visitor_phone)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Telefone</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->visitor_phone }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Iniciada em</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($session->closed_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Encerrada em</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->closed_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Atendente -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                            Atendente
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($session->assignedTo)
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($session->assignedTo->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $session->assignedTo->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $session->assignedTo->email }}</p>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500 dark:text-gray-400 italic mb-4">Nenhum atendente atribuído</p>
                        @endif
                        
                        @if($session->status !== 'closed')
                        <form action="{{ route('co-admin.chat.assign', $session->id) }}" method="POST">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $session->assignedTo ? 'Transferir para' : 'Atribuir a' }}
                            </label>
                            <select name="assigned_to" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white mb-3">
                                <option value="">Selecione um atendente</option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $session->assigned_to == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 transition-colors">
                                {{ $session->assignedTo ? 'Transferir' : 'Atribuir' }}
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($session->status !== 'closed')
@push('scripts')
<script>
(function() {
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const sessionId = {{ $session->id }};
    let lastMessageId = {{ $session->messages->last()?->id ?? 0 }};
    let pollInterval = null;
    
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const messagesContainer = document.getElementById('chat-messages-container');
    
    // Enviar mensagem
    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            messageInput.disabled = true;
            const originalValue = messageInput.value;
            messageInput.value = '';
            
            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${sessionId}/api/message`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify({ message }),
                });
                
                const data = await response.json();
                
                if (data.success) {
                    appendMessage(data.message);
                    scrollToBottom();
                } else {
                    messageInput.value = originalValue;
                    alert(data.message || 'Erro ao enviar mensagem');
                }
            } catch (error) {
                console.error('Erro:', error);
                messageInput.value = originalValue;
                alert('Erro ao enviar mensagem');
            } finally {
                messageInput.disabled = false;
                messageInput.focus();
            }
        });
    }
    
    // Polling para novas mensagens
    async function checkNewMessages() {
        try {
            const response = await fetch(`{{ url('co-admin/chat') }}/${sessionId}/api/messages?last_id=${lastMessageId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
            });
            
            const data = await response.json();
            
            if (data.success && data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    if (msg.id > lastMessageId) {
                        appendMessage(msg);
                        lastMessageId = msg.id;
                    }
                });
                scrollToBottom();
            }
        } catch (error) {
            console.error('Erro ao verificar mensagens:', error);
        }
    }
    
    function appendMessage(msg) {
        if (!messagesContainer) return;
        if (messagesContainer.querySelector(`[data-message-id="${msg.id}"]`)) return;
        
        const isSent = msg.sender_type === 'user';
        const isSystem = msg.sender_type === 'system';
        
        const wrapper = document.createElement('div');
        wrapper.className = `flex ${isSent ? 'justify-end' : (isSystem ? 'justify-center' : 'justify-start')}`;
        wrapper.setAttribute('data-message-id', msg.id);
        
        const time = new Date(msg.created_at).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' });
        const senderName = msg.sender?.name || (isSent ? 'Você' : '{{ $session->visitor_name ?? "Visitante" }}');
        
        if (isSystem) {
            wrapper.innerHTML = `
                <div class="max-w-[90%]">
                    <div class="px-4 py-2.5 rounded-2xl bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-sm text-center">
                        <p class="whitespace-pre-wrap">${escapeHtml(msg.message)}</p>
                        <p class="text-xs mt-1 opacity-70">${time}</p>
                    </div>
                </div>
            `;
        } else {
            wrapper.innerHTML = `
                <div class="max-w-[75%]">
                    <div class="flex items-center gap-2 mb-1 ${isSent ? 'justify-end' : ''}">
                        <span class="text-xs font-medium ${isSent ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400'}">${escapeHtml(senderName)}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">${time}</span>
                    </div>
                    <div class="px-4 py-2.5 rounded-2xl shadow-sm ${isSent ? 'bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/40 dark:to-green-800/30 text-gray-900 dark:text-white rounded-br-md' : 'bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-bl-md'}">
                        <p class="whitespace-pre-wrap break-words">${escapeHtml(msg.message)}</p>
                    </div>
                </div>
            `;
        }
        
        messagesContainer.appendChild(wrapper);
    }
    
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Iniciar polling
    scrollToBottom();
    pollInterval = setInterval(checkNewMessages, 3000);
    
    // Cleanup
    window.addEventListener('beforeunload', () => {
        if (pollInterval) clearInterval(pollInterval);
    });
})();
</script>
@endpush
@endif
@endsection
