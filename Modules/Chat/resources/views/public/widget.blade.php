@php
$chatEnabled = \Nwidart\Modules\Facades\Module::isEnabled('Chat');
$publicEnabled = \Modules\Chat\App\Models\ChatConfig::isPublicEnabled();
@endphp
@if($chatEnabled && $publicEnabled)
<!-- Chat Widget SEMAGRI - Sistema 100% Interno -->
<div id="semagri-chat-widget" class="fixed" style="position: fixed !important; bottom: 6rem !important; right: 1.5rem !important; z-index: 9999 !important;">
    <!-- Botão Flutuante -->
    <button id="chat-toggle-btn"
            class="group relative w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800 transform hover:scale-110"
            aria-label="Abrir chat de suporte">
        <!-- Ícone de Chat -->
        <svg id="chat-icon" class="w-6 h-6 md:w-7 md:h-7 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
        </svg>
        <!-- Ícone de Fechar -->
        <svg id="chat-close-icon" class="w-6 h-6 md:w-7 md:h-7 transition-transform duration-300 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <!-- Badge de Notificação -->
        <span id="chat-notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden animate-pulse">1</span>
    </button>

    <!-- Janela do Chat -->
    <div id="chat-window" class="hidden fixed bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 flex flex-col overflow-hidden" 
         style="bottom: 7rem !important; right: 1.5rem !important; width: 380px !important; max-width: calc(100vw - 2rem) !important; height: 600px !important; max-height: calc(100vh - 8rem) !important; z-index: 10000 !important;">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Suporte SEMAGRI</h3>
                    <p id="chat-status-text" class="text-sm text-green-100">
                        <span class="inline-block w-2 h-2 bg-green-300 rounded-full mr-1 animate-pulse"></span>
                        Online
                    </p>
                </div>
            </div>
            <button id="chat-minimize-btn" class="w-8 h-8 flex items-center justify-center text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
        </div>

        <!-- Mensagem Offline -->
        <div id="chat-offline-message" class="hidden px-5 py-8 text-center bg-amber-50 dark:bg-amber-900/20 border-b border-amber-200 dark:border-amber-800">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            </div>
            <h4 class="font-semibold text-amber-800 dark:text-amber-200 mb-2">Fora do horário de atendimento</h4>
            <p class="text-sm text-amber-600 dark:text-amber-300" id="chat-next-availability">Voltamos em breve!</p>
        </div>

        <!-- Formulário Inicial -->
        <div id="chat-initial-form" class="hidden px-5 py-6 bg-gray-50 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700">
            <div class="text-center mb-5">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Bem-vindo ao Chat!</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Preencha seus dados para iniciar o atendimento</p>
            </div>
            <form id="chat-start-form" class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Nome completo *</label>
                    <input type="text" id="visitor-name" name="name" required
                           placeholder="Digite seu nome completo"
                           class="w-full px-4 py-2.5 text-sm bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:text-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">CPF *</label>
                    <input type="text" id="visitor-cpf" name="cpf" required
                           placeholder="000.000.000-00" maxlength="14"
                           class="w-full px-4 py-2.5 text-sm bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:text-white transition-colors">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Usado para identificar seu atendimento</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail (opcional)</label>
                    <input type="email" id="visitor-email" name="email"
                           placeholder="seu@email.com"
                           class="w-full px-4 py-2.5 text-sm bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:text-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone (opcional)</label>
                    <input type="tel" id="visitor-phone" name="phone"
                           placeholder="(00) 00000-0000"
                           class="w-full px-4 py-2.5 text-sm bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:text-white transition-colors">
                </div>
                <button type="submit" id="chat-start-btn"
                        class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-semibold rounded-xl transition-all transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-2">
                    <span>Iniciar Conversa</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Área de Mensagens -->
        <div id="chat-messages-container" class="flex-1 overflow-y-auto p-4 space-y-3" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            <div id="chat-welcome-message" class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Carregando...</p>
            </div>
        </div>

        <!-- Indicador de Digitação -->
        <div id="chat-typing-indicator" class="hidden px-4 py-2 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex gap-1">
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                </div>
                <span>Atendente digitando...</span>
            </div>
        </div>

        <!-- Input de Mensagem -->
        <div id="chat-input-container" class="hidden px-4 py-3 border-t border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
            <form id="chat-message-form" class="flex items-end gap-2">
                <div class="flex-1 relative">
                    <textarea id="chat-message-input" 
                              rows="1"
                              placeholder="Digite sua mensagem..."
                              class="w-full px-4 py-2.5 pr-10 text-sm bg-gray-100 dark:bg-slate-700 border-0 rounded-2xl focus:ring-2 focus:ring-green-500 dark:text-white resize-none"
                              style="max-height: 100px;"></textarea>
                </div>
                <button type="submit" id="chat-send-btn"
                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </form>
            <p class="text-xs text-gray-400 dark:text-gray-500 text-center mt-2">
                Pressione Enter para enviar
            </p>
        </div>

        <!-- Sessão Encerrada -->
        <div id="chat-session-closed" class="hidden px-4 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Esta conversa foi encerrada</p>
            <button id="chat-new-session-btn"
                    class="px-4 py-2 text-sm font-medium text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors">
                Iniciar nova conversa
            </button>
        </div>
    </div>
