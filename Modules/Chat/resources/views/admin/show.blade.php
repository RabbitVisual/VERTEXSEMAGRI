@extends('admin.layouts.admin')

@section('title', 'Sessão de Chat - ' . ($session->visitor_name ?? 'Sem nome'))

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-7xl">
    <div class="space-y-6 md:space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Chat" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $session->visitor_name ?? 'Sessão de Chat' }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.chat.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Chat</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Sessão</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-800 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
                Voltar
            </a>
            @if($session->status !== 'closed')
            <form action="{{ route('admin.chat.close', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja encerrar esta sessão?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Encerrar Sessão
                </button>
            </form>
            @endif
        </div>
    </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chat Messages -->
            <div class="lg:col-span-2 min-w-0">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mensagens</h3>
                    </div>
                    <div id="chat-messages-container" class="p-6 h-[600px] overflow-y-auto bg-gray-50 dark:bg-slate-900/50">
                    <div id="typing-indicator" class="hidden mb-2 text-sm text-gray-500 dark:text-gray-400 italic"></div>
                    @foreach($session->messages as $message)
                    <div class="mb-4 flex {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%]">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-medium {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }}">
                                    {{ $message->sender_name }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $message->created_at->format('d/m H:i') }}
                                </span>
                            </div>
                            <div class="px-4 py-2 rounded-lg {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'bg-blue-100 dark:bg-blue-900/30 text-gray-900 dark:text-white' : 'bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white' }}">
                                {!! $message->formatted_message !!}
                            </div>
                        </div>
                    </div>
                        @endforeach
                    </div>
                    @if($session->status !== 'closed')
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                        <form id="message-form" class="flex gap-2">
                            @csrf
                            <input type="text" id="message-input" placeholder="Digite sua mensagem..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
            <!-- Informações da Sessão -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</label>
                        <p class="mt-1">
                            <span class="px-2 py-1 text-xs font-medium rounded
                                {{ $session->status === 'waiting' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : '' }}
                                {{ $session->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $session->status === 'closed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                            ">
                                {{ $session->status_texto }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Visitante</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $session->visitor_name ?? 'N/A' }}</p>
                        @if($session->visitor_email)
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session->visitor_email }}</p>
                        @endif
                        @if($session->visitor_phone)
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session->visitor_phone }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Atendente</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $session->assignedTo?->name ?? 'Sem atendente' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Criada em</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $session->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($session->closed_at)
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Encerrada em</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $session->closed_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Atribuir Atendente -->
            @if(!$session->assigned_to || $session->status === 'waiting')
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Atribuir Atendente</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.chat.assign', $session->id) }}" method="POST">
                        @csrf
                        <select name="assigned_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white mb-4">
                            <option value="">Selecione um atendente</option>
                            @foreach(\App\Models\User::whereHas('roles', function($q) { $q->whereIn('name', ['admin', 'co-admin']); })->get() as $user)
                            <option value="{{ $user->id }}" {{ $session->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Atribuir
                        </button>
                    </form>
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
@vite(['resources/js/chat.js'])
<script>
// Configuração global para o sistema de chat
// Usar apenas Redis ou polling - sem dependências externas
window.BROADCAST_DRIVER = '{{ config("broadcasting.default") }}';
window.currentUserId = {{ auth()->id() ?? 'null' }};

// Rotas do chat (usar rotas web ao invés de API)
window.CHAT_ROUTES = {
    getMessages: '{{ route("admin.chat.api.session.messages", $session->id) }}',
    sendMessage: '{{ route("admin.chat.api.session.message", $session->id) }}',
    markAsRead: '{{ route("admin.chat.api.session.read", $session->id) }}',
    typing: '{{ route("admin.chat.api.session.typing", $session->id) }}',
};

// Inicializar sistema de chat quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    if (typeof ChatSystem !== 'undefined') {
        ChatSystem.init(
            '{{ $session->session_id }}',
            {{ $session->id }},
            {{ auth()->id() ?? 'null' }}
        );
    }
});
</script>
@if($session->status !== 'closed')
<script>
// Manter compatibilidade com código antigo se necessário
(function() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    
    if (messageForm && typeof ChatSystem !== 'undefined') {
        // O ChatSystem já cuida do envio, mas podemos adicionar validações extras aqui
        messageForm.addEventListener('submit', function(e) {
            // ChatSystem.handleSendMessage já será chamado
            // Este código é apenas para compatibilidade
        });
    }
})();
</script>
@endif

@push('scripts')
@vite(['resources/js/chat.js'])
<script>
// Configuração global para o sistema de chat
// Usar apenas Redis ou polling - sem dependências externas
window.BROADCAST_DRIVER = '{{ config("broadcasting.default") }}';
window.currentUserId = {{ auth()->id() ?? 'null' }};

// Rotas do chat (usar rotas web ao invés de API)
window.CHAT_ROUTES = {
    getMessages: '{{ route("admin.chat.api.session.messages", $session->id) }}',
    sendMessage: '{{ route("admin.chat.api.session.message", $session->id) }}',
    markAsRead: '{{ route("admin.chat.api.session.read", $session->id) }}',
    typing: '{{ route("admin.chat.api.session.typing", $session->id) }}',
};

// Inicializar sistema de chat quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    if (typeof ChatSystem !== 'undefined') {
        ChatSystem.init(
            '{{ $session->session_id }}',
            {{ $session->id }},
            {{ auth()->id() ?? 'null' }}
        );
    }
});
</script>
@if($session->status !== 'closed')
<script>
// Manter compatibilidade com código antigo se necessário
(function() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    
    if (messageForm && typeof ChatSystem !== 'undefined') {
        // O ChatSystem já cuida do envio, mas podemos adicionar validações extras aqui
        messageForm.addEventListener('submit', function(e) {
            // ChatSystem.handleSendMessage já será chamado
            // Este código é apenas para compatibilidade
        });
    }
})();
</script>
@endif
@endpush
@endsection

