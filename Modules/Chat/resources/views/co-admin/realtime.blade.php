@extends('Co-Admin.layouts.app')

@section('title', 'Chat em Tempo Real')

@push('styles')
<style>
    .chat-container { height: calc(100vh - 180px); min-height: 600px; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
</style>
@endpush

@section('content')
<div class="animate__animated animate__fadeIn">
    <!-- Header/Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group transition-all">
            <div class="w-14 h-14 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <x-icon name="clock" style="duotone" class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Aguardando</p>
                <h4 id="stats-waiting" class="text-2xl font-black text-slate-900 dark:text-white leading-none">
                    {{ $sessions->where('status', 'waiting')->count() }}
                </h4>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group transition-all">
            <div class="w-14 h-14 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <x-icon name="message-dots" style="duotone" class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Em Atendimento</p>
                <h4 id="stats-active" class="text-2xl font-black text-slate-900 dark:text-white leading-none">
                    {{ $sessions->where('status', 'active')->count() }}
                </h4>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group transition-all">
            <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <x-icon name="users" style="duotone" class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Visitantes Online</p>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white leading-none">
                    {{ $sessions->unique('visitor_name')->count() }}
                </h4>
            </div>
        </div>
    </div>

    <!-- Main Chat Interface -->
    <div class="chat-container bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col md:flex-row">

        <!-- Sidebar: Sessions List -->
        <div class="w-full md:w-80 lg:w-96 border-r border-slate-100 dark:border-slate-700 flex flex-col bg-slate-50/30 dark:bg-slate-900/10">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-green-500 transition-colors">
                        <x-icon name="magnifying-glass" class="w-4 h-4" />
                    </div>
                    <input type="text" id="search-sessions" placeholder="Pesquisar conversas..."
                           class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-800 rounded-2xl focus:ring-4 focus:ring-green-500/10 text-xs font-bold pl-11 p-4 transition-all">
                </div>
            </div>

            <div id="sessions-list" class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-3">
                @forelse($sessions as $session)
                <div class="chat-session-item @if($activeSession && $activeSession->id == $session->id) ring-2 ring-green-500 bg-white dark:bg-slate-800 @else hover:bg-white dark:hover:bg-slate-800 @endif p-4 rounded-3xl border border-transparent hover:border-slate-100 dark:hover:border-slate-700 transition-all cursor-pointer group"
                     data-session-id="{{ $session->id }}"
                     onclick="window.location.href='{{ route('co-admin.chat.realtime', ['session' => $session->id]) }}'">
                    <div class="flex items-center gap-4">
                        <div class="relative flex-shrink-0">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-green-200 dark:shadow-none transition-transform group-hover:rotate-6">
                                {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-slate-50 dark:border-slate-900 @if($session->status === 'active') bg-green-500 @elseif($session->status === 'waiting') bg-amber-500 @else bg-slate-400 @endif"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-0.5">
                                <h4 class="text-sm font-black text-slate-900 dark:text-white truncate uppercase tracking-tight">{{ $session->visitor_name ?? 'Visitante' }}</h4>
                                <span class="text-[9px] font-black text-slate-400 uppercase">{{ $session->last_activity_at?->diffForHumans(null, true) ?? $session->created_at->diffForHumans(null, true) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate pr-2">
                                    @if($session->lastMessage)
                                        <span class="font-black text-[10px] uppercase text-slate-400">@if($session->lastMessage->sender_type === 'user') Você: @endif</span>
                                        {{ \Illuminate\Support\Str::limit($session->lastMessage->message, 40) }}
                                    @else
                                        <span class="italic opacity-60">Nova conversa</span>
                                    @endif
                                </p>
                                @if($session->unread_count_user > 0)
                                <span class="unread-badge flex-shrink-0 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[9px] font-black animate-bounce">
                                    {{ $session->unread_count_user }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <x-icon name="message-slash" class="w-10 h-10 text-slate-200 mx-auto mb-4" />
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-8">Nenhuma conversa ativa no momento.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-white dark:bg-slate-800">
            @if($activeSession)
            <!-- Chat Header -->
            <div class="p-6 md:p-8 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between bg-white dark:bg-slate-800 z-10 transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-black shadow-xl shadow-indigo-500/10">
                        {{ strtoupper(substr($activeSession->visitor_name ?? 'V', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight leading-none mb-1">{{ $activeSession->visitor_name ?? 'Visitante' }}</h2>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full @if($activeSession->status === 'active') bg-green-500 animate-pulse @else bg-slate-300 @endif"></span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $activeSession->status_texto }}</span>
                            @if($activeSession->visitor_cpf)
                            <span class="mx-1 text-slate-200">•</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">CPF: {{ \Modules\Chat\App\Helpers\CpfHelper::format($activeSession->visitor_cpf) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('co-admin.chat.show', $activeSession->id) }}"
                       class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all active:scale-95 group" title="Ver detalhes">
                        <x-icon name="circle-info" style="duotone" class="w-5 h-5" />
                    </a>
                    @if($activeSession->status !== 'closed')
                    <button id="btn-close-session" class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-red-400 hover:bg-red-50 hover:text-red-600 transition-all active:scale-95 group" title="Encerrar conversa">
                        <x-icon name="xmark" class="w-5 h-5 group-hover:rotate-90 transition-transform" />
                    </button>
                    @endif
                </div>
            </div>

            <!-- Messages List -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-8 space-y-6 bg-slate-50/30 dark:bg-slate-900/10 custom-scrollbar"
                 data-session-id="{{ $activeSession->id }}"
                 style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">

                @foreach($activeSession->messages as $message)
                    @if($message->sender_type === 'system')
                        <div class="flex justify-center" data-message-id="{{ $message->id }}">
                            <div class="px-6 py-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700 shadow-sm">
                                {{ $message->message }}
                                <span class="ml-2 opacity-50">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex {{ $message->sender_type === 'user' ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $message->id }}">
                            <div class="max-w-[80%] group">
                                <div class="flex items-center gap-2 mb-2 {{ $message->sender_type === 'user' ? 'justify-end' : '' }}">
                                    @if($message->sender_type !== 'user')
                                        <div class="w-6 h-6 rounded-lg bg-green-500 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                            {{ strtoupper(substr($message->sender_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $message->sender_name }}</span>
                                    <span class="text-[9px] font-black text-slate-300 uppercase">{{ $message->created_at->format('H:i') }}</span>
                                    @if($message->sender_type === 'user')
                                        <div class="w-6 h-6 rounded-lg bg-slate-900 dark:bg-green-600 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                            {{ strtoupper(substr($message->sender_name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="relative px-6 py-4 rounded-3xl shadow-sm border {{ $message->sender_type === 'user' ? 'bg-slate-900 dark:bg-green-600 text-white border-slate-800 dark:border-green-500 rounded-tr-none' : 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white border-slate-100 dark:border-slate-700 rounded-tl-none' }}">
                                    <p class="text-sm font-medium leading-relaxed whitespace-pre-wrap break-words">{{ $message->message }}</p>
                                    @if($message->sender_type === 'user')
                                    <div class="absolute -bottom-1 -right-1 text-green-400 @if($message->is_read) text-green-500 @else opacity-50 @endif">
                                        <x-icon name="check-double" class="w-3 h-3" />
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Typing indicator -->
                <div id="typing-indicator" class="hidden animate-pulse">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                            <div class="flex gap-1">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Digitando...</span>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-8 border-t border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800 relative z-10 transition-all duration-300">
                @if($activeSession->status !== 'closed')
                <form id="message-form" class="relative group">
                    @csrf
                    <textarea id="message-input" autocomplete="off" rows="1" placeholder="Escreva sua mensagem aqui... (Shift+Enter para nova linha)"
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:bg-white dark:focus:bg-slate-900 text-slate-900 dark:text-white text-sm font-bold pl-6 pr-32 py-5 transition-all shadow-inner custom-scrollbar overflow-hidden resize-none"></textarea>
                    <button type="submit" id="send-button" class="absolute right-2 top-2 bottom-2 px-6 bg-slate-900 dark:bg-green-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black dark:hover:bg-green-700 transition-all active:scale-95 shadow-lg group">
                        <span>Enviar</span>
                        <x-icon name="paper-plane" class="w-4 h-4 ml-2 inline group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                    </button>
                </form>
                @else
                <div class="flex flex-col items-center justify-center gap-4 py-2">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Conversa Encerrada</p>
                    <button id="btn-reopen-session" class="px-10 py-4 bg-green-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-green-700 transition-all shadow-xl shadow-green-500/10 active:scale-95 border-b-4 border-green-800 group">
                        <x-icon name="rotate-right" class="w-4 h-4 mr-2 inline group-hover:rotate-180 transition-transform" />
                        Reabrir Conversa
                    </button>
                </div>
                @endif
            </div>

            @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center p-20 text-center">
                <div class="w-32 h-32 bg-slate-50 dark:bg-slate-900/50 rounded-[3rem] flex items-center justify-center mb-10 border-2 border-dashed border-slate-200 dark:border-slate-700 relative group transition-all duration-500 hover:rotate-12">
                    <div class="absolute inset-0 bg-green-500 opacity-0 group-hover:opacity-5 blur-2xl rounded-full transition-opacity"></div>
                    <x-icon name="message-question" style="duotone" class="w-16 h-16 text-slate-200" />
                </div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-4">Central de Atendimento</h3>
                <p class="text-slate-400 max-w-md mx-auto leading-relaxed text-sm font-medium">Selecione uma conversa na lista lateral para iniciar o atendimento em tempo real. Você poderá interagir com os visitantes de forma instantânea.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Som de notificação -->
<audio id="notification-sound" preload="auto">
    <source src="/sounds/chat/notification.mp3" type="audio/mpeg">
</audio>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const POLLING_INTERVAL = 3000;

        // Elementos UI
        const sessionsList = document.getElementById('sessions-list');
        const chatMessages = document.getElementById('chat-messages');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const searchInput = document.getElementById('search-sessions');
        const typingIndicator = document.getElementById('typing-indicator');
        const notificationSound = document.getElementById('notification-sound');
        const btnCloseSession = document.getElementById('btn-close-session');
        const btnReopenSession = document.getElementById('btn-reopen-session');

        let currentSessionId = chatMessages?.dataset.sessionId || null;
        let lastMessageId = 0;
        let pollingInterval = null;
        let sessionsPollingInterval = null;

        function init() {
            if (currentSessionId) {
                updateLastMessageId();
                scrollToBottom();
                startPolling();

                if (messageInput) {
                    messageInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            handleSendMessage(e);
                        }
                    });

                    messageInput.addEventListener('input', function() {
                        this.style.height = 'auto';
                        this.style.height = this.scrollHeight + 'px';
                    });
                }
            }

            if (messageForm) messageForm.addEventListener('submit', handleSendMessage);
            if (searchInput) searchInput.addEventListener('input', debounce(filterSessions, 300));
            if (btnCloseSession) btnCloseSession.addEventListener('click', handleCloseSession);
            if (btnReopenSession) btnReopenSession.addEventListener('click', handleReopenSession);

            updateSessionsList();
            startSessionsPolling();
        }

        async function handleSendMessage(e) {
            e.preventDefault();
            if (!messageInput || !currentSessionId) return;

            const message = messageInput.value.trim();
            if (!message) return;

            messageInput.disabled = true;
            const sendButton = document.getElementById('send-button');
            if (sendButton) sendButton.disabled = true;

            const originalValue = messageInput.value;
            messageInput.value = '';
            messageInput.style.height = 'auto';

            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${currentSessionId}/api/message`, {
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
                    showToast(data.message || 'Erro ao enviar mensagem', 'error');
                }
            } catch (error) {
                console.error('[Chat] Erro ao enviar:', error);
                messageInput.value = originalValue;
                showToast('Erro ao enviar mensagem. Tente novamente.', 'error');
            } finally {
                messageInput.disabled = false;
                if (sendButton) sendButton.disabled = false;
                messageInput.focus();
            }
        }

        async function loadNewMessages() {
            if (!currentSessionId) return;
            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${currentSessionId}/api/messages?last_id=${lastMessageId}`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                });
                const data = await response.json();
                if (data.success && data.messages && data.messages.length > 0) {
                    let hasNewFromVisitor = false;
                    data.messages.forEach(msg => {
                        if (msg.id > lastMessageId) {
                            appendMessage(msg);
                            lastMessageId = msg.id;
                            if (msg.sender_type === 'visitor') hasNewFromVisitor = true;
                        }
                    });
                    if (hasNewFromVisitor) {
                        playNotificationSound();
                        scrollToBottom();
                    }
                }
            } catch (error) {
                console.error('[Chat] Polling error:', error);
            }
        }

        function appendMessage(msg) {
            if (!chatMessages) return;
            if (chatMessages.querySelector(`[data-message-id="${msg.id}"]`)) return;

            const isSent = msg.sender_type === 'user';
            const isSystem = msg.sender_type === 'system';
            const wrapper = document.createElement('div');
            wrapper.className = `flex ${isSent ? 'justify-end' : (isSystem ? 'justify-center' : 'justify-start')}`;
            wrapper.setAttribute('data-message-id', msg.id);

            const time = new Date(msg.created_at).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
            const senderName = msg.sender_name || (isSent ? 'Você' : 'Visitante');

            if (isSystem) {
                wrapper.innerHTML = `
                    <div class="px-6 py-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700 shadow-sm">
                        ${escapeHtml(msg.message)}
                        <span class="ml-2 opacity-50">${time}</span>
                    </div>
                `;
            } else {
                wrapper.innerHTML = `
                    <div class="max-w-[80%] group">
                        <div class="flex items-center gap-2 mb-2 ${isSent ? 'justify-end' : ''}">
                            ${!isSent ? `
                                <div class="w-6 h-6 rounded-lg bg-green-500 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                    ${escapeHtml(senderName.substring(0,1).toUpperCase())}
                                </div>
                            ` : ''}
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${escapeHtml(senderName)}</span>
                            <span class="text-[9px] font-black text-slate-300 uppercase">${time}</span>
                            ${isSent ? `
                                <div class="w-6 h-6 rounded-lg bg-slate-900 dark:bg-green-600 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                    ${escapeHtml(senderName.substring(0,1).toUpperCase())}
                                </div>
                            ` : ''}
                        </div>
                        <div class="relative px-6 py-4 rounded-3xl shadow-sm border ${isSent ? 'bg-slate-900 dark:bg-green-600 text-white border-slate-800 dark:border-green-500 rounded-tr-none' : 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white border-slate-100 dark:border-slate-700 rounded-tl-none'}">
                            <p class="text-sm font-medium leading-relaxed whitespace-pre-wrap break-words">${escapeHtml(msg.message)}</p>
                            ${isSent ? `
                            <div class="absolute -bottom-1 -right-1 text-green-400 ${msg.is_read ? 'text-green-500' : 'opacity-50'}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            if (typingIndicator) chatMessages.insertBefore(wrapper, typingIndicator);
            else chatMessages.appendChild(wrapper);
            scrollToBottom();
        }

        async function updateSessionsList() {
            try {
                const response = await fetch(`{{ route('co-admin.chat.api.sessions') }}`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
                });
                const data = await response.json();
                if (data.success && data.sessions) {
                    const waiting = data.sessions.filter(s => s.status === 'waiting').length;
                    const active = data.sessions.filter(s => s.status === 'active').length;
                    document.getElementById('stats-waiting').textContent = waiting;
                    document.getElementById('stats-active').textContent = active;

                    data.sessions.forEach(session => {
                        const item = sessionsList?.querySelector(`[data-session-id="${session.id}"]`);
                        if (item) {
                            const badge = item.querySelector('.unread-badge');
                            if (session.unread_count_user > 0) {
                                if (badge) {
                                    badge.textContent = session.unread_count_user;
                                    badge.classList.remove('hidden');
                                }
                            } else if (badge) {
                                badge.classList.add('hidden');
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('[Chat] Erro ao atualizar sessões:', error);
            }
        }

        function filterSessions() {
            const query = searchInput?.value.toLowerCase() || '';
            const items = sessionsList?.querySelectorAll('.chat-session-item') || [];
            items.forEach(item => {
                const name = item.querySelector('h4')?.textContent.toLowerCase() || '';
                const preview = item.querySelector('p')?.textContent.toLowerCase() || '';
                if (name.includes(query) || preview.includes(query)) item.style.display = '';
                else item.style.display = 'none';
            });
        }

        async function handleCloseSession() {
            if (!currentSessionId || !confirm('Deseja encerrar esta conversa?')) return;
            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${currentSessionId}/close`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
                });
                const data = await response.json();
                if (data.success) {
                    showToast('Conversa encerrada com sucesso!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else showToast(data.message || 'Erro ao encerrar conversa', 'error');
            } catch (error) { showToast('Erro ao encerrar conversa', 'error'); }
        }

        async function handleReopenSession() {
            if (!currentSessionId) return;
            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${currentSessionId}/reopen`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
                });
                const data = await response.json();
                if (data.success) {
                    showToast('Conversa reaberta com sucesso!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else showToast(data.message || 'Erro ao reabrir conversa', 'error');
            } catch (error) { showToast('Erro ao reabrir conversa', 'error'); }
        }

        function startPolling() { pollingInterval = setInterval(loadNewMessages, POLLING_INTERVAL); }
        function stopPolling() { if (pollingInterval) clearInterval(pollingInterval); pollingInterval = null; }
        function startSessionsPolling() { sessionsPollingInterval = setInterval(updateSessionsList, 5000); }
        function scrollToBottom() { if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight; }
        function updateLastMessageId() {
            if (chatMessages) {
                const messages = chatMessages.querySelectorAll('[data-message-id]');
                if (messages.length > 0) lastMessageId = parseInt(messages[messages.length - 1].dataset.messageId) || 0;
            }
        }

        function playNotificationSound() {
            if (notificationSound && !document.hidden) {
                notificationSound.currentTime = 0;
                notificationSound.play().catch(() => {});
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-2xl shadow-2xl text-white z-50 transform transition-all duration-300 font-black text-xs uppercase tracking-widest ${
                type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-slate-900'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopPolling();
            } else if (currentSessionId) {
                loadNewMessages();
                startPolling();
            }
        });

        window.addEventListener('beforeunload', () => {
            stopPolling();
            if (sessionsPollingInterval) {
                clearInterval(sessionsPollingInterval);
            }
        });

        init();
    });
})();
</script>
@endpush