</div>

<!-- Som de notificação -->
<audio id="chat-notification-sound" preload="auto">
    <source src="/sounds/chat/notification.mp3" type="audio/mpeg">
</audio>

<style>
/* Estilos do Chat Widget */
#semagri-chat-widget .message-bubble {
    max-width: 85%;
    word-wrap: break-word;
    animation: chatFadeIn 0.3s ease;
}

#semagri-chat-widget .message-bubble.sent {
    background: linear-gradient(135deg, #dcf8c6 0%, #c5e1a5 100%);
    margin-left: auto;
    border-radius: 16px 16px 4px 16px;
}

.dark #semagri-chat-widget .message-bubble.sent {
    background: linear-gradient(135deg, #005c4b 0%, #00695c 100%);
    color: white;
}

#semagri-chat-widget .message-bubble.received {
    background: white;
    margin-right: auto;
    border-radius: 16px 16px 16px 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.dark #semagri-chat-widget .message-bubble.received {
    background: #1e293b;
}

#semagri-chat-widget .message-bubble.system {
    background: rgba(59, 130, 246, 0.1);
    margin: 0 auto;
    border-radius: 12px;
    font-size: 0.75rem;
    max-width: 90%;
    text-align: center;
}

.dark #semagri-chat-widget .message-bubble.system {
    background: rgba(59, 130, 246, 0.2);
}

@keyframes chatFadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scrollbar personalizada */
#chat-messages-container::-webkit-scrollbar {
    width: 6px;
}

#chat-messages-container::-webkit-scrollbar-track {
    background: transparent;
}

#chat-messages-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.dark #chat-messages-container::-webkit-scrollbar-thumb {
    background: #475569;
}

/* Máscara de CPF */
#visitor-cpf {
    font-variant-numeric: tabular-nums;
}
</style>

