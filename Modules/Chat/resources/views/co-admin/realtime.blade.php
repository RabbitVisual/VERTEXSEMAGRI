@extends('Co-Admin.layouts.app')

@section('title', 'Chat em Tempo Real')

@push('styles')
{{-- Importar estilos do módulo Chat --}}
@vite(['Modules/Chat/resources/assets/sass/app.scss'])
@endpush

@section('content')
<div class="chat-module">
    <div class="container mx-auto px-4 py-4 max-w-full">
        <!-- Header -->
        <div class="chat-header mb-4">
            <div class="chat-header__title">
                <div class="icon-wrapper">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                    </div>
                </div>

                <!-- Lista de Sessões -->
                <div id="sessions-list" class="chat-sidebar__list">
                    @forelse($sessions as $session)
                    <div class="chat-session-item {{ $activeSession && $activeSession->id == $session->id ? 'active' : '' }}"
                         data-session-id="{{ $session->id }}"
                         data-session-uuid="{{ $session->session_id }}">
                        <div class="chat-session-item__avatar">
                            <div class="avatar">
                                {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                            </div>
                            <div class="status-dot {{ $session->status }}"></div>
                        </div>

                        <div class="chat-session-item__info">
                            <div class="header">
                                <span class="name">{{ $session->visitor_name ?? 'Visitante' }}</span>
                                <span class="time">
                                    {{ $session->last_activity_at?->diffForHumans(null, true) ?? $session->created_at->diffForHumans(null, true) }}
                                </span>
                            </div>
                            <p class="preview">
                                @if($session->lastMessage)
                                    @if($session->lastMessage->sender_type === 'user')
                                        <span class="sender">Você:</span>
                                    @endif
                                    {{ \Illuminate\Support\Str::limit($session->lastMessage->message, 40) }}
                                @else
                                    <span class="italic">Nova conversa</span>
                                @endif
                            </p>
                            <div class="meta">
                                <span class="status-badge {{ $session->status }}">
                                    {{ $session->status_texto }}
                                </span>
                                @if($session->unread_count_user > 0)
                                <span class="unread-badge">
                                    {{ $session->unread_count_user }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="chat-sidebar__empty">
                        <x-icon name="arrow-left" class="w-5 h-5" />
                        </button>
                        <div class="avatar">
                            {{ strtoupper(substr($activeSession->visitor_name ?? 'V', 0, 1)) }}
                        </div>
                        <div class="details">
                            <h3 id="active-visitor-name">{{ $activeSession->visitor_name ?? 'Visitante' }}</h3>
                            <p>
                                <span id="active-session-status">{{ $activeSession->status_texto }}</span>
                                @if($activeSession->visitor_cpf)
                                • CPF: {{ \Modules\Chat\App\Helpers\CpfHelper::format($activeSession->visitor_cpf) }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="chat-conversation-header__actions">
                        @if($activeSession->status !== 'closed')
                        <button id="btn-close-session" class="danger" title="Encerrar conversa">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        @endif
                        <a href="{{ route('co-admin.chat.show', $activeSession->id) }}" title="Ver detalhes">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Mensagens -->
                <div id="chat-messages" class="chat-messages" data-session-id="{{ $activeSession->id }}">
                    @foreach($activeSession->messages as $message)
                    <div class="message-wrapper {{ $message->sender_type === 'user' ? 'sent' : ($message->sender_type === 'system' ? 'system' : 'received') }}"
                         data-message-id="{{ $message->id }}">
                        <div class="message-bubble {{ $message->sender_type === 'user' ? 'sent' : ($message->sender_type === 'system' ? 'system' : 'received') }}">
                            @if($message->sender_type !== 'system')
                            <p class="message-content">{{ $message->message }}</p>
                            <div class="message-meta">
                                <span class="time">{{ $message->created_at->format('H:i') }}</span>
                                @if($message->sender_type === 'user')
                                <svg class="read-status {{ $message->is_read ? 'read' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                @endif
                            </div>
                            @else
                            <p>{{ $message->message }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- Indicador de digitação -->
                    <div id="typing-indicator" class="typing-indicator__wrapper hidden">
                        <div class="typing-indicator__bubble">
                            <div class="typing-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input de Mensagem -->
                @if($activeSession->status !== 'closed')
                <div class="chat-input-area">
                    <form id="message-form" class="message-form">
                        <div class="message-form__input-wrapper">
                            <textarea id="message-input"
                                      class="message-form__textarea"
                                      rows="1"
                                      placeholder="Digite sua mensagem..."></textarea>
                        </div>
                        <button type="submit" id="send-button" class="message-form__send-btn">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                        </button>
                    </form>
                </div>
                @else
                <div class="chat-input-area closed">
                    <p>Esta conversa foi encerrada</p>
                    <button id="btn-reopen-session" class="reopen-btn">
                        Reabrir conversa
                    </button>
                </div>
                @endif
                @else
                <!-- Estado vazio -->
                <div class="chat-empty-state">
                    <div class="icon-wrapper">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <h3>Selecione uma conversa</h3>
                    <p>Escolha uma conversa na lista ao lado para começar a atender ou aguarde novas mensagens dos visitantes.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Som de notificação -->
<audio id="notification-sound" preload="auto">
    <source src="/sounds/chat/notification.mp3" type="audio/mpeg">
</audio>
@endsection

@push('scripts')
{{-- Importar JavaScript do módulo Chat --}}
@vite(['Modules/Chat/resources/assets/js/app.js'])

<script>
(function() {
    'use strict';

    // Aguardar carregamento do módulo
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar se o ChatSystem está disponível
        if (typeof window.ChatSystem === 'undefined') {
            console.warn('[Chat] ChatSystem não carregado, usando fallback');
            initFallbackChat();
            return;
        }

        // Inicializar sistema de chat
        const chat = new window.ChatSystem({
            baseUrl: '{{ url("co-admin/chat") }}',
            currentUserId: {{ auth()->id() ?? 'null' }},
            pollingInterval: 3000,
            sessionsPollingInterval: 5000,
            enableSound: true,
        });

        chat.init({{ $activeSession?->id ?? 'null' }});

        // Expor globalmente para debug
        window.chatInstance = chat;
    });

    // Fallback se o módulo não carregar
    function initFallbackChat() {
        const POLLING_INTERVAL = 3000;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let currentSessionId = {{ $activeSession?->id ?? 'null' }};
        let lastMessageId = 0;
        let pollingInterval = null;
        let sessionsPollingInterval = null;

        const chatMessages = document.getElementById('chat-messages');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const sessionsList = document.getElementById('sessions-list');
        const typingIndicator = document.getElementById('typing-indicator');
        const notificationSound = document.getElementById('notification-sound');
        const searchInput = document.getElementById('search-sessions');

        function init() {
            setupEventListeners();

            if (currentSessionId) {
                scrollToBottom();
                updateLastMessageId();
                startPolling();
            }

            startSessionsPolling();
        }

        function setupEventListeners() {
            if (messageForm) {
                messageForm.addEventListener('submit', handleSendMessage);
            }

            if (messageInput) {
                messageInput.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
                });

                messageInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        messageForm.dispatchEvent(new Event('submit'));
                    }
                });
            }

            if (sessionsList) {
                sessionsList.addEventListener('click', function(e) {
                    const sessionItem = e.target.closest('.chat-session-item');
                    if (sessionItem) {
                        const sessionId = sessionItem.dataset.sessionId;
                        window.location.href = `{{ route('co-admin.chat.realtime') }}?session=${sessionId}`;
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', debounce(filterSessions, 300));
            }

            const btnClose = document.getElementById('btn-close-session');
            if (btnClose) {
                btnClose.addEventListener('click', handleCloseSession);
            }

            const btnReopen = document.getElementById('btn-reopen-session');
            if (btnReopen) {
                btnReopen.addEventListener('click', handleReopenSession);
            }

            const toggleSidebar = document.getElementById('toggle-sidebar-mobile');
            const chatSidebar = document.getElementById('chat-sidebar');
            if (toggleSidebar && chatSidebar) {
                toggleSidebar.addEventListener('click', () => {
                    chatSidebar.classList.toggle('open');
                });
            }

            const backToList = document.getElementById('back-to-list');
            if (backToList && chatSidebar) {
                backToList.addEventListener('click', () => {
                    chatSidebar.classList.add('open');
                });
            }
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
                    credentials: 'same-origin',
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
                console.error('Erro ao enviar mensagem:', error);
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
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();

                if (data.success && data.messages && data.messages.length > 0) {
                    let hasNewFromVisitor = false;

                    data.messages.forEach(msg => {
                        if (msg.id > lastMessageId) {
                            appendMessage(msg);
                            lastMessageId = msg.id;

                            if (msg.sender_type === 'visitor') {
                                hasNewFromVisitor = true;
                            }
                        }
                    });

                    if (hasNewFromVisitor) {
                        playNotificationSound();
                        scrollToBottom();
                    }
                }
            } catch (error) {
                console.error('Erro ao carregar mensagens:', error);
            }
        }

        function appendMessage(msg) {
            if (!chatMessages) return;

            if (chatMessages.querySelector(`[data-message-id="${msg.id}"]`)) return;

            const isSent = msg.sender_type === 'user';
            const isSystem = msg.sender_type === 'system';

            const wrapper = document.createElement('div');
            wrapper.className = `message-wrapper ${isSent ? 'sent' : (isSystem ? 'system' : 'received')}`;
            wrapper.setAttribute('data-message-id', msg.id);

            const time = new Date(msg.created_at).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

            if (isSystem) {
                wrapper.innerHTML = `
                    <div class="message-bubble system">
                        <p>${escapeHtml(msg.message)}</p>
                    </div>
                `;
            } else {
                wrapper.innerHTML = `
                    <div class="message-bubble ${isSent ? 'sent' : 'received'}">
                        <p class="message-content">${escapeHtml(msg.message)}</p>
                        <div class="message-meta">
                            <span class="time">${time}</span>
                            ${isSent ? `
                            <svg class="read-status ${msg.is_read ? 'read' : ''}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            if (typingIndicator) {
                chatMessages.insertBefore(wrapper, typingIndicator);
            } else {
                chatMessages.appendChild(wrapper);
            }
        }

        async function updateSessionsList() {
            try {
                const response = await fetch(`{{ route('co-admin.chat.api.sessions') }}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();

                if (data.success && data.sessions) {
                    const waiting = data.sessions.filter(s => s.status === 'waiting').length;
                    const active = data.sessions.filter(s => s.status === 'active').length;

                    const statsWaiting = document.getElementById('stats-waiting');
                    const statsActive = document.getElementById('stats-active');

                    if (statsWaiting) statsWaiting.textContent = waiting;
                    if (statsActive) statsActive.textContent = active;

                    data.sessions.forEach(session => {
                        const item = sessionsList?.querySelector(`[data-session-id="${session.id}"]`);
                        if (item) {
                            const badge = item.querySelector('.unread-badge');
                            if (session.unread_count > 0) {
                                if (badge) {
                                    badge.textContent = session.unread_count;
                                    badge.classList.remove('hidden');
                                }
                            } else if (badge) {
                                badge.classList.add('hidden');
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Erro ao atualizar sessões:', error);
            }
        }

        function filterSessions() {
            const query = searchInput?.value.toLowerCase() || '';
            const items = sessionsList?.querySelectorAll('.chat-session-item') || [];

            items.forEach(item => {
                const name = item.querySelector('.name')?.textContent.toLowerCase() || '';
                const message = item.querySelector('.preview')?.textContent.toLowerCase() || '';

                if (name.includes(query) || message.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        async function handleCloseSession() {
            if (!currentSessionId) return;

            if (!confirm('Deseja encerrar esta conversa?')) return;

            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${currentSessionId}/close`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Conversa encerrada com sucesso!', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || 'Erro ao encerrar conversa', 'error');
                }
            } catch (error) {
                console.error('Erro ao encerrar sessão:', error);
                showToast('Erro ao encerrar conversa', 'error');
            }
        }

        async function handleReopenSession() {
            if (!currentSessionId) return;

            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${currentSessionId}/reopen`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Conversa reaberta com sucesso!', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || 'Erro ao reabrir conversa', 'error');
                }
            } catch (error) {
                console.error('Erro ao reabrir sessão:', error);
                showToast('Erro ao reabrir conversa', 'error');
            }
        }

        function startPolling() {
            stopPolling();
            pollingInterval = setInterval(loadNewMessages, POLLING_INTERVAL);
        }

        function stopPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
        }

        function startSessionsPolling() {
            sessionsPollingInterval = setInterval(updateSessionsList, 5000);
        }

        function scrollToBottom() {
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        function updateLastMessageId() {
            if (chatMessages) {
                const messages = chatMessages.querySelectorAll('[data-message-id]');
                if (messages.length > 0) {
                    const lastMsg = messages[messages.length - 1];
                    lastMessageId = parseInt(lastMsg.dataset.messageId) || 0;
                }
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
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
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
    }
})();
</script>
@endpush