<script>
(function() {
    'use strict';
    
    // Evitar inicialização duplicada
    if (window.semagriChatInitialized) return;
    window.semagriChatInitialized = true;
    
    // Configuração
    const POLLING_INTERVAL = 3000;
    const ROUTES = {
        status: '{{ route("chat.status") }}',
        start: '{{ route("chat.start") }}',
        session: (id) => `/chat/session/${id}`,
        message: (id) => `/chat/session/${id}/message`,
    };
    
    // Estado
    const state = {
            isOpen: false,
            sessionId: null,
            isAvailable: false,
        lastMessageId: 0,
            pollInterval: null,
            notificationSound: null,
    };
    
    // Elementos DOM
    const elements = {
        toggleBtn: null,
        chatWindow: null,
        chatIcon: null,
        closeIcon: null,
        minimizeBtn: null,
        offlineMessage: null,
        initialForm: null,
        startForm: null,
        messagesContainer: null,
        welcomeMessage: null,
        inputContainer: null,
        messageForm: null,
        messageInput: null,
        sendBtn: null,
        sessionClosed: null,
        newSessionBtn: null,
        notificationBadge: null,
        typingIndicator: null,
        statusText: null,
        nextAvailability: null,
    };
    
    // Inicialização
    function init() {
        cacheElements();
        setupEventListeners();
        setupCpfMask();
        restoreSession();
    }
    
    // Cache de elementos
    function cacheElements() {
        elements.toggleBtn = document.getElementById('chat-toggle-btn');
        elements.chatWindow = document.getElementById('chat-window');
        elements.chatIcon = document.getElementById('chat-icon');
        elements.closeIcon = document.getElementById('chat-close-icon');
        elements.minimizeBtn = document.getElementById('chat-minimize-btn');
        elements.offlineMessage = document.getElementById('chat-offline-message');
        elements.initialForm = document.getElementById('chat-initial-form');
        elements.startForm = document.getElementById('chat-start-form');
        elements.messagesContainer = document.getElementById('chat-messages-container');
        elements.welcomeMessage = document.getElementById('chat-welcome-message');
        elements.inputContainer = document.getElementById('chat-input-container');
        elements.messageForm = document.getElementById('chat-message-form');
        elements.messageInput = document.getElementById('chat-message-input');
        elements.sendBtn = document.getElementById('chat-send-btn');
        elements.sessionClosed = document.getElementById('chat-session-closed');
        elements.newSessionBtn = document.getElementById('chat-new-session-btn');
        elements.notificationBadge = document.getElementById('chat-notification-badge');
        elements.typingIndicator = document.getElementById('chat-typing-indicator');
        elements.statusText = document.getElementById('chat-status-text');
        elements.nextAvailability = document.getElementById('chat-next-availability');
        state.notificationSound = document.getElementById('chat-notification-sound');
    }
    
    // Event Listeners
    function setupEventListeners() {
        if (elements.toggleBtn) {
            elements.toggleBtn.addEventListener('click', toggleChat);
        }
        
        if (elements.minimizeBtn) {
            elements.minimizeBtn.addEventListener('click', toggleChat);
        }
        
        if (elements.startForm) {
            elements.startForm.addEventListener('submit', handleStartChat);
        }
        
        if (elements.messageForm) {
            elements.messageForm.addEventListener('submit', handleSendMessage);
        }
        
        if (elements.messageInput) {
            elements.messageInput.addEventListener('input', handleInputResize);
            elements.messageInput.addEventListener('keydown', handleInputKeydown);
        }
        
        if (elements.newSessionBtn) {
            elements.newSessionBtn.addEventListener('click', handleNewSession);
        }
    }
    
    // Máscara de CPF
    function setupCpfMask() {
        const cpfInput = document.getElementById('visitor-cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                
                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                }
                
                e.target.value = value;
            });
        }
    }
    
    // Toggle chat
    function toggleChat() {
        state.isOpen = !state.isOpen;
        
        if (state.isOpen) {
            elements.chatWindow?.classList.remove('hidden');
            elements.chatIcon?.classList.add('hidden');
            elements.closeIcon?.classList.remove('hidden');
            elements.notificationBadge?.classList.add('hidden');
            
            checkAvailability().then(() => {
                if (state.sessionId) {
                    showChatInterface();
                    loadMessages();
                    startPolling();
                } else if (state.isAvailable) {
                    showInitialForm();
                } else {
                    showOfflineMessage();
                }
            });
        } else {
            elements.chatWindow?.classList.add('hidden');
            elements.chatIcon?.classList.remove('hidden');
            elements.closeIcon?.classList.add('hidden');
            stopPolling();
        }
    }
    
    // Verificar disponibilidade
    async function checkAvailability() {
        try {
            const response = await fetch(ROUTES.status);
            const data = await response.json();
            
            state.isAvailable = data.available || false;
            
            if (elements.statusText) {
                if (state.isAvailable) {
                    elements.statusText.innerHTML = '<span class="inline-block w-2 h-2 bg-green-300 rounded-full mr-1 animate-pulse"></span>Online';
                } else {
                    elements.statusText.innerHTML = '<span class="inline-block w-2 h-2 bg-amber-300 rounded-full mr-1"></span>Offline';
                }
            }
            
            if (!state.isAvailable && data.next_availability && elements.nextAvailability) {
                elements.nextAvailability.textContent = `Próxima disponibilidade: ${data.next_availability.day} às ${data.next_availability.time}`;
            }
        } catch (error) {
            console.error('Erro ao verificar disponibilidade:', error);
            state.isAvailable = true; // Assumir disponível em caso de erro
        }
    }
    
    // Restaurar sessão
    async function restoreSession() {
        const savedSessionId = localStorage.getItem('semagri_chat_session');
        if (!savedSessionId) return;
        
        try {
            const response = await fetch(ROUTES.session(savedSessionId), {
                headers: { 'Accept': 'application/json' }
            });
            
            if (response.ok) {
                const data = await response.json();
                if (data.success && data.session && data.session.status !== 'closed') {
                    state.sessionId = savedSessionId;
                }
            }
            
            if (!state.sessionId) {
                localStorage.removeItem('semagri_chat_session');
            }
        } catch (error) {
            console.error('Erro ao restaurar sessão:', error);
        }
    }
    
    // Iniciar chat
    async function handleStartChat(e) {
        e.preventDefault();
        
        const name = document.getElementById('visitor-name')?.value.trim();
        const cpf = document.getElementById('visitor-cpf')?.value.replace(/\D/g, '');
        const email = document.getElementById('visitor-email')?.value.trim();
        const phone = document.getElementById('visitor-phone')?.value.trim();

            if (!name) {
            showAlert('Por favor, informe seu nome completo.');
                return;
            }

            if (!cpf || cpf.length !== 11) {
            showAlert('Por favor, informe um CPF válido com 11 dígitos.');
                return;
            }
        
        const startBtn = document.getElementById('chat-start-btn');
        if (startBtn) {
            startBtn.disabled = true;
            startBtn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            }

            try {
            const response = await fetch(ROUTES.start, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                body: JSON.stringify({ name, cpf, email, phone }),
                });

                const data = await response.json();

                if (data.success) {
                state.sessionId = data.session_id;
                localStorage.setItem('semagri_chat_session', state.sessionId);
                showChatInterface();
                loadMessages();
                startPolling();
            } else if (response.status === 409 && data.existing_session_id) {
                // Sessão existente
                state.sessionId = data.existing_session_id;
                localStorage.setItem('semagri_chat_session', state.sessionId);
                showChatInterface();
                loadMessages();
                startPolling();
                showAlert('Você já possui uma conversa ativa. Continuando com a sessão anterior.');
            } else {
                showAlert(data.message || 'Erro ao iniciar o chat. Tente novamente.');
            }
        } catch (error) {
            console.error('Erro ao iniciar chat:', error);
            showAlert('Erro ao iniciar o chat. Tente novamente.');
        } finally {
            if (startBtn) {
                startBtn.disabled = false;
                startBtn.innerHTML = '<span>Iniciar Conversa</span><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>';
            }
        }
    }
    
    // Enviar mensagem
    async function handleSendMessage(e) {
        e.preventDefault();
        
        if (!state.sessionId || !elements.messageInput) return;
        
        const message = elements.messageInput.value.trim();
        if (!message) return;
        
        elements.messageInput.disabled = true;
        if (elements.sendBtn) elements.sendBtn.disabled = true;
        
        const originalValue = elements.messageInput.value;
        elements.messageInput.value = '';
        elements.messageInput.style.height = 'auto';
        
        try {
            const response = await fetch(ROUTES.message(state.sessionId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ message }),
            });
            
            const data = await response.json();
            
            if (data.success) {
                appendMessage(data.message);
                scrollToBottom();
            } else {
                elements.messageInput.value = originalValue;
                
                if (data.message?.includes('encerrada')) {
                    handleSessionClosed();
                    } else {
                    showAlert(data.message || 'Erro ao enviar mensagem.');
                }
            }
        } catch (error) {
            console.error('Erro ao enviar mensagem:', error);
            elements.messageInput.value = originalValue;
            showAlert('Erro ao enviar mensagem. Tente novamente.');
        } finally {
            elements.messageInput.disabled = false;
            if (elements.sendBtn) elements.sendBtn.disabled = false;
            elements.messageInput.focus();
        }
    }
    
    // Carregar mensagens
    async function loadMessages() {
        if (!state.sessionId) return;
        
        try {
            const response = await fetch(ROUTES.session(state.sessionId), {
                headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                if (response.status === 404 || response.status === 403) {
                    handleSessionClosed();
                    }
                    return;
                }

                const data = await response.json();

            if (data.success && data.messages) {
                // Verificar se sessão foi encerrada
                if (data.session?.status === 'closed') {
                    handleSessionClosed();
                    return;
                }

                const previousCount = state.lastMessageId;
                let hasNewFromAgent = false;
                
                // Limpar container se for primeira carga
                if (previousCount === 0 && elements.messagesContainer) {
                    elements.messagesContainer.innerHTML = '';
                }
                
                data.messages.forEach(msg => {
                    if (msg.id > state.lastMessageId) {
                        appendMessage(msg);
                        state.lastMessageId = msg.id;
                        
                        if (msg.sender_type === 'user' && previousCount > 0) {
                            hasNewFromAgent = true;
                        }
                    }
                });
                
                if (hasNewFromAgent && !state.isOpen) {
                    showNotificationBadge();
                    playNotificationSound();
                } else if (hasNewFromAgent) {
                    playNotificationSound();
                }
                
                scrollToBottom();
            }
        } catch (error) {
            console.error('Erro ao carregar mensagens:', error);
        }
    }
    
    // Adicionar mensagem ao DOM
    function appendMessage(msg) {
        if (!elements.messagesContainer) return;
        
        // Verificar se já existe
        if (elements.messagesContainer.querySelector(`[data-message-id="${msg.id}"]`)) return;
        
        const isSent = msg.sender_type === 'visitor';
            const isSystem = msg.sender_type === 'system';

        const wrapper = document.createElement('div');
        wrapper.className = `flex ${isSent ? 'justify-end' : (isSystem ? 'justify-center' : 'justify-start')}`;
        wrapper.setAttribute('data-message-id', msg.id);
        
        const time = new Date(msg.created_at).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        
        if (isSystem) {
            wrapper.innerHTML = `
                <div class="message-bubble system px-4 py-2">
                    <p class="text-gray-600 dark:text-gray-400">${escapeHtml(msg.message)}</p>
                </div>
            `;
        } else {
            wrapper.innerHTML = `
                <div class="message-bubble ${isSent ? 'sent' : 'received'} px-4 py-2.5 shadow-sm">
                    <p class="text-sm whitespace-pre-wrap break-words text-gray-900 dark:text-white">${escapeHtml(msg.message)}</p>
                    <div class="flex items-center justify-end gap-1 mt-1">
                        <span class="text-xs opacity-60">${time}</span>
                        ${isSent ? `
                        <svg class="w-4 h-4 ${msg.is_read ? 'text-blue-500' : 'opacity-60'}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        ` : ''}
                    </div>
                </div>
            `;
        }
        
        elements.messagesContainer.appendChild(wrapper);
    }
    
    // UI Helpers
    function showInitialForm() {
        elements.offlineMessage?.classList.add('hidden');
        elements.initialForm?.classList.remove('hidden');
        elements.messagesContainer?.classList.add('hidden');
        elements.welcomeMessage?.classList.add('hidden');
        elements.inputContainer?.classList.add('hidden');
        elements.sessionClosed?.classList.add('hidden');
    }
    
    function showOfflineMessage() {
        elements.offlineMessage?.classList.remove('hidden');
        elements.initialForm?.classList.add('hidden');
        elements.messagesContainer?.classList.add('hidden');
        elements.welcomeMessage?.classList.add('hidden');
        elements.inputContainer?.classList.add('hidden');
        elements.sessionClosed?.classList.add('hidden');
    }
    
    function showChatInterface() {
        elements.offlineMessage?.classList.add('hidden');
        elements.initialForm?.classList.add('hidden');
        elements.messagesContainer?.classList.remove('hidden');
        elements.welcomeMessage?.classList.add('hidden');
        elements.inputContainer?.classList.remove('hidden');
        elements.sessionClosed?.classList.add('hidden');
    }
    
    function handleSessionClosed() {
        localStorage.removeItem('semagri_chat_session');
        state.sessionId = null;
        state.lastMessageId = 0;
        stopPolling();
        
        elements.inputContainer?.classList.add('hidden');
        elements.sessionClosed?.classList.remove('hidden');
    }
    
    function handleNewSession() {
        localStorage.removeItem('semagri_chat_session');
        state.sessionId = null;
        state.lastMessageId = 0;
        
        if (elements.messagesContainer) {
            elements.messagesContainer.innerHTML = '';
        }
        
        if (state.isAvailable) {
            showInitialForm();
        } else {
            showOfflineMessage();
        }
    }
    
    function handleInputResize() {
        if (elements.messageInput) {
            elements.messageInput.style.height = 'auto';
            elements.messageInput.style.height = Math.min(elements.messageInput.scrollHeight, 100) + 'px';
        }
    }
    
    function handleInputKeydown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            elements.messageForm?.dispatchEvent(new Event('submit'));
        }
    }
    
    function showNotificationBadge() {
        if (elements.notificationBadge) {
            elements.notificationBadge.classList.remove('hidden');
        }
    }
    
    function playNotificationSound() {
        if (state.notificationSound && !document.hidden) {
            state.notificationSound.currentTime = 0;
            state.notificationSound.play().catch(() => {});
        }
    }
    
    function scrollToBottom() {
        if (elements.messagesContainer) {
            elements.messagesContainer.scrollTop = elements.messagesContainer.scrollHeight;
        }
    }
    
    // Polling
    function startPolling() {
        stopPolling();
        state.pollInterval = setInterval(loadMessages, POLLING_INTERVAL);
    }
    
    function stopPolling() {
        if (state.pollInterval) {
            clearInterval(state.pollInterval);
            state.pollInterval = null;
        }
    }
    
    // Utilitários
    function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    
    function showAlert(message) {
        // Toast simples
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-20 right-4 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg z-[10001] animate-pulse';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Pausar polling quando aba não está visível
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopPolling();
        } else if (state.sessionId && state.isOpen) {
            loadMessages();
            startPolling();
        }
    });
    
    // Cleanup
    window.addEventListener('beforeunload', stopPolling);
    
    // Inicializar quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endif
